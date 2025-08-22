<?php

namespace App\Services;

use App\Models\ImportHistory;
use App\Jobs\ImportAuthorsJob;
use App\Jobs\ImportAuthorListJob;
use App\Enums\ImportStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Facade Pattern - Bulk Import işlemlerini basitleştirir
 * 
 * Bu sınıf karmaşık import sürecini basit method'larla sağlar:
 * - File upload & validation
 * - ImportHistory management
 * - Job dispatching
 * - Error handling
 */
class BulkImportFacade
{
    /**
     * Ana import method - Tek method ile tüm import süreci
     */
    public function importFromFile(UploadedFile $file, string $type, array $options = []): array
    {
        try {
            // 1. File validation
            $this->validateFile($file, $type);
            
            // 2. File storage
            $filePath = $this->storeFile($file);
            
            // 3. ImportHistory creation
            $importHistory = $this->createImportHistory($type, $filePath, $options);
            
            // 4. Parse & validate data structure
            $this->validateFileStructure($filePath, $type);
            
            // 5. Dispatch import job
            $this->dispatchImportJob($filePath, $type, $importHistory->id);
            
            return [
                'success' => true,
                'import_id' => $importHistory->id,
                'message' => 'Import başlatıldı. İşlem arka planda devam ediyor.',
                'import_history' => $importHistory
            ];
            
        } catch (\Exception $e) {
            Log::error("BulkImportFacade error: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Import status sorgulama - Basit interface
     */
    public function getImportStatus(int $importId): array
    {
        $importHistory = ImportHistory::find($importId);
        
        if (!$importHistory) {
            return [
                'success' => false,
                'message' => 'Import bulunamadı'
            ];
        }

        $progress = $importHistory->total_records > 0 
            ? round(($importHistory->processed_records / $importHistory->total_records) * 100, 2)
            : 0;

        return [
            'success' => true,
            'status' => $importHistory->status,
            'progress' => $progress,
            'total_records' => $importHistory->total_records,
            'processed_records' => $importHistory->processed_records,
            'successful_records' => $importHistory->successful_records,
            'failed_records' => $importHistory->failed_records,
            'error_log' => $importHistory->error_log
        ];
    }

    /**
     * Import geçmişi listeleme
     */
    public function getImportHistory(int $limit = 10): array
    {
        $imports = ImportHistory::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($import) {
                return [
                    'id' => $import->id,
                    'file_name' => $import->file_name,
                    'import_type' => $import->import_type,
                    'status' => $import->status,
                    'progress' => $import->total_records > 0 
                        ? round(($import->processed_records / $import->total_records) * 100, 2)
                        : 0,
                    'created_at' => $import->created_at->format('d.m.Y H:i')
                ];
            });

        return [
            'success' => true,
            'imports' => $imports
        ];
    }

    // ========== PRIVATE HELPER METHODS (Karmaşıklığı gizler) ==========

    private function validateFile(UploadedFile $file, string $type): void
    {
        // File type validation
        if (!in_array($file->getClientOriginalExtension(), ['csv', 'xlsx', 'xls'])) {
            throw new \InvalidArgumentException('Dosya formatı desteklenmiyor. CSV, XLSX veya XLS yükleyin.');
        }

        // File size validation (5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \InvalidArgumentException('Dosya boyutu 5MB\'dan büyük olamaz.');
        }

        // Import type validation
        if (!in_array($type, ['author', 'book'])) {
            throw new \InvalidArgumentException('Desteklenmeyen import türü: ' . $type);
        }
    }

    private function storeFile(UploadedFile $file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $fileName);
        
        return Storage::path($path);
    }

    private function createImportHistory(string $type, string $filePath, array $options): ImportHistory
    {
        return ImportHistory::create([
            'file_name' => basename($filePath),
            'file_path' => $filePath,
            'import_type' => $type,
            'status' => ImportStatus::Pending->value,
            'total_records' => 0, // Job içinde update edilecek
            'processed_records' => 0,
            'successful_records' => 0,
            'failed_records' => 0,
            'user_id' => auth()->id(),
            'options' => json_encode($options)
        ]);
    }

    private function validateFileStructure(string $filePath, string $type): void
    {
        $data = Excel::toArray([], $filePath);
        
        if (empty($data) || empty($data[0])) {
            throw new \InvalidArgumentException('Dosya boş veya okunamıyor.');
        }

        $header = array_map('strtolower', $data[0][0] ?? []);
        $requiredColumns = $this->getRequiredColumns($type);

        foreach ($requiredColumns as $column) {
            if (!in_array($column, $header)) {
                throw new \InvalidArgumentException("Gerekli kolon bulunamadı: {$column}");
            }
        }
    }

    private function getRequiredColumns(string $type): array
    {
        return match ($type) {
            'author' => ['name'],
            'book' => ['name', 'author'],
            default => []
        };
    }

    private function dispatchImportJob(string $filePath, string $type, int $importHistoryId): void
    {
        match ($type) {
            'author' => ImportAuthorsJob::dispatch($filePath, $importHistoryId),
            'book' => ImportAuthorListJob::dispatch($filePath, $importHistoryId), // Örnek için
            default => throw new \InvalidArgumentException('Desteklenmeyen import türü')
        };
    }
}

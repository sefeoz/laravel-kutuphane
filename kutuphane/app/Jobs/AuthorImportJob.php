<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\ImportHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AuthorImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;
    public $tries = 3;

    public function __construct(
        private array $authorData,
        private int $importHistoryId
    ) {}

    public function handle()
    {
        try {
            $importHistory = ImportHistory::find($this->importHistoryId);
            
            if (!$importHistory) {
                Log::error("ImportHistory bulunamadı: {$this->importHistoryId}");
                return;
            }

            $name = trim($this->authorData['name'] ?? '');
            
            if (empty($name)) {
                $this->updateFailedRecord($importHistory, 'Yazar adı boş');
                return;
            }

            $existingAuthor = Author::where('name', $name)->first();
            
            if ($existingAuthor) {
                $this->updateFailedRecord($importHistory, "Duplicate: '{$name}' zaten mevcut");
                return;
            }

            $author = Author::create([
                'name' => $name,
                'bio' => $this->authorData['bio'] ?? null,
                'birth_date' => $this->parseDate($this->authorData['birth_date'] ?? null),
            ]);

            $this->updateSuccessfulRecord($importHistory);
            
            Log::info("Yazar başarıyla oluşturuldu: {$name} (ID: {$author->id})");

        } catch (\Exception $e) {
            Log::error("AuthorImportJob hatası: " . $e->getMessage());
            $this->updateFailedRecord($importHistory, $e->getMessage());
        }
    }

    public function failed(\Throwable $exception)
    {
        $importHistory = ImportHistory::find($this->importHistoryId);
        if ($importHistory) {
            $this->updateFailedRecord($importHistory, $exception->getMessage());
        }
        
        Log::error("AuthorImportJob başarısız: " . $exception->getMessage());
    }

    private function updateSuccessfulRecord(ImportHistory $importHistory)
    {
        $importHistory->increment('processed_records');
        $importHistory->increment('successful_records');
        
        $this->checkIfCompleted($importHistory);
    }

    private function updateFailedRecord(ImportHistory $importHistory, string $errorMessage)
    {
        $importHistory->increment('processed_records');
        $importHistory->increment('failed_records');
        
        $currentLog = $importHistory->error_log ?? '';
        $newLog = $currentLog . "\n" . date('Y-m-d H:i:s') . ": " . $errorMessage;
        $importHistory->update(['error_log' => trim($newLog)]);
        
        $this->checkIfCompleted($importHistory);
    }

    private function checkIfCompleted(ImportHistory $importHistory)
    {
        if ($importHistory->processed_records >= $importHistory->total_records) {
            $importHistory->update(['status' => 'completed']);
            Log::info("Import tamamlandı: ID {$importHistory->id}");
        }
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {   
            $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];
            
            foreach ($formats as $format) {
                $parsed = \DateTime::createFromFormat($format, $date);
                if ($parsed && $parsed->format($format) === $date) {
                    return $parsed->format('Y-m-d');
                }
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

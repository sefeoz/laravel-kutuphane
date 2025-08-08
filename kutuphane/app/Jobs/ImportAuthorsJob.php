<?php

namespace App\Jobs;

use App\Models\ImportHistory;
use App\Jobs\AuthorImportJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportAuthorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    public $tries = 3;

    public function __construct(
        private string $filePath,
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

            $importHistory->update(['status' => 'processing']);

            $data = Excel::toArray([], $this->filePath);
            
            if (empty($data) || empty($data[0])) {
                $importHistory->update([
                    'status' => 'failed',
                    'error_log' => 'Dosya boş veya okunamadı'
                ]);
                return;
            }

            $rows = $data[0];
            $totalRecords = count($rows) - 1;

            $header = $rows[0];
            if (!in_array('name', array_map('strtolower', $header))) {
                $importHistory->update([
                    'status' => 'failed',
                    'error_log' => 'Excel dosyasında "name" kolonları bulunamadı'
                ]);
                return;
            }

            $importHistory->update(['total_records' => $totalRecords]);

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                $authorData = [];
                foreach ($header as $index => $column) {
                    $authorData[strtolower($column)] = $row[$index] ?? null;
                }

                if (empty(trim($authorData['name'] ?? ''))) {
                    continue;
                }

                AuthorImportJob::dispatch($authorData, $this->importHistoryId);
            }

            Log::info("ImportAuthorsJob tamamlandı. Toplam {$totalRecords} kayıt işleme gönderildi.");

        } catch (\Exception $e) {
            Log::error("ImportAuthorsJob hatası: " . $e->getMessage());
            
            ImportHistory::where('id', $this->importHistoryId)->update([
                'status' => 'failed',
                'error_log' => $e->getMessage()
            ]);
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("ImportAuthorsJob başarısız: " . $exception->getMessage());
        
        ImportHistory::where('id', $this->importHistoryId)->update([
            'status' => 'failed',
            'error_log' => $exception->getMessage()
        ]);
    }
}

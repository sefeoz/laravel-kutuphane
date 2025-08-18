<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\ImportHistory;
use App\DTOs\AuthorImportData;
use App\Imports\Authors\ImportContext;
use App\Imports\Authors\AuthorImportPipeline;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Enums\ImportStatus;

class AuthorImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 60;
    public $tries = 3;

    public function __construct(
        private AuthorImportData $authorData,
        private int $importHistoryId
    ) {
    }

    public function handle()
    {
        $importHistory = ImportHistory::findOrFail($this->importHistoryId);

        try {
            $context = new ImportContext($this->authorData, $importHistory);
            $pipeline = AuthorImportPipeline::build();
            $pipeline->handle($context);

            $this->updateSuccessfulRecord($importHistory);
            Log::info("Yazar başarıyla oluşturuldu: {$this->authorData->name}");
        } catch (\Throwable $e) {
            $this->updateFailedRecord($importHistory, $e->getMessage());
            Log::error('AuthorImportJob hata: '.$e->getMessage());
        }
    }

    public function failed(\Throwable $exception)
    {
        $importHistory = ImportHistory::find($this->importHistoryId);
        if ($importHistory) {
            $this->updateFailedRecord($importHistory, $exception->getMessage());
        } else {
            Log::error("AuthorImportJob başarısız; ImportHistory bulunamadı (ID: {$this->importHistoryId}). Hata: " . $exception->getMessage());
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
            $importHistory->update(['status' => ImportStatus::Completed->value]);
            Log::info("Import tamamlandı: ID {$importHistory->id}");
        }
    }

    
}

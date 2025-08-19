<?php

namespace App\Jobs;

use App\Models\ImportHistory;
use App\Enums\ImportStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class AbstractImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;
    public $tries = 3;

    protected int $importHistoryId;

    public function __construct(int $importHistoryId)
    {
        $this->importHistoryId = $importHistoryId;
    }

    /**
     * Template Method - Ana import akışını tanımlar
     */
    public function handle()
    {
        $importHistory = ImportHistory::findOrFail($this->importHistoryId);

        try {
            // Concrete sınıflar bu method'u implement eder
            $this->processImport($importHistory);
            
            $this->updateSuccessfulRecord($importHistory);
            $this->logSuccess();
        } catch (\Throwable $e) {
            $this->updateFailedRecord($importHistory, $e->getMessage());
            $this->logError($e->getMessage());
        }
    }

    /**
     * Template Method - Başarısızlık durumunu handle eder
     */
    public function failed(\Throwable $exception)
    {
        $importHistory = ImportHistory::find($this->importHistoryId);
        if ($importHistory) {
            $this->updateFailedRecord($importHistory, $exception->getMessage());
        } else {
            Log::error("{$this->getJobName()} başarısız; ImportHistory bulunamadı (ID: {$this->importHistoryId}). Hata: " . $exception->getMessage());
        }
        Log::error("{$this->getJobName()} başarısız: " . $exception->getMessage());
    }

    /**
     * Abstract method - Her concrete sınıf kendi import logic'ini implement eder
     */
    abstract protected function processImport(ImportHistory $importHistory): void;

    /**
     * Abstract method - Her job kendi ismini döner
     */
    abstract protected function getJobName(): string;

    /**
     * Abstract method - Her job kendi success mesajını döner
     */
    abstract protected function getSuccessMessage(): string;

    /**
     * Ortak method - Başarılı record update
     */
    protected function updateSuccessfulRecord(ImportHistory $importHistory)
    {
        $importHistory->increment('processed_records');
        $importHistory->increment('successful_records');
        $this->checkIfCompleted($importHistory);
    }

    /**
     * Ortak method - Başarısız record update
     */
    protected function updateFailedRecord(ImportHistory $importHistory, string $errorMessage)
    {
        $importHistory->increment('processed_records');
        $importHistory->increment('failed_records');

        $currentLog = $importHistory->error_log ?? '';
        $newLog = $currentLog . "\n" . date('Y-m-d H:i:s') . ": " . $errorMessage;
        $importHistory->update(['error_log' => trim($newLog)]);

        $this->checkIfCompleted($importHistory);
    }

    /**
     * Ortak method - Import tamamlanma kontrolü
     */
    protected function checkIfCompleted(ImportHistory $importHistory)
    {
        if ($importHistory->processed_records >= $importHistory->total_records) {
            $importHistory->update(['status' => ImportStatus::Completed->value]);
            Log::info("Import tamamlandı: ID {$importHistory->id}");
        }
    }

    /**
     * Hook method - Concrete sınıflar override edebilir
     */
    protected function logSuccess()
    {
        Log::info($this->getSuccessMessage());
    }

    /**
     * Hook method - Concrete sınıflar override edebilir
     */
    protected function logError(string $errorMessage)
    {
        Log::error("{$this->getJobName()} hata: {$errorMessage}");
    }
}

<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\ImportHistory;
use App\DTOs\AuthorImportData;
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

        $name = trim($this->authorData->name ?? '');
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
            'bio' => $this->authorData->bio ?? null,
            'birth_date' => $this->parseDate($this->authorData->birthDate ?? null),
        ]);

        $this->updateSuccessfulRecord($importHistory);
        Log::info("Yazar başarıyla oluşturuldu: {$name} (ID: {$author->id})");
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

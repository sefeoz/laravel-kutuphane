<?php

namespace App\Jobs;

use App\Models\ImportHistory;
use App\Jobs\AuthorImportJob;
use App\DTOs\AuthorImportData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Enums\ImportStatus;

class ImportAuthorListJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 300;
    public $tries = 3;

    public function __construct(
        private string $filePath,
        private int $importHistoryId
    ) {
    }

    public function handle()
    {
        try {
            $importHistory = ImportHistory::find($this->importHistoryId);

            if (!$importHistory) {
                Log::error("ImportHistory bulunamadı: {$this->importHistoryId}");
                return;
            }

            $importHistory->update(['status' => ImportStatus::Processing->value]);

            $data = Excel::toArray([], $this->filePath);

            if (empty($data) || empty($data[0])) {
                $importHistory->update([
                    'status' => ImportStatus::Failed->value,
                    'error_log' => 'Dosya boş veya okunamadı'
                ]);
                return;
            }

            $rows = $data[0];
            $totalRecords = count($rows) - 1;

            $header = $rows[0];
            if (!in_array('name', array_map('strtolower', $header))) {
                $importHistory->update([
                    'status' => ImportStatus::Failed->value,
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

                $dto = AuthorImportData::fromArray($authorData);
                AuthorImportJob::dispatch($dto, $this->importHistoryId);
            }

            Log::info("ImportAuthorListJob tamamlandı. Toplam {$totalRecords} kayıt işleme gönderildi.");

        } catch (\Exception $e) {
            Log::error("ImportAuthorListJob hatası: " . $e->getMessage());

            ImportHistory::where('id', $this->importHistoryId)->update([
                'status' => ImportStatus::Failed->value,
                'error_log' => $e->getMessage()
            ]);
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("ImportAuthorListJob başarısız: " . $exception->getMessage());

        ImportHistory::where('id', $this->importHistoryId)->update([
            'status' => ImportStatus::Failed->value,
            'error_log' => $exception->getMessage()
        ]);
    }
}

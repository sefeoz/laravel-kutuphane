<?php

namespace App\Jobs;

use App\Models\ImportHistory;
use App\DTOs\AuthorImportData;
use App\Imports\Authors\ImportContext;
use App\Imports\Authors\AuthorImportPipeline;

class AuthorImportJob extends AbstractImportJob
{
    private AuthorImportData $authorData;

    public function __construct(
        AuthorImportData $authorData,
        int $importHistoryId
    ) {
        parent::__construct($importHistoryId);
        $this->authorData = $authorData;
    }

    /**
     * Template Method implementation - Author import logic
     */
    protected function processImport(ImportHistory $importHistory): void
    {
        $context = new ImportContext($this->authorData, $importHistory);
        $pipeline = AuthorImportPipeline::build();
        $pipeline->handle($context);
    }

    /**
     * Job ismi döner
     */
    protected function getJobName(): string
    {
        return 'AuthorImportJob';
    }

    /**
     * Başarı mesajı döner
     */
    protected function getSuccessMessage(): string
    {
        return "Yazar başarıyla oluşturuldu: {$this->authorData->name}";
    }
}

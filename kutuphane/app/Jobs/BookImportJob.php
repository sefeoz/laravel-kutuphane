<?php

namespace App\Jobs;

use App\Models\ImportHistory;
use App\DTOs\AuthorImportData; // Örnek için AuthorImportData kullanıyorum
use App\Imports\Authors\ImportContext;
use App\Imports\AbstractImportPipelineFactory;

class BookImportJob extends AbstractImportJob
{
    private AuthorImportData $bookData; // Normalde BookImportData olurdu

    public function __construct(
        AuthorImportData $bookData, // Örnek için
        int $importHistoryId
    ) {
        parent::__construct($importHistoryId);
        $this->bookData = $bookData;
    }

    /**
     * Template Method implementation - Book import logic
     * Author'dan farklı olarak farklı pipeline kullanır
     */
    protected function processImport(ImportHistory $importHistory): void
    {
        $context = new ImportContext($this->bookData, $importHistory);
        
        // Factory pattern ile book pipeline oluşturur
        $factory = AbstractImportPipelineFactory::createForType('book');
        $pipeline = $factory->createPipeline();
        
        $pipeline->handle($context);
    }

    /**
     * Job ismi döner
     */
    protected function getJobName(): string
    {
        return 'BookImportJob';
    }

    /**
     * Başarı mesajı döner - Book için farklı mesaj
     */
    protected function getSuccessMessage(): string
    {
        return "Kitap başarıyla oluşturuldu: {$this->bookData->name}";
    }

    /**
     * Hook method override - Book için özel log
     */
    protected function logSuccess()
    {
        parent::logSuccess();
        
        // Book import için ekstra log
        \Log::info("Book import completed with additional validation checks");
    }
}

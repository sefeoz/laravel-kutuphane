<?php

namespace App\Imports\Books\Handlers;

use App\Imports\Authors\Handlers\AbstractHandler;
use App\Imports\Authors\ImportContext;
use RuntimeException;

class BookValidateHandler extends AbstractHandler
{
    protected function process(ImportContext $context): void
    {
        // Book validation logic - Author'dan farklı olabilir
        $title = trim($context->data->name ?? '');
        if ($title === '') {
            throw new RuntimeException('Kitap başlığı boş');
        }
        
        // Book için ekstra validasyonlar
        if (strlen($title) < 2) {
            throw new RuntimeException('Kitap başlığı çok kısa');
        }
    }
}

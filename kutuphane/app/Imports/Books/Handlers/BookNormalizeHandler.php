<?php

namespace App\Imports\Books\Handlers;

use App\Imports\Authors\Handlers\AbstractHandler;
use App\Imports\Authors\ImportContext;

class BookNormalizeHandler extends AbstractHandler
{
    protected function process(ImportContext $context): void
    {
        // Book normalization - Author'dan farklı olabilir
        $context->data->name = ucwords(strtolower(trim($context->data->name)));
        
        // Kitap özel normalization'ları
        // Örn: ISBN format düzeltme, sayfa sayısı kontrolü vs.
    }
}

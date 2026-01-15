<?php

namespace App\Imports\Books\Handlers;

use App\Imports\Authors\Handlers\AbstractHandler;
use App\Imports\Authors\ImportContext;
use App\Models\Book;
use RuntimeException;

class BookDuplicateCheckHandler extends AbstractHandler
{
    protected function process(ImportContext $context): void
    {
        // Book duplicate check - farklı kriterler olabilir
        $existingBook = Book::where('name', $context->data->name)->first();
        
        if ($existingBook) {
            throw new RuntimeException("Kitap zaten mevcut: {$context->data->name}");
        }
    }
}

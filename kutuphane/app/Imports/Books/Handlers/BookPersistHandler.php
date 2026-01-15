<?php

namespace App\Imports\Books\Handlers;

use App\Imports\Authors\Handlers\AbstractHandler;
use App\Imports\Authors\ImportContext;
use App\Models\Book;

class BookPersistHandler extends AbstractHandler
{
    protected function process(ImportContext $context): void
    {
        // Book persist logic - Author'dan farklı fieldlar
        $book = Book::create([
            'name' => $context->data->name,
            'author_id' => $context->data->author_id ?? null,
            'page_count' => $context->data->page_count ?? null,
            'publish_date' => $context->data->publish_date ?? null,
        ]);
    }
}

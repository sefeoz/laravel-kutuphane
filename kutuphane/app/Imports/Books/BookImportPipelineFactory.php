<?php

namespace App\Imports\Books;

use App\Imports\AbstractImportPipelineFactory;
use App\Imports\Authors\Handlers\HandlerInterface;
use App\Imports\Books\Handlers\BookValidateHandler;
use App\Imports\Books\Handlers\BookNormalizeHandler;
use App\Imports\Books\Handlers\BookDuplicateCheckHandler;
use App\Imports\Books\Handlers\BookPersistHandler;

class BookImportPipelineFactory extends AbstractImportPipelineFactory
{
    public function createPipeline(): HandlerInterface
    {
        $validate = app(BookValidateHandler::class);
        $normalize = app(BookNormalizeHandler::class);
        $duplicate = app(BookDuplicateCheckHandler::class);
        $persist = app(BookPersistHandler::class);

        // Book'larda farklı bir akış olabilir
        $validate->setNext($normalize)
            ->setNext($duplicate)
            ->setNext($persist);

        return $validate;
    }
}

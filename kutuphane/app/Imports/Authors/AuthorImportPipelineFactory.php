<?php

namespace App\Imports\Authors;

use App\Imports\AbstractImportPipelineFactory;
use App\Imports\Authors\Handlers\HandlerInterface;
use App\Imports\Authors\Handlers\ValidateHandler;
use App\Imports\Authors\Handlers\NormalizeHandler;
use App\Imports\Authors\Handlers\DuplicateCheckHandler;
use App\Imports\Authors\Handlers\PersistHandler;

class AuthorImportPipelineFactory extends AbstractImportPipelineFactory
{
    public function createPipeline(): HandlerInterface
    {
        $validate = new ValidateHandler();
        $normalize = new NormalizeHandler();
        $duplicate = new DuplicateCheckHandler();
        $persist = new PersistHandler();

        $validate->setNext($normalize)
            ->setNext($duplicate)
            ->setNext($persist);

        return $validate;
    }
}

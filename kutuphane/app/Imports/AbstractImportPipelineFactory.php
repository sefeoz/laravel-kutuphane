<?php

namespace App\Imports;

use App\Imports\Contracts\ImportPipelineFactoryInterface;
use App\Imports\Authors\Handlers\HandlerInterface;

abstract class AbstractImportPipelineFactory implements ImportPipelineFactoryInterface
{
    abstract public function createPipeline(): HandlerInterface;
    
    /**
     * Template method - Ana factory metodu
     */
    public static function createForType(string $type): ImportPipelineFactoryInterface
    {
        return match ($type) {
            'author' => new \App\Imports\Authors\AuthorImportPipelineFactory(),
            'book' => new \App\Imports\Books\BookImportPipelineFactory(),
            default => throw new \InvalidArgumentException("Unsupported import type: {$type}")
        };
    }
}

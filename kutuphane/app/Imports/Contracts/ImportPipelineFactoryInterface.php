<?php

namespace App\Imports\Contracts;

use App\Imports\Authors\Handlers\HandlerInterface;

interface ImportPipelineFactoryInterface
{
    public function createPipeline(): HandlerInterface;
}

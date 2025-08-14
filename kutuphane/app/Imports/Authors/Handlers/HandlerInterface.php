<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;

interface HandlerInterface
{
	public function setNext(HandlerInterface $handler): HandlerInterface;

	public function handle(ImportContext $context): void;
}



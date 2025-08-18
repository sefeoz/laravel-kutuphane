<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;
use App\Models\Author;
use RuntimeException;

class DuplicateCheckHandler extends AbstractHandler
{
	protected function process(ImportContext $context): void
	{
		$exists = Author::where('name', $context->data->name)->exists();
		if ($exists) {
			throw new RuntimeException("Duplicate: '{$context->data->name}' zaten mevcut");
		}
	}
}



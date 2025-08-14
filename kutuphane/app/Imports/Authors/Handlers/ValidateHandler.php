<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;
use RuntimeException;

class ValidateHandler extends AbstractHandler
{
	protected function process(ImportContext $context): void
	{
		$name = trim($context->data->name ?? '');
		if ($name === '') {
			throw new RuntimeException('Yazar adı boş');
		}
	}
}



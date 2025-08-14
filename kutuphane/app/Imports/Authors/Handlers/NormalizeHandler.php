<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;

class NormalizeHandler extends AbstractHandler
{
	protected function process(ImportContext $context): void
	{
		$context->data->name = trim($context->data->name);
		if ($context->data->bio !== null) {
			$context->data->bio = trim($context->data->bio);
		}
	}
}



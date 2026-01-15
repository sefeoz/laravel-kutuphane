<?php

namespace App\Imports\Authors;

use App\Imports\Authors\Handlers\HandlerInterface;
use App\Imports\AbstractImportPipelineFactory;

/**
 * @deprecated Use AuthorImportPipelineFactory instead
 * Bu sınıf geriye uyumluluk için korunmuştur
 */
class AuthorImportPipeline
{
	public static function build(): HandlerInterface
	{
		$factory = AbstractImportPipelineFactory::createForType('author');
		return $factory->createPipeline();
	}
}



<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;
use App\Models\Author;

class PersistHandler extends AbstractHandler
{
	protected function process(ImportContext $context): void
	{
		$author = Author::create([
			'name' => $context->data->name,
			'bio' => $context->data->bio,
			'birth_date' => $this->parseDate($context->data->birthDate),
		]);
	}

	private function parseDate($date)
	{
		if (empty($date)) {
			return null;
		}

		try {
			$formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];

			foreach ($formats as $format) {
				$parsed = \DateTime::createFromFormat($format, $date);
				if ($parsed && $parsed->format($format) === $date) {
					return $parsed->format('Y-m-d');
				}
			}

			return null;
		} catch (\Exception $e) {
			return null;
		}
	}
}



<?php

namespace App\Imports\Authors\Handlers;

use App\Imports\Authors\ImportContext;

abstract class AbstractHandler implements HandlerInterface
{
	protected ?HandlerInterface $next = null;

	public function setNext(HandlerInterface $handler): HandlerInterface
	{
		$this->next = $handler;
		return $handler;
	}

	public function handle(ImportContext $context): void
	{
		$this->process($context);
		if ($this->next) {
			$this->next->handle($context);
		}
	}

	abstract protected function process(ImportContext $context): void;
}



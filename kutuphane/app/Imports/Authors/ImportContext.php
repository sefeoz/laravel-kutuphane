<?php

namespace App\Imports\Authors;

use App\DTOs\AuthorImportData;
use App\Models\ImportHistory;

class ImportContext
{
	public function __construct(
		public AuthorImportData $data,
		public ImportHistory $history,
	) {
	}
}



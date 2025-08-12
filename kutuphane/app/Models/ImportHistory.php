<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ImportStatus;

class ImportHistory extends Model
{
    protected $fillable = [
        'filename',
        'status',
        'total_records',
        'processed_records',
        'successful_records',
        'failed_records',
        'error_log',
    ];
    
    protected $casts = [
        'status' => ImportStatus::class,
        'total_records' => 'integer',
        'processed_records' => 'integer',
        'successful_records' => 'integer',
        'failed_records' => 'integer',
    ];
    
}

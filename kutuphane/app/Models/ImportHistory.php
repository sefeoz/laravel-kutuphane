<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email', 'website'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_store')->withPivot('price', 'stock', 'is_active')->withTimestamps();
    }
}

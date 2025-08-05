<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = ['book_name', 'author_id', 'ISBN', 'image'];
    
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_books');
    }
    
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'book_store')
                    ->withPivot('price', 'stock', 'is_active')
                    ->withTimestamps();
    }
}

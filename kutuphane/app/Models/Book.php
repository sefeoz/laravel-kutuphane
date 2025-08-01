<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['kitap_adi', 'yazar_id', 'ISBN', 'image'];
    
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_books');
    }
    
    public function yazar()
    {
        return $this->belongsTo(Yazar::class);
    }
    
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'book_store')
                    ->withPivot('price', 'stock', 'is_active')
                    ->withTimestamps();
    }
}

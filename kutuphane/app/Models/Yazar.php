<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yazar extends Model
{
    protected $table = 'yazarlar';
    protected $fillable = ['isim'];
    
    public function books(){
        return $this->hasMany(Book::class);
    }
}

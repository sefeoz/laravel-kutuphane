<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $table = 'authors';
    protected $fillable = ['name', 'bio', 'birth_date'];
    
    protected $casts = [
        'birth_date' => 'date',
    ];
    
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
    public static function createOrSkip(array $data)
    {
        $name = trim($data['name'] ?? '');
        
        if (empty($name)) {
            return null;
        }
        
        $existingAuthor = static::where('name', $name)->first();
        
        if ($existingAuthor) {
            return null;
        }
        
        return static::create([
            'name' => $name,
            'bio' => $data['bio'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);
    }
    public static function isDuplicate(string $name): bool
    {
        return static::where('name', trim($name))->exists();
    }
    public static function bulkImport(array $authors): array
    {
        $results = [
            'successful' => [],
            'duplicates' => [],
            'errors' => []
        ];
        
        foreach ($authors as $authorData) {
            try {
                $name = trim($authorData['name'] ?? '');
                
                if (empty($name)) {
                    $results['errors'][] = 'Boş isim: ' . json_encode($authorData);
                    continue;
                }
                
                if (static::isDuplicate($name)) {
                    $results['duplicates'][] = $name;
                    continue;
                }
                
                $author = static::create([
                    'name' => $name,
                    'bio' => $authorData['bio'] ?? null,
                    'birth_date' => $authorData['birth_date'] ?? null,
                ]);
                
                $results['successful'][] = $author;
                
            } catch (\Exception $e) {
                $results['errors'][] = "Hata: {$e->getMessage()} - " . json_encode($authorData);
            }
        }
        
        return $results;
    }
}

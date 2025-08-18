<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\DTOs\AuthorImportData;

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
    /**
     * @param AuthorImportData[] $authors
     */
    public static function bulkImport(array $authors): array
    {
        $results = [
            'successful' => [],
            'duplicates' => [],
            'errors' => []
        ];

        foreach ($authors as $authorData) {
            try {
                if (!$authorData instanceof AuthorImportData) {
                    throw new \InvalidArgumentException('bulkImport yalnızca AuthorImportData dizisi kabul eder');
                }

                $name = trim($authorData->name ?? '');

                if (empty($name)) {
                    $results['errors'][] = 'Boş isim: ' . json_encode($authorData);
                    continue;
                }

                $author = static::firstOrCreate(
                    ['name' => $name],
                    [
                        'bio' => $authorData->bio ?? null,
                        'birth_date' => $authorData->birthDate ?? null,
                    ]
                );

                if ($author->wasRecentlyCreated) {
                    $results['successful'][] = $author;
                } else {
                    $results['duplicates'][] = $name;
                }

            } catch (\Exception $e) {
                $results['errors'][] = "Hata: {$e->getMessage()} - " . json_encode($authorData);
            }
        }

        return $results;
    }
}

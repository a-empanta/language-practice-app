<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TopicCategory extends Model
{
    protected $fillable = [
        'title',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public static function withTopicSummaries()
    {
        return self::with('topics')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'topics' => $category->topics->map(function ($topic) {
                    return [
                        'id' => $topic->id,
                        'title' => $topic->title,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }
}

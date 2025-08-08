<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'topic_id',
        'level',
        'native_language_id',
        'practising_language_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function nativeLanguage()
    {
        return $this->belongsTo(Language::class, 'native_language_id');
    }

    public function practisingLanguage()
    {
        return $this->belongsTo(Language::class, 'practising_language_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends Model
{
    protected $fillable = [
        'name',
        'speech_generator_engine',
        'transcriber_ai_model',
        'speech_generator_language_code',
        'speech_generator_voice_id',
        'speech_generator_gender',
        'is_translating_language',
    ];

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class);
    }
}

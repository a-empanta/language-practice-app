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
        'phrases',
    ];

    protected $casts = [
        'phrases' => 'json',
    ];

    public function nativeConversations()
    {
        return $this->hasMany(Conversation::class, 'native_language_id');
    }

    public function practisingConversations()
    {
        return $this->hasMany(Conversation::class, 'practising_language_id');
    }
}

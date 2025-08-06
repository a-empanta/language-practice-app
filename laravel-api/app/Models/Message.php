<?php

namespace App\Models;

use App\Enums\SenderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    // Message.php
    protected $casts = [
        'sender_type' => SenderType::class,
    ];

    protected $fillable = [
        'message',
        'sender_type',
        'conversation_id',
    ];

    /**
     * Relationship: Message belongs to a conversation.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}

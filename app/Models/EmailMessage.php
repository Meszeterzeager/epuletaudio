<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailMessage extends Model
{
    protected $fillable = [
        'folder_id',
        'thread_id',
        'direction',
        'status',
        'starred',
        'resend_message_id',
        'message_id_header',
        'in_reply_to',
        'from_name',
        'from_email',
        'to',
        'cc',
        'bcc',
        'subject',
        'body_html',
        'body_text',
        'is_draft',
        'is_autoreply',
        'sent_at',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'to' => 'array',
            'cc' => 'array',
            'bcc' => 'array',
            'starred' => 'boolean',
            'is_draft' => 'boolean',
            'is_autoreply' => 'boolean',
            'sent_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(EmailFolder::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(EmailAttachment::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(EmailLabel::class, 'email_label_email_message');
    }

    public function markAsRead(): void
    {
        if ($this->status !== 'read') {
            $this->update(['status' => 'read']);
        }
    }
}

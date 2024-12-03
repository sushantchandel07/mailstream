<?php
namespace Mailstream\Quickmail\Models;

use Illuminate\Database\Eloquent\Model;


class EmailRecipient extends Model{
    protected $table = 'email_recipients';

    protected $fillable = [
        'recipients_id',
        'mail_id',
        'sender_id',
        'is_read',
        'is_starred',
        'is_trashed',
        'is_archived',
        'is_important',
        'recipient_type',
    ];
    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }
}
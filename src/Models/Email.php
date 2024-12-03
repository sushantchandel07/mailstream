<?php
namespace Mailstream\Quickmail\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';

    protected $fillable = [
        'mail_subject',
        'mail_body',
        'is_sent',
        'is_draft',
        'user_id',
        'draft_is_starred'
    ];
    protected $casts = [
        'is_sent' => 'boolean',
        'is_draft' => 'boolean',
    ];


    public function labels()
    {
        return $this->belongsToMany(EmailLabel::class, 'email_label', 'email_id', 'label_id');
    }

}
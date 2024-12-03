<?php

namespace Mailstream\Quickmail\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLabel  extends Model
{

    protected $table = 'email_labels';


    protected $fillable = [
        'user_id',
        'label_id',
        'mail_id'
    ];

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'id');
    }
}

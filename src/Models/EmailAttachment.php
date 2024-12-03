<?php
namespace Mailstream\Quickmail\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model{
    protected $table = 'email_attachments';

    protected $fillable = [
        'email_id',
        'filename',
        'file_path',
    ];

}
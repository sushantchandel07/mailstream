<?php
namespace Mailstream\Quickmail\Models;

use Illuminate\Database\Eloquent\Model;

class Label  extends Model{

    protected $table = 'labels';


    protected $fillable = [
        'name',
        'user_id'
    ];
    

}
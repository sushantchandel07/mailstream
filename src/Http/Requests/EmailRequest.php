<?php
namespace Mailstream\Quickmail\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules() :array
    {
        return[
         'email' => 'required|email', 
         'mail_subject' => 'required|string',
         'mail_body'=>'string',
        ];
    }
}



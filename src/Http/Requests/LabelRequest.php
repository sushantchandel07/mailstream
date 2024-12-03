<?php
namespace Mailstream\Quickmail\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class LabelRequest extends FormRequest{

    public function authorize(): bool
    {
        return true;
    }

    public function rules() :array
    {
        return[
         'label' => 'required', 
        ];
    }
}
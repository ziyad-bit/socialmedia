<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:20|min:3',
            'abbr'      => 'required|string|max:5|min:2',
            'direction' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'you should enter name',
            'name.max'       => 'you should enter less than 20 characters',
            'email.required' => 'you should enter email',
            'email.min'      => 'you should enter more than 3 characters',
        ];
        
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'text'    => 'required|string|max:250',
            'post_id'    => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'    => 'this field is required',
            'max'         => 'you should enter less than 250 characters',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'text'=>filter_var($this->text,FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ]);
    }

}

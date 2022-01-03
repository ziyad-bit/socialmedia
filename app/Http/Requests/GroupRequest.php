<?php

namespace App\Http\Requests;

use App\Rules\ArrayAtLeastOneRequired;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'photo'  => 'required_without:photo_id|image|mimes:jpg,gif,jpeg,png|max:14',
            'status' => 'required',
        ];
    }
}

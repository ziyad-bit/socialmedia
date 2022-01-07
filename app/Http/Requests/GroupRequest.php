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
            'group.*.name'        => 'nullable|string|min:3|max:30',
            'group.*.description' => 'nullable|string|min:10|max:250',
            'photo'               => 'required_without:photo_id|image|mimes:jpg,gif,jpeg,png|max:14',
            'status'              => 'required_without:photo_id',
        ];
    }

    public function messages()
    {
        return [
            'group.*.name.min'        => 'you should enter at least 3 characters',
            'group.*.name.max'        => "you shouldn't enter more than 30 characters",
            'group.*.description.min' => 'you should enter at least 10 characters',
            'group.*.description.max' => "you shouldn't enter more than 250 characters",
            'required_without'        => "this field shouldn't be empty",
        ];
    }

}

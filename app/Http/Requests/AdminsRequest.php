<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AdminsRequest extends FormRequest
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
            'name'     => 'required_without:id|string|max:50|min:3',
            'email'    => 'required_without:id|email|max:50|min:10|unique:admins,email,' . Auth::user()->id,
            'password' => 'required_without:id|string|max:50|min:8',
            'photo'    => 'required_without:photo_id|image|mimes:jpg,gif,jpeg,png,webp|max:14',
        ];
    }

    public function messages()
    {
        return [
            'name.required_without'     => 'you should enter name',
            'name.max'                  => 'you should enter less than 20 characters',
            'email.required_without'    => 'you should enter email',
            'email.min'                 => 'you should enter more than 3 characters',
            'email.unique'              => 'this email is used',
            'password.required_without' => 'you should enter password',
            'password.min'              => 'you should enter more than 6 characters',
            'photo.required_without'    => 'you should select photo',
            'photo.image'               => 'photo is invalid',
        ];
        
    }

}

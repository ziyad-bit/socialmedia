<?php

namespace App\Http\Requests;

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
			'name'=>'required|string|min:3|max:30',
			'description'=>'required|string|min:10|max:250',
			'photo'=>'required_without:photo_id|image|mimes:jpg,gif,jpeg,png|max:14',
		];
	}

	public function messages()
	{
		return [
			'name.min'=>'you should enter at least 3 characters',
			'name.max'=>"you shouldn't enter more than 30 characters",
			'description.min'=>'you should enter at least 10 characters',
			'description.max'=>"you shouldn't enter more than 250 characters",
			'required_without'=>"this field shouldn't be empty",
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'name'=>filter_var($this->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'description'=>filter_var($this->description, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		]);
	}
}

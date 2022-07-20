<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
			'receiver_id'=>'required|numeric',
			'text'=>'required|string|max:250',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'text'=>filter_var($this->text, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		]);
	}
}

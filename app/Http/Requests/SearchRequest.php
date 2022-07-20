<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
			'search'=>'required|string|max:50',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'search'=>filter_var($this->search, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		]);
	}
}

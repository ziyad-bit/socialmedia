<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
			'text'=>'required|string|min:2|max:500',
			'video'=>'nullable|file|mimes:mp4,mov,flv,avi|max:1000000',
			'photo'=>'nullable|image|mimes:gif,png,jpg|max:100000',
			'group_id'=>'nullable|numeric',
			'file'=>'nullable|file|max:100000',
		];
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'text'=>filter_var($this->text, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		]);
	}
}

<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionsRequest extends FormRequest {

	/**
	 * Baboon Script By [it v 1.6.32]
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Baboon Script By [it v 1.6.32]
	 * Get the validation rules that apply to the request.
	 *
	 * @return array (onCreate,onUpdate,rules) methods
	 */
	protected function onCreate() {
		return [
             'question'=>'required|string',
             'category_id'=>'required|integer|exists:categories,id',
             'correct'=>'',
             'wrong1'=>'',
             'wrong2'=>'',
             'wrong3'=>'',
             'question_type'=>'required|in:true,false,multi',
		];
	}


	protected function onUpdate() {
		return [
             'question'=>'required|string',
             'category_id'=>'required|integer|exists:categories,id',
             'correct'=>'',
             'wrong1'=>'',
             'wrong2'=>'',
             'wrong3'=>'',
             'question_type'=>'required|in:true,false,multi',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	/**
	 * Baboon Script By [it v 1.6.32]
	 * Get the validation attributes that apply to the request.
	 *
	 * @return array
	 */
	public function attributes() {
		return [
             'question'=>trans('admin.question'),
             'category_id'=>trans('admin.category_id'),
             'correct'=>trans('admin.correct'),
             'wrong1'=>trans('admin.wrong1'),
             'wrong2'=>trans('admin.wrong2'),
             'wrong3'=>trans('admin.wrong3'),
             'question_type'=>trans('admin.question_type'),
		];
	}

	/**
	 * Baboon Script By [it v 1.6.32]
	 * response redirect if fails or failed request
	 *
	 * @return redirect
	 */
	public function response(array $errors) {
		return $this->ajax() || $this->wantsJson() ?
		response([
			'status' => false,
			'StatusCode' => 422,
			'StatusType' => 'Unprocessable',
			'errors' => $errors,
		], 422) :
		back()->withErrors($errors)->withInput(); // Redirect back
	}



}
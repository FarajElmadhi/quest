<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OnlineRequest extends FormRequest {

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
             'token1'=>'',
             'token2'=>'',
             'quest_id'=>'',
             'ans1'=>'',
             'ans2'=>'',
             'winner'=>'',
             'game_id'=>'',
		];
	}

	protected function onUpdate() {
		return [
             'token1'=>'',
             'token2'=>'',
             'quest_id'=>'',
             'ans1'=>'',
             'ans2'=>'',
             'winner'=>'',
             'game_id'=>'',
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
             'token1'=>trans('admin.token1'),
             'token2'=>trans('admin.token2'),
             'quest_id'=>trans('admin.quest_id'),
             'ans1'=>trans('admin.ans1'),
             'ans2'=>trans('admin.ans2'),
             'winner'=>trans('admin.winner'),
             'game_id'=>trans('admin.game_id'),
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
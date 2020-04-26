<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;
class AdminCrudRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest {
	/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'jenis' => 'required',
            'password' => 'required|min:6|foo_confirmation',
            'confirm_password' => 'required|min:6|foo_confirmation'
        ];
    }
}

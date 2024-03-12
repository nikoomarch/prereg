<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->method() == 'PUT')
        return [
            'name' => 'required',
            'family' => 'required',
            'username' => 'required|unique:users,username,' . $this->user->id,
            'national_code' => 'required|doesnt_start_with:0',
            'gender' => 'required',
            'entrance_term_id'=>'required|exists:terms,id',
            'is_allowed' => 'boolean'

        ];
        else
            return [
                'name' => 'required',
                'family' => 'required',
                'username' => 'required|unique:users,username',
                'national_code' => 'required|doesnt_start_with:0',
                'gender' => 'required',
                'entrance_term_id'=>'required|exists:terms,id',
                'is_allowed' => 'boolean'
            ];
    }
}

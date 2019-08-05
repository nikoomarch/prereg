<?php

namespace studentPreRegisteration\Http\Requests;

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
        return [
            'name' => 'required',
            'family' => 'required',
            'username' => 'required',
            'nationalCode' => 'required',
            'gender' => 'required_if:role,student',
            'field_id' => 'required'
        ];
    }
}

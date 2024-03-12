<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->method() == 'PUT')
            return [
                'name' => 'required',
                'family' => 'required',
                'username' => 'required|unique:users,username,' . $this->user->id,
                'confirm' => 'required_with:password|same:password',
                'field' => 'required|unique:fields,name,' . $this->user->field->id,
            ];
        else
            return [
                'name' => 'required',
                'family' => 'required',
                'username' => 'required|unique:users,username',
                'field' => 'required|unique:fields,name',
                'password' => 'required',
                'confirm' => 'required_with:password|same:password',
            ];

    }
}

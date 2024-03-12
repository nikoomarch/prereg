<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        if ($this->method() == 'POST')
            return [
                'name' => 'required|unique:courses,name,NULL,id,field_id,' . auth()->user()->field_id,
                'unit' => 'required|numeric'
            ];
        elseif ($this->method() == 'PUT')
            return [
                'name' => 'required|unique:courses,name,' . $this->course->id . ',id,field_id,' . auth()->user()->field_id,
                'unit' => 'required|numeric'
            ];
    }
}

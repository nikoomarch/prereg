<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectionRequest extends FormRequest
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
                'terms' => 'required',
                'field_id' => 'required',
                'max' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'term' => 'required|unique:selections,term,NULL,id,field_id,' . $this->input('field_id')
            ];
        else
            return [
                'terms' => 'required',
                'field_id' => 'required',
                'max' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'term' => 'required|unique:selections,term,'. $this->selection->id .',id,field_id,' . $this->input('field_id')
            ];
    }
}

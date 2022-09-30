<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'List_Classes.*.class_name' => 'required',
            'List_Classes.*.class_name_en' => 'required',
        ];
    }


    public function messages()
    {
        return [

            'class_name.required' => trans('validation.required'),
            'class_name.unique' => trans('validation.unique'),
            'class_name_en.required' => trans('validation.required'),
            'class_name_en.unique' => trans('validation.unique'),
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'nomeragazzo' => 'required|unique:clients,name'
        ];
    }

    public function messages(){
        return [
            'nomeragazzo.required' => 'Il nome del ragazzo è obbligatorio',
            'nomeragazzo.unique' => 'Il nome del ragazzo deve essere univoco'
        ];
    }
}

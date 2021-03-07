<?php

namespace App\Http\Requests;

use App\Dto\ActivityCreateDto;
use Illuminate\Foundation\Http\FormRequest;

final class AttivitaRequest extends FormRequest
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
            'nomeattivita' => 'required|unique:activities,name'
        ];
    }

    public function messages(){
        return [
            'nomeattivita.required' => 'Il nome dell\'attività è obbligatoria',
            'nomeattivita.unique' => 'Il nome dell\'attività deve essere univoca'
        ];
    }

    public function getDto() : ActivityCreateDto
    {
        return new ActivityCreateDto(
            $this->get('nomeattivita'),
            $this->get('costo'),
            $this->get('tipo')
        );
    }
}

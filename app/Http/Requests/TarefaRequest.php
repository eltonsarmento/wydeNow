<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TarefaRequest extends Request
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
    public function rules(){
        return [
            'texto'       => 'required|min:15'            
        ];
    }

    public function messages(){
        return [
            'required'       => 'O :attribute é obrigatório',            
        ];
    } 
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class crearAlumnoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dni' => ['required','numeric','max:999999999'],
            'nombre' => ['required','regex:/[a-zA-Z0-9\s]+/'],
            'apellido' => ['required','regex:/[a-zA-Z0-9\s]+/'],
            'fecha_nacimiento' => ['required','date'],
            'ciudad' => ['required'],
            'calle' => ['required','alpha_num'],
            'casa_numero' => ['required','numeric'],
            'dpto' => ['nullable'],
            'piso' => ['nullable'],
            'estado_civil' => ['required'],
            'email' => ['required'],
            'titulo_anterior' => ['nullable'],
            'becas' => ['nullable'],
            'observaciones' => ['nullable'],
            'telefono1' => ['nullable','numeric'],
            'telefono2' => ['nullable','numeric'],
            'telefono3' => ['nullable','numeric'],
            'codigo_postal' => ['required','numeric']
        ];
    }
}

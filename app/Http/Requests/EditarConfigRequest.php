<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarConfigRequest extends FormRequest
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
            'filas_por_tabla' => ['required'],
            'horas_habiles_inscripcion' => ['required','min:0'],
            'horas_habiles_desinscripcion' => ['required','min:0'],
            'fecha_inicial_rematriculacion' => ['required'],
            'fecha_final_rematriculacion' => ['required'],
            'anio_remat' => ['required'],
            'anio_ciclo_actual' => ['required'],
            'fecha_limite_desrematriculacion' => ['required'],
            'diferencia_llamados' => ['required']
        ];
    }
}

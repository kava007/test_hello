<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionRequest extends FormRequest
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
            'folio'          => 'required',          
            'cliente_id'     => 'required',
            'auto_id'        => 'required',
            'precio'         => 'required',
            'fecha_creacion' => 'required'
        ];
    }
}

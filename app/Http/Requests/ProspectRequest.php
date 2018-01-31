<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectRequest extends FormRequest
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
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'numTelPortable' => 'required',
            'nationalite' => 'required',
            'paysNaissance' => 'required',
            'departementNaissance' => 'required',
            'VilleDeNaissance' => 'required',
            'profession' => 'required',
            'revenusNetMensuel' => 'required',
            'adresse' => 'required',
            'codePostal' => 'required',
            'ville' => 'required',
            'NomBanque' => 'required'
        ];
    }
}

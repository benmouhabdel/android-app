<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ou utilisez une logique d'autorisation appropriée
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|required|string|min:5',
            'phone' => 'sometimes|nullable|string|max:20', // Ajout de la règle pour le champ 'phone'

            // Ajout des règles pour les nouveaux champs
            'annee' => 'sometimes|nullable|in:1,2,3,4,5', // Validation pour 'annee'
            'classe' => 'sometimes|nullable|string|max:255', // Validation pour 'classe'
            'filiere' => 'sometimes|nullable|in:IAM,Ingénierie,RH,Management,Finance,Marketing', // Validation pour 'filiere'
        ];
    }
}

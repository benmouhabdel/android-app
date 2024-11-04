<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ou utilisez une logique d'autorisation appropriée
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20', // Ajout de la règle pour le champ 'phone'

            // Ajout des règles pour les nouveaux champs
            'annee' => 'nullable|in:1,2,3,4,5', // Validation pour 'annee' avec les valeurs enum
            'classe' => 'nullable|string|max:255', // Validation pour 'classe'
            'filiere' => 'nullable|in:IAM,Ingénierie,RH,Management,Finance,Marketing', // Validation pour 'filiere' avec les valeurs enum
        ];
    }
}

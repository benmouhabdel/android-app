<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:12',
            'annee' => 'nullable|in:1,2,3,4,5', // Ajout des règles pour 'annee'
            'classe' => 'nullable|string|max:255', // Ajout des règles pour 'classe'
            'filiere' => 'nullable|in:IAM,Ingénierie,RH,Management,Finance,Marketing', // Ajout des règles pour 'filiere'
        ];

        // Vérifiez si la route actuelle est pour l'enregistrement d'un admin
        if ($this->route()->getName() !== 'register.admin') {
            $rules['registration_key'] = 'required|string|exists:registration_keys,key';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = Helper::sendError('Validation error', $validator->errors()->toArray());
        throw new HttpResponseException($response);
    }
}

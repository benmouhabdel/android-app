<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'image_url'=>$this->image_url,
            'annee' => $this->annee, // Ajout du champ 'annee'
            'classe' => $this->classe, // Ajout du champ 'classe'
            'filiere' => $this->filiere, // Ajout du champ 'filiere'
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'last_login' => $this->last_login ? $this->last_login->toDateTimeString() : null,
            'token' => $this->whenNotNull($this->currentAccessToken()?->plainTextToken),
        ];
    }
}

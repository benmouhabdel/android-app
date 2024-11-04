<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function profile()
    {
        // Implement logic for user profile
        return response()->json(['message' => 'Welcome to your profile!']);
    }


    public function listHouses()
    {
        $houses = [
            'Gryffindor',
            'Hufflepuff',
            'Ravenclaw',
            'Slytherin'
        ];
        return response()->json($houses);
    }

  
}

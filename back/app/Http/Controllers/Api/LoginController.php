<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import de la classe Log
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Utilisez le gardien 'web' pour authentifier l'utilisateur
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Email or Password is wrong'], 401);
        }

        // Obtenez l'utilisateur authentifié
        $user = Auth::guard('web')->user();

        if ($user instanceof \App\Models\User) {
            // Créez un token avec Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json(['error' => 'User instance not found'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Log::info('Tentative de déconnexion pour l\'utilisateur : ' . $request->user()->id);
            $request->user()->currentAccessToken()->delete();
            Log::info('Déconnexion réussie');
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur de déconnexion : ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la déconnexion'], 500);
        }
    }
}

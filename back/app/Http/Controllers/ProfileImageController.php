<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileImageController extends Controller
{
    /**
     * Update user's profile image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Récupérer l'utilisateur authentifié via le modèle User
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Supprimer l'ancienne image si elle existe
            if ($user->image_url) {
                Storage::disk('public')->delete($user->image_url);
            }

            // Stocker la nouvelle image
            $imagePath = $request->file('image')->store('profile-images', 'public');

            // Mettre à jour l'URL de l'image dans la base de données
            $user->image_url = $imagePath;
            $user->update();

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'image_url' => Storage::url($imagePath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove user's profile image
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage()
    {
        try {
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->image_url) {
                // Supprimer l'image du stockage
                Storage::disk('public')->delete($user->image_url);

                // Supprimer l'URL de l'image de la base de données
                $user->image_url = null;
                $user->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's profile image
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImage($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->image_url) {
                return response()->json([
                    'success' => true,
                    'image_url' => Storage::url($user->image_url)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image found for this user'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving image: ' . $e->getMessage()
            ], 500);
        }
    }
}

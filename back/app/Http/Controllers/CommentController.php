<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Liste tous les commentaires pour un post spécifique
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        return response()->json($post->comments, 200);
    }

    // Crée un nouveau commentaire pour un post spécifique
    public function store(Request $request, $postId)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json(['message' => 'User must be logged in to comment'], 401);
        }

        // Valide les champs
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Trouve le post associé
        $post = Post::findOrFail($postId);

        // Crée un nouveau commentaire
        $comment = new Comment();
        $comment->author = $validated['author'];
        $comment->content = $validated['content'];
        $comment->post()->associate($post);

        // Associe l'utilisateur connecté
        $comment->user_id = Auth::id();

        // Sauvegarde le commentaire
        $comment->save();

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }

    // Affiche un commentaire spécifique
    public function show($postId, $id)
    {
        $post = Post::findOrFail($postId);
        $comment = $post->comments()->findOrFail($id);
        return response()->json($comment, 200);
    }

    // Met à jour un commentaire spécifique
    public function update(Request $request, $postId, $id)
    {
        $post = Post::findOrFail($postId);
        $comment = $post->comments()->findOrFail($id);

        $validated = $request->validate([
            'author' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        // Mise à jour des champs validés
        $comment->update($validated);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    // Supprime un commentaire spécifique
    public function destroy($postId, $id)
    {
        $post = Post::findOrFail($postId);
        $comment = $post->comments()->findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }
}

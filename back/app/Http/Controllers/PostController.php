<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    // Récupérer les posts avec l'utilisateur associé et les commentaires
    return Post::with(['user', 'comments'])->get();
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'image_url' => 'nullable|string',
        ]);

        $post = new Post();
        $post->description = $validated['description'];
        $post->image_url = $validated['image_url'] ?? null;
        $post->user_id = auth()->id(); // Associer l'utilisateur connecté
        $post->save();

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }


    public function show($id)
{
    // Inclure l'utilisateur et les relations nécessaires
    $post = Post::with(['user', 'comments', 'likes'])->findOrFail($id);
    $likesCount = $post->likes->where('is_like', true)->count();
    $dislikesCount = $post->likes->where('is_like', false)->count();

    return response()->json([
        'post' => $post,
        'likes' => $likesCount,
        'dislikes' => $dislikesCount,
    ]);
}

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(null, 204);
    }

    public function like(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $like = Like::updateOrCreate(
            ['user_id' => $request->user()->id, 'post_id' => $id],
            ['is_like' => $request->input('is_like')]
        );

        return response()->json($like, 200);
    }
}

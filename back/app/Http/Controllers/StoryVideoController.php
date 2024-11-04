<?php

namespace App\Http\Controllers;

use App\Models\StoryVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StoryVideoController extends Controller
{
    public function index()
    {
        Log::info('StoryVideoController index method called');
        $storyVideos = StoryVideo::all();
        return response()->json($storyVideos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',
            'image_url' => 'nullable|url', // Ajout de validation pour image_url
        ]);

        $storyVideo = StoryVideo::create($request->all());
        return response()->json($storyVideo, 201);
    }

    public function show($id)
    {
        $storyVideo = StoryVideo::findOrFail($id);
        return response()->json($storyVideo);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'video_url' => 'url',
            'image_url' => 'nullable|url', // Ajout de validation pour image_url
        ]);

        $storyVideo = StoryVideo::findOrFail($id);
        $storyVideo->update($request->all());
        return response()->json($storyVideo);
    }

    public function destroy($id)
    {
        $storyVideo = StoryVideo::findOrFail($id);
        $storyVideo->delete();
        return response()->json(null, 204);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimetypes:video/mp4|max:100000', // 100MB max
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $path = $file->store('videos', 'public');
            $url = Storage::url($path);

            return response()->json(['url' => $url], 201);
        }

        return response()->json(['error' => 'No video file provided'], 400);
    }

    // Nouvelle méthode pour l'upload de l'image
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimetypes:image/jpeg,image/png|max:10000', // 10MB max
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $url = Storage::url($path);

            return response()->json(['url' => $url], 201);
        }

        return response()->json(['error' => 'No image file provided'], 400);
    }
}

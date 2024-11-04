<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\{
    LoginController, RegisterController};
use Illuminate\Auth\Events\Logout;
use App\Http\Controllers\StoryVideoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\ProfileImageController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[LoginController::class,'login']);
Route::post('register/user', [RegisterController::class, 'register']);
Route::post('register/admin', [RegisterController::class, 'registerAdmin'])->name('register.admin');
Route::post('logout', [LoginController::class, 'logout']);

Route::middleware([
    "auth:sanctum",
    "role:admin",
])->controller(AdminController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'store');
    Route::put('/users/{id}', 'update');
    Route::delete('/users/{id}', 'destroy');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('story-videos', [StoryVideoController::class, 'index']);
    Route::post('story-videos', [StoryVideoController::class, 'store']);
    Route::get('story-videos/{id}', [StoryVideoController::class, 'show']);
    Route::put('story-videos/{id}', [StoryVideoController::class, 'update']);
    Route::delete('story-videos/{id}', [StoryVideoController::class, 'destroy']);
    Route::post('upload-video', [StoryVideoController::class, 'uploadVideo']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Afficher tous les posts avec les commentaires
    Route::get('/posts', [PostController::class, 'index']);

    // Créer un nouveau post
    Route::post('/posts', [PostController::class, 'store']);

    // Afficher un post spécifique avec les commentaires et les likes
    Route::get('/posts/{id}', [PostController::class, 'show']);

    // Mettre à jour un post spécifique
    Route::put('/posts/{id}', [PostController::class, 'update']);

    // Supprimer un post spécifique
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // Aimer ou ne pas aimer un post spécifique
    Route::post('/posts/{id}/like', [PostController::class, 'like']);
});
Route::middleware('auth:sanctum')->group(function () {
    // Liste tous les commentaires pour un post spécifique
    Route::get('/posts/{postId}/comments', [CommentController::class, 'index']);

    // Créer un nouveau commentaire pour un post spécifique
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store']);

    // Afficher un commentaire spécifique
    Route::get('/posts/{postId}/comments/{id}', [CommentController::class, 'show']);

    // Mettre à jour un commentaire spécifique
    Route::put('/posts/{postId}/comments/{id}', [CommentController::class, 'update']);

    // Supprimer un commentaire spécifique
    Route::delete('/posts/{postId}/comments/{id}', [CommentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    // ... autres routes existantes ...

    // Routes pour la gestion des images de profil
    Route::post('/profile/image', [ProfileImageController::class, 'updateImage']);
    Route::delete('/profile/image', [ProfileImageController::class, 'deleteImage']);
    Route::get('/user/{userId}/image', [ProfileImageController::class, 'getImage']);
});

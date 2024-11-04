<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class AdminController extends Controller
{
    // Get all users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Get a specific user
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return new UserResource($user);
        }
        return response()->json(['error' => 'User not found'], 404);
    }

    // Create a new user
    public function store(CreateUserRequest $request)
{
    $user = User::create($request->validated());
    return response()->json($user, 201);
}

public function update(UpdateUserRequest $request, $id)
{
    $user = User::findOrFail($id);
    $user->update($request->validated());
    return response()->json($user);
}

    // Update a user


    // Delete a user
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }
        return response()->json(['error' => 'User not found'], 404);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('hobbies')->get();
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->all();
        
        if ($request->hasFile('profilePic')) {
            $path = $request->file('profilePic')->store('profilePics');
            $validatedData['profilePic'] = $path;
        }

        $user = User::create($validatedData);

        // Attach hobbies
        if ($request->hobbies) {
            $user->hobbies()->attach($request->hobbies);
        }

        return response()->json($user);
    }

  
}


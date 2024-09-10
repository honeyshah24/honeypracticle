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
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->contactNumber = $request->input('contactNumber');
        $user->gender = $request->input('gender');
        
        if ($request->hasFile('profilePic')) {
            $file = $request->file('profilePic');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $user->profilePic = $filename;
        }

        $user->save();
        $user->hobbies()->sync($request->input('hobbies'));
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }

}


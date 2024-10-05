<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        // dd("hello");
        return view('auth.register');
    }

    public function store()
    {
        // dd("To do!");
        // dd(request()->all());
        // Validate the request data
        $attributes = request()->validate([
            'first_name' => ['required'], // Fixed typo here
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'], // Added unique validation
            'password' => ['required', Password::min(6), 'confirmed']
        ]);

        // Hash the password before saving
        $attributes['password'] = Hash::make($attributes['password']);

        // Create the user
        $user = User::create($attributes);

        // Log the user in
        Auth::login($user);

        // Redirect to the desired route
        return redirect('/jobs');

        //     //from fixed by ChatGPT
        //     // Validate the request data
        //     $validatedData = request()->validate([
        //         'first_name' => ['required'],
        //         'last_name' => ['required'],
        //         'email' => ['required', 'email', 'unique:users,email'],
        //         'password' => ['required', Password::min(6), 'confirmed']
        //     ]);

        //     // Create a new user
        //     $user = User::create([
        //         'first_name' => $validatedData['first_name'],
        //         'last_name' => $validatedData['last_name'],
        //         'email' => $validatedData['email'],
        //         'password' => Hash::make($validatedData['password']) // Hash the password before saving
        //     ]);

        //     // Log the user in
        //     Auth::login($user);

        //     // Redirect to the desired route
        //     return redirect('/jobs');
    }
}

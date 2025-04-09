<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function edit()
{
    return view('profile.edit', ['user' => auth()->user()]);
}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
    ]);

    auth()->user()->update($request->only('name', 'email'));

    return back()->with('status', 'Profile updated!');
}

}

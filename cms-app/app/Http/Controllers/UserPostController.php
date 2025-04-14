<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class UserPostController extends Controller
{
    /**
     * Display a listing of the user's post.
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('userposts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('userposts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                // Prevents duplicate titles for the same user
                function ($attribute, $value, $fail) {
                    if (Post::where('user_id', auth()->id())->where('title', $value)->exists()) {
                        $fail('You have already used this title.');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Sanitize input
        $validated['title'] = strip_tags($validated['title']);
        $validated['description'] = strip_tags($validated['description'] ?? '');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('myposts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(string $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('userposts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($post) {
                    if (Post::where('user_id', auth()->id())
                        ->where('title', $value)
                        ->where('id', '!=', $post->id)
                        ->exists()) {
                        $fail('You already have another post with this title.');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Sanitize input
        $validated['title'] = strip_tags($validated['title']);
        $validated['description'] = strip_tags($validated['description'] ?? '');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('myposts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $post->delete();

        return redirect()->route('myposts.index')->with('success', 'Post deleted successfully!');
    }
}

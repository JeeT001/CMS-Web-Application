<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class UserPostController extends Controller
{
    /**
     * Display a listing of the user's posts.
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
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
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) {
                    if (Post::where('user_id', auth()->id())->where('title', $value)->exists()) {
                        $fail('You have already used this title.');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Sanitize inputs
        $validated['title'] = strip_tags($validated['title']);
        $validated['description'] = strip_tags($validated['description'] ?? '');

        // Handle file upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('dashboard')->with('success', 'Post created and shown on your dashboard!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(string $id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('userposts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'title' => [
                'required', 'string', 'max:255',
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

        // Sanitize inputs
        $validated['title'] = strip_tags($validated['title']);
        $validated['description'] = strip_tags($validated['description'] ?? '');

        // Handle file upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        // Redirect to dashboard after update
        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $post->delete();

        // Redirect to dashboard after deletion
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}

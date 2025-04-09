<x-app-layout>
    <div class="container">
        <h1>Edit Post</h1>

        <form action="{{ route('myposts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description" required>{{ old('description', $post->description) }}</textarea>
            </div>

            <div>
                <label>Current Image</label><br>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" width="150">
                @endif
            </div>

            <div>
                <label>Change Image</label>
                <input type="file" name="image">
            </div>

            <button type="submit">Update Post</button>
        </form>
    </div>
</x-app-layout>

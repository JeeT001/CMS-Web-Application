<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- My Posts Section --}}
            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold">My Posts</h2>
                        <a href="{{ route('myposts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">+ Create Post</a>
                    </div>

                    @if($posts->isEmpty())
                        <p class="text-gray-600">You haven't created any posts yet.</p>
                    @else
                        @foreach ($posts as $post)
                            <article class="border p-4 mb-4 rounded">
                                <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                                <p class="text-gray-700">{{ $post->description }}</p>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-48 mt-2 rounded">
                                @endif
                                <div class="mt-2 flex gap-4">
                                    <a href="{{ route('myposts.edit', $post->id) }}" class="text-blue-500">Edit</a>
                                    <form method="POST" action="{{ route('myposts.destroy', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </section>

        </div>
    </section>
</x-app-layout>

<script>
    // Handle image upload form submission
    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this); // Collect form data

        // Send POST request to the server
        const response = await fetch('/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        const result = await response.json();

        // Show upload result to the user
        if (response.ok) {
            document.getElementById('uploadResult').textContent = 'Upload successful! Path: ' + result.path;
        } else {
            document.getElementById('uploadResult').textContent = 'Upload failed.';
        }
    });
</script>

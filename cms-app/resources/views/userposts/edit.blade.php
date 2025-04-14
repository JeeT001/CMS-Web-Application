<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Post</h2>
    </x-slot>

    <section class="py-6 max-w-3xl mx-auto">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
                <strong class="block font-bold mb-2">Whoops! Something went wrong:</strong>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Post Edit Form --}}
        <form action="{{ route('myposts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block font-semibold mb-1">Title:</label>
                <input 
                    type="text" 
                    name="title" 
                    class="border p-2 w-full rounded" 
                    value="{{ old('title', $post->title) }}" 
                    required
                >
            </div>

            {{-- Description --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Description:</label>
                <textarea 
                    name="description" 
                    class="border p-2 w-full rounded" 
                    rows="4" 
                    required
                >{{ old('description', $post->description) }}</textarea>
            </div>

            {{-- Current Image --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Current Image:</label>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" width="150" class="rounded mt-1">
                @else
                    <p class="text-gray-600">No image uploaded.</p>
                @endif
            </div>

            {{-- Change Image --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Change Image:</label>
                <input 
                    type="file" 
                    name="image" 
                    class="border p-2 w-full rounded"
                >
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit" 
                class="mt-6 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
            >
                Update Post
            </button>
        </form>

    </section>
</x-app-layout>

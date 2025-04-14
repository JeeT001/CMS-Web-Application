<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
    </x-slot>

    <section class="py-6 max-w-3xl mx-auto">

        {{-- Validation Error Messages --}}
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

        {{-- Post Creation Form --}}
        <form action="{{ route('myposts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div>
                <label class="block font-semibold mb-1">Title:</label>
                <input 
                    type="text" 
                    name="title" 
                    class="border p-2 w-full rounded" 
                    value="{{ old('title') }}" 
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
                >{{ old('description') }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div class="mt-4">
                <label class="block font-semibold mb-1">Image:</label>
                <input 
                    type="file" 
                    name="image" 
                    class="border p-2 w-full rounded"
                >
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit" 
                class="mt-6 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
            >
                Submit
            </button>
        </form>

    </section>
</x-app-layout>

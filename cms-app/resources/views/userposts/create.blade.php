<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
    </x-slot>

    <div class="py-6">
        <form action="{{ route('myposts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label>Title:</label>
                <input type="text" name="title" class="border p-2 w-full">
            </div>
            <div class="mt-2">
                <label>Description:</label>
                <textarea name="description" class="border p-2 w-full"></textarea>
            </div>
            <div class="mt-2">
                <label>Image:</label>
                <input type="file" name="image" class="border p-2 w-full">
            </div>
            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Submit</button>
        </form>
    </div>
</x-app-layout>

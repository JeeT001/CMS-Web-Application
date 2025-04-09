<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Posts</h2>
    </x-slot>

    <div class="py-6">
        <a href="{{ route('myposts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">New Post</a>
        <div class="mt-4">
            @foreach ($posts as $post)
                <div class="p-4 border mb-4">
                    <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                    <p>{{ $post->description }}</p>
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-48 mt-2">
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('myposts.edit', $post->id) }}" class="text-blue-500">Edit</a>
                        <form method="POST" action="{{ route('myposts.destroy', $post->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

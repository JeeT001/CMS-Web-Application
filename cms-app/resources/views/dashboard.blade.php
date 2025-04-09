<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <form id="uploadForm" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required class="mb-2">
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Upload Image</button>
</form>

<div id="uploadResult" class="mt-4 text-green-600 font-semibold"></div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const response = await fetch('/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        const result = await response.json();

        if (response.ok) {
            document.getElementById('uploadResult').textContent = 'Upload successful! Path: ' + result.path;
        } else {
            document.getElementById('uploadResult').textContent = 'Upload failed.';
        }
    });
</script>


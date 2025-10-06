<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('作品編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('comics.show', $comic) }}" class="text-blue-500 hover:text-blue-700 mr-2">詳細に戻る</a>
                    <form method="POST" action="{{ route('comics.update', $comic) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit image</label>
                            <span class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">現在の画像</span>
                            @if($comic->image)
                            <img src="{{ asset('storage/' . $comic->image)}}" alt="{{$comic->title}}の画像" class="md-2">
                            @else
                            <p class="border">画像なし</p>
                            @endif
                            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('description')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit title</label>
                            <input type="text" name="title" id="title" value="{{ $comic->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('title')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            <label for="author" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit author</label>
                            <input type="text" name="author" id="author" value="{{ $comic->author }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('author')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            <label for="publisher" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit publisher</label>
                            <input type="text" name="publisher" id="publisher" value="{{ $comic->publisher }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('publisher')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Edit description</label>
                            <input type="text" name="description" id="description" value="{{ $comic->description }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('description')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
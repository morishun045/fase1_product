<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('作品追加') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form method="POST" action="{{ route('comics.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
              <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">作品名</label>
              <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('title')
              <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-4">
              <label for="author" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">作者</label>
              <input type="text" name="author" id="author" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('author')
              <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-4">
              <label for="publisher" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">出版社</label>
              <input type="text" name="publisher" id="publisher" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('publisher')
              <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-4">
              <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">あらすじ</label>
              <input type="text" name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('description')
              <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-4">
              <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">画像</label>
              <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('image')
              <span class="text-red-500 text-xs italic">使用できない画像です</span>
              @enderror
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded border focus:outline-none focus:shadow-outline">追加</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
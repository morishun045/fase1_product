<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('作品一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($comics as $comics)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
             @if($comics->image)
                <img src="{{ asset('storage/' . $comics->image)}}" alt="{{$comics->title}}の画像" class="w-100">
            @else
                <p class="border">画像なし</p>
            @endif
            <p class="text-gray-800 dark:text-gray-300">{{ $comics->title }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">作者: {{ $comics->author }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">出版社: {{ $comics->publisher }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">あらすじ: {{ $comics->description }}</p>
            <a href="{{ route('comics.show', $comics) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('作品一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="mb-4">
            {{ $comics->appends(request()->input())->links() }}
          </div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($comics as $comic)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
             @if($comic->image)
                <img src="{{ asset('storage/' . $comic->image)}}" alt="{{$comic->title}}の画像" class="w-100">
            @else
                <p class="border">画像なし</p>
            @endif
            <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $comic->title }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">作者: {{ $comic->author }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">出版社: {{ $comic->publisher }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">あらすじ: {{ $comic->description }}</p>
            <a href="{{ route('comics.show', $comic) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
            <div class="flex">
              @if ($comic->liked->contains(auth()->id()))
              <form action="{{ route('comics.dislike', $comic) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-500 hover:text-gray-700"> お気に入り登録済み★{{$comic->liked->count()}}</button>
              </form>
              @else
              <form action="{{ route('comics.like', $comic) }}" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700"> 
                  お気に入り登録☆{{$comic->liked->count()}}
                </button>
              </form>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('作品詳細')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('comics.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        @if($comic->image)
                        <img src="{{ asset('storage/' . $comic->image)}}" alt="{{$comic->title}}の画像" class="w-100">
                        @else
                        <p class="border">画像なし</p>
                        @endif
                        <p class="text-gray-800 dark:text-gray-300 text-lg">作品名: {{ $comic->title }}</p>
                        @if ($comic->comments->isNotEmpty())
                        @php
                        $averageRating = $comic->comments->avg('rating');
                        $roundedAverage = round($averageRating);
                        @endphp
                        <div class="flex items-center mb-4">
                            <p class="text-lg text-yellow-400" title="平均評価: {{ number_format($averageRating, 1) }}">
                                {{ str_repeat('★', $roundedAverage) . str_repeat('☆', 5 - $roundedAverage) }}
                            </p>
                            <p class="ml-2 text-gray-600 dark:text-gray-400 font-semibold">{{ number_format($averageRating, 1) }}</p>
                        </div>
                        @endif
                        <p class="text-gray-600 dark:text-gray-400 text-sm">作者: {{ $comic->author }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">出版社: {{ $comic->publisher }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">あらすじ: {{ $comic->description }}</p>
                        <div class="text-gray-600 dark:text-gray-400 text-sm">
                            <p>作成日時: {{ $comic->created_at->format('Y-m-d H:i') }}</p>
                            <p>更新日時: {{ $comic->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="flex mt-4">
                            <a href="{{ route('comics.edit', $comic) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
                            <form action="{{ route('comics.destroy', $comic) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                            </form>
                        </div>
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
                        @if($existReview)
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-400 ml-4">review {{ $comic->comments->count() }}</p>
                            <a href="{{ route('comics.comments.edit', ['comic' => $comic, 'comment' => $existReview]) }}" class="text-blue-500 hover:text-blue-700 mr-2">レビューを編集する</a>
                        </div>
                        @else
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-400 ml-4">review {{ $comic->comments->count() }}</p>
                            <a href="{{ route('comics.comments.create', $comic) }}" class="text-blue-500 hover:text-blue-700 mr-2">レビューする</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <div class="mt-4">
                                @foreach ($comic->comments as $comment)
                                <a href="{{ route('profile.show', $comment->user) }}">
                                    <p>{{ $comment->user->name }} </p>
                                </a>
                                <p>{{ $comment->comment }} </p>
                                <p class="text-yellow-400 my-1 text-lg">
                                    {{ str_repeat('★', $comment->rating) . str_repeat('☆', 5 - $comment->rating) }}
                                </p>
                                <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
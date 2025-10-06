<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('comics.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
                    <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $user->name }}</p>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">
                        <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <p class="text-lg text-gray-900 dark:text-gray-100">
                                フォロー情報
                            </p>
                            <div class="mt-4 space-x-6">
                                <a href="{{ route('profile.following', $user) }}" class="text-blue-500 hover:underline">
                                    フォロー中: {{ $user->following()->count() }}人
                                </a>
                                <span>
                                    フォロワー: {{ $user->followers()->count() }}人
                                </span>
                            </div>
                        </div>
                    </div>
                    @if ($user->id !== auth()->id())
                    <div class="text-gray-900 dark:text-gray-100">
                        @if ($user->followers->contains(auth()->id()))
                        <form action="{{ route('follow.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">unFollow</button>
                        </form>
                        @else
                        <form action="{{ route('follow.store', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-700">follow</button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    お気に入り登録した漫画
                </h2>

                <div class="mt-6">
                    @if ($user->likes->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($user->likes as $comic)
                        <a href="{{ route('comics.show', $comic) }}" class="group">
                            <div class="overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                @if($comic->image)
                                <img src="{{ asset('storage/' . $comic->image) }}" alt="{{ $comic->title }}の画像" class="w-100 h-48 object-cover group-hover:opacity-75 transition-opacity">
                                @else
                                <div class="w-100 h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500">画像なし</span>
                                </div>
                                @endif
                                <div class="p-4 bg-gray-50 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate group-hover:text-blue-500">
                                        {{ $comic->title }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        お気に入り登録した漫画はまだありません。
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('作品検索') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg-px-8">
            <div class="mb-6 p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <form action="{{ route('comics.search') }}" method="GET">
                    <div class="flex items-center">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="作品タイトルで検索..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">検索</button>
                    </div>
                </form>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($comics as $comic)
                        <div class="mb-4 p-4 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-gray-800 dark:text-gray-300 text-lg font-semibold">{{ $comic->title }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">作者: {{ $comic->author }}</p>
                            <a href="{{ route('comics.show', $comic) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                        </div>
                    @empty
                        <p>検索結果が見つかりませんでした。</p>
                    @endforelse
                </div>
            </div>

            {{-- ページネーションリンク --}}
            @if ($comics->hasPages())
            <div class="mt-4">
                {{ $comics->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('レビュー作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('comics.show', $comic) }}" class="text-blue-500 hover:text-blue-700 mr-2">作品詳細に戻る</a>
                    <form method="POST" action="{{ route('comics.comments.store', $comic) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="comment" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">レビュー</label>
                            <textarea name="comment" id="comment" raw="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('comment') }}</textarea>
                            @error('comment')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <div x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0 }" class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">評価</label>
                            <div class="flex items-center">
                                <template x-for="star in 5">
                                    <svg @click="rating = star" @mouseenter="hoverRating = star" @mouseleave="hoverRating = 0"
                                        class="w-8 h-8 cursor-pointer transition-colors duration-150"
                                        :class="star <= (hoverRating || rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                </template>
                            </div>
                            <input type="hidden" name="rating" :value="rating">
                            @error('rating')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">レビューする</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
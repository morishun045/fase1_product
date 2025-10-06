<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}さんがフォロー中のユーザー
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($users as $followed_user)
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            {{-- ユーザー名とプロフィールへのリンク --}}
                            <a href="{{ route('profile.show', $followed_user) }}" class="font-bold hover:underline">
                                {{ $followed_user->name }}
                            </a>
                        </div>
                    @empty
                        <p>フォロー中のユーザーはいません。</p>
                    @endforelse

                    {{-- ページネーション --}}
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

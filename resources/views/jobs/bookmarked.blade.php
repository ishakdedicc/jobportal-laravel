<x-layout>

    <section class="max-w-7xl mx-auto px-6 pt-4 pb-8">

        {{-- Section header --}}
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-semibold text-gray-900">
                Saved Jobs
            </h2>

            <p class="text-gray-600 mt-1 max-w-xl mx-auto">
                Jobs you bookmarked to review or apply to later.
            </p>
        </div>

        {{-- Job grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @forelse ($bookmarks as $bookmark)
                <x-job-card :job="$bookmark" />
            @empty
                <p class="text-center text-gray-500 col-span-3">
                    You haven’t saved any jobs yet.
                </p>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($bookmarks->hasPages())
            <div class="flex justify-center">
                {{ $bookmarks->links() }}
            </div>
        @endif

    </section>

</x-layout>

<x-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- TITLE -->
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            All Jobs
        </h1>

        <!-- JOBS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-12">
                    No jobs found.
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="mt-8 flex justify-center">
            {{ $jobs->links() }}
        </div>

    </div>
</x-layout>

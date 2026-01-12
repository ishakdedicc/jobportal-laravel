<x-layout>

    <section class="max-w-7xl mx-auto px-6 py-10">

        {{-- Section header --}}
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-semibold text-gray-900">
                Latest Job Opportunities
            </h2>

            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">
                Browse recently posted jobs from trusted employers and apply with confidence.
            </p>
        </div>

        {{-- Job grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            @forelse($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <p class="text-center col-span-3 text-gray-500">
                    No jobs available at the moment.
                </p>
            @endforelse
        </div>

        {{-- CTA --}}
        <div class="text-center mb-14">
            <a
                href="{{ route('jobs.index') }}"
                class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-900 font-medium"
            >
                View all jobs
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>

        {{-- Bottom banner --}}
        <x-bottom-banner />

    </section>

</x-layout>

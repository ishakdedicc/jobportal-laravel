@props(['job'])

<div class="relative bg-white rounded-2xl p-6 border border-gray-100
            hover:border-indigo-300 transition group flex flex-col h-full">

    {{-- Accent line --}}
    <div class="absolute left-0 top-6 h-12 w-1 rounded-r
        {{ $job->remote ? 'bg-green-500' : 'bg-indigo-500' }}">
    </div>

    {{-- Header --}}
    <div class="flex items-start gap-4 mb-4">
        @if ($job->company?->logo)
            <img
                src="{{ asset('storage/' . $job->company->logo) }}"
                alt="{{ $job->company->name }}"
                class="w-10 h-10 object-contain rounded-md"
            />
        @endif

        <div class="flex-1">
            <h2 class="text-lg font-semibold text-gray-900 leading-snug">
                {{ $job->title }}
            </h2>
            <p class="text-xs uppercase tracking-wide text-gray-400 mt-1">
                {{ $job->job_type }}
            </p>
        </div>
    </div>

    {{-- Description --}}
    <p class="text-sm text-gray-600 leading-relaxed mb-6">
        {{ \Illuminate\Support\Str::limit($job->description, 110) }}
    </p>

    {{-- Meta --}}
    <div class="mt-auto space-y-3">

        <div class="flex justify-between text-sm">
            <span class="text-gray-500">
                📍 {{ optional($job->location)->city }}
            </span>

            <span class="font-semibold text-gray-900">
                ${{ number_format($job->salary) }}
            </span>
        </div>

        <div class="flex items-center justify-between">
            <span class="px-3 py-1 text-xs rounded-full font-medium
                {{ $job->remote
                    ? 'bg-green-50 text-green-700'
                    : 'bg-indigo-50 text-indigo-700' }}">
                {{ $job->remote ? 'Remote position' : 'On-site role' }}
            </span>

            <a
                href="{{ route('jobs.show', $job->id) }}"
                class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition"
            >
                View → 
            </a>
        </div>

    </div>
</div>


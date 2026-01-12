@props([
    'heading' => 'Hiring made simple',
    'subheading' => 'Create a job listing and connect with qualified candidates in minutes.'
])

<section class="max-w-7xl mx-auto px-6 my-12">
    <div class="bg-linear-to-r from-blue-900 to-blue-800 text-white rounded-xl p-6 md:p-8
                flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-lg">

        <div class="max-w-xl">
            <h2 class="text-2xl font-semibold tracking-tight">
                {{ $heading }}
            </h2>

            <p class="text-blue-200 text-base md:text-lg mt-2">
                {{ $subheading }}
            </p>
        </div>

        <x-button-link
            url="/jobs/create"
            icon="edit"
            class="bg-white text-blue-900 hover:bg-blue-100"
        >
            Post a Job
        </x-button-link>
    </div>
</section>

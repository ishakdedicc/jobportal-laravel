@props([
    'heading' => 'Build Your Career with Confidence',
    'subheading' => 'Explore verified job opportunities and apply in minutes.'
])

<section class="bg-linear-to-r from-blue-900 via-blue-800 to-blue-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-semibold tracking-tight">
            {{ $heading }}
        </h2>

        <p class="text-blue-200 text-base md:text-lg mt-2 max-w-2xl mx-auto">
            {{ $subheading }}
        </p>
    </div>
</section>

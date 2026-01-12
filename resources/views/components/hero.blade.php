@props(['title' => 'Find Your Dream Job'])

<section
    class="relative h-80 md:h-96 bg-cover bg-center"
    style="background-image: url('{{ asset('images/hero.jpg') }}')"
>
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Content --}}
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full">

            <div class="max-w-3xl">
                <h2 class="text-4xl md:text-5xl font-semibold text-white mb-6 leading-tight">
                    {{ $title }}
                </h2>

                <x-search />
            </div>

        </div>
    </div>
</section>

<x-layout>

    <section class="min-h-[70vh] flex items-center justify-center px-6">

        <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            {{-- Header --}}
            <div class="mb-6 text-center">
                <h2 class="text-3xl font-semibold text-gray-900">
                    Welcome back
                </h2>

                <p class="text-gray-500 mt-1 text-sm">
                    Sign in to your JobPortal account
                </p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-4">
                @csrf

                <x-inputs.text
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Email address"
                    autocomplete="username"
                />

                <x-inputs.text
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password"
                    autocomplete="current-password"
                />

                <button
                    type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2.5 rounded-lg font-medium transition"
                >
                    Sign in
                </button>
            </form>

            {{-- Footer --}}
            <p class="mt-6 text-center text-sm text-gray-500">
                Don’t have an account?
                <a
                    href="{{ route('register') }}"
                    class="text-blue-700 hover:text-blue-900 font-medium"
                >
                    Create one
                </a>
            </p>

        </div>

    </section>

</x-layout>

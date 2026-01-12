<x-layout>
    <div class="min-h-[70vh] flex items-center justify-center px-6">

        <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            <div class="mb-6 text-center">
                <h2 class="text-3xl font-semibold text-gray-900">
                    Create your account
                </h2>
                <p class="text-gray-500 mt-1">
                    Join JobPortal and start applying today
                </p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                <x-inputs.text
                    id="name"
                    name="name"
                    placeholder="Full name"
                    autocomplete="name"
                />

                <x-inputs.text
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Email address"
                    autocomplete="email"
                />

                <x-inputs.text
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password"
                    autocomplete="new-password"
                />

                <x-inputs.text
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Confirm password"
                    autocomplete="new-password"
                />

                <button
                    type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2.5 rounded-lg font-medium transition"
                >
                    Create account
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-gray-500">
                Already have an account?
                <a
                    href="{{ route('login') }}"
                    class="text-blue-700 hover:text-blue-900 font-medium"
                >
                    Login
                </a>
            </p>

        </div>

    </div>
</x-layout>

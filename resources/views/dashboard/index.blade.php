<x-layout>
    <section class="max-w-7xl mx-auto px-6 pt-4 pb-10">

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- PROFILE INFO --}}
            <aside class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm p-6">

                <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">
                    Profile Settings
                </h3>

                @if($user->avatar)
                    <div class="flex justify-center mb-4">
                        <img
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="{{ $user->name }}"
                            class="w-28 h-28 rounded-full object-cover ring-2 ring-blue-600"
                        >
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                    enctype="multipart/form-data"
                    class="space-y-4"
                >
                    @csrf
                    @method('PUT')

                    <x-inputs.text
                        id="name"
                        name="name"
                        label="Name"
                        :value="$user->name"
                    />

                    <x-inputs.text
                        id="email"
                        name="email"
                        label="Email"
                        type="email"
                        :value="$user->email"
                    />

                    <x-inputs.file
                        id="avatar"
                        name="avatar"
                        label="Profile photo"
                    />

                    <button
                        type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2.5 rounded-lg font-medium"
                    >
                        Save changes
                    </button>
                </form>
            </aside>

            {{-- JOB LISTINGS --}}
            <main class="w-full lg:w-2/3 bg-white rounded-xl shadow-sm p-6">

                <h3 class="text-xl font-semibold text-gray-900 mb-6">
                    My Job Listings
                </h3>

                @forelse($jobs as $job)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">

                        {{-- JOB HEADER --}}
                        <div class="flex justify-between items-start gap-4 mb-3">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    {{ $job->title }}
                                </h4>
                                <p class="text-sm text-gray-600">
                                    {{ $job->job_type }} ·
                                    {{ $job->location->city }},
                                    {{ $job->location->state }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ route('jobs.edit', $job->id) }}"
                                    class="text-blue-700 text-sm font-medium hover:underline"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('jobs.destroy', $job->id) }}"
                                    onsubmit="return confirm('Delete this job?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 text-sm hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- APPLICANTS --}}
                        <div class="bg-white rounded-lg p-4">

                            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-700 mb-4">
                                Applicants
                            </h5>

                            @forelse($job->applicants as $applicant)
                                <div data-applicant-row class="pb-4 mb-4 border-b border-gray-200 last:border-0 last:mb-0 last:pb-0">
                                    <p class="text-sm">
                                        <span class="font-medium">Name:</span>
                                        {{ $applicant->full_name }}
                                    </p>

                                    <p class="text-sm text-gray-600">
                                        {{ $applicant->contact_email }}
                                    </p>

                                    @if($applicant->contact_phone)
                                        <p class="text-sm text-gray-600">
                                            {{ $applicant->contact_phone }}
                                        </p>
                                    @endif

                                    @if($applicant->message)
                                        <p class="text-sm text-gray-700 mt-2">
                                            {{ $applicant->message }}
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-4 mt-3">
                                        <a
                                            href="{{ asset('storage/' . $applicant->resume_path) }}"
                                            download
                                            class="text-blue-700 text-sm font-medium hover:underline"
                                        >
                                            <i class="fas fa-download mr-1"></i>
                                            Resume
                                        </a>

                                        <a
                                            href="#"
                                            class="text-red-600 text-sm hover:underline"
                                            data-delete-applicant
                                            data-applicant-id="{{ $applicant->id }}"
                                        >
                                            Remove
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">
                                    No applicants yet.
                                </p>
                            @endforelse

                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">
                        You haven’t posted any jobs yet.
                    </p>
                @endforelse

            </main>

        </div>

        <x-bottom-banner />

    </section>
</x-layout>

<x-layout>
    <x-slot name="title">Edit Job</x-slot>

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="bg-white mx-auto p-8 rounded-xl shadow-sm w-full md:max-w-3xl">

            {{-- Header --}}
            <div class="text-center mb-10">
                <h2 class="text-3xl font-semibold text-gray-900">
                    Edit Job Listing
                </h2>
                <p class="text-gray-500 mt-1">
                    Update your job details and keep your listing accurate.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('jobs.update', $job->id) }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                {{-- JOB INFO --}}
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Job Information
                    </h3>

                    <x-inputs.text
                        id="title"
                        name="title"
                        label="Job Title"
                        :value="old('title', $job->title)"
                    />

                    <x-inputs.textarea
                        id="description"
                        name="description"
                        label="Description"
                        :value="old('description', $job->description)"
                    />

                    <x-inputs.text
                        id="salary"
                        name="salary"
                        type="number"
                        label="Salary"
                        :value="old('salary', $job->salary)"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-inputs.select
                            id="job_type"
                            name="job_type"
                            label="Job Type"
                            :options="[
                                'Full-Time' => 'Full-Time',
                                'Part-Time' => 'Part-Time',
                                'Contract' => 'Contract'
                            ]"
                            :value="old('job_type', $job->job_type)"
                        />

                        <x-inputs.select
                            id="remote"
                            name="remote"
                            label="Remote"
                            :options="[0 => 'No', 1 => 'Yes']"
                            :value="old('remote', $job->remote)"
                        />
                    </div>

                    <x-inputs.textarea
                        id="requirements"
                        name="requirements"
                        label="Requirements"
                        :value="old('requirements', $job->requirements)"
                    />

                    <x-inputs.textarea
                        id="benefits"
                        name="benefits"
                        label="Benefits"
                        :value="old('benefits', $job->benefits)"
                    />
                </div>

                {{-- LOCATION --}}
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Location
                    </h3>

                    <x-inputs.text
                        id="address"
                        name="address"
                        label="Address"
                        :value="old('address', $job->location->address)"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-inputs.text
                            id="city"
                            name="city"
                            label="City"
                            :value="old('city', $job->location->city)"
                        />

                        <x-inputs.text
                            id="state"
                            name="state"
                            label="State"
                            :value="old('state', $job->location->state)"
                        />

                        <x-inputs.text
                            id="zipcode"
                            name="zipcode"
                            label="Zip Code"
                            :value="old('zipcode', $job->location->zipcode)"
                        />
                    </div>
                </div>

                {{-- COMPANY INFO --}}
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Company Information
                    </h3>

                    <x-inputs.text
                        id="company_name"
                        name="company_name"
                        label="Company Name"
                        :value="old('company_name', $job->company->name)"
                    />

                    <x-inputs.textarea
                        id="company_description"
                        name="company_description"
                        label="Company Description"
                        :value="old('company_description', $job->company->description)"
                    />

                    <x-inputs.text
                        id="company_website"
                        name="company_website"
                        label="Company Website"
                        type="url"
                        :value="old('company_website', $job->company->website)"
                    />

                    <x-inputs.file
                        id="company_logo"
                        name="company_logo"
                        label="Company Logo"
                        accept="image/*"
                    />
                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center gap-4">
                    <button
                        type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2.5 rounded-lg font-semibold"
                    >
                        Save Changes
                    </button>

                    <a
                        href="{{ route('jobs.show', $job->id) }}"
                        class="w-full text-center py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</x-layout>

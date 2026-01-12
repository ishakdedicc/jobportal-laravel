<x-layout>
    <x-slot name="title">Create Job</x-slot>

    <section class="max-w-7xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-semibold text-gray-900">
                Create a Job Listing
            </h1>
            <p class="text-gray-600 mt-1">
                Fill in the details below to publish your job post.
            </p>
        </div>

        <div class="bg-white max-w-3xl mx-auto p-8 rounded-xl shadow-sm">

            <form method="POST"
                  action="{{ route('jobs.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- JOB INFO --}}
                <div class="mb-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Job Information
                    </h2>

                    <x-inputs.text
                        id="title"
                        name="title"
                        label="Job Title"
                        placeholder="Software Engineer"
                    />

                    <x-inputs.textarea
                        id="description"
                        name="description"
                        label="Description"
                        placeholder="Describe the role and responsibilities"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-inputs.text
                            id="salary"
                            name="salary"
                            type="number"
                            label="Salary"
                        />

                        <x-inputs.select
                            id="job_type"
                            name="job_type"
                            label="Job Type"
                            :options="[
                                'Full-Time' => 'Full-Time',
                                'Part-Time' => 'Part-Time',
                                'Contract' => 'Contract'
                            ]"
                        />
                    </div>

                    <x-inputs.select
                        id="remote"
                        name="remote"
                        label="Remote Work"
                        :options="[0 => 'No', 1 => 'Yes']"
                    />

                    <x-inputs.textarea
                        id="requirements"
                        name="requirements"
                        label="Requirements"
                    />

                    <x-inputs.textarea
                        id="benefits"
                        name="benefits"
                        label="Benefits"
                    />
                </div>

                {{-- LOCATION --}}
                <div class="mb-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Location
                    </h2>

                    <x-inputs.text id="address" name="address" label="Address" />

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-inputs.text id="city" name="city" label="City" />
                        <x-inputs.text id="state" name="state" label="State" />
                        <x-inputs.text id="zipcode" name="zipcode" label="Zip Code" />
                    </div>
                </div>

                {{-- COMPANY INFO --}}
                <div class="mb-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Company Information
                    </h2>

                    <x-inputs.text
                        id="company_name"
                        name="company_name"
                        label="Company Name"
                    />

                    <x-inputs.textarea
                        id="company_description"
                        name="company_description"
                        label="Company Description"
                    />

                    <x-inputs.text
                        id="company_website"
                        name="company_website"
                        label="Company Website"
                        type="url"
                    />

                    <x-inputs.file
                        id="company_logo"
                        name="company_logo"
                        label="Company Logo"
                        accept="image/*"
                    />
                </div>

                {{-- SUBMIT --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-lg font-semibold"
                    >
                        Publish Job
                    </button>
                </div>

            </form>
        </div>

    </section>
</x-layout>

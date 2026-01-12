<x-layout>
    <section class="max-w-7xl mx-auto px-6 pt-4 pb-10">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- LEFT CONTENT --}}
            <section class="md:col-span-3 space-y-6">

                {{-- JOB HEADER --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">

                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('jobs.index') }}"
                           class="text-sm text-blue-700 hover:text-blue-900 flex items-center">
                            <i class="fa fa-arrow-left mr-2"></i>
                            Back to jobs
                        </a>

                        @can('update', $job)
                            <div class="flex gap-2">
                                <a href="{{ route('jobs.edit', $job->id) }}"
                                   class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('jobs.destroy', $job->id) }}"
                                      onsubmit="return confirm('Delete this job?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <h1 class="text-2xl font-semibold text-gray-900 mb-2">
                        {{ $job->title }}
                    </h1>

                    <p class="text-gray-600 leading-relaxed mb-5">
                        {{ $job->description }}
                    </p>

                    <ul class="bg-gray-50 rounded-lg p-4 space-y-2 text-sm text-gray-700">
                        <li><strong>Job type:</strong> {{ $job->job_type }}</li>
                        <li><strong>Remote:</strong> {{ $job->remote ? 'Yes' : 'No' }}</li>
                        <li><strong>Salary:</strong> ${{ number_format($job->salary) }}</li>
                        <li>
                            <strong>Location:</strong>
                            {{ $job->location->city }},
                            {{ $job->location->state }}
                        </li>
                    </ul>
                </div>

                {{-- JOB DETAILS --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Job details
                    </h3>

                    @if ($job->requirements)
                        <h4 class="text-sm uppercase tracking-wide text-blue-700 font-semibold mb-1">
                            Requirements
                        </h4>
                        <p class="text-gray-600 mb-4">
                            {{ $job->requirements }}
                        </p>
                    @endif

                    @if ($job->benefits)
                        <h4 class="text-sm uppercase tracking-wide text-blue-700 font-semibold mb-1">
                            Benefits
                        </h4>
                        <p class="text-gray-600">
                            {{ $job->benefits }}
                        </p>
                    @endif

                    @if(!$job->requirements && !$job->benefits)
                        <p class="text-gray-500">
                            No additional details provided.
                        </p>
                    @endif
                </div>

                {{-- APPLY CTA --}}
                @auth
                    @if($isApplied)
                        <button
                            class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold cursor-not-allowed opacity-90"
                            disabled>
                            ✅ Application submitted
                        </button>
                    @else
                        <button
                            type="button"
                            data-open-apply
                            class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-lg font-semibold shadow-sm">
                            Apply now
                        </button>
                    @endif
                @else
                    <p class="bg-gray-100 text-gray-600 p-4 rounded-lg text-center">
                        Please log in to apply for this job.
                    </p>
                @endauth

            </section>

            {{-- SIDEBAR --}}
            <aside class="bg-white p-6 rounded-xl shadow-sm">

                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Company
                </h3>

                @if ($job->company->logo)
                    <img
                        src="{{ asset('storage/' . $job->company->logo) }}"
                        alt="{{ $job->company->name }}"
                        class="w-full rounded-lg bg-gray-50 p-3 mb-4"
                    />
                @endif

                <h4 class="font-semibold text-gray-900">
                    {{ $job->company->name }}
                </h4>

                @if ($job->company->description)
                    <p class="text-gray-600 text-sm leading-relaxed my-3">
                        {{ $job->company->description }}
                    </p>
                @endif

                @if ($job->company->website)
                    <a href="{{ $job->company->website }}"
                       target="_blank"
                       class="text-sm text-blue-700 hover:underline">
                        Visit company website
                    </a>
                @endif

                {{-- BOOKMARK --}}
                @auth
                    <form
                        method="POST"
                        action="{{ $isBookmarked ? route('bookmarks.destroy', $job->id) : route('bookmarks.store', $job->id) }}"
                        class="mt-6">
                        @csrf
                        @if($isBookmarked)
                            @method('DELETE')
                            <button
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm">
                                <i class="fas fa-bookmark mr-2"></i>
                                Remove bookmark
                            </button>
                        @else
                            <button
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                                <i class="fas fa-bookmark mr-2"></i>
                                Save job
                            </button>
                        @endif
                    </form>
                @endauth

                {{-- MAP --}}
                <div id="map"
                     class="w-full h-56 rounded-lg mt-6 border border-gray-200"></div>
            </aside>

        </div>
    </section>

    {{-- APPLY MODAL --}}
    <div id="applyModal"
         class="fixed inset-0 hidden bg-black/50 items-center justify-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-xl relative">
            <button id="closeApply"
                    class="absolute top-3 right-4 text-gray-400 text-xl">&times;</button>

            <h3 class="text-xl font-semibold mb-4">
                Apply for {{ $job->title }}
            </h3>

            <div id="applyError"
                 class="hidden bg-red-100 text-red-800 p-3 rounded mb-4"></div>
            <div id="applySuccess"
                 class="hidden bg-green-100 text-green-800 p-3 rounded mb-4"></div>

            <form id="applyForm"
                  data-job-id="{{ $job->id }}"
                  enctype="multipart/form-data">
                @csrf

                <x-inputs.text id="full_name" name="full_name" label="Full name" required />
                <x-inputs.text id="contact_email" name="contact_email" label="Email" required />
                <x-inputs.text id="contact_phone" name="contact_phone" label="Phone" />
                <x-inputs.textarea id="message" name="message" label="Message" />
                <x-inputs.file id="resume" name="resume" label="Resume (PDF)" required />

                <button
                    id="submitApplicationBtn"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded-lg mt-4 font-semibold">
                    Submit application
                </button>
            </form>
        </div>
    </div>

</x-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (typeof mapboxgl === 'undefined') return;

  const mapContainer = document.getElementById('map');
  if (!mapContainer) return;

  mapboxgl.accessToken = "{{ config('services.mapbox.key') }}";

  const city = @json($job->location->city);
  const state = @json($job->location->state);
  if (!city || !state) return;

  const address = `${city}, ${state}`;

  fetch(`/geocode?address=${encodeURIComponent(address)}`)
    .then(res => res.json())
    .then(data => {
      if (!data?.features?.length) return;

      const [lng, lat] = data.features[0].center;

      // 2️⃣ ONDA inicijalizuj mapu
      const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [lng, lat],
        zoom: 14,
      });

      map.on('load', () => {
        map.resize();

        new mapboxgl.Marker()
          .setLngLat([lng, lat])
          .addTo(map);
      });
    })
    .catch(console.error);
});
</script>


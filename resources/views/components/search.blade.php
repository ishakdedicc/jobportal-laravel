<form
    method="GET"
    action="{{ route('jobs.search') }}"
    class="mx-5 flex flex-col gap-2 md:mx-auto md:flex-row md:items-center md:gap-2"
>
    <input
    type="text"
    name="keywords"
    placeholder="Keywords"
    value="{{ request('keywords') }}"
    class="w-full md:w-72 px-4 py-3 border bg-white text-gray-800
           placeholder-gray-400
           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
           focus:outline-none"
    />


    <input
        type="text"
        name="location"
        placeholder="Location"
        value="{{ request('location') }}"
        class="w-full md:w-72 px-4 py-3 border bg-white text-gray-800
           placeholder-gray-400
           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
           focus:outline-none"
    />

    <button
        type="submit"
        class="w-full md:w-auto bg-blue-700 hover:bg-blue-600 text-white px-4 py-3"
    >
        <i class="fa fa-search mr-1"></i> Search
    </button>
</form>

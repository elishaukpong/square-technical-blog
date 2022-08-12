<x-app-layout>

    <div class="max-w-xl mb-10 md:mx-auto sm:text-center lg:max-w-2xl md:mb-40">

        <h2 class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
      <span class="relative inline-block">
        <svg viewBox="0 0 52 24" fill="currentColor" class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 text-blue-gray-100 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block">
          <defs>
            <pattern id="db164e35-2a0e-4c0f-ab05-f14edc6d4d30" x="0" y="0" width=".135" height=".30">
              <circle cx="1" cy="1" r=".7"></circle>
            </pattern>
          </defs>
          <rect fill="url(#db164e35-2a0e-4c0f-ab05-f14edc6d4d30)" width="52" height="24"></rect>
        </svg>
      </span>
            Blog Posts @if(request()->has('search')) - Filtered @endif
        </h2>

    </div>

    <div class="w-full mb-4 md:mr-0 sm:text-center md:mb-4 flex justify-end">
        <form action="{{url()->current()}}">
            <p>Sort By Publication Date: </p>
            <input type="hidden" name="order" value="publication_date">
            <select name="direction" class="block mt-1 w-full">
                <option value="asc" @if(request()->direction == 'asc') selected @endif>Ascending</option>
                <option value="desc" @if(request()->direction == 'desc') selected @endif>Descending</option>
            </select>

            <button class="w-full items-center justify-center h-12 px-6 font-medium mt-2 text-white transition duration-200 rounded shadow-md bg-deep-purple-accent-400 hover:bg-deep-purple-accent-700 focus:shadow-outline focus:outline-none">
                Sort
            </button>
        </form>
    </div>


    <x-posts :posts="$entities"/>

</x-app-layout>

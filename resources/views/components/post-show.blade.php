@props(['post'])

<div class="max-w-xl md:mx-auto sm:text-center lg:max-w-2xl">
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
        {{$post->title}}
    </h2>

    <div class="mb-4 sm:text-center ">
        <div>
            <p  data-text="{{$post->author->name}}, {{$post->author->dateJoined}}" class="tooltip-text font-semibold text-gray-800 transition-colors duration-200 hover:text-deep-purple-accent-700">
                {{$post->author->name}}</p>
            <p class="text-sm font-medium leading-4 text-gray-600">Author</p>
        </div>
    </div>
    <p class="mb-2 text-xs font-semibold tracking-wide text-gray-600 uppercase sm:text-center">
        {{$post->datePosted}}
    </p>

</div>


<div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:pt-10 lg:pb-10">

    <div class="lg:w-1/2 py-10  mx-auto mb-5">
        <p class="text-base text-gray-700 text-center ">
            {!! $post->body !!}
        </p>
    </div>

    <hr class="">

</div>


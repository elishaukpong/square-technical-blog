@props(['posts'])

@if(! $posts->count())
    <h2 class=" text-center max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">No Posts Yet</h2>

    <div class="text-center mt-4">
        <a href="{{route('admin.posts.create')}}"
           class="inline-flex items-center justify-center w-full h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md md:w-auto bg-deep-purple-accent-400 hover:bg-deep-purple-accent-700 focus:shadow-outline focus:outline-none">
            Create Post
        </a>
    </div>

@else

    <div class="grid max-w-sm gap-5 mb-8 lg:grid-cols-3 sm:mx-auto lg:max-w-full">
        @foreach($posts as $post)
            <div class="px-10 py-20 text-center border rounded lg:px-5 lg:py-10 xl:py-20">
                <p class="mb-2 text-xs font-semibold tracking-wide text-gray-600 uppercase">
                    {{$post->datePosted}}
                </p>
                <div class="">
                    <x-badge class="bg-black text-white mx-2">
                        {{$post->author->name}}
                    </x-badge>
                </div>
                <p class="inline-block max-w-xs mx-auto mb-3 text-2xl font-extrabold leading-7 transition-colors duration-200 hover:text-deep-purple-accent-400" aria-label="Read article" title="{{$post->shortText}}">
                    {{$post->title}}
                </p>
                <p class="max-w-xs mx-auto mb-2 text-gray-700">
                    {{$post->shortBody}}
                </p>
                <a href="{{route('show.post',$post->slug)}}" aria-label="" class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">Read more</a>
            </div>
        @endforeach
    </div>

    @if(method_exists($posts, 'links'))
        <div class="my-5">
            {{$posts->appends(request()->input())->links()}}
        </div>
    @endif

@endif


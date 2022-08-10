<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts
        </h2>
    </x-slot>


    <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-60">
        <h2>Create Post</h2>

        <form method="POST" action="{{ route('admin.posts.store') }}" class="py-16">
        @csrf

            <div>
                <x-label for="title" :value="__('Name')" />

                <x-input
                    id="title"
                    class="block mt-1 w-full"
                    type="text"
                    name="title"
                    :value="old('title')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="text" :value="__('Body')" />

                <x-text-area
                    id="text"
                    class="block mt-1 w-full"
                    rows="10"
                    name="body"
                    required />
            </div>

            <div class="mt-4">
                <x-label for="publication_date" :value="__('Publication Date')" />

                <x-input
                    id="publication_date"
                    class="block mt-1 w-full"
                    type="date"
                    name="publication_date"
                    :value="old('publication_date')"
                    required />

                <x-input
                    type="hidden"
                    name="user_id"
                    value="{{auth()->id()}}"/>

            </div>

            <hr class="mt-5">

            <div class="flex items-center justify-end mt-4  text-center">
                <x-button class="w-full md:inline-block mx-4">
                    Create Post
                </x-button>
            </div>
        </form>
    </div>

</x-dashboard-layout>

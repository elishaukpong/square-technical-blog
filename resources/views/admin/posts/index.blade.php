<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts

            <x-badge :href="route('admin.post.create')" class="bg-teal-accent-400 text-teal-900">
                Create
            </x-badge>
        </h2>
    </x-slot>

    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
        <x-posts :posts="$entities"/>
    </div>

</x-dashboard-layout>

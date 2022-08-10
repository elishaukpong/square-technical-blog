<x-app-layout>

    <x-slot name="meta">
        <meta name="title" content="{{$entity->title}}">
        <meta name="body" content="{{$entity->shortBody}}">
    </x-slot>

    <x-post-show :post="$entity"/>

</x-app-layout>

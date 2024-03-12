<x-layout.baseLayout>
    <x-slot name="links">
    </x-slot>
    <x-slot name="content">
    </x-slot>
    <x-slot name="floatingButtons">
        @auth()
            <x-extras.backButton :backTo="$backTo"/>
        @endauth
    </x-slot>
    <x-slot name="scripts">
        @include('home._homeScript')
    </x-slot>
</x-layout.baseLayout>

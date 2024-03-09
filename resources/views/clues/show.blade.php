<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
        <script>
            showPopup(
                `{{__('Estás en modo previsualización. Podrás ver lo que los participantes de tu búsqueda verán al escanear su código.')}}`,
                `{{__('Mostrando pista:').' '.ucwords($clue->title)}}`,
                'success'
            )
        </script>
        @include('home._homeScript')
    </x-slot>
</x-layout.baseLayout>

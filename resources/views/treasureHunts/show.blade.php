<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
        <div class="row g-5">
            <div class="col-12 d-flex justify-content-center">
                <div class="paperCard max-width-lg w-100">
                    <div class="d-flex justify-content-center gap-2 align-items-center">
                        <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-book"></i></span>
                        <h1 class="display-4 d-inline-block m-0">{{__('Búsqueda del Tesoro')}}</h1>
                    </div>
                </div>
            </div>
            <x-treasureHunt.treasureHuntInformation :treasureHunt="$treasureHunt">
                <x-slot name="content">
                    @include('clues.index')
                </x-slot>
            </x-treasureHunt.treasureHuntInformation>
        </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
        <x-treasureHunt.deleteConfirmationScript/>
        <x-clue.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

        <div class="row g-5 justify-content-center">
            <div class="col-12 max-width-md">
                <article class="paperCard">
                    <div class="">
                        <i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-note-sticky"></i>
                        <h1 class="d-inline-block">{{__('Añadiendo Pista')}} {{count($treasureHunt->clues)+1}}<span class="text-body"> {{__('a')}}: {{$treasureHunt->title}}</span></h1>
                    </div>
                    <x-clue.clueForm :method="'create'" :treasureHunt="$treasureHunt" :clue="null"/>
                </article>
            </div>
        </div>

    </x-slot>
    <x-slot name="floatingButtons">
        @include('components.extras.backButton')
    </x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

        <div class="row g-5 justify-content-center">
            <div class="col-12 max-width-md">
                <article class="paperCard">
                    <div>
                        <i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-note-sticky"></i>
                        <h1 class="d-inline-block">{{__('Editando Pista')}} {{$clue->title}}<span class="text-body fs-4"> {{__('en')}} {{$clue->treasure_hunt->title}}</span></h1>
                    </div>
                    <x-clue.clueForm :clue="$clue" :method="'update'"/>
                </article>
            </div>
        </div>

    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
{{--        <a href="{{route('treasureHunt.show',['treasureHunt'=>$clue->treasure_hunt->id])}}" class="btn btn-primary">--}}
{{--            <i class="fa-solid fa-angle-left"></i>--}}
{{--            {{__('Volver a').' '.$clue->treasure_hunt->title}}--}}
{{--        </a>--}}
    </x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

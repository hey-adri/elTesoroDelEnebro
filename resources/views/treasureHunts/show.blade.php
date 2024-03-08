<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
        <div class="row">
            <x-treasureHunt.treasureHuntInformation :treasureHunt="$treasureHunt">
                <x-slot name="content">
                    <article class="paperCard max-width-lg w-100 mt-5">
                        <h1 class=" mt-2">{{__('Pistas Asociadas')}}</h1>
                        <x-extras.searchFilter :tooltip="__('Buscar por título de la Búsqueda del Tesoro o el Título de sus Pistas...')"/>
                        <hr>
                        @if(count($clues)>0)
                            <div class="treasureHuntsContainer row justify-content-evenly align-items-stretch row-cols-1">
                                <div class="my-4">
                                    {{$clues->appends(request()->all())->links()}}
                                </div>
                                @foreach($clues as $clue)
                                    <div class="col py-3">
                                        <x-clue.clueInformationCompact :clue="$clue"/>
                                    </div>
                                @endforeach
                                <div class="my-4">
                                    {{$clues->appends(request()->all())->links()}}
                                </div>
                            </div>
                        @else
                            <x-extras.nothingFound :text="__('Parece que no hay ninguna pista por aquí...')"/>
                            <a class="btn btn-outline-primary w-100" href="{{route('clue.create',['treasureHunt'=>$treasureHunt->id])}}"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-note-sticky"></i> {{__('Añadir Pista')}}</a>
                        @endif
                    </article>
                </x-slot>
            </x-treasureHunt.treasureHuntInformation>
        </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <a href="{{route('userArea.index')}}" class="btn btn-primary">
            <i class="fa-solid fa-angle-left"></i>
            {{__('Volver a Área Personal')}}
        </a>
    </x-slot>
    <x-slot name="scripts">
        <x-treasureHunt.deleteConfirmationScript/>
        <x-clue.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

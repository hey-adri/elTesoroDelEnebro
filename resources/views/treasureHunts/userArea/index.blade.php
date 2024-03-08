<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
      <div class="row g-5">
            <x-user.userInformation :user="auth()->user()"></x-user.userInformation>
            <section class="treasureHuntsSection">
                <div class="col-12 d-flex justify-content-center">
                    <article class="paperCard max-width-lg w-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-2 mb-4">
                            <h1 class="paperCardTitle d-inline-block">{{__('Tus Búsquedas del Tesoro')}}</h1>
                            <a href="{{route('treasureHunt.create')}}" class="btn btn-outline-primary"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</a>
                        </div>
                        <x-extras.searchFilter :tooltip="__('Buscar por título de la Búsqueda del Tesoro o el Título de sus Pistas...')"/>
                        <hr>
                        @if(count($treasure_hunts))
                        <div class="treasureHuntsContainer row justify-content-evenly align-items-stretch row-cols-1 row-cols-sm-2 row-cols-lg-3">
                            @foreach($treasure_hunts as $treasureHunt)
                                <div class="col py-3">
                                    <x-treasureHunt.treasureHuntInformationCompact :treasureHunt="$treasureHunt"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="my-4">
                            {{$treasure_hunts->appends(request()->all())->links()}}
                        </div>
                        @else
                            <x-extras.nothingFound :text="__('Parece que no hay ninguna Búsqueda del Tesoro por aquí...')"/>
                            <div class="row mt-4">
                                <div class="col">
                                    <a href="{{route('treasureHunt.create')}}" class="btn btn-outline-primary w-100"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</a>
                                </div>
                            </div>
                        @endif
                    </article>
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">
        <x-treasureHunt.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

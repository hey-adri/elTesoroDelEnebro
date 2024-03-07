<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <x-treasureHunt.treasureHuntForm :method="'create'" :treasureHunt="null"></x-treasureHunt.treasureHuntForm>
                    </article>
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <a href="{{route('userArea.index')}}" class="btn btn-primary">
            <i class="fa-solid fa-angle-left"></i>
            {{__('Volver al Área Personal')}}
        </a>
    </x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

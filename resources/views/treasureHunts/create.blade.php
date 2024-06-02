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
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

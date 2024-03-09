<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
        <div class="row">
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

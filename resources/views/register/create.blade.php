<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <x-user.createUserForm :adminFeatures="false"/>
                    </article>
                </div>
                <div class="p-2 mt-5 d-flex justify-content-center">
                    <img src="{{asset('/assets/img/logos/logoPrimary.svg')}}" class="img-fluid max-width-60" alt="" srcset="">
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

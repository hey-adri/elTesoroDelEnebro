<x-layout.baseLayout>
    <x-slot name="links">
        {{--  Recaptcha Call  --}}
        {!! RecaptchaV3::initJs() !!}
    </x-slot>
    <x-slot name="content">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <x-user.createUserForm :adminFeatures="false"/>
                    </article>
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>

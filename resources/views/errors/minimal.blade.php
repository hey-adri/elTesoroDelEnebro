<!DOCTYPE html>
<x-layout.baseLayout>
    <x-slot name="links">
    </x-slot>
    <x-slot name="content">

        <div class="row justify-content-center my-5">
            <div class="col-12 d-flex flex-column justify-content-center max-width-sm">
                <span class="fs-6 mb-0 d-block fw-light text-center">@yield('title')</span>
                <x-extras.nothingFound :text="null"/>
                <span class="display-1 mb-4 mt-0 d-block fw-bolder text-center">@yield('code')</span>
                <a class="btn btn-outline-primary" href="{{route('home')}}"><i class="fa-solid fa-home"></i>{{__('Home')}}</a>
            </div>
        </div>

    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="[
                'route'=>route('home'),
                'icon'=>'fa-house',
                'name'=>__('Home')
            ]"/>
    </x-slot>
    <x-slot name="scripts">
    </x-slot>
</x-layout.baseLayout>




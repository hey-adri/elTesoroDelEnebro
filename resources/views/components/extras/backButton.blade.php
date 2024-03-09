@props(['backTo'])
<a href="{{$backTo['route']}}" class="btn btn-primary">
    <div class="d-flex ">
        <i class="fa-solid fa-angle-left me-1"></i>
        <i class="fa-solid {{$backTo['icon']}} ms-0"></i>
        <div class="ms-2">
            {{__('Volver a')}}
            <span class="fw-semibold text-decoration-underline">{{ucwords($backTo['name'])}}</span>
        </div>
    </div>
</a>

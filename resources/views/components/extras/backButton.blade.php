@props(['backTo'])
<a href="{{$backTo['route']}}" class="btn border-0 glassButton rounded-4 growOnHover">
    <div class="d-flex flex-nowrap">
        <i class="fa-solid fa-angle-left me-1"></i>
        <i class="fa-solid {{$backTo['icon']}} ms-0"></i>
        <div class="ms-2 text-truncate small max-width-150">
            <span class="fw-bold align-middle">{{ucwords($backTo['name'])}}</span>
        </div>
    </div>
</a>

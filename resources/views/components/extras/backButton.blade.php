@props(['backTo'])
<div class="bg-body rounded-4">
    <a href="{{$backTo['route']}}" class="btn btn-outline-primary">
        <div class="d-flex flex-nowrap">
            <i class="fa-solid fa-angle-left me-1"></i>
            <i class="fa-solid {{$backTo['icon']}} ms-0"></i>
            <div class="ms-2 text-truncate small max-width-150">
                <span class="fw-semibold text-decoration-underline">{{ucwords($backTo['name'])}}</span>
            </div>
        </div>
    </a>
</div>

<!-- ! Footer -->
<footer class="">
    <div class="d-none d-sm-block">
        <div class="mb-5 d-flex justify-content-center">
            <a href="{{route('home')}}" class="w-100 max-width-60">
                <img src="{{asset('/assets/img/logos/logoPrimary.svg')}}" class="img-fluid" alt="" srcset="">
            </a>
        </div>
    </div>
    <div class="py-3 shadow rounded rounded-top-4 text-center">
        <div class="container d-flex flex-column justify-content-center flex-sm-row gap-3 align-items-center">
            <a href="mailto:{{env('CONTACT_MAIL')}}" class="">
                {{__('Contacto')}}
            </a>
            <span class="d-none d-sm-inline">&#xb7;</span>
            <span class="text-muted">{{__('Una web de')}} <a href="https://heyadri.ddns.net/" target="_blank">Adrián García</a></span>
        </div>
    </div>
</footer>

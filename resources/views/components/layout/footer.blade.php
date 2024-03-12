<!-- ! Footer -->
<footer class="">
    <div>
        <div class="mb-5 d-flex justify-content-center">
            <img src="{{asset('/assets/img/logos/logoPrimary.svg')}}" class="img-fluid max-width-60" alt="" srcset="">
        </div>
    </div>
    <div class="py-3 shadow rounded rounded-top-4">
        <div class="container d-flex justify-content-center gap-4 align-items-center">
            <span class="text-muted">{{__('Una web de')}} <a href="https://heyadri.ddns.net/" target="_blank">Adrián García</a></span>
            &#xb7;
            <a href="mailto:{{env('ADMIN_MAIL')}}" class="">
                {{__('Contacto')}}
            </a>
        </div>
    </div>
</footer>

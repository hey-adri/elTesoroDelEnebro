<!-- ! Footer -->
<footer class="">
    <div class="d-none d-sm-block">
        <div class="mb-5 d-flex justify-content-center">
            <a href="{{route('home')}}" class="w-100 max-width-60">
                <img src="{{asset('/assets/img/logos/logoPrimary.svg')}}" class="img-fluid" alt="" srcset="">
            </a>
        </div>
    </div>
    <div class="py-3 shadow rounded rounded-top-4 text-center d-flex flex-column align-items-center px-2">
        <div class="container d-flex flex-column justify-content-center flex-sm-row gap-3 align-items-center">
            <a href="mailto:{{env('CONTACT_MAIL')}}" class="">
                {{__('Contacto')}}
            </a>
        </div>
        <div class="w-50 max-width-200">
            <hr>
        </div>
        <div class="container d-flex justify-content-center">
            <span class="text-muted"><small>© {{__('Una web de')}} <a href="https://heyadri.ddns.net/" target="_blank">Adrián García</a> • {{__('Todos los Derechos Reservados')}} • 2024</small></span>
        </div>
    </div>
</footer>

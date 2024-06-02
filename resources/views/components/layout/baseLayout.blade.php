<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('El Tesoro del Enebro')}}</title>
    <!-- Css -->
    <link rel="stylesheet" href="{{asset('/assets/css/modules/fontAwesome/fontawesome.css')}}">
    {{$links}}
    {{--  Custom CSS  --}}
    @vite('resources/sass/app.scss')

    {{--  Recaptcha Call  --}}
    {!! RecaptchaV3::initJs() !!}
</head>

<body>
<div id="topOfThePage"></div> <!-- Top of the page anchor -->
<div id="viewPort" class="d-flex flex-column min-vh-100 justify-content-between px-2">
   <x-layout.header/>
    <!-- ! Main Content -->
    <main class="flex-grow-1 d-flex flex-column justify-content-center z-0">
        <div class="container py-5">
            <!-- Content Here -->
            <div id="mainContent">
            {{$content}}
            </div>
        </div>
    </main>
    <x-layout.floatingButtons>
        <x-slot name="slot">
            {{$floatingButtons}}
        </x-slot>
    </x-layout.floatingButtons>
    <x-layout.footer/>
</div>
</body>
<!-- ! Scripts -->
<script src="{{asset('/assets/js/modules/jquery/jquery.js')}}"></script>
<script src="{{asset('/assets/js/modules/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/assets/js/modules/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('/assets/js/modules/fontAwesome/fontAwesome.min.js')}}"></script>
<script src="{{asset('/assets/js/modules/jqueryValidation/jquery.validate.min.js')}}"></script>
@if(app()->getLocale()!='en')
    {{-- Adding the validation messages localized --}}
    <script src="{{asset('/assets/js/modules/jqueryValidation/localization/messages_'.app()->getLocale().'.js')}}"></script>
@endif
<script src="{{asset('/assets/js/commonFunctions.js')}}"></script>


@if(session('popup'))
    <script>
        $(()=>{
            showPopup(
                '{{session('popup')['text']}}',
                '{{session('popup')['title']}}',
                '{{session('popup')['icon']}}'
            )
        })
    </script>
@endif

@if(session('toast'))
    <script>
        $(()=>{
            showToast(
                '{{session('toast')['text']}}',
                '{{session('toast')['icon']}}'
            )
        })
    </script>
@endif

@error('g-recaptcha-response')
    <script>
        $(()=>{
            showToast("{{__("¿Eres un humano?")}}",'error')
        })
    </script>
@enderror


{{$scripts}}

</html>

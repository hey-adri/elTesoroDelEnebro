@props(['user'])
<section class="userInfo">
    <div class="col-12 d-flex justify-content-center">
        <article class="paperCard max-width-lg w-100">
            <div class="row align-items-stretch">
                <div class="col-12 col-sm-5 d-flex align-items-center">
                    <div class="w-100">
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <div class="d-flex align-items-center">
                                <div class="userProfilePhoto roundPhoto max-width-60 mx-auto">
                                    <img class="" src="{{$user->profile_image}}">
                                </div>
                            </div>
                            <ul class="list-unstyled text-center text-md-start d-flex flex-column gap-1">
                                <li class="fs-6 fw-bold">{{$user->name}}</li>
                                <li class="small text-muted"><i class="fa-solid fa-user"></i>{{$user->username}}</li>
                                <li class="small text-muted"><i class="fa-solid fa-at"></i>{{$user->email}}</li>
                            </ul>
                        </div>
                        <div class="row row-cols-1 g-2">
                            <div class="col">
                                <a class="btn btn-outline-success btn-sm w-100" href="{{route('user.show',auth()->user())}}"
                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                   data-bs-title="{{__('Modifica tus Datos, Cambia tu Contraseña o Elimina tu Cuenta')}}"
                                ><i class="fa-solid fa-user-gear"></i></i> {{__('Gestionar Cuenta')}}</a>
                            </div>
                        </div>
                        <hr class="d-sm-none">
                    </div>
                </div>
                <div class="col-12 col-sm-7 d-flex align-items-center">
                    <div class="w-100 text-center d-flex flex-column flex-lg-row justify-content-evenly gap-1">
                        <div class="flex-grow-1 d-flex flex-column flex-xl-row align-items-center justify-content-center">
                            <span class="handwritten">{{__('Tus Búsquedas Del Tesoro')}}</span>
                            <span class="ms-2"><i class="fa-solid fa-book"></i>{{$user->treasure_hunts()->count()}}</span>
                        </div>
                        <hr class="d-lg-none">
                        <div class="vr d-none d-lg-block"></div>
                        <div class="flex-grow-1 d-flex flex-column flex-xl-row align-items-center justify-content-center">
                            <span class="handwritten">{{__('Tus Pistas')}}</span>
                            <span class="ms-2"><i class="fa-solid fa-note-sticky"></i>{{$user->clues()->count()}}</span>
                        </div>
                        <hr class="d-lg-none">
                        <div class="vr d-none d-lg-block"></div>
                        <div class="flex-grow-1 d-flex  flex-column align-items-center justify-content-center position-relative">
                            <span class="handwritten">{{__('Pistas Pro Utilizadas')}}</span>
                            <span class="{{(count($user->proClues())>0)?'badge-secondary':'badge'}} ms-2"><i class="fa-solid fa-note-sticky"></i>{{count($user->proClues())}} {{__('PRO')}} / {{$user->max_pro_clues}} {{__('MAX')}}</span>

                            <div class="badge mt-2"
                                 data-bs-toggle="tooltip" data-bs-placement="top"
                                 data-bs-title="{{__('Las Pistas Pro te permitirán adjuntar fotos y vídeos.')}}"
                            >
                                {{__('¿Qué son las Pistas Pro?')}}
                            </div>

                            <div class="badge mt-2"
                                 data-bs-toggle="tooltip" data-bs-placement="bottom"
                                 data-bs-title="{{__('Puedes eliminar las imágenes y vídeos de Pistas que ya no uses para que dejen de ser PRO.')}}"
                            >
                                {{__('¿Cómo puedo conseguir más?')}}
                            </div>

                        </div>
{{--                        <hr class="d-md-none">--}}
{{--                        <div class="vr d-none d-md-block"></div>--}}

                    </div>
{{--                    <div class="w-100 text-center d-flex flex-column flex-md-row justify-content-evenly">--}}
{{--                        <ul class="list-unstyled mb-0">--}}
{{--                            <li class="handwritten">{{__('Tus Búsquedas Del Tesoro')}}</li>--}}
{{--                            <li>{{$user->treasure_hunts()->count()}}</li>--}}
{{--                        </ul>--}}
{{--                        <hr class="d-md-none">--}}
{{--                        <div class="vr d-none d-md-block"></div>--}}
{{--                        <ul class="list-unstyled mb-0">--}}
{{--                            <li class="handwritten">{{__('Tus Pistas')}}</li>--}}
{{--                            <li>{{$user->clues()->count()}}</li>--}}
{{--                        </ul>--}}
{{--                        <hr class="d-md-none">--}}
{{--                        <div class="vr d-none d-md-block"></div>--}}
{{--                        <ul class="list-unstyled mb-0">--}}
{{--                            <li class="handwritten">{{__('Pistas Pro Utilizadas')}}</li>--}}
{{--                            <li>{{count($user->proClues())}} / {{$user->max_pro_clues}}</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
            </div>
        </article>
    </div>
</section>

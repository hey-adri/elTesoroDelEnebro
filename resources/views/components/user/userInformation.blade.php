@props(['user'])
<section class="userInfo">
    <div class="col-12 d-flex justify-content-center">
        <article class="paperCard max-width-lg w-100">
            <div class="row align-items-stretch">
                <div class="col-12 col-sm-5 d-flex align-items-center">
                    <div class="w-100">
                        <div class="d-flex flex-column flex-lg-row gap-2">
                            <div class="d-flex align-items-center">
                                <div class="userProfilePhoto roundPhoto max-width-80 mx-auto me-lg-2 mb-lg-2">
                                    <img class="" src="{{asset('storage/'.$user->profile_image)}}">
                                </div>
                            </div>
                            <ul class="list-unstyled text-center text-lg-start d-flex flex-column gap-1">
                                <li class="fs-6 fw-bold">{{$user->name}}</li>
                                <li class="small text-muted"><i class="fa-solid fa-user"></i>{{$user->username}}</li>
                                <li class="small text-muted"><i class="fa-solid fa-at"></i>{{$user->email}}</li>
                            </ul>
                        </div>
                        <div class="row row-cols-1 g-2">
                            <div class="col">
                                <a class="btn btn-outline-success btn-sm w-100" href="{{route('user.edit',auth()->user())}}"
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
                            <span class="ms-2"><i class="fa-solid fa-scroll"></i>{{$user->clues()->count()}}</span>
                        </div>
                        <hr class="d-lg-none">
                        <div class="vr d-none d-lg-block"></div>
                        <div class="flex-grow-1 d-flex  flex-column align-items-center justify-content-center position-relative">
                            <span class="handwritten">{{__('Pistas Pro Utilizadas')}}</span>
                            <span class="{{($user->countProClues()>0)?'badge-secondary':'badge'}} ms-2"><i class="fa-solid fa-scroll"></i>{{$user->countProClues()}} {{__('PRO')}} / {{$user->max_pro_clues}} {{__('MAX')}}</span>

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
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

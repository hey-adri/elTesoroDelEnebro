@props(['user'])
<section class="userInfo">
    <div class="col-12 d-flex justify-content-center">
        <article class="paperCard max-width-lg w-100">
            <div class="row align-items-stretch">
                <div class="col-12 col-sm-5">
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <div class="d-flex align-items-center">
                            <div class="userProfilePhoto roundPhoto max-width-60 mx-auto">
                                <img class="" src="{{$user->profileImage}}">
                            </div>
                        </div>
                        <ul class="list-unstyled text-center text-md-start d-flex flex-column gap-1">
                            <li class="fs-6 fw-bold">{{$user->name}}</li>
                            <li class="small text-muted"><i class="fa-solid fa-user"></i>{{$user->username}}</li>
                            <li class="small text-muted"><i class="fa-solid fa-at"></i>{{$user->email}}</li>
                        </ul>
                    </div>
                    <hr class="d-sm-none">
                </div>

                <div class="col-12 col-sm-7 d-flex align-items-center">
                    <div class="w-100 text-center d-flex flex-column flex-md-row justify-content-evenly">
                        <ul class="list-unstyled mb-0">
                            <li class="handwritten">{{__('Tus Búsquedas Del Tesoro')}}</li>
                            <li>{{$user->treasure_hunts()->count()}}</li>
                        </ul>
                        <hr class="d-md-none">
                        <div class="vr d-none d-md-block"></div>
                        <ul class="list-unstyled mb-0">
                            <li class="handwritten">{{__('Tus Pistas')}}</li>
                            <li>{{$user->clues()->count()}}</li>
                        </ul>
                        <hr class="d-md-none">
                        <div class="vr d-none d-md-block"></div>
                        <ul class="list-unstyled mb-0">
                            <li class="handwritten">{{__('Pistas Pro Utilizadas')}}</li>
                            <li>2/4</li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

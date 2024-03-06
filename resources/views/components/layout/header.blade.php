<!-- ! Header -->
<header>
    <nav class="navbar navbar-expand-md sticky-top py-3 shadow rounded-bottom-4">
        <div class="container">
            <a class="navbar-brand text-primary d-flex align-items-center flex-grow-1" href="{{route('home')}}">
                <img src="./assets/img/logos/logoPrimary.svg" class="headerLogo" alt="" srcset="">
                <h1 class="m-0 pt-2 pt-md-0 text-center flex-grow-1 flex-md-grow-0 text-md-start">
                {{__('El Tesoro del Enebro')}}
                </h1>
            </a>
            <button class="btn btn-outline-primary border-0 d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation">
                <i class="fa-solid fa-user"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header position-relative justify-content-between">
                    <h1 class="offcanvas-title " id="offcanvasNavbarLabel">
                        <img src="./assets/img/logos/logoPrimary.svg" class="headerLogo" alt="" srcset="">
                        {{__('El Tesoro del Enebro')}}
                    </h1>
                    <button type="button" class="btn btn-lg btn-outline-primary border-0 d-md-none"
                            data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav gap-4 justify-content-end align-items-start flex-grow-1 p-3">
                        <li class="nav-item text-primary">
                            <a class="nav-link {{request()->routeIs(['home','home.*'])?'active':''}}" aria-current="page" href="{{route('home')}}">
                                <i class="fa-solid fa-house"></i>
                                {{__('Home')}}
                            </a>
                        </li>
                        <li class="nav-item text-primary dropdown">
                            <button class="nav-link  dropdown-toggle {{request()->routeIs(['sessions.*','userArea.*'])?'active':''}}" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user m-1"></i>
                                {{__('Cuenta')}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @auth()
                                    <span class="dropdown-item text-center disabled text-primary">{{__('Sesión Iniciada como')}} {{auth()->user()->username}}</span>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item {{request()->routeIs(['userArea.*'])?'fw-bold':''}}" href="{{route('userArea.index')}}">Área Personal</a></li>
                                    <li class="dropdown-item text-center bg-body">
                                        <a href="{{route('logout')}}" class="btn btn-danger">
                                            <i class="fa-solid fa-right-from-bracket m-1"></i>
                                            {{__('Cerrar Sesión')}}
                                        </a>
                                    </li>
                                @else
                                    <li class="dropdown-item text-center bg-body">
                                        <a href="{{route('login')}}" class="btn btn-primary">
                                            <i class="fa-solid fa-right-to-bracket m-1"></i>
                                            {{__('Inciar Sesión')}}
                                        </a>
                                    </li>
                                    <li class="dropdown-item text-center bg-body">
                                        <a href="{{route('register.create')}}" class="btn btn-secondary">
                                            <i class="fa-solid fa-user-plus m-1"></i>
                                            {{__('Crea tu Cuenta')}}
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </li>
                        @include('partials.languageSwitcher')
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

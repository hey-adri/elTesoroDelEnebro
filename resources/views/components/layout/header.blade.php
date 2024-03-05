<!-- ! Header -->
<header>
    <nav class="navbar navbar-expand-md sticky-top py-3 shadow rounded-bottom-4">
        <div class="container">
            <a class="navbar-brand text-primary d-flex align-items-center flex-grow-1" href="/">
                <!-- Logo -->
                <img src="./assets/img/logos/logoPrimary.svg" class="headerLogo" alt="" srcset="">
                <h1 class="m-0 pt-2 pt-md-0 text-center flex-grow-1 flex-md-grow-0 text-md-start">
                {{__('El Tesoro del Enebro')}}
                </h1>
            </a>
            <!-- ! OffCanvas Button -->
            <button class="btn btn-outline-primary border-0 d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation">
                <i class="fa-solid fa-user"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header position-relative">
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
                    <ul class="navbar-nav gap-4 justify-content-end flex-grow-1 p-3">
                        <li class="nav-item text-primary">
                            <a class="nav-link active" aria-current="page" href="/">
                                <i class="fa-solid fa-house"></i>
                                {{__('Home')}}
                            </a>
                        </li>
                        <li class="nav-item text-primary dropdown">
                            <button class="nav-link  dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user m-1"></i>
                                {{__('Área Personal')}}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end ">
                                <!-- Todo Name o no iniciada sesión -->
                                <span class="dropdown-item text-center disabled text-primary">{{__('Bienvenido')}} UserName</span>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li class="dropdown-item text-center bg-body">
                                    <!-- Todo cierre o inicio sesión -->
                                    <!-- Cierre de Sesión -->
                                    <a href="/login" class="btn btn-primary">
                                        <i class="fa-solid fa-right-to-bracket m-1"></i>
                                        {{__('Inciar Sesión')}}
                                    </a>
                                </li>
                                <li class="dropdown-item text-center bg-body">
                                    <!-- Todo cierre o inicio sesión -->
                                    <!-- Cierre de Sesión -->
                                    <a href="/register" class="btn btn-secondary">
                                        <i class="fa-solid fa-user-plus m-1"></i>
                                        {{__('Registrarse')}}
                                    </a>
                                </li>
                                <li class="dropdown-item text-center bg-body">
                                    <!-- Todo cierre o inicio sesión -->
                                    <!-- Cierre de Sesión -->
                                    <a href="/logout" class="btn btn-danger">
                                        <i class="fa-solid fa-right-from-bracket m-1"></i>
                                        {{__('Cerrar Sesión')}}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

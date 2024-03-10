<section class="welcomePage">
    <div class="row g-5">
        <div class="col-12 col-lg-8">
            <article class="paperCard">
                <h1 class="paperCardTitle">{{__('Bienvenido al Tesoro del Enebro')}}</h1>
                <p>{{__('Para participar en el Tesoro del Enebro, podrás escanear los códigos QR de las pistas proporcionadas por tus anfitriones.')}}</p>
                <p>{!!__('También podrás introducir manualmente la <b>clave indentificativa de tu pista</b> a continuación:')!!}</p>

                <!-- ! clueKeyForm -->
                <form method="post" action="#" class="clueKeyForm">
                    <!-- Clue Key Input  -->
                    <div class="mb-4">
                        <div class="form-floating">
                            <!-- Input -->
                            <input id="clueKeyInput" type="text"
                                   value="${configuration.clueKey}"
                                   class="form-control" name="clueKeyInput"
                                   placeholder=" " data-bs-toggle="tooltip" data-bs-placement="top"
                                   data-bs-title="{{__('Introduce aquí la clave de la pista encontrada si no puedes escanear su código QR')}}">
                            <!-- Label -->
                            <label for="clueKeyInput" class="form-label" for="clueKeyInput">
                                <i class="fa-solid fa-qrcode"></i>
                                {{__('Clave Identificativa de Pista')}}
                            </label>
                        </div>
                        <!-- Error -->
                        <div class="clueKeyErrors d-none my-4">
                            <div class="form-text text-danger">{{__('¡Vaya, no hemos encontrado ninguna pista asociada!')}}</div>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="mb-4">
                        <div class="row">
                            <div class="col">
                                <button id="analizeButton" type="submit"
                                        class="btn btn-primary w-100 btn-lg" disabled>
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <span>{{__('Analizar Clave')}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="paperCard">
                <h3 class="paperCardTitle display-5">{{__('¿Deseas Crear tu propia Búsqueda del Tesoro?')}}</h3>
                <p>{{__('Podrás crear tu propia búsqueda del tesoro entrando en')}} <a href="#Todo">{{__('Tu Área Personal')}}</a>.
                </p>
            </article>
        </div>
    </div>
</section>

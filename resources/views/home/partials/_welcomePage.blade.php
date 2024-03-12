<section class="welcomePage">
    <div class="row g-5 justify-content-center">
        <div class="col-12 d-flex justify-content-center">
            <div class="paperCard max-width-lg w-100">
                <div class="d-flex justify-content-center gap-2 align-items-center">
                    <h1 class="display-4 d-inline-block m-0">{{__('Bienvenido al Tesoro del Enebro')}}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <article class="paperCard">
                <div class="d-flex justify-content-center gap-2 align-items-center paperCardTitle">
                    <span class="fs-5 text-primary pb-2"><i class="fa-solid fa-qrcode"></i></span>
                    <h1>{{__('¿Has encontrado una clave?')}}</h1>
                </div>
                <p>
                    {{__('Para acceder a su contenido, es suficiente con que escanees su código QR')}}
                    <i class="fa-solid fa-qrcode"></i>
                    {{__("no obstante, puedes introducir su clave aquí:")}}
                </p>

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
                                   data-bs-title="{{__('Introduce aquí la clave de la pista encontrada')}}">
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
        <div class="col-12 col-md-6">
            <article class="paperCard">
                <div class="d-flex justify-content-center gap-2 align-items-center paperCardTitle">
                    <span class="fs-5 text-primary pb-2"><i class="fa-solid fa-hand-sparkles"></i></span>
                    <h1>{{__('¿Es tu primera vez?')}}</h1>
                </div>
                <p>
                    {{__('¡Estamos encantados de verte por aquí!')}}
                </p>
                <ul>
                    <li>
                        <p>
                            {{__('Si deseas ver cómo funcionan las pistas por tí mismo, puedes introducir la')}}
                            <span class="fw-bold">
                            <i class="fa-solid fa-qrcode"></i>
                            {{__('clave de demostración')}} TODO
                            </span>
                                {{__('en la sección anterior.')}}
                        </p>
                    </li>
                    <li>
                        <p>{{__('Si quieres saber')}} <span class="fw-bold">{{ucwords(__('cómo crear tu búsqueda del tesoro'))}}</span> {{__(', en esta sección te contamos todo lo que necesitas saber.')}}</p>
                    </li>
                </ul>
                <div class="accordion" id="helpAccordion">
                    <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa-solid fa-user-plus"></i> {{__('Paso 1. Crea una cuenta o Inicia Sesión')}}
                            </button>
                        </span>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>
                                        <div>
                                            {{__('En primer lugar, deberás crear una cuenta pulsando el botón')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <button class="btn btn-outline-primary border-0" type="button">
                                                    <i class="fa-solid fa-user"></i>
                                                </button>
                                            </div>
                                            {{__('que encontrarás arriba en la barra de estado. Una vez ahí tendrás la opción de iniciar sesión o crear una nueva cuenta.')}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <i class="fa-solid fa-book"></i> {{__('Paso 2. Crea una Búsqueda del Tesoro')}}
                            </button>
                        </span>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>
                                        <div>
                                            {{__('Una vez hayas iniciado sesión, entrarás en tu Área Personal. Para acceder a tu área personal siempre podrás pulsar sobre tu nombre de usuario, junto a')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <button class="btn btn-outline-primary border-0" type="button">
                                                    <i class="fa-solid fa-user"></i>
                                                </button>
                                            </div>
                                            {{__('en la barra de navegación.')}}
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            {{__('Desde tu Área Personal podrás ver todas tus')}}  <i class="fa-solid fa-book"></i> {{__('Búsquedas del Tesoro. Para crear una nueva, pulsa sobre ')}}
                                            <div class="disabled d-inline-block">
                                                <div class="btn btn-outline-primary demoButton"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</div>
                                            </div>
                                            {{__('sobre la barra de buscador.')}}
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            {{__('Al pulsar sobre')}}
                                            <div class="disabled d-inline-block">
                                                <button type="button" class="btn btn-primary demoButton">
                                                    <i class="fa-solid fa-floppy-disk"></i>
                                                    {{__('Guardar')}}
                                                </button>
                                            </div>
                                            {{__('crearás tu nueva búsqueda y entrarás en la sección "')}}<i class="fa-solid fa-book"></i>{{__('Búsqueda del Tesoro".')}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <i class="fa-solid fa-scroll"></i> {{__('Paso 3. Crea tus pistas')}}
                            </button>
                        </span>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>
                                        <div>
                                            {{__('Dentro de una Búsqueda del Tesoro, verás todas las pistas asociadas a ella. Para crear una nueva pista, pulsa sobre')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <div class="btn btn-primary demoButton"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-scroll"></i> {{__('Añadir Pista')}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            {{__('Se abrirá un formulario donde podrás establecer todos los campos de tu pista. Al terminar pulsa sobre')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <button type="button" class="btn btn-primary demoButton">
                                                    <i class="fa-solid fa-floppy-disk"></i>
                                                    {{__('Guardar')}}
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            {{__('A continuación, podrás crear más pistas pulsando')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <div class="btn btn-primary demoButton"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-scroll"></i> {{__('Añadir Pista')}}</div>
                                            </div>
                                            {{__('y podrás previasualizarlas con')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <div class="btn btn-outline-primary demoButton"><i class="fa-solid fa-eye"></i> {{__('Previsualizar')}}</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                            <span class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <i class="fa-solid fa-qrcode"></i> {{__('Paso 4. Genera tus códigos QR')}}
                                </button>
                            </span>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>
                                        <div>
                                            {{__('Cuando hayas terminado, puedes recibir los códigos QR de tu Búsqueda del Tesoro en tu email. Para ello pulsa')}}
                                            <div class="disabled d-inline-block fs-6">
                                                <button type="button" class="getTreasureHuntQRsButton btn btn-secondary demoButton">
                                                    <i class="fa-solid fa-qrcode"></i> {{__('Generar QRs')}}
                                                </button>
                                            </div>
                                            .
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            {{__('¡Listo! Cuando los recibas, podrás imprimirlos, recortarlos y ...')}} <span class="fw-bold">{{__('!Que empiece la aventura!')}}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                            <span class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <i class="fa-solid fa-question-circle"></i> {{__('¿Tienes alguna otra Duda?')}}
                                </button>
                            </span>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <div>
                                    <div class="accordion" id="extrasAccordion">
                                        <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneExtrasAccordion" aria-expanded="true" aria-controls="collapseOneExtrasAccordion">
                                <i class="fa-solid fa-question-circle"></i> {{__('¿Qué son las pistas PRO?')}} <span class="badge-secondary ms-2"><i class="fa-solid fa-scroll"></i>{{__('PRO')}}</span>
                            </button>
                        </span>
                                            <div id="collapseOneExtrasAccordion" class="accordion-collapse collapse" data-bs-parent="#extrasAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>
                                                            <p>
                                                                {{__('Las pistas PRO')}}<span class="badge-secondary mx-2"><i class="fa-solid fa-scroll"></i>{{__('PRO')}}</span>{{__('te permiten añadir imágenes y vídeos.')}}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                {{__('Tienes un número máximo limitado. Podrás consultarlo en tu Área personal, donde verás las pistas PRO en uso y tu límite: ')}}<span class="badge-secondary mx-2"><i class="fa-solid fa-scroll"></i>1 {{__('PRO')}} / 8 {{__('MAX')}}</span>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoExtrasAccordion" aria-expanded="true" aria-controls="collapseTwoExtrasAccordion">
                                <i class="fa-solid fa-arrow-turn-up"></i> {{__('¿Qué puedo hacer si he llegado a mi máximo de pistas PRO?')}}
                            </button>
                        </span>
                                            <div id="collapseTwoExtrasAccordion" class="accordion-collapse collapse" data-bs-parent="#extrasAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>
                                                            <p>
                                                            <div>
                                                                {{__('No te preocupes, puedes editar las pistas que ya tienes pulsando')}}
                                                                <div class="disabled d-inline-block fs-6">
                                                                    <div class="btn btn-outline-success demoButton"><i class="fa-solid fa-pen-nib"></i> {{__('Editar')}}</div>
                                                                </div>
                                                                {{__('y eliminado su contenido multimedia para que dejen de ser PRO.')}}
                                                            </div>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                            <div>
                                                                {{__('También puedes eliminar tus pistas en uso para recuperar tus pistas PRO, para ello pulsa')}}
                                                                <div class="disabled d-inline-block fs-6">
                                                                    <button type="button" class="deleteClueButton btn btn-outline-danger demoButton"><i class="fa-solid fa-trash"></i> {{__('Eliminar')}}</button>
                                                                </div>
                                                                {{__('sobre la pista particular o sobre la Búsqueda del Tesoro que la contiene para recuperar todas las pistas PRO en uso.')}}
                                                            </div>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeExtrasAccordion" aria-expanded="true" aria-controls="collapseThreeExtrasAccordion">
                                <i class="fa-solid fa-qrcode"></i> {{__('¿Puedo editar una pista si ya he impreso los códigos QR?')}}
                            </button>
                        </span>
                                            <div id="collapseThreeExtrasAccordion" class="accordion-collapse collapse" data-bs-parent="#extrasAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>
                                                            <p>
                                                            <div>
                                                                {{__('Sin problema, un código QR te llevará siempre a la pista actualizada.')}}
                                                            </div>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                            <div>
                                                                {{__('Ahora bien, si añades más pistas a la Búsqueda del Tesoro, probablemente desees volver a imprimir tus códigos para obtener los de las nuevas pistas añadidas.')}}
                                                            </div>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                        <span class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourExtrasAccordion" aria-expanded="true" aria-controls="collapseFourExtrasAccordion">
                                <i class="fa-solid fa-question-circle"></i> {{__('¿Puedo ampliar mi límite?')}} <span class="badge-secondary ms-2"><i class="fa-solid fa-scroll"></i>{{__('PRO')}}</span>
                            </button>
                        </span>
                                            <div id="collapseFourExtrasAccordion" class="accordion-collapse collapse" data-bs-parent="#extrasAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>
                                                            <p>
                                                                {{__('Si crees que no es suficiente con tu máximo de pistas PRO, puedes contactarnos por correo')}}
                                                            </p>
                                                            <div class="w-100 d-flex justify-content-center my-2">
                                                                <a href="mailto:{{env('ADMIN_MAIL')}}" class="btn btn-secondary btn-sm">
                                                                    <i class="fa-solid fa-envelope-circle-check"></i>
                                                                    {{__('Envíanos un Correo')}}
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </article>
        </div>
    </div>
</section>

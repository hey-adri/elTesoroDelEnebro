<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

        <div class="row g-5 justify-content-center">
            <div class="col-12 max-width-md">
                <article class="paperCard">
                    <div>
                        <i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-note-sticky"></i>
                        <h1 class="d-inline-block">{{__('Añadiendo Pista')}} {{count($treasureHunt->clues)+1}}<span class="text-body"> {{__('a')}}: {{$treasureHunt->title}}</span></h1>
                    </div>

                    <form method="post" action="{{route('clue.store',['treasureHunt'=>$treasureHunt->id])}}" id="clueForm" enctype="multipart/form-data">
                        @csrf
                        <fieldset>
                            <legend
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{__('Aquí podrás introducir el contenido principal de tu pista')}}"
                            >
                                <i class="fa-solid fa-quote-left"></i>
                                {{__('Contenido Principal')}}
                            </legend>

                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: El Canto del Arroyo')}}"
                                    >
                                        <input type="text" class="form-control" name="title" id="title" placeholder=" " value="{{old('title')}}">
                                        <label for="title" class="form-label">
                                            <i class="fa-solid fa-heading"></i>
                                            {{__('Título')}}
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('El título de la pista se mostrará en su cabecera.')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: Comienza tu búsqueda en el arroyo que serpentea a través del bosque. Escucha con atención el canto del agua y busca debajo de la piedra más grande para encontrar la siguiente pista.')}}"
                                    >
                                        <textarea type="text" class="form-control" name="body" id="body" placeholder=" " style="height: 150px">{{old('body')}}</textarea>

                                        <label for="body" class="form-label">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                            {{__('Cuerpo')}}
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('Escribe aquí tu mensaje para indicar dónde encontrar la siguiente pista.')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: Cuidado, no te vayas a mojar los pies.')}}"
                                    >
                                        <input type="text" class="form-control" name="footNote" id="footNote" placeholder=" " value="{{old('footNote')}}">
                                        <label for="footNote" class="form-label">
                                            <i class="fa-solid fa-pen-fancy"></i>
                                            {{__('Nota en pie de página')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('Línea escrita en el pie de la pista, perfecta para Posdata o Recomendaciones')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: La siguiente pista se encuentra bajo la roca que hay en el riachuelo detrás de casa.')}}"
                                    >
                                        <textarea type="text" class="form-control" name="help" id="help" placeholder=" " style="height: 150px">{{old('help')}}</textarea>

                                        <label for="help" class="form-label">
                                            <i class="fa-solid fa-life-ring"></i>
                                            {{__('Sección de Ayuda')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('La sección de ayuda se mostrará cuando el participante haya pasado 1 minuto en la página. Es útil para dar indicaciones exactas de dónde encontrar la siguiente pista')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{__('Aquí podrás establecer un código de desbloqueo para acceder a tu pista')}}"
                            >
                                <i class="fa-solid fa-lock"></i>
                                {{__('Bloqueo')}}
                            </legend>
                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: Magdalenas')}}"
                                    >
                                        <input type="text" class="form-control" name="unlockKey" id="unlockKey" placeholder=" " value="{{old('unlockKey')}}">
                                        <label for="unlockKey" class="form-label">
                                            <i class="fa-solid fa-key"></i>
                                            {{__('Código de Desbloqueo')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('Puedes bloquear el acceso a tu pista con un código secreto. El desbloqueo no tendrá en cuenta espaciado, puntuación, mayúsculas o minúsculas.')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('P.ej: ¿Cuál es la merienda preferida de la Abuela?')}}"
                                    >
                                        <input type="text" class="form-control" name="unlockHint" id="unlockHint" placeholder=" " value="{{old('unlockHint')}}">
                                        <label for="unlockHint" class="form-label">
                                            <i class="fa-solid fa-info"></i>
                                            {{__('Ayuda de Desbloqueo')}} <span class="small opacity-25">~ {{__('Obligatoria si hay Código de Desbloqueo')}}</span>
                                        </label>
                                    </div>
                                    <span class="input-group-text"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="{{__('Puedes bloquear el acceso a tu pista con un código secreto. El desbloqueo no tendrá en cuenta espaciado, puntuación, mayúsculas o minúsculas.')}}"
                                    ><i class="fa-solid fa-question"></i></span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{__('Puedes adjuntar una foto y un vídeo a tu pista. Ojo, sólo si tienes pistas Pro suficientes')}}">
                                <i class="fa-solid fa-photo-film"></i>
                                {{__('Sección Multimedia')}}
                                <span class="badge-secondary"><i class="fa-solid fa-book ms-2"></i>{{$treasureHunt->owner->proCluesLeft()}} {{__('Pistas PRO')}} {{__('sin usar')}}</span>
                            </legend>

                            @if($treasureHunt->owner->proCluesLeft()>0)
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="w-100">
                                            <label for="image_src" class="form-label"
                                                   data-bs-toggle="tooltip" data-bs-placement="right"
                                                   data-bs-title="{{__('Esta imagen aparecerá bajo el cuerpo que has introducido antes.')}}"
                                            >
                                                <i class="fa-solid fa-image"></i>
                                                {{__('Adjunta una imagen')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                            <div
                                                data-bs-toggle="tooltip" data-bs-placement="right"
                                                data-bs-title="{{__('P.ej: Una imagen del riachuelo.')}}"
                                            >
                                                <input type="file" class="form-control" name="image_src" id="image_src" placeholder=" " accept="{{env('IMAGE_TYPES_ACCEPTED')}}" value="{{old('image_src')}}">
                                            </div>
                                        </div>
                                    </div>
                                    @error('image_src')
                                    <div class="error text-danger my-2">{{__('¡Vaya, parece que hay algún fallo con esta imagen!')}}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('P.ej: Riachuelo detrás de casa')}}"
                                        >
                                            <input type="text" class="form-control" name="image_title" id="image_title" placeholder=" " value="{{old('image_title')}}">
                                            <label for="image_title" class="form-label">
                                                <i class="fa-solid fa-heading"></i>
                                                {{__('Título de la Imagen')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                        </div>
                                        <span class="input-group-text"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{__('El título se mostrará sobre tu imagen.')}}"
                                        ><i class="fa-solid fa-question"></i></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('P.ej: ¿Recuerdas su frescor en verano?')}}"
                                        >
                                            <input type="text" class="form-control" name="image_caption" id="image_caption" placeholder=" " value="{{old('image_caption')}}">
                                            <label for="image_caption" class="form-label">
                                                <i class="fa-solid fa-pen-fancy"></i>
                                                {{__('Pie de Imagen')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                        </div>
                                        <span class="input-group-text"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{__('Se mostrará bajo tu imagen.')}}"
                                        ><i class="fa-solid fa-question"></i></span>
                                    </div>
                                </div>

                                <hr class="my-4">


                                <div class="mb-4">
                                    <label class="form-label"
                                           data-bs-toggle="tooltip" data-bs-placement="right"
                                           data-bs-title="{{__('Puedes adjuntar un vídeo de YouTube con su enlace.')}}"
                                    >
                                        <i class="fa-brands fa-youtube"></i>
                                        {{__('Adjunta un Vídeo de YouTube')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('Asegúrate de que el vídeo sea oculto o público, nunca privado')}}"
                                        >
                                            <input type="url" class="form-control" name="embedded_video_src" id="embedded_video_src" placeholder=" " value="{{old('embedded_video_src')}}">
                                            <label for="embedded_video_src" class="form-label">
                                                <i class="fa-brands fa-youtube"></i>
                                                {{__('Enlace del vídeo')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                        </div>
                                        <span class="input-group-text"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{__('Sube un vídeo a YouTube como oculto o público y pega aquí su URL.')}}"
                                        ><i class="fa-solid fa-question"></i></span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('P.ej: Riachuelo detrás de casa')}}"
                                        >
                                            <input type="text" class="form-control" name="embedded_video_title" id="embedded_video_title" placeholder=" " value="{{old('embedded_video_title')}}">
                                            <label for="embedded_video_title" class="form-label">
                                                <i class="fa-solid fa-heading"></i>
                                                {{__('Título de tu vídeo')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                        </div>
                                        <span class="input-group-text"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{__('El título se mostrará sobre tu vídeo.')}}"
                                        ><i class="fa-solid fa-question"></i></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('P.ej: ¿Recuerdas su frescor en verano?')}}"
                                        >
                                            <input type="text" class="form-control" name="embedded_video_caption" id="embedded_video_caption" placeholder=" " value="{{old('embedded_video_caption')}}">
                                            <label for="image_caption" class="form-label">
                                                <i class="fa-solid fa-pen-fancy"></i>
                                                {{__('Pie de Vídeo')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                                            </label>
                                        </div>
                                        <span class="input-group-text"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{__('Se mostrará bajo tu vídeo.')}}"
                                        ><i class="fa-solid fa-question"></i></span>
                                    </div>
                                </div>
                            @else
                                <x-extras.nothingFound :text="__('Parece que has usado todas tus pistas PRO. Puedes eliminar la sección multimedia de tus pistas PRO para que dejen de serlo...')"/>
                            @endif
                        </fieldset>

                        <div class="my-4">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        {{__('Guardar')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </article>
            </div>
        </div>

    </x-slot>
    <x-slot name="floatingButtons">
        <a href="{{route('userArea.index')}}" class="btn btn-primary">
            <i class="fa-solid fa-angle-left"></i>
            {{__('Volver a Área Personal')}}
        </a>
    </x-slot>
    <x-slot name="scripts">
        <script>
            $(()=>{
                confForm()
                confTogglePassword()
                makeInputDependentOn('#unlockKey','#unlockHint');
                makeInputDependentOn('#image_src','#image_title,#image_caption');
                makeInputDependentOn('#embedded_video_src','#embedded_video_title,#embedded_video_caption');
                $('#username').on('input',()=>{$('#username').val($('#username').val().toLowerCase())})
                $('#deleteImageButton').on('click',deleteImageButtonClicked)
                $('#image_src').on('input',checkImage)
            })

            /**
             * Hides or shows the password fields
             */
            const confTogglePassword=()=>{
                $('#togglePasswordButton').on('click',()=> {
                    if ($('#togglePasswordButton >*').hasClass('fa-eye')) $('#togglePasswordButton >*').removeClass('fa-eye').addClass('fa-eye-slash')
                    else $('#togglePasswordButton >*').removeClass('fa-eye-slash').addClass('fa-eye')
                    const type = $('.passwordToggle').attr('type') === "password" ? "text" : "password";
                    $('.passwordToggle').attr('type', type)
                })
            }

            /**
             * Ensures the image stays within its limits
             */
            const checkImage = ()=>{
                if(!checkInputFileSize('#image_src',{{env('MAX_PROFILE_IMAGE_SIZE')}})){
                    $('#image_src').val('')
                    $('#image_src').addClass('is-invalid').removeClass('is-valid')
                    showPopup(`{{__('La imagen seleccionada es demasiado grande.')}}`,`{{__('Atención')}}`,'warning')
                }else{
                    $('#image_src').addClass('is-valid').removeClass('is-invalid')
                }
            }

            /**
             * Toggles the hidden delete flag
             */
            const deleteImageButtonClicked = ()=>{
                const deleteImageInput = $(`#deleteImage`);
                deleteImageInput.prop('disabled',!deleteImageInput.prop('disabled')) //Toggling the input's enabling
                if(deleteImageInput.prop('disabled')){
                    $('#deleteImageButton span').text(`{{__('Eliminar Imagen de Perfil')}}`);
                    $('#deleteImageButton').addClass('btn-outline-danger').removeClass('btn-warning');
                    $('#profile_image').prop('disabled',false)
                }else{
                    $('#deleteImageButton span').text(`{{__('Cancelar Borrado')}}`);
                    $('#deleteImageButton').removeClass('btn-outline-danger').addClass('btn-warning')
                    $('#profile_image').val('')
                    $('#profile_image').prop('disabled',true)
                    showPopup(`{{__('Tu Imagen de Perfil se borrará tras el guardado, todavía puedes cancelarlo.')}}`,`{{__('Atención')}}`,'warning')
                }
            }

            /**
             * Uses Jquery Validate to configure the form
             */
            const confForm = () => {
                $("#clueForm").validate(
                    {
                        errorElement: "div",
                        errorPlacement: function (error, element) {
                            $(error).addClass('text-danger').addClass('my-4')
                            error.addClass();
                            $(element.closest(".input-group")).after(error)
                        },
                        highlight: function (element, errorClass, validClass) {
                            // disableBSTooltips()
                            $(element).addClass("is-invalid").removeClass("is-valid");
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).addClass("is-valid").removeClass("is-invalid");
                        },
                        rules: {
                            title:{
                                required:true,
                                maxlength:255,
                            },
                            body:{
                                required:true,
                            },
                            footNote: {
                                required: false,
                                maxlength:255,
                            },
                            help: {
                                required: false,
                            },
                            unlockKey: {
                                required: false,
                                maxlength:255,
                            },
                            unlockHint:{
                                required: true,
                                maxlength:255,
                            },
                            image_src:{
                                required: false,
                                maxlength:255,
                            },
                            image_title:{
                                required: false,
                                maxlength:255,
                            },
                            image_caption:{
                                required: false,
                                maxlength:255,
                            },
                            embedded_video_src:{
                                required:false,
                                maxlength:255,
                                regex:/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/
                            },
                            embedded_video_title:{
                                required: false,
                                maxlength:255,
                            },
                            embedded_video_caption:{
                                required: false,
                                maxlength:255,
                            }

                        },
                        messages:{
                            unlockHint:{
                                required: `{{__('Debes proporcionar una ayuda para que los participantes puedan averiguar la Clave de Desbloqueo.')}}`,
                            },
                            embedded_video_src:{
                                regex:  `{{__('Parece que esta url no corresponde a un vídeo en YouTube.')}}`
                            }
                        },
                        submitHandler: (form) => {
                            showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Enviando Datos ...")}}`)
                            form.submit()
                        }
                    }
                );
                $.validator.messages.emailV2 = '{{__("Por favor, introduce in email válido.")}}';
                $.validator.messages.username = '{{__("Debe tener entre 4 y 30 carácteres. Sólo letras minúsculas, dígitos y . _ -")}}';
                $.validator.messages.passwordCheck = '{{__("Debe tener entre 8 y 30 carácteres. Sólo letras, espacios, dígitos y cualquier carácter especial.")}}';
            };
        </script>
    </x-slot>
</x-layout.baseLayout>

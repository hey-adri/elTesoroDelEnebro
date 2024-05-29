@props(['method','clue','treasureHunt'])
@if($method=='update')
    <form method="post" action="{{route('clue.update',['clue'=>$clue->clueKey])}}" id="clueForm" enctype="multipart/form-data">
        @method('PUT')
@else
    <form method="post" action="{{route('clue.store',['treasureHunt'=>$treasureHunt->id])}}" id="clueForm" enctype="multipart/form-data">
@endif

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
                     data-bs-title="{{__('Esta posición es la que ocupará tu pista en la Búsqueda del Tesoro')}}"
                >
                    <select class="form-select form-control" name="order" >
                        @if($method=='create')
                            @for($i = 1; $i<=$treasureHunt->clues()->count();$i++){
                            <option value="{{$i}}">
                                {{__('Pista')}} {{$i}}
                            </option>
                            @endfor
                            <option value="{{$treasureHunt->clues()->count()+1}}" {{(!old('order')?'selected':'')}}>
                                {{__('Pista')}} {{$treasureHunt->clues()->count()+1}}
                            </option>
                        @else
                            @for($i = 1; $i<=$clue->treasure_hunt->clues()->count();$i++){
                            <option value="{{$i}}" {{(old('order',$clue->order)==$i?'selected':'')}}>
                                {{__('Pista')}} {{$i}}
                            </option>
                            @endfor
                        @endif

                    </select>
                    <label for="title" class="form-label">
                        <i class="fa-solid fa-heading"></i>
                        {{__('Posición')}}
                    </label>
                </div>
                <span class="input-group-text"
                      data-bs-toggle="tooltip" data-bs-placement="top"
                      data-bs-title="{{__('Por defecto, las pistas se añaden como las últimas')}}"
                ><i class="fa-solid fa-question"></i></span>
            </div>
        </div>

        <div class="mb-4">
            <div class="input-group">
                <div class="form-floating"
                     data-bs-toggle="tooltip" data-bs-placement="right"
                     data-bs-title="{{__('P.ej: El Canto del Arroyo')}}"
                >
                    <input type="text" class="form-control" name="title" id="title" placeholder=" " value="{{old('title',$clue?->title)}}">
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
                    <textarea type="text" class="form-control" name="body" id="body" placeholder=" " style="height: 150px">{{old('body',$clue?->body)}}</textarea>

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
                    <input type="text" class="form-control" name="footNote" id="footNote" placeholder=" " value="{{old('footNote',$clue?->footNote)}}">
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
                    <textarea type="text" class="form-control" name="help" id="help" placeholder=" " style="height: 150px">{{old('help',$clue?->help)}}</textarea>

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
                    <input type="text" class="form-control" name="unlockKey" id="unlockKey" placeholder=" " value="{{old('unlockKey',($clue?->unlockKey!='default'?$clue?->unlockKey:''))}}">
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
                    <input type="text" class="form-control" name="unlockHint" id="unlockHint" placeholder=" " value="{{old('unlockHint',$clue?->unlockHint)}}">
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
            @if($method=='update')
                <span class="badge-secondary"><i class="fa-solid fa-book ms-2"></i>{{$clue?->treasure_hunt->owner->proCluesLeft()}} {{__('Pistas PRO')}} {{__('sin usar')}}</span>
            @else
                <span class="badge-secondary"><i class="fa-solid fa-book ms-2"></i>{{$treasureHunt->owner->proCluesLeft()}} {{__('Pistas PRO')}} {{__('sin usar')}}</span>
            @endif
        </legend>



        {{-- Showing the pro section only if the owner has proCluesLeft or if this clue itself is a pro one, so that it can be edited--}}
        @if(
            ($method=='create')&&($treasureHunt?->owner->proCluesLeft()>0)||
            ($method=='update')&&($clue?->isPro() || $clue?->treasure_hunt->owner->proCluesLeft()>0)
        )
            @if($method=='update'&&$clue?->image)
                    <div class="mb-2">
                        <div class="d-flex flex-column align-items-center gap-2 mb-4">
                            <div class="mb-2">
                                <i class="fa-solid fa-image"></i>
                                {{__('Tu imagen Actual:')}}
                            </div>
                            <div class="imageContainer col-12 col-sm-6 mb-2">
                                <img class="img-fluid rounded-4 shadow" src="{{asset('storage/'.$clue?->image->src)}}">
                            </div>
                            <div class="d-flex justify-content-evenly">
                                <button type="button" class="btn btn-outline-danger" id="deleteImageButton">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>{{__('Eliminar Imagen')}}</span>
                                </button>
                                <input type="hidden" name="deleteImage" id="deleteImage" value="true" disabled>
                            </div>
                        </div>
                    </div>
            @endif

            <div class="imageSection">
                <div class="mb-4">
                    <div class="input-group">
                        <div class="w-100">
                            <label for="image_src" class="form-label"
                                   data-bs-toggle="tooltip" data-bs-placement="right"
                                   data-bs-title="{{__('Esta imagen aparecerá bajo el cuerpo que has introducido antes.')}}"
                            >
                                <i class="fa-solid fa-image"></i>
                                {{__('Actualiza tu imagen')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                            </label>
                            <div
                                data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-title="{{__('P.ej: Una imagen del riachuelo.')}}"
                            >
                                <input type="file" class="form-control" name="image_src" id="image_src" placeholder=" " accept="{{env('IMAGE_TYPES_ACCEPTED')}}">
                                <input type="hidden" class="form-control" id="image_src_has_value" value="{{old('image_src',$clue?->image?->src)}}">
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
                            <input type="text" class="form-control" name="image_title" id="image_title" placeholder=" " value="{{old('image_title',$clue?->image?->title)}}">
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
                            <input type="text" class="form-control" name="image_caption" id="image_caption" placeholder=" " value="{{old('image_caption',$clue?->image?->caption)}}">
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
            </div>

            <hr class="my-4">

                @if($method=='update'&&$clue?->embedded_video)
                    <div class="mb-2">
                        <div class="d-flex flex-column align-items-center gap-2 mb-4">
                            <div class="mb-2">
                                <i class="fa-solid fa-image"></i>
                                {{__('Tu Vídeo de YouTube Actual:')}}
                            </div>
                            <div class="videoContainer col-12 col-sm-6 mb-2">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{$clue?->embedded_video->src}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" class="rounded-4 shadow" allowfullscreen=""></iframe>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly">
                                <button type="button" class="btn btn-outline-danger" id="deleteEmbeddedVideoButton">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>{{__('Eliminar Vídeo de YouTube')}}</span>
                                </button>
                                <input type="hidden" name="deleteEmbeddedVideo" id="deleteEmbeddedVideo" value="true" disabled>
                            </div>
                        </div>
                    </div>
                @endif

            <div class="embeddedVideoSection">
                <div class="mb-4">
                <label class="form-label"
                data-bs-toggle="tooltip" data-bs-placement="right"
                data-bs-title="{{__('Puedes adjuntar un vídeo de YouTube con su enlace.')}}"
                >
                <i class="fa-brands fa-youtube"></i>
                {{__('Actualiza tu Vídeo de YouTube')}} <span class="small opacity-25">~ {{__('Opcional')}}</span>
                </label>
                <div class="input-group">
                    <div class="form-floating"
                         data-bs-toggle="tooltip" data-bs-placement="right"
                         data-bs-title="{{__('Asegúrate de que el vídeo sea oculto o público, nunca privado')}}"
                    >
                        <input type="url" class="form-control" name="embedded_video_src" id="embedded_video_src" placeholder=" " value="{{old('embedded_video_src',$clue?->embedded_video?->src)}}">
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
                            <input type="text" class="form-control" name="embedded_video_title" id="embedded_video_title" placeholder=" " value="{{old('embedded_video_title',$clue?->embedded_video?->title)}}">
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
                            <input type="text" class="form-control" name="embedded_video_caption" id="embedded_video_caption" placeholder=" " value="{{old('embedded_video_caption',$clue?->embedded_video?->caption)}}">
                            <label for="embedded_video_caption" class="form-label">
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
            </div>
        @else
            <x-extras.nothingFound :text="__('Parece que has usado todas tus pistas PRO. Puedes eliminar la sección multimedia de tus pistas PRO para que dejen de serlo...')"/>
        @endif
    </fieldset>
    @if($method=='create')
        {{-- Recaptcha Field--}}
        {!! RecaptchaV3::field('clue') !!}
    @endif
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
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        confForm()
        makeInputDependentOn('#unlockKey','#unlockHint');
        @if(empty($clue?->image))
        {{-- If there's no image present, we will disable the fields linked to that image if there's no selection made --}}
        makeInputDependentOn('#image_src','#image_title,#image_caption');
        @endif
        makeInputDependentOn('#embedded_video_src','#embedded_video_title,#embedded_video_caption');
        @if($method=='update')
            @if($clue?->image)
            $('#deleteImageButton').on('click',deleteImageButtonClicked)
            @endif
            @if($clue?->embedded_video)
            $('#deleteEmbeddedVideoButton').on('click',deleteEmbeddedVideoButtonClicked)
           @endif
        @endif
        $('#image_src').on('input',checkImage)
    })


    /**
     * Ensures the image stays within its limits
     */
    const checkImage = ()=>{
        if(!checkInputFileSize('#image_src',{{env('MAX_CLUE_IMAGE_SIZE')}})){
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
            $('#deleteImageButton span').text(`{{__('Eliminar Imagen')}}`);
            $('#deleteImageButton').addClass('btn-outline-danger').removeClass('btn-warning');
            $('.imageSection input').prop('disabled',false)
            selectForDeletion('.imageContainer img',false)
            showPopup(`{{__('Borrado Cancelado')}}`,`{{__('Información')}}`,'info',
                ()=>{
                    animateShow('.imageSection');
                }
            )
        }else{
            $('#deleteImageButton span').text(`{{__('Cancelar Borrado')}}`);
            $('#deleteImageButton').removeClass('btn-outline-danger').addClass('btn-warning')
            $('.imageSection').prop('disabled',true)
            selectForDeletion('.imageContainer img',true)
            showPopup(`{{__('La imagen se borrará tras el guardado, todavía puedes cancelarlo.')}}`,`{{__('Atención')}}`,'warning',
                ()=>{
                    animateHide('.imageSection')
                }
            )
        }
    }

    /**
     * Toggles the hidden delete flag
     */
    const deleteEmbeddedVideoButtonClicked = ()=>{
        const deleteEmbeddedVideoInput = $(`#deleteEmbeddedVideo`);
        deleteEmbeddedVideoInput.prop('disabled',!deleteEmbeddedVideoInput.prop('disabled')) //Toggling the input's enabling
        if(deleteEmbeddedVideoInput.prop('disabled')){
            $('#deleteEmbeddedVideoButton span').text(`{{__('Eliminar Vídeo')}}`);
            $('#deleteEmbeddedVideoButton').addClass('btn-outline-danger').removeClass('btn-warning');
            $('.embeddedVideoSection input').prop('disabled',false)

            selectForDeletion('.videoContainer iframe',false)
            showPopup(`{{__('Borrado Cancelado')}}`,`{{__('Información')}}`,'info',
                ()=>{
                    animateShow('.embeddedVideoSection');
                }
            )
        }else{
            $('#deleteEmbeddedVideoButton span').text(`{{__('Cancelar Borrado')}}`);
            $('#deleteEmbeddedVideoButton').removeClass('btn-outline-danger').addClass('btn-warning')
            $('.embeddedVideoSection input').prop('disabled',true)
            selectForDeletion('.videoContainer iframe',true)
            showPopup(`{{__('El vídeo se borrará tras el guardado, todavía puedes cancelarlo.')}}`,`{{__('Atención')}}`,'warning',
                ()=>{
                    animateHide('.embeddedVideoSection');
                }
            )
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
                    order:{
                        required:true,
                        digits:true
                    },
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
                        @if($method=='update'&&!empty($clue->embedded_video))
                            {{-- If there's a video present, use the delete button to delete it, don't leave the field empty  --}}
                        required:true,
                        @else
                        required:false,
                        @endif
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
                        required: `{{__('Para eliminar un vídeo, utiliza el botón de borrado, no dejes el campo vacío')}}`,
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

@props([
    'method',
    'treasureHunt'
    ])

<form method="post" action="{{
    ($method=='update'?route('treasureHunt.update',['treasureHunt'=>$treasureHunt]):route('treasureHunt.store'))
    }}" id="treasureHuntForm">
    @if($method=='update')
        @method('PUT')
    @endif
    @csrf
    <fieldset>
        @if($method=='update')
            <legend><i class="fa-solid fa-pen-nib"></i></i> {{__('Editar Búsqueda del Tesoro')}}</legend>
        @else
            <legend><i class="fa-solid fa-plus"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</legend>
        @endif
        <div class="mb-4">
            <div class="input-group">
                <div class="form-floating"
                     data-bs-toggle="tooltip" data-bs-placement="right"
                     data-bs-title="{{__('P.ej: Explorando la Naturaleza...')}}"
                >
                    <input type="text" class="form-control" name="title" id="title" placeholder=" " value="{{old('title',$treasureHunt?->title)}}">
                    <label for="title" class="form-label">
                        <i class="fa-solid fa-heading"></i>
                        {{__('Título')}}
                    </label>
                </div>
                <span class="input-group-text"
                      data-bs-toggle="tooltip" data-bs-placement="top"
                      data-bs-title="{{__('El título de la búsqueda del tesoro se mostrará en todas sus pistas.')}}"
                ><i class="fa-solid fa-question"></i></span>
            </div>
        </div>
        {{-- Submit --}}
        <div class="mb-4">
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{__('Guardar')}}
                    </button>
                </div>
            </div>
        </div>
    </fieldset>
</form>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        confForm()
    })
    /**
     * Uses Jquery Validate to configure the form
     */
    const confForm = () => {
        $("#treasureHuntForm").validate(
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
                },
                submitHandler: (form) => { //! Si no hay ningún error se corre el bloque submitHandler
                    showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Enviando Datos ...")}}`)
                    form.submit()
                }
            }
        );
    };


</script>


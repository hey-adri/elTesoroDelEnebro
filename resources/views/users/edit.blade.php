<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <form method="post" action="{{route('user.update',['user'=>$user->username])}}" id="userForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <fieldset>
                        <legend>{{__('Datos Personales')}}</legend>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="userProfilePhoto roundPhoto max-width-100 mx-auto">
                                    <img class="" src="{{asset('storage/'.$user->profile_image)}}">
                                </div>
                            </div>
                            @if(!\App\Models\User::isImagePathDefault($user->profile_image))
                                <div class="my-2 d-flex justify-content-evenly">
                                    <button type="button" class="btn btn-outline-danger" id="deleteImageButton">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>{{__('Eliminar Imagen de Perfil')}}</span>
                                    </button>
                                    <input type="hidden" name="deleteImage" id="deleteImage" value="true" disabled>
                                </div>
                            @endif


                            <div class="my-4">
                                <div class="input-group">
                                    <div class="w-100">
                                        <label for="profile_image" class="form-label">
                                            <i class="fa-solid fa-image-portrait"></i>
                                            {{__('Actualiza tu Imagen de Perfil')}}
                                        </label>
                                        <input type="file" class="form-control" name="profile_image" id="profile_image" placeholder=" " accept="{{env('IMAGE_TYPES_ACCEPTED')}}" value="{{old('profile_image',$user->profile_image)}}">
                                    </div>
                                </div>
                                @error('profile_image')
                                <div class="error text-danger my-2">{{__('¡Vaya, parece que hay algún fallo con esta imagen!')}}</div>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="my-4">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" placeholder=" " value="{{old('name',$user->name)}}">
                                    <label for="name" class="form-label">
                                        <i class="fa-solid fa-signature"></i>
                                        {{__('Nombre y Apellidos')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="email" id="email" placeholder=" " value="{{$user->email}}">
                                    <label for="email" class="form-label">
                                        <i class="fa-solid fa-at"></i>
                                        {{__('Email')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('email')
                        <div class="error text-danger my-4">{{__('¡Vaya, parece que ').old('email').__(' ya está en uso!')}}</div>
                        @enderror
                        <div class="mb-4">
                            <div class="input-group"
                                 data-bs-toggle="tooltip" data-bs-placement="right"
                                 data-bs-title="{{__('Debe tener entre 4 y 30 carácteres. Sólo letras minúsculas, dígitos y . _ -')}}">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="username" id="username" placeholder=" " value="{{$user->username}}">
                                    <label for="username" class="form-label">
                                        <i class="fa-solid fa-id-badge"></i>
                                        {{__('Nombre de Usuario')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('username')
                        <div class="error text-danger my-4">{{__('¡Vaya, parece que ').old('username').__(' ya está en uso!')}}</div>
                        @enderror
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
                    </fieldset>
                    <fieldset>
                        <legend>{{__('Cambio de Contraseña')}}</legend>
                        <div class="mb-4">
                            <div class="input-group"
                                 data-bs-toggle="tooltip" data-bs-placement="right"
                                 data-bs-title="{{__("Debe tener entre 8 y 30 carácteres. Sólo letras, espacios, dígitos y cualquier carácter especial.")}}"
                            >
                                <div class="form-floating">
                                    <input type="password" class="form-control passwordToggle" name="password" id="password" placeholder=" ">
                                    <label for="password" class="form-label">
                                        <i class="fa-solid fa-shield"></i>
                                        {{__('Nueva contraseña')}}
                                    </label>
                                </div>
                                <span class="input-group-text" id="togglePasswordButton"><i class="fa-solid fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="input-group"
                                 data-bs-toggle="tooltip" data-bs-placement="right"
                                 data-bs-title="{{__('Debe coincidir con la contraseña anterior')}}">
                                <div class="form-floating">
                                    <input type="password" class="form-control passwordToggle" name="rePassword" id="rePassword" placeholder=" ">
                                    <label for="rePassword" class="form-label">
                                        <i class="fa-solid fa-shield"></i>
                                        {{__('Repite tu nueva contraseña')}}
                                    </label>
                                </div>
                            </div>
                        </div>
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
                    </fieldset>
        </form>
                    </article>
                    <div class="my-5">
                        <form method="POST" action="{{route('user.destroy',['user'=>$user])}}" class="userDeletionForm d-inline-block w-100">
                            @method("DELETE")
                            @csrf
                            <button type="submit" class="deleteUserButton btn btn-outline-danger w-100" data-username="{{$user->username}}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{__('Si eliminas esta cuenta, sus Búsquedas del Tesoro y sus Pistas se eliminarán también.')}}"
                            ><i class="fa-solid fa-trash"></i> {{__('Eliminar cuenta')}}</button>
                        </form>
                    </div>
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
                makeInputDependentOn('#password','#rePassword');
                $('#username').on('input',()=>{$('#username').val($('#username').val().toLowerCase())})
                $('#deleteImageButton').on('click',deleteImageButtonClicked)
                $('#profile_image').on('input',checkImage)
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
                if(!checkInputFileSize('#profile_image',{{env('MAX_PROFILE_IMAGE_SIZE')}})){
                    $('#profile_image').val('')
                    $('#profile_image').addClass('is-invalid').removeClass('is-valid')
                    showPopup(`{{__('La imagen seleccionada es demasiado grande.')}}`,`{{__('Atención')}}`,'warning')
                }else{
                    $('#profile_image').addClass('is-valid').removeClass('is-invalid')
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
                $("#userForm").validate(
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
                            name:{
                                required:true,
                                maxlength:255,
                            },
                            email:{
                                required:true,
                                maxlength:255,
                                emailV2:true
                            },
                            username: {
                                required: true,
                                maxlength:255,
                                username:true
                            },
                            password: {
                                maxlength:255,
                                passwordCheck: true,
                            },
                            rePassword:{
                                required: true,
                                maxlength:255,
                                equalTo:'#password',
                                passwordCheck: true,
                            },
                            profile_image:{
                                required:false
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
            {{-- Adding Confirmation to delete Buttons --}}
            document.addEventListener('DOMContentLoaded',()=>{
                $('.deleteUserButton').on('click',askForUserDeleteConfirmation)
            })
            const askForUserDeleteConfirmation = ()=>{
                event.preventDefault()
                const form = $(event.target).closest('form')
                showAccountDeleteDialog(
                    `{{__('Soy consciente de que eliminando la cuenta ')}} "${$(event.target).attr(`data-username`)}", se eliminarán todas sus Búsquedas del Tesoro y Pistas.`,
                    `{{__('¿Estás Seguro?')}}`,
                    `{{__('Eliminar Cuenta y todos sus recursos')}}`,
                    `{{__('Marca la casilla para eliminar ésta cuenta')}}`,
                    ()=>{
                    showLoading(`{{__("¡Hasta Pronto!")}}`,`{{__("Eliminando Cuenta...")}}`)
                    form.submit()
                })
            }
        </script>
    </x-slot>
</x-layout.baseLayout>

<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <form method="post" action="{{route('register.store')}}" id="registerForm">
                            @csrf
                            <fieldset>
                                <legend>{{__('Crea tu Cuenta')}}</legend>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="name" id="name" placeholder=" " value="{{old('name')}}">
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
                                            <input type="text" class="form-control" name="email" id="email" placeholder=" " value="{{old('email')}}">
                                            <label for="email" class="form-label">
                                                <i class="fa-solid fa-at"></i>
                                                {{__('Email')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="error text-danger my-4">{{__('¡Vaya, parece que este email ya está en uso!')}}</div>
                                @enderror
                                <div class="mb-4">
                                    <div class="input-group"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('Debe tener entre 4 y 30 carácteres. Sólo letras minúsculas, dígitos y . _ -')}}">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="username" id="username" placeholder=" " value="{{old('username')}}">
                                            <label for="username" class="form-label">
                                                <i class="fa-solid fa-id-badge"></i>
                                                {{__('Nombre de Usuario')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('username')
                                    <div class="error text-danger my-4">{{__('¡Vaya, parece que alguien ya tiene este nombre de usuario!')}}</div>
                                @enderror
                                <div class="mb-4">
                                    <div class="input-group"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__("Debe tener entre 8 y 30 carácteres. Sólo letras, espacios, dígitos y cualquier carácter especial.")}}"
                                    >
                                        <div class="form-floating">
                                            <input type="password" class="form-control passwordToggle" name="password" id="password" placeholder=" ">
                                            <label for="password" class="form-label">
                                                <i class="fa-solid fa-shield"></i>
                                                {{__('Crea tu contraseña')}}
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
                                                {{__('Repite tu contraseña')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fa-solid fa-user-plus"></i>
                                                {{__('Regístrate')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    {{__('¿Ya tienes cuenta?')}}
                                    <a href="{{route('login')}}">{{__('Inicia Sesión')}}</a>
                                </div>
                            </fieldset>
                        </form>
                    </article>
                </div>
                <div class="p-2 mt-5 d-flex justify-content-center">
                    <img src="{{asset('/assets/img/logos/logoPrimary.svg')}}" class="img-fluid max-width-60" alt="" srcset="">
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">
        <script>
            $(()=>{
                confForm()
                confTogglePassword()
                $('#username').on('input',()=>{$('#username').val($('#username').val().toLowerCase())})
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
             * Uses Jquery Validate to configure the form
             */
            const confForm = () => {
                $("#registerForm").validate(
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
                                required: true,
                                maxlength:255,
                                passwordCheck: true,
                            },
                            rePassword:{
                                required: true,
                                maxlength:255,
                                equalTo:'#password',
                                passwordCheck: true,
                            }
                        },
                        submitHandler: (form) => {
                            showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Creando tu Cuenta...")}}`)
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

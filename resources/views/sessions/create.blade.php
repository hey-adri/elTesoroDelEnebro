<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <form method="post" action="{{route('sessions.store')}}" id="loginForm">
                            @csrf
                            <fieldset>
                                <legend>{{__('Accede a tu Cuenta')}}</legend>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating"
                                             data-bs-toggle="tooltip" data-bs-placement="right"
                                             data-bs-title="{{__('Introduce tu nombre de usuario. ¡Cuidado, es distinto de tu correo!')}}"
                                        >
                                            <input type="text" class="form-control" name="username" id="username" placeholder=" " value="{{old('username')}}">
                                            <label for="username" class="form-label">
                                                <i class="fa-solid fa-id-badge"></i>
                                                {{__('Nombre de Usuario')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="password" class="form-control passwordToggle" name="password" id="password" placeholder=" ">
                                            <label for="password" class="form-label">
                                                <i class="fa-solid fa-shield"></i>
                                                {{__('Contraseña')}}
                                            </label>
                                        </div>
                                        <span class="input-group-text" id="togglePasswordButton"><i class="fa-solid fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                                <i class="fa-solid fa-right-to-bracket"></i>
                                                {{__('Iniciar Sesión')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    {{__('¿No tienes cuenta aún?')}}
                                    <a href="{{route('register.create')}}">{{__('Regístrate')}}</a>
                                </div>
                            </fieldset>
                        </form>
                    </article>
                </div>
                <div class="p-2 mt-5 d-flex justify-content-center">
                    <img src="./assets/img/logos/logoPrimary.svg" class="img-fluid max-width-60" alt="" srcset="">
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">
        <script>
            $(()=>{
                @error('login')
                showToast('{{$message}}','error')
                @enderror
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
                $("#loginForm").validate(
                    {
                        errorElement: "div",
                        errorPlacement: function (error, element) {
                            $(error).addClass('text-danger').addClass('mt-2')
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
                            username: {
                                required: true,
                                maxlength:255,
                                username:true
                            },
                            password: {
                                required: true,
                                maxlength:255,
                                password: true,
                            }
                        },
                        submitHandler: (form) => { //! Si no hay ningún error se corre el bloque submitHandler
                            form.submit()
                        }
                    }
                );
                $.validator.messages.username = '{{__("Debe tener entre 4 y 30 carácteres. Sólo letras minúsculas, dígitos y . _ -")}}';
                $.validator.messages.password = '{{__("Debe tener entre 8 y 30 carácteres. Sólo letras, espacios, dígitos y cualquier carácter especial.")}}';
            };

        </script>
    </x-slot>
</x-layout.baseLayout>

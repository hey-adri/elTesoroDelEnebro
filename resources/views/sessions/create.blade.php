<x-layout.baseLayout>
    <x-slot name="links">
        {{--  Recaptcha Call  --}}
        {!! RecaptchaV3::initJs() !!}
    </x-slot>
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
                                {{-- Recaptcha Field--}}
                                {!! RecaptchaV3::field('login') !!}
                                <!-- Submit -->
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary w-100">
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
                            username: {
                                required: true,
                                maxlength:255,
                                regex:/^((?!@).)*$/
                            },
                            password: {
                                required: true,
                                maxlength:255
                            }
                        },
                        messages:{
                            username:{
                                regex:`{{__('Debes iniciar sesión con tu nombre de usuario, no tu email.')}}`
                            }
                        },
                        submitHandler: (form) => {
                            showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Comprobando Credenciales...")}}`)
                            form.submit()
                        }
                    }
                );
            };

        </script>
    </x-slot>
</x-layout.baseLayout>

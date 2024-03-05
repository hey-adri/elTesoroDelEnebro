<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">

            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <form method="post" action="{{route('sessions.store')}}" id="registerForm">
                            @csrf
                            <fieldset>
                                <legend>{{__('Crea tu Cuenta')}}</legend>
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder=" " value="{{old('name')}}">
                                        <label for="name" class="form-label">
                                            <i class="fa-solid fa-signature"></i>
                                            {{__('Nombre y Apellidos')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder=" " value="{{old('email')}}">
                                        <label for="email" class="form-label">
                                            <i class="fa-solid fa-at"></i>
                                            {{__('Email')}}
                                        </label>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="error text-danger mt-2">{{__('¡Vaya, parece que este email ya está en uso!')}}</div>
                                @enderror
                                <div class="mb-4">
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('Crea tu nombre de usuario. Inspírate, debe ser único.')}}"
                                    >
                                        <input type="text" class="form-control" name="username" id="username" placeholder=" " value="{{old('username')}}">
                                        <label for="username" class="form-label">
                                            <i class="fa-solid fa-id-badge"></i>
                                            {{__('Nombre de Usuario')}}
                                        </label>
                                    </div>
                                </div>
                                @error('username')
                                    <div class="error text-danger mt-2">{{__('¡Vaya, parece que alguien ya tiene este nombre de usuario!')}}</div>
                                @enderror
                                <div class="mb-4">
                                    <div class="input-group"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('La contraseña debe tener al menos 8 carácteres')}}"
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
                                    <div class="form-floating"
                                         data-bs-toggle="tooltip" data-bs-placement="right"
                                         data-bs-title="{{__('Debe coincidir con la contraseña anterior')}}"
                                    >
                                        <input type="password" class="form-control passwordToggle" name="rePassword" id="rePassword" placeholder=" ">
                                        <label for="rePassword" class="form-label">
                                            <i class="fa-solid fa-shield"></i>
                                            {{__('Repite tu contraseña')}}
                                        </label>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                                <i class="fa-solid fa-user-plus"></i>
                                                {{__('Regístrate')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    {{__('¿Ya tienes cuenta?')}}
                                    <a href="{{route('sessions.create')}}">{{__('Inicia Sesión')}}</a>
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
                confForm()
                confTogglePassword()
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
                //Todo seguir, validar campos
                $("#registerForm").validate(
                    {
                        errorElement: "div",
                        errorPlacement: function (error, element) {
                            $(error).addClass('text-danger').addClass('mt-2')
                            error.addClass();
                            $(element.parent("div")).after(error)
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
                            username: {
                                required: true,
                                maxlength:255,
                                minlength:2
                            },
                            password: {
                                required: true,
                                maxlength:255
                            },
                        },
                        submitHandler: (form) => { //! Si no hay ningún error se corre el bloque submitHandler
                            form.submit()
                        }
                    }
                );
            };

        </script>
    </x-slot>
</x-layout.baseLayout>

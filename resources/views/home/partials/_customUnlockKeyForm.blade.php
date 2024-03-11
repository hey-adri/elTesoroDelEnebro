<div>
    <p>{{__('Necesitarás introducir un código de desbloqueo para desbloquear esta pista:')}}</p>
    <form method="post">
        <!-- Custom Input unlockKeyInput -->
        <div class="mb-4">
            <div class="form-floating">
                <!-- Input -->
                <input id="unlockKeyInput" type="text" class="form-control" name="unlockKey"
                       placeholder=" " data-bs-toggle="tooltip" data-bs-placement="top"
                       data-bs-title="${data.unlock_hint}">
                <!-- Label -->
                <label for="unlockKeyInput" class="form-label" for="unlockKey">
                    <i class="fa-solid fa-key"></i>
                    {{__('Código de Desbloqueo')}}
                </label>
            </div>
            <!-- Error -->
            <div class="form-text text-danger d-none unlockKeyErrors my-4">{{__('¡Vaya, Código de Desbloqueo incorrecto!')}}</div>
        </div>
        <!-- Submit -->
        <div class="mb-4">
            <div class="row">
                <div class="col">
                    <button id="unlockButton" type="submit"
                            class="btn btn-primary w-100 btn-lg" disabled>
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        {{__('Desbloquear')}}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

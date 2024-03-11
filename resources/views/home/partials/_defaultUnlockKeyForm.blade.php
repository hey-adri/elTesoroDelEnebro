<div>
    <p>¿Deseas desbloquear esta clave?</p>
    <form method="post">
        <!-- Default unlockKeyInput -->
        <input type="hidden" name="unlockKey" id="unlockKeyInput" value="${configuration.unlockKey}">
        <!-- Submit -->
        <div class="mb-4">
            <div class="row">
                <div class="col">
                    <button id="unlockButton" type="submit"
                            class="btn btn-primary w-100 btn-lg">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <span>{{__('Desbloquear')}}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

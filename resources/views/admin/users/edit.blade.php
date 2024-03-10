<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-sm">
                    <article>
                        <x-user.editUserForm :user="$user" :adminFeatures="true"/>
                    </article>
                    <div class="my-5">
                        <form method="POST" action="{{route('admin.users.destroy',['user'=>$user])}}" class="userDeletionForm d-inline-block w-100">
                            @method("DELETE")
                            @csrf
                            <button type="submit" class="deleteUserButton btn btn-outline-danger w-100" data-username="{{$user->username}}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{__('Si eliminas esta cuenta, sus Búsquedas del Tesoro y sus Pistas se eliminarán también.')}}"
                            ><i class="fa-solid fa-trash"></i> {{__('Eliminar')}} {{$user->username}}</button>
                        </form>
                    </div>
                </div>
            </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
        <x-user.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

@props(['user'])
<div class="mb-4">
    <div class="input-group">
        <div class="form-floating"
        @if($user->id==auth()->user()->id)
            data-bs-toggle="tooltip" data-bs-placement="top"
             data-bs-title="{{__('No puedes editar tus propios permisos de Administración')}}"
        @endif
        >
            <select class="form-select form-control" name="grantAdministrationPrivileges" id="grantAdministrationPrivileges" {{$user->id==auth()->user()->id?'disabled':''}}> {{--An administrator can't remove its administration priviledges--}}
                <option value="false" {{(!old('grantAdministrationPrivileges',$user->isAdmin)?'selected':'')}}>
                    No
                </option>
                <option value="true" {{(old('grantAdministrationPrivileges',$user->isAdmin)?'selected':'')}}>
                    Sí
                </option>

            </select>
            <label for="grantAdministrationPrivileges" class="form-label">
                <i class="fa-solid fa-user-gear"></i>
                {{__("Administrador")}}
            </label>
        </div>
        <span class="input-group-text"
              data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="{{__('¿Deseas que el usuario tenga permisos de Administración?')}}"
        ><i class="fa-solid fa-question"></i></span>
    </div>
</div>
<div class="mb-4">
    <div class="input-group">
        <div class="form-floating"
             data-bs-toggle="tooltip" data-bs-placement="right"
             data-bs-title="{{__('El número mínimo corresponde a las pistas PRO en uso')}}"
        >
            <input type="number" class="form-control" name="maximumProClues" id="maximumProClues" placeholder=" " value="{{
                // Setting the highest value, the user's max_pro_clues or the ones in use, even though, we're not allowing that to be possible through this UI
                    (old('maximumProClues',$user->max_pro_clues)>$user->countProClues())?old('maximumProClues',$user->max_pro_clues):$user->countProClues()
                }}" min="{{$user->countProClues()}}">
            <label for="title" class="form-label">
                <i class="fa-solid fa-scroll"></i>
                {{__('Número Máximo de Pistas Pro')}}
            </label>
        </div>
        <span class="input-group-text"
              data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="{{__('Número máximo de Pistas Pro que un usuario puede utilizar a la vez.')}}"
        ><i class="fa-solid fa-question"></i></span>
    </div>
</div>

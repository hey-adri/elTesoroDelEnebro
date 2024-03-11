@props(['user'=>null])
<div class="mb-4">
    <div class="input-group">
        <div class="form-floating"
        @if($user?->id==auth()->user()->id)
            data-bs-toggle="tooltip" data-bs-placement="top"
             data-bs-title="{{__('No puedes editar tus propios permisos de Administración')}}"
        @endif
        >
            <select class="form-select form-control" name="isAdmin" id="isAdmin" {{$user?->id==auth()->user()->id?'disabled':''}}> {{--An administrator can't remove its administration priviledges--}}
                <option value="0" {{(!old('isAdmin',$user?->isAdmin)?'selected':'')}}>
                    No
                </option>
                <option value="1" {{(old('isAdmin',$user?->isAdmin)?'selected':'')}}>
                    Sí
                </option>

            </select>
            <label for="isAdmin" class="form-label">
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
             @if($user)
                 data-bs-title="{{__('El número mínimo corresponde a las pistas PRO en uso')}}"
             @else
                 data-bs-title="{{__('Por defecto, su valor es el mismo que si se registrase normalmente')}}"
             @endif
        >
            <input type="number" class="form-control" name="max_pro_clues" id="max_pro_clues" placeholder=" " value="{{
                ($user?
                //Updating,Setting the highest value, the user's max_pro_clues or the ones in use, even though, we're not allowing that to be possible through this UI
                (old('max_pro_clues',$user?->max_pro_clues)>$user?->countProClues())?old('max_pro_clues',$user?->max_pro_clues):$user?->countProClues()
                :
                //Creating
                old('max_pro_clues',env('USER_INITIAL_PRO_CLUES'))
                )

                }}" min="{{($user?->countProClues()?$user?->countProClues():0)}}">
            <label for="max_pro_clues" class="form-label">
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

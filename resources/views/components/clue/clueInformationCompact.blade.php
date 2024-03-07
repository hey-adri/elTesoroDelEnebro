@props(['clue'])
<div class="clueInformationCompact paperCard h-100">
    <span class="{{$clue->isPro()?'badge-secondary':'badge'}}"><i class="fa-solid fa-note-sticky"></i> {{__('Pista').($clue->isPro()?' '.__('PRO'):'')}}</span>
    <h3 class="fs-3 mt-2 mb-2">
        <span class="fs-1">{{$clue->order}}.</span>
        {{$clue->title}}
    </h3>
    <div class="d-flex flex-column flex-sm-row gap-3">
        <div class="small flex-grow-1">
            <div class="text-muted my-1"><i class="fa-solid fa-clock-rotate-left"></i>{{__('Actualizada')}} {{$clue->updated_at->diffForHumans()}}</div>
            <div class="text-muted my-1"><i class="fa-solid fa-qrcode"></i>{{__('Clave Identificativa')}}: <span class="text-primary">{{$clue->clueKey}}</span></div>
            @if($clue->unlockKey!='default')
                <div class="text-muted my-1"><i class="fa-solid fa-key"></i>{{__('Código de Desbloqueo')}}: <span class="text-primary">{{$clue->unlockKey}}</span></div>
            @else
                <div class="text-muted my-1"><i class="fa-solid fa-lock-open"></i>{{__('Sin Código de Desbloqueo')}}</div>
            @endif
            @if(!empty($clue->help))
                <div class="text-muted my-1"><i class="fa-solid fa-life-ring"></i>{{__('Con ayuda disponible')}}</div>
            @endif

        </div>

        <hr class="d-sm-none">
        <div class="vr d-none d-sm-block"></div>
        <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center">
            <div>
                <a class="btn btn-outline-primary w-100" href="{{route('clue.show',['clue'=>$clue->clueKey])}}"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   data-bs-title="{{__('Visualiza cómo sería al escanear el QR')}}"
                ><i class="fa-solid fa-eye"></i> {{__('Previsualizar')}}</a>
            </div>
            <div>
                <a class="btn btn-outline-success w-100" href="{{route('clue.edit',['clue'=>$clue->clueKey])}}"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   data-bs-title="{{__('Edita los detalles de')}} {{$clue->title}}"
                ><i class="fa-solid fa-pen-nib"></i> {{__('Editar')}}</a>
            </div>
            <div>
                <form method="POST" action="{{route('clue.destroy',['clue'=>$clue->clueKey])}}" class="deleteClueForm d-inline-block w-100">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="deleteClueButton btn btn-outline-danger w-100" data-clueTitle="{{$clue->title}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{__('Eliminar ')}} {{$clue->title}}"
                    ><i class="fa-solid fa-trash"></i> {{__('Eliminar')}}</button>
                </form>
            </div>
        </div>
    </div>

</div>

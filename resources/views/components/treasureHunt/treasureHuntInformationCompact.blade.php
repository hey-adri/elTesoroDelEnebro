@props(['treasureHunt'])
<div class="treasureHunt paperCard h-100">
    @if($treasureHunt->isPro())
        <span class="badge-secondary"><i class="fa-solid fa-book"></i>{{count($treasureHunt->proClues())}} {{__('PRO')}}</span>
    @else
        <span class="badge"><i class="fa-solid fa-book"></i>{{__('Búsqueda del Tesoro')}}</span>
    @endif
    <h3 class="fs-3 mt-3"><span class="text-muted">{{__('Título: ')}}</span>{{$treasureHunt->title}}</h3>
    <ul class="list-unstyled d-flex flex-column fs-6 gap-1 mb-0">
        <li class="small text-muted"><i class="fa-solid fa-scroll"></i>{{__('Pistas:')}} {{$treasureHunt->clues->count()}}</li>
        <li class="small text-muted"><i class="fa-solid fa-clock-rotate-left"></i>{{__('Actualizada ')}} {{$treasureHunt->getLastUpdate()->diffForHumans()}}</li>
        <hr>
        <li class="d-flex flex-column flex-lg-row gap-2 justify-content-evenly mt-2">
            <a class="btn btn-success" href="{{route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id])}}"
               data-bs-toggle="tooltip" data-bs-placement="top"
               data-bs-title="{{__('¡Crea y consulta sus Pistas!')}}"
            ><i class="fa-solid fa-compass"></i> {{__('Explorar')}}</a>
            <form method="POST" action="{{route('treasureHunt.destroy',['treasureHunt'=>$treasureHunt->id])}}" class="deleteTreasureHuntForm d-inline-block">
                @method("DELETE")
                @csrf
                <button type="submit" class="deleteTreasureHuntButton btn btn-outline-danger w-100" data-treasureHuntTitle="{{$treasureHunt->title}}"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="{{__('Eliminando la Búsqueda del Tesoro también eliminarás sus pistas.')}}"
                ><i class="fa-solid fa-trash"></i> {{__('Eliminar')}}</button>
            </form>
        </li>
    </ul>
</div>

@props(['treasureHunt'])
<section class="col-12 d-flex justify-content-center treasureHuntInfo">
    <article class="paperCard max-width-lg w-100">
        <span class="{{$treasureHunt->isPro()?'badge-secondary':'badge'}}"><i class="fa-solid fa-book"></i> {{__('Búsqueda del Tesoro').($treasureHunt->isPro()?' '.__('PRO'):'')}}</span>
        <div class="d-flex justify-content-start gap-2 align-items-center">
            <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-book"></i></span>
            <h1 class="paperCardTitle d-inline-block">{{$treasureHunt->title}}</h1>
        </div>
        <span class="text-body text-muted">
            <i class="fa-solid fa-clock-rotate-left"></i>
            {{__('Actualizada ')}} {{$treasureHunt->getLastUpdate()->diffForHumans()}}
        </span>
        <div class="mt-4">
            <div class="w-100 text-center d-flex flex-column flex-md-row justify-content-evenly gap-3">
                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <span class="handwritten">{{__('Pistas Totales:')}}</span>
                    <span class="ms-2"><i class="fa-solid fa-scroll"></i>{{$treasureHunt->clues->count()}}</span>
                </div>
                <hr class="d-md-none">
                <div class="vr d-none d-md-block"></div>
                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <span class="handwritten">{{__('Pistas Pro:')}}</span>
                    <span class="{{$treasureHunt->isPro()?'badge-secondary':'badge'}} ms-2"><i class="fa-solid fa-scroll"></i>{{count($treasureHunt->proClues())}} {{__('PRO')}}</span>
                </div>
                <hr class="d-md-none">
                <div class="vr d-none d-md-block"></div>
                <div class="row row-cols-1 row-cols-sm-2 flex-grow-1 g-2">
                    <div class="col">
                        <a class="btn btn-primary w-100" href="{{route('clue.create',['treasureHunt'=>$treasureHunt->id])}}"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           data-bs-title="{{__('Crea y añade pistas tu Búsqueda')}}"
                        ><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-scroll"></i> {{__('Añadir Pista')}}</a>
                    </div>
                    <div class="col">
                        <a class="btn btn-success w-100" href="{{route('treasureHunt.edit',['treasureHunt'=>$treasureHunt->id])}}"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           data-bs-title="{{__('Edita el título de tu Búsqueda')}}"
                        ><i class="fa-solid fa-pen-nib"></i> {{__('Editar')}}</a>
                    </div>
                    <div class="col"
                         data-bs-toggle="tooltip" data-bs-placement="top"
                         @if($treasureHunt->clues()->count()>0)
                             data-bs-title="{{__('¡Genera QRs para imprimirlos y comenzar la aventura!')}}"
                         @else
                             data-bs-title="{{__('Para Generar QRs es necesario que hayas creado alguna Pista')}}"
                        @endif>
                        <form method="GET" action="{{route('treasureHunt.generateQRCodes',['treasureHunt'=>$treasureHunt->id])}}" class="getTreasureHuntQRsForm d-inline-block w-100">
                            @csrf
                            <button type="submit" class="getTreasureHuntQRsButton btn btn-secondary w-100 {{!$treasureHunt->clues()->count()>0?'disabled':''}}"  data-treasureHuntTitle="{{$treasureHunt->title}}">
                                <i class="fa-solid fa-qrcode"></i> {{__('Generar QRs')}}
                            </button>
                        </form>
                        <x-treasureHunt.getQrsConfirmationScript/>
                    </div>
                    <div class="col">
                        <form method="POST" action="{{route('treasureHunt.destroy',['treasureHunt'=>$treasureHunt->id])}}" class="deleteTreasureHuntForm d-inline-block w-100">
                            @method("DELETE")
                            @csrf
                            <input type="hidden" name="backTo" value="{{'userArea.index'}}">
                            <button type="submit" class="deleteTreasureHuntButton btn btn-outline-danger w-100" data-treasureHuntTitle="{{$treasureHunt->title}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{__('Eliminando la Búsqueda del Tesoro también eliminarás sus pistas.')}}"
                            ><i class="fa-solid fa-trash"></i> {{__('Eliminar')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{$content}}
    </article>
</section>

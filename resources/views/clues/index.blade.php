<article class="paperCard max-width-lg w-100 mt-5">
    <div class="d-flex justify-content-start gap-2 align-items-center my-2">
        <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-note-sticky"></i></span>
        <h1 class="d-inline-block">{{__('Pistas Asociadas')}}</h1>
    </div>
    <x-extras.searchFilter :tooltip="__('Buscar por título de la Búsqueda del Tesoro o el Título de sus Pistas...')">
        <x-slot name="filters">
            <div>
                <div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="filters[]" value="ProOnly" id="proOnly" {{
                                                    in_array('ProOnly',(request('filters')?request('filters'):[]))
                                                    ?'checked':''
                                                    }}>
                        <label class="form-check-label" for="proOnly">
                            {{__('Sólo Mostrar')}} <span class="badge-secondary ms-2"><i class="fa-solid fa-book"></i>{{__('PRO')}}</span>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-row gap-1 align-items-center">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                    <div class="flex-grow w-100">
                        <select class="form-select w-100" name="sortBy" >
                            <option value="latest" {{ ((request('sortBy')==''||(request('sortBy')=='latest'))?'selected':'')}}>
                                {{__('Últimas')}}
                            </option>
                            <option value="oldest" {{ ((request('sortBy')=='oldest')?'selected':'')}}>
                                {{__('Antiguas')}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-extras.searchFilter>
    <hr>
    @if(count($clues)>0)
        <div class="treasureHuntsContainer row justify-content-evenly align-items-stretch row-cols-1">
            <div class="my-4">
                {{$clues->appends(request()->all())->links()}}
            </div>
            @foreach($clues as $clue)
                <div class="col py-3">
                    <x-clue.clueInformationCompact :clue="$clue"/>
                </div>
            @endforeach
            <div class="my-4">
                {{$clues->appends(request()->all())->links()}}
            </div>
        </div>
    @else
        <x-extras.nothingFound :text="__('Parece que no hay ninguna pista por aquí...')"/>
        <a class="btn btn-outline-primary w-100" href="{{route('clue.create',['treasureHunt'=>$treasureHunt->id])}}"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-note-sticky"></i> {{__('Añadir Pista')}}</a>
    @endif
</article>

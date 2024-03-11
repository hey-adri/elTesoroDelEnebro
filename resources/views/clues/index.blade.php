<article class="paperCard max-width-lg w-100 mt-5">
    <div class="d-flex justify-content-start gap-2 align-items-center my-2">
        <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-scroll"></i></span>
        <h1 class="d-inline-block">{{__('Pistas Asociadas')}}</h1>
    </div>
    <x-extras.searchFilter :tooltip="__('Buscar por título, contenido, clave...')">
        <x-slot name="filters">
            <div>
                <div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="filters[]" value="pro" id="pro" {{
                                                    in_array('pro',(request('filters')?request('filters'):[]))
                                                    ?'checked':''
                                                    }}>
                        <label class="form-check-label" for="pro">
                            {{__('Sólo Mostrar')}} <span class="badge-secondary ms-2"><i class="fa-solid fa-book"></i>{{__('PRO')}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="filters[]" value="has_image" id="has_image" {{
                                                    in_array('has_image',(request('filters')?request('filters'):[]))
                                                    ?'checked':''
                                                    }}>
                        <label class="form-check-label" for="has_image">
                            {{__('Con Imagen')}} <i class="fa-solid fa-images"></i>
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="filters[]" value="has_embedded_video" id="has_embedded_video" {{
                                                    in_array('has_embedded_video',(request('filters')?request('filters'):[]))
                                                    ?'checked':''
                                                    }}>
                        <label class="form-check-label" for="has_embedded_video">
                            {{__('Con Vídeo')}} <i class="fa-brands fa-youtube"></i>
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex flex-row gap-1 align-items-center">
                <div class="flex-grow h-100">
                    <div class="d-flex">
                        <div class="form-check ps-0">
                            <input class="form-check-input d-none" type="radio" name="sortDirection" id="sortDirectionDesc" value="desc" {{ ((request('sortDirection')==''|| request('sortDirection')=='desc')?'checked':'')}}>
                            <label class="form-check-label" for="sortDirectionDesc">
                                <i class="fa-solid fa-arrow-down-wide-short"></i>
                            </label>
                        </div>
                        <div class="form-check ps-0">
                            <input class="form-check-input d-none" type="radio" name="sortDirection" id="sortDirectionAsc" value="asc" {{ (((request('sortDirection')=='asc'))?'checked':'')}}>
                            <label class="form-check-label" for="sortDirectionAsc">
                                <i class="fa-solid fa-arrow-up-wide-short"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex-grow w-100">
                    <select class="form-select w-100" name="sortBy" >
                        <option value="updated_at" {{ (request('sortBy')==''||(request('sortBy')=='updated_at'))?'selected':''}}>
                            {{__('Recientes')}}
                        </option>
                        <option value="order" {{((request('sortBy')=='order')?'selected':'')}}>
                            {{__('Posición')}}
                        </option>
                        <option value="title" {{ ((request('sortBy')=='title')?'selected':'')}}>
                            {{__('Título')}}
                        </option>
                    </select>
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
        <a class="btn btn-outline-primary w-100" href="{{route('clue.create',['treasureHunt'=>$treasureHunt->id])}}"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-scroll"></i> {{__('Añadir Pista')}}</a>
    @endif
</article>

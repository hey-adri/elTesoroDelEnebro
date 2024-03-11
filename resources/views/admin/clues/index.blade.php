<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
        <div class="row g-5">
            <section class="treasureHuntsSection">
                <div class="col-12 d-flex justify-content-center">
                    <article class="paperCard max-width-lg w-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-2 mb-2">
                            <div class="d-flex justify-content-center gap-2 align-items-center">
                                <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-scroll"></i></span>
                                <h1 class="paperCardTitle d-inline-block">{{__('Administración de Pistas')}}</h1>
                            </div>
                        </div>
                        <x-extras.searchFilter :tooltip="__('Buscar por título, clave identificativa, clave de desbloqueo, título de búsqueda del tesoro o nombre de usuario...')">
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
                                            <option value="title" {{ ((request('sortBy')=='title')?'selected':'')}}>
                                                {{__('Título')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </x-slot>
                        </x-extras.searchFilter>

                        <hr>
                        <div class="userTableContainer row justify-content-evenly">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('Clave')}}</th>
                                        <th scope="col">{{__('Título')}}</th>
                                        <th scope="col">{{__('Actualizada')}}</th>
                                        <th scope="col">{{__('Usuario')}}</th>
                                        <th scope="col">{{__('Búsqueda del Tesoro')}}</th>
                                        <th scope="col">{{__('PRO')}}</th>
                                        <th scope="col">{{__('Código Desbloqueo')}}</th>
                                        <th scope="col">{{__('Acciones')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($clues))
                                        @foreach($clues as $clue)
                                            <x-clue.clueRow :clue="$clue"/>
                                        @endforeach
                                    @else
                                       <tr>
                                           <td colspan="9">
                                               <x-extras.nothingFound :text="__('Parece que no hay nada por aquí...')"/>
                                           </td>
                                       </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    {{$clues->appends(request()->all())->links()}}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
        <x-clue.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

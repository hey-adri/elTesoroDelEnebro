<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
      <div class="row g-5">
          <div class="col-12 d-flex justify-content-center">
              <div class="paperCard max-width-lg w-100">
                  <div class="d-flex justify-content-center gap-2 align-items-center">
                      <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-user"></i></span>
                      <h1 class="display-4 d-inline-block m-0">{{__('Área Personal')}}</h1>
                  </div>
              </div>
          </div>

            <x-user.userInformation :user="auth()->user()"/>
            <section class="treasureHuntsSection">
                <div class="col-12 d-flex justify-content-center">
                    <article class="paperCard max-width-lg w-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-2 mb-4">
                            <div class="d-flex justify-content-center gap-2 align-items-center">
                                <span class="fs-3 text-primary pb-2"><i class="fa-solid fa-book"></i></span>
                                <h1 class="paperCardTitle d-inline-block">{{__('Tus Búsquedas del Tesoro')}}</h1>
                            </div>

                            <a href="{{route('treasureHunt.create')}}" class="btn btn-outline-primary"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</a>
                        </div>
                        <x-extras.searchFilter :tooltip="__('Buscar por título de la Búsqueda del Tesoro o el Título de sus Pistas...')">
                            <x-slot name="filters">
                                <div>
                                    <div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="filters[]" value="pro" id="pro" {{
                                                    in_array('pro',(request('filters')?request('filters'):[]))
                                                    ?'checked':''
                                                    }}>
                                            <label class="form-check-label" for="pro">
                                                {{__('Sólo Mostrar Búsquedas')}} <span class="badge-secondary ms-2"><i class="fa-solid fa-book"></i>{{__('PRO')}}</span>
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
                                            <option value="updated_at" {{ ((request('sortBy')==''||(request('sortBy')=='updated_at'))?'selected':'')}}>
                                                {{__('Recientes')}}
                                            </option>
                                            <option value="pro_clues_count" {{ ((request('sortBy')=='pro_clues_count')?'selected':'')}}>
                                                {{__('Número de Pistas Pro')}}
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
                        @if(count($treasure_hunts))
                        <div class="treasureHuntsContainer row justify-content-evenly align-items-stretch row-cols-1 row-cols-sm-2 row-cols-lg-3">
                            @foreach($treasure_hunts as $treasureHunt)
                                <div class="col py-3">
                                    <x-treasureHunt.treasureHuntInformationCompact :treasureHunt="$treasureHunt"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="my-4">
                            {{$treasure_hunts->appends(request()->all())->links()}}
                        </div>
                        @else
                            <x-extras.nothingFound :text="__('Parece que no hay ninguna Búsqueda del Tesoro por aquí...')"/>
                            <div class="row mt-4">
                                <div class="col">
                                    <a href="{{route('treasureHunt.create')}}" class="btn btn-outline-primary w-100"><i class="fa-solid fa-plus me-0"></i><i class="fa-solid fa-book"></i> {{__('Crear una Búsqueda del Tesoro')}}</a>
                                </div>
                            </div>
                        @endif
                    </article>
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="floatingButtons">
        <x-extras.backButton :backTo="$backTo"/>
    </x-slot>
    <x-slot name="scripts">
        <x-treasureHunt.deleteConfirmationScript/>
    </x-slot>
</x-layout.baseLayout>

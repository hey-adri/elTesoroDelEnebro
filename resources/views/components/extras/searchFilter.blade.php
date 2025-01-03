@props(['tooltip'])
<form method="get" action="{{request()->url().'#searchBar'}}" id="searchBar">
    <div class="input-group">
        <div class="form-floating"
             data-bs-toggle="tooltip" data-bs-placement="top"
             data-bs-title="{{$tooltip}}"
        >
            <input type="text" class="form-control" name="search" id="search" placeholder=" " value="{{request('search')}}">
            <label for="search" class="form-label">
                <i class="fa-solid fa-search"></i>
                {{__('Buscar...')}}
            </label>
        </div>
        <div class="input-group-text border-0 py-0 px-0">
            <div class="dropdown-center h-100 me-2">
                <button type="button" class="btn {{request('filters')?'btn-warning':'btn-outline-primary'}} dropdown-toggle h-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    @if(request('filters'))
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    @else
                        <i class="fa-solid fa-filter"></i>
                    @endif

                    <span class="d-none d-sm-inline-block">{{__('Filtros')}}</span>
                </button>
                <div class="dropdown-menu p-4">
                    {{$filters}}
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-0 h-100">
                <i class="fa-solid fa-search"></i>
            </button>
        </div>
    </div>
</form>

<li class="nav-item text-primary dropdown">
    <button class="nav-link  dropdown-toggle
        {{request()->routeIs(['setLocale.*'])?'active':''}}
    " href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-language"></i>
        {{__('Idioma')}}
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        @foreach(config('app.available_locales') as $locale_name => $available_locale)
            @if($available_locale === app()->getLocale())
                <li><span class="dropdown-item disabled fw-bold text-primary">{{ __($locale_name) }}</span></li>
            @else
                <li><a class="dropdown-item" href="{{route('setLocale',['locale'=>$available_locale])}}">{{ __($locale_name) }}</a></li>
            @endif
        @endforeach
    </ul>
</li>

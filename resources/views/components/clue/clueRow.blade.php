@props(['clue'])
<tr>
    <td class="">
        <span>
            {{$clue->clueKey}}
        </span>
    </td>
    <td class="">
        <span>
            {{$clue->title}}
        </span>
    </td>
    <td class="">
        <span>
            {{$clue->updated_at->diffForHumans()}}
        </span>
    </td>
    <td>
       <a href="{{route('admin.users.index',['search'=>$clue->treasure_hunt->owner->username])}}" class="d-flex justify-content-start gap-2 align-items-center w-100 overflow-x-scroll">
           <div class="userProfilePhoto roundPhoto max-width-30 flex-grow-0 flex-shrink-0">
               <img class="" src="{{asset('storage/'.$clue->treasure_hunt->owner->profile_image)}}">
           </div>
           <span>
            {{$clue->treasure_hunt->owner->username}}
            </span>
       </a>
    </td>
    <td class="">
        <a href="{{route('admin.treasureHunts.index',['search'=>$clue->treasure_hunt->title])}}">
            {{$clue->treasure_hunt->title}}
        </a>
    </td>
    <td>

        <span class="{{($clue->isPro())?'badge-secondary':'badge'}}"><i class="fa-solid fa-scroll"></i>
        @if($clue->image)
                <i class="fa-solid fa-image"></i>
        @endif
        @if($clue->embedded_video)
                <i class="fa-brands fa-youtube"></i>
        @endif
        </span>
    </td>
    <td class="text-start">
        <span>
        @if($clue->unlockKey!='default')

            <span data-bs-toggle="tooltip" data-bs-placement="right"
                  data-bs-title="{{__('Bloqueo Personalizado')}}">
                <i class="fa-solid fa-lock"></i>  {{$clue->unlockKey}}
            </span>
        @else
            <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="right"
                  data-bs-title="{{__('Bloqueo Por defecto')}}">
                <i class="fa-solid fa-lock-open"></i>
            </span>
        @endif
        </span>
    </td>
    <td>
        <div class="d-flex flex-column flex-lg-row gap-3 justify-content-center align-items-lg-center">
            <div>
                <a class="btn btn-outline-primary w-100" href="{{route('admin.clues.show',['clue'=>$clue->clueKey])}}"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   data-bs-title="{{__('Previsualizar')}} {{$clue->clueKey}}"
                ><i class="fa-solid fa-eye"></i></a>
            </div>
            <div>
                <form method="POST" action="{{route('admin.clues.destroy',['clue'=>$clue->clueKey])}}" class="deleteClueForm d-inline-block w-100">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="deleteClueButton btn btn-outline-danger w-100" data-clueTitle="{{$clue->title}}"  data-clueKey="{{$clue->clueKey}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{__('Eliminar ')}} {{$clue->clueKey}}"
                    ><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </td>

</tr>

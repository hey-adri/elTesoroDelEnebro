@props(['user'])
<tr>
    <td>
       <div class="d-flex justify-content-start gap-2 align-items-center w-100 overflow-x-scroll">
           <div class="userProfilePhoto roundPhoto max-width-30 flex-grow-0 flex-shrink-0">
               <img class="" src="{{asset('storage/'.$user->profile_image)}}">
           </div>
           <span>
            {{$user->username}}
            </span>
       </div>
    </td>
    <td class="">
        <span>
            {{$user->name}}
        </span>
    </td>
    <td class="">
        <span>
            {{$user->email}}
        </span>
    </td>
    <td class="">

        @if($user->isAdmin)
            <span class="text-primary"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="{{__('Usuario Administrador')}}">
            <i class="fa-solid fa-gears"></i>
        </span>
        @else
            <span class="text-muted"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="{{__('Usuario Estándar')}}">
            <i class="fa-solid fa-user"></i>
        </span>
        @endif
    </td>
    <td>
        <a href="{{route('admin.treasureHunts.index',['search'=>$user->username])}}">{{$user->treasure_hunts()->count()}}</a>
    </td>
    <td>
        <a href="{{route('admin.clues.index',['search'=>$user->username])}}">{{$user->clues()->count()}}</a>
    </td>
    <td>
        <span class="{{($user->countProClues()>0)?'badge-secondary':'badge'}}"><i class="fa-solid fa-scroll"></i>{{$user->countProClues()}} {{__('PRO')}} / {{$user->max_pro_clues}} {{__('MAX')}}</span>
    </td>
    <td>
        <span class="{{($user->countCluesWithImages()>0)?'text-primary':'text-muted'}}">{{$user->countCluesWithImages()}}</span>
    </td>
    <td>
        <span class="{{($user->countCluesWithEmbeddedVideos()>0)?'text-primary':'text-muted'}}">{{$user->countCluesWithEmbeddedVideos()}}</span>
    </td>
    <td>
        <div class="d-flex flex-column flex-lg-row gap-3 justify-content-center align-items-lg-center">
            <div>
                <a class="btn btn-outline-success btn-sm w-100" href="{{route('admin.users.edit',$user)}}"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   data-bs-title="{{__('Gestionar')}} {{$user->username}}"
                ><i class="fa-solid fa-user-gear"></i></a>
            </div>
            <div>
                <form method="POST" action="{{route('admin.users.destroy',['user'=>$user])}}" class="userDeletionForm d-inline-block w-100">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="deleteUserButton btn btn-outline-danger w-100 btn-sm" data-username="{{$user->username}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{__('Eliminar')}} {{$user->username}}"
                    ><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>

    </td>

</tr>

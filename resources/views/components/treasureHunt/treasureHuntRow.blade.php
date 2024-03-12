@props(['treasureHunt'])
<tr>
    <td class="">
        <span>
            {{$treasureHunt->title}}
        </span>
    </td>
    <td class="">
        <span>
            {{$treasureHunt->getLastUpdate()->diffForHumans()}}
        </span>
    </td>
    <td>
       <a href="{{route('admin.users.index',['search'=>$treasureHunt->owner->username])}}" class="d-flex justify-content-start gap-2 align-items-center w-100 overflow-x-scroll">
           <div class="userProfilePhoto roundPhoto max-width-30 flex-grow-0 flex-shrink-0">
               <img class="" src="{{asset('storage/'.$treasureHunt->owner->profile_image)}}">
           </div>
           <span>
            {{$treasureHunt->owner->username}}
            </span>
       </a>
    </td>
    <td class="">
        <a href="{{route('admin.clues.index',['search'=>$treasureHunt->title])}}">
            {{$treasureHunt->clues()->count()}}
        </a>
    </td>
    <td>
        <span class="{{($treasureHunt->proCluesCount()>0)?'badge-secondary':'badge'}}"><i class="fa-solid fa-scroll"></i>{{$treasureHunt->proCluesCount()}}</span>
    </td>
    <td>
        <span>{{$treasureHunt->countCluesWithImages()}}</span>
    </td>
    <td>
        <span>{{$treasureHunt->countCluesWithEmbeddedVideos()}}</span>
    </td>

    <td>
        <div class="d-flex flex-column flex-lg-row gap-3 justify-content-center align-items-lg-center">
            <div>
                <div data-bs-toggle="tooltip" data-bs-placement="top"
                     @if($treasureHunt->clues()->count()>0)
                         data-bs-title="{{__('Generar QRs de')}} {{$treasureHunt->title}}"
                     @else
                         data-bs-title="{{__('Para Generar QRs es necesario que exista alguna Pista')}}"
                    @endif>
                    <form method="GET" action="{{route('admin.treasureHunts.generateQRCodes',['treasureHunt'=>$treasureHunt->id])}}" class="getTreasureHuntQRsForm d-inline-block w-100">
                        @csrf
                        <button type="submit" class="getTreasureHuntQRsButton btn btn-outline-primary btn-sm w-100 {{!$treasureHunt->clues()->count()>0?'disabled':''}}"  data-treasureHuntTitle="{{$treasureHunt->title}}">
                            <i class="fa-solid fa-qrcode"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div>
                <form method="POST" action="{{route('admin.treasureHunts.destroy',['treasureHunt'=>$treasureHunt->id])}}" class="deleteTreasureHuntForm d-inline-block w-100">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" name="backTo">
                    <button type="submit" class="deleteTreasureHuntButton btn btn-outline-danger btn-sm w-100" data-treasureHuntTitle="{{$treasureHunt->title}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{__('Eliminar')}} {{$treasureHunt->title}}"
                    ><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </td>

    </td>

</tr>

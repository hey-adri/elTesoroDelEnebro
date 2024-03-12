<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{__(str_replace("-", " ", __('El Tesoro Del Enebro'.' '.$treasureHunt->title.' '.now())))}}</title>

    <style>
        *{
            font-family: Helvetica ;
            color: #603601;
        }
        .qrCard{
            text-align: center;
            width: 68px;
            height: 150px;
            overflow: hidden;
            border: rgba(96, 54, 1, 1) solid 1px;
            border-radius: 10px;
            margin: auto;
            padding: 15px 22px 30px 22px;
        }
        .imageContainer{
            width: 100%;
        }
        .qrCard img{
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        table{
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }
        td{
            text-align: center;
            vertical-align: top;
            margin: 0px;
        }
        .clueKey{
            font-size: 12px;
            margin: 2px;
        }
        .clueTitle, .label{
            font-size: 9px;
            opacity: 0.5;
        }
        .head{
            font-size: 7px;
            opacity: 0.5;
        }

    </style>
</head>
<body>
<main>
    <div style="text-align: left">
        <h1 style="display: inline-block; margin-top: 0">
            <span style="opacity: 0.5">{{__('Búsqueda del Tesoro')}}:</span>
            {{$treasureHunt->title}}</h1>
    </div>
    <div style="text-align: right">

        <h3 >
            <span style="opacity: 0.5; font-size: 13px">~ De {{$treasureHunt->owner->name}} / {{\Illuminate\Support\Carbon::parse($treasureHunt->getLastUpdate())->translatedFormat('d F Y')}} </span>
            {{__('El Tesoro del Enebro')}}
        </h3>
    </div>
    <table class="cluesQrCodesContainer">
        <tr>
            @foreach($treasureHunt->clues as $clue)
                <td>
                    <div class="qrCard">
                        <div class="head">{{__('El Tesoro del Enebro')}}</div>
                        <div class="imageContainer">
                            <img class="" src="data:image/png;base64, {!! base64_encode(
                                                            SimpleSoftwareIO\QrCode\Facades\QrCode::size(512)
                                                                    ->format('png')
                                                                     ->merge('assets/img/logos/logoQr.png', 0.35, true)
                                                                     ->color(96,54,1)
                                                                     ->errorCorrection('H')
                                                                     ->eye('square',0.5)
                                                                     ->style('round',0.5)
                                                                     ->generate(route('home.showKey',['clueKey'=>$clue->clueKey]))
                                                        ) !!} ">
                        </div>
                        <div class="label">Clave</div>
                        <div class="clueKey">{{$clue->clueKey}}</div>
                        <div class="clueTitle">{{$clue->order}}. {{$clue->title}}</div>
                    </div>

                </td>
                @if($loop->iteration%6==0)
            </tr>
            <tr>
                @endif
            @endforeach
        </tr>
    </table>
</main>
</body>
</html>

<x-layout.baseLayout>
    <x-slot name="links"></x-slot>
    <x-slot name="content">
        <div class="row g-5">
            <x-user.userInformation :user="auth()->user()"></x-user.userInformation>
            <section class="treasureHuntsSection">
                <div class="col-12 d-flex justify-content-center">
{{--                    Todo 0. Cambiar rowcols tamaño pantalla--}}
{{--                    Todo 0.1 Mostrar si no hay treasure hunts--}}
{{--                    Todo 1. Extreaer treasure hunts en componente y poner titulo--}}
{{--                    Todo 2. Implementar delete th--}}
{{--                    Todo 3. Implementar show th, tb edita--}}
                    <article class="paperCard max-width-lg w-100">
                        <div class="treasureHuntsContainer row align-items-stretch row-cols-1 row-cols-sm-2 row-cols-lg-3">
                            @foreach(auth()->user()->treasure_hunts as $treasureHunt)
                                <div class="col py-3">
                                    <div class="treasureHunt paperCard h-100 position-relative">
{{--                                        Todo una etiqueta u otra si pistas pro y explicacion --}}
                                        <span class="small position-absolute top-0 start-0 bg-secondary p-1 m-2 text-white rounded"><i class="fa-solid fa-book"></i>PRO</span>
                                        <span class="small position-absolute top-0 start-0 bg-primary-subtle p-1 m-2 text-primary rounded"><i class="fa-solid fa-book"></i></span>
                                        {{--Spacer--}}
                                        <div class="my-4"></div>
                                        <h3 class="fs-3"><span class="text-muted">{{__('Título: ')}}</span>{{$treasureHunt->title}}</h3>
                                        <ul class="list-unstyled d-flex flex-column fs-6 gap-1 mb-0">
                                            <li class="small text-muted"><i class="fa-solid fa-note-sticky"></i>{{__('Pistas:')}} {{$treasureHunt->clues->count()}}</li>
                                            <li class="small text-muted"><i class="fa-solid fa-clock-rotate-left"></i>{{__('Actualizada ')}} {{$treasureHunt->getLastUpdate()->diffForHumans()}}</li>
                                            <hr>
                                            <li class="d-flex flex-column flex-lg-row gap-2 justify-content-evenly mt-2">
                                                <a class="btn btn-primary" href="{{route('userArea.treasureHunt.show',['treasureHunt'=>$treasureHunt->id])}}"><i class="fa-solid fa-compass"></i> {{__('Explorar')}}</a>
                                                <form method="POST" action="{{route('treasureHunt.destroy',['treasureHunt'=>$treasureHunt->id])}}" class="deleteTreasureHuntForm d-inline-block">
                                                    @method("DELETE")
                                                    @csrf
                                                    <button type="submit" class="deleteTreasureHuntButton btn btn-danger w-100" data-treasureHuntTitle="{{$treasureHunt->title}}"><i class="fa-solid fa-trash"></i> {{__('Eliminar')}}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <script>
                            {{-- Adding Confirmation to delete  --}}
                            document.addEventListener('DOMContentLoaded',()=>{
                                $('.deleteTreasureHuntButton').on('click',askForDeleteConfirmation)
                            })
                            const askForDeleteConfirmation = ()=>{
                                event.preventDefault()
                                const form = $(event.target).closest('form');
                                showDeleteDialog(
                                    `{{__('Vas a eliminar')}} "${$(event.target).attr(`data-treasureHuntTitle`)}". {{__('¡Se eliminarán todas las pistas asociadas!')}}`,
                                    `{{__('¿Estás Seguro?')}}`,
                                    `{{__('Sí, eliminar')}}`,
                                    `{{__('No, cancelar')}}`,
                                    ()=>{form.submit()},
                                    ()=>{console.log('cancel')}
                                )
                            }
                        </script>
                    </article>
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="floatingButtons"></x-slot>
    <x-slot name="scripts">

    </x-slot>
</x-layout.baseLayout>

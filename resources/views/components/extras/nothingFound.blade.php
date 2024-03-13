@props(['text'])
<div class="col my-2">
    <div class="display-1 w-100 d-flex justify-content-center"><i class="fa-solid fa-kiwi-bird"></i></div>
    @if($text)
        <p class="text-center mt-2">
            {{$text}}
        </p>
    @endif
</div>

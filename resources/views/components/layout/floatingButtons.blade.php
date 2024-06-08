<aside class="floatingButtonsContainer z-2 position-fixed bottom-0 end-0 mb-5 mx-3">
    <div class="floatingButtons d-flex flex-row gap-3 align-items-end">
        {{$slot}}
        <!-- Link topOfThePage -->
        <a href="#topOfThePage" id="topOfThePageButton" class="btn d-none border-0 glassButton rounded-4 growOnHover">
            <i class="fa-solid fa-chevron-up"></i>
        </a>
    </div>
</aside>

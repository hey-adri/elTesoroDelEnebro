<script>
    "use strict";
    //! Main Configuration
    const configuration = {
        clueKey: @if(isset($clueKey))`{{$clueKey}}`@else ``@endif,
        unlockKey: "default",
        timeoutToHelp: 60, //secs to help
        animationMs: 700,
        host: "{{route('apiCluesRoot')}}",
        clueFoundResponse: null, //Stores the clue once retrived
        wait: {
            min: 3,
            max: 5
        }
    }

    $(() => {
        //Checking whether we received a clueKey or not through url
        if (configuration.clueKey != null && configuration.clueKey != "") {
            //clueKey Received, checking immediately
            checkClueDetails(true);
        } else {
            //No clueKey, display welcomePage
            displayWelcomePage();
        }
    })

    //! Welcome Page View
    /**
     * Displays a welcome page with the form to view a key from its clueKey
     */
    const displayWelcomePage = () => {
        //Emptying the main content and replacing it
        $('#mainContent').empty();
        $('#mainContent').append(
            `@include('home.partials._welcomePage')
            `
        )
        refreshBSTooltips();
        animateShow($('#mainContent .welcomePage'),configuration.animationMs)
        //Adding the listener to enable the unlock button just if the unlockKey is correct
        $("#clueKeyInput").on("input", clueKeyInputChanged)
        clueKeyInputChanged(); //Checking the input right upon creation

        //Adding form submission listener
        $(`.clueKeyForm`).on("submit", clueKeyFormSubmitted)
    }
    /**
     * Allows the clueKeyForm submit only if the clueKey exists
     */
    const clueKeyInputChanged = async () => {
        $(`#clueKeyInput`).val($(`#clueKeyInput`).val().toUpperCase())
        if ($(`#clueKeyInput`).val() != "") {
            $(`#clueKeyInput`).addClass("is-invalid");
        }
        else {
            $(`#clueKeyInput`).removeClass("is-invalid").removeClass("is-valid");
        }
        if ($(`#clueKeyInput`).hasClass('is-invalid')  && $('.clueKeyErrors').hasClass('d-none')) {
            animateShow('.clueKeyErrors',configuration.animationMs)
        }
        $(`#analizeButton`).prop("disabled", true);

        //Updating the clueKey with the value in the input
        configuration.clueKey = $(`#clueKeyInput`).val()
        if(configuration.clueKey != null && configuration.clueKey != "") { //Making the request only if there's an input value
            try {
                //Checking the value in backEnd, enabling button if correct
                const checkedKey = configuration.clueKey //Making sure the checked key hasn't changed after async request
                const json = await queryCheckClueDetails()
                if ((!json.error)&&(configuration.clueKey==checkedKey)) {
                    //Correct key found, enabling submit
                    $(`#analizeButton`).prop("disabled", false);
                    $(`#clueKeyInput`).removeClass("is-invalid").addClass("is-valid");
                    animateHide('.clueKeyErrors',configuration.animationMs)
                }
            } catch (error) {
                showPopup(`{{__('Error en Conexión con BD')}}`,`{{__('Error')}}`,`{{__('error')}}`)
            }
        }
    }

    /**
     * Checks the clue details while it displays a spinner
     * @param {*} event
     */
    const clueKeyFormSubmitted = (event) => {
        event.preventDefault()
        $(`.clueKeyForm`).after(
            `<div class='loaderContainer'><div class='loader'></div></div>`
        );
        animateShow(`.loaderContainer`,configuration.animationMs);
        $('#analizeButton').prop("disabled", true)
        $(`#clueKeyInput`).prop('disabled',true)
        $('#analizeButton span').text(`{{__('Analizando')}}`)
        checkClueDetails()
    }

    /**
     * Checks if the clueKey in configuration references an existing clue:
     *  If the clue exists, printUnlockForm()
     *  If the clue doesn't exists or is null, displayWelcomePage()
     * ! Waits some time to printUnlockForm(), for dramatism
     */
    const checkClueDetails = async (skipWaitTime=false) => {
        //Getting the clue key details from backEnd
        try {
            const startOfQuery = new Date();
            //Checking the value in backEnd, enabling button if correct
            const json = await queryCheckClueDetails()
            //Waiting some time for dramatism
            let waitSecs = generateWaitSecs(configuration.wait.min,configuration.wait.max,startOfQuery);
            if(skipWaitTime) waitSecs = 0;
            window.setTimeout(
                () => {
                    if (!json.error) {
                        //The clue exists
                        //Printing the decryption form according to its encription
                        printUnlockForm(json.data);
                        //Removing the welcomePage
                        animateDestroy(`.welcomePage`,configuration.animationMs)

                    } else {
                        //The clue key doesn't exist, print greeting form
                        showPopup(`{{__('Parece que no hemos encontrado la clave introducida!')}}`,`{{__('Vaya!')}}`,'error',displayWelcomePage,`{{__('Probar con otra clave')}}`)
                    }
                }
                , waitSecs) //Having into account time taken by query
        } catch (error) {
            showPopup(`{{__('Error en Conexión con BD')}}`,`{{__('Error')}}`,`error`)
        }
    }

    //! UnlockFormView
    /**
     * Prints the unlockForm according to the clue's unlockKey
     * @param {*} data Json clue data
     */
    const printUnlockForm = (data) => {
        let unlockFormView = `
    @include('home.partials._unlockFormView')
        `;
        const customUnlockKeyForm =
            `
    @include('home.partials._customUnlockKeyForm')
            `;

        const defaultUnlockKeyForm = `
    @include('home.partials._defaultUnlockKeyForm')
        `
        //Hiding the welcomePage if present
        animateDestroy('.welcomePage',configuration.animationMs)
        $('#mainContent').append(unlockFormView)
        //Adding a custom unlockkey form if the clue's encrypted
        if (data.unlock_hint) {
            //Custom Lock
            $('#mainContent .unlockForm .formSlot').append(customUnlockKeyForm)
            refreshBSTooltips()
            //If the unlockKey is stored in keyChain, we'll populate the value of the unlockKeyInput
            const storedKey = getStoredUnlockKey()
            if (storedKey != null) {
                $('#unlockKeyInput').val(storedKey)
                showToast("{{__('Clave de desbloqueo autocompletada!')}}",'success',5000)
            }
            //Adding the listener to enable the unlock button just if the unlockKey is correct
            $("#unlockKeyInput").on("input", unlockKeyInputChanged)
            unlockKeyInputChanged(); //Checking the input right upon creation
        } else {
            //Default unlockKey
            $('#mainContent .unlockForm .formSlot').append(defaultUnlockKeyForm)
        }
        animateShow('.unlockForm',configuration.animationMs)
        //Adding form submission listener
        $(`.unlockForm form`).on("submit", unlockFormSubmitted)
        refreshBSTooltips();

    }

    /**
     * Disables the unlockForm unlockButton if the unlockKey won't unlock the clue it refers to
     */
    const unlockKeyInputChanged = async() => {
        if ($(`#unlockKeyInput`).val() != "") {
            $(`#unlockKeyInput`).addClass("is-invalid");
        }
        else {
            $(`#unlockKeyInput`).removeClass("is-invalid").removeClass("is-valid");
        }
        if ($(`#unlockKeyInput`).hasClass('is-invalid') && $(`#unlockButton`).prop("disabled") && $('.unlockKeyErrors').hasClass('d-none')) {
            animateShow('.unlockKeyErrors',configuration.animationMs)
        } else if ($(`#unlockKeyInput`).hasClass('is-valid')) {
            animateHide('.unlockKeyErrors',configuration.animationMs)
        }
        $(`#unlockButton`).prop("disabled", true);

        //Updating the unlockKey with the value in the input
        configuration.unlockKey = $(`#unlockKeyInput`).val()

        try {
            //Checking the value in backEnd, enabling button if correct
            const json = await queryGetClue()
            console.log(json);
            if (!json.data.locked) {
                //Correct key found, enabling submit
                $(`#unlockButton`).prop("disabled", false);
                $(`#unlockKeyInput`).removeClass("is-invalid").addClass("is-valid");
                animateHide('.unlockKeyErrors',configuration.animationMs)
            }
        } catch (error) {
            showPopup(`{{__('Error en Conexión con BD')}}`,`{{__('Error')}}`,`error`)
        }
    }

    /**
     * Checks the clue details while it displays a spinner
     * @param {*} event
     */
    const unlockFormSubmitted = (event) => {
        event.preventDefault()
        $(`.unlockForm form`).after(
            `<div class='loaderContainer'><div class='loader'></div></div>`
        );
        $(`#unlockKeyInput`).prop('disabled',true)
        animateShow(`.loaderContainer`,configuration.animationMs);
        $('#unlockButton').prop("disabled", true)
        $('#unlockButton span').text(`{{__('Desbloqueando')}}`)
        getClue()
    }


    //! ClueView
    /**
     * Gets the clueKey and unlockKey from configuration JSON
     * Gets the clue details from backend and stores it con configuration.clue
     * Stores the key that unlocked the clue in keychain
     * Then printClueCard()
     */
    const getClue = async() => {
        //Getting the clue from backEnd
        try {
            const startOfQuery = new Date();
            //Checking the value in backEnd, enabling button if correct
            const json = await queryGetClue()
            //Waiting some time for dramatism
            window.setTimeout(
                () => {
                    console.log(json);
                    if (!json.data.locked) {
                        ///Clue Key and unlockKey correct, storing the clueFoundResponse
                        configuration.clueFoundResponse = json.data
                        //Storing the clue and unlockKey in keyChain
                        storeClueUnlockKey(configuration.clueKey, configuration.unlockKey)
                        printClueCard()
                    } else {
                        //The clue key doesn't exist, print greeting form
                        showPopup(`{{__('Parece que no hemos encontrado la clave introducida!')}}`,`{{__('Vaya!')}}`,'error',displayWelcomePage,`{{__('Probar con otra clave')}}`)
                    }
                }
                , generateWaitSecs(configuration.wait.min,configuration.wait.max,startOfQuery)) //Having into account time taken by query
        } catch (error) {
            showPopup(`{{__('Error en Conexión con BD')}}`,`{{__('Error')}}`,`error`)
        }
    }

    /**
     * Prints the clue in configuration Json to screen
     */
    const printClueCard = () => {
        //Removing the unlockForm if present
        animateDestroy('.unlockForm',configuration.animationMs)
        const clue = configuration.clueFoundResponse.clue
        const cluePageView = `
    @include('home.partials._cluePage')
        `;

        //Adding the clue to the view
        $('#mainContent').append(cluePageView);


        //Adding the textbody if set
        if(clue.body){
            $('.clue').append(`<div class="textSection mb-4">${formatAsParagraphs(clue.body)}</div>`)
        }
        //Adding the media section if necessary
        if(clue.image||clue.embedded_video||clue.video){
            $('.clue').append(`<div class="mediaSection max-width-xs mx-auto"></div>`);
            if(clue.image){
                $('.mediaSection').append(`
            <div class="imageSection mb-4"><div class="row justify-content-center"></div></div>
            `)
                if(clue.image.title){
                    $(`.imageSection .row`).append(`<h4>${clue.image.title}</h4>`)
                }
                if(clue.image.src){
                    $(`.imageSection .row`).append(`
                <div class="imageContainer col-10 col-sm-6 col-md-8 col-lg-10">
                    <img class="img-fluid w-100 rounded-4 shadow" src="${clue.image.src}">
                </div>
                `)
                }
                if(clue.image.caption){
                    $(`.imageSection .row`).append(`
                <div class="col-12">
                    <p class="handwritten text-end mt-2 ">~ ${clue.image.caption}</p>
                </div>`)
                }

            }
            if(clue.video){
                $('.mediaSection').append(`
            <div class="videoSection mb-4"><div class="row justify-content-center"></div></div>
            `)
                if(clue.video.title){
                    $(`.videoSection .row`).append(`<h4>${clue.video.title}</h4>`)
                }
                if(clue.video.src){
                    $(`.videoSection .row`).append(`
                <div class="videoContainer col-10 col-sm-6 col-md-8 col-lg-10">
                    <video id="videoPlayer" preload="metadata" controls onplay="goToStart()" class="img-fluid w-100 rounded-4 shadow">
                        <source src="${clue.video.src}#t=1">
                    </video>
                </div>
                `)
                }
                if(clue.video.caption){
                    $(`.videoSection .row`).append(`
                <div class="col-12">
                    <p class="handwritten text-end mt-2 ">~ ${clue.video.caption}</p>
                </div>`)
                }

            }
            if(clue.embedded_video){
                $('.mediaSection').append(`
            <div class="embeddedVideoSection mb-4"><div class="row justify-content-center"></div></div>
            `);
                if(clue.embedded_video.title){
                    $(`.embeddedVideoSection .row`).append(`<h4>${clue.embedded_video.title}</h4>`)
                }
                if(clue.embedded_video.src){
                    $(`.embeddedVideoSection .row`).append(`
                <div class="videoContainer col-10 col-sm-6 col-md-8 col-lg-10">
                    <div class="ratio ratio-16x9">
                        <iframe src="${clue.embedded_video.src}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" class="rounded-4 shadow" allowfullscreen></iframe>
                    </div>
                </div>
                `)
                }
                if(clue.embedded_video.caption){
                    $(`.embeddedVideoSection .row`).append(`
                <div class="col-12">
                    <p class="handwritten text-end mt-2 ">~ ${clue.embedded_video.caption}</p>
                </div>`)
                }
            }
        }

        if(clue.footNote){
            $('.clue').append(`
        <div class="footNoteSection">
            <h2 class="footNote handwritten text-end">~ ${clue.footNote}</h2>
        </div>
        `)
        }

        $('.clue').append(
            `<div class="d-flex justify-content-end gap-2 align-items-center w-100 my-2 opacity-75">
                        <span class="handwritten fs-3">
                            {{__('~ De')}} ${configuration.clueFoundResponse.owner.name}
                        </span>
                    <div class="userProfilePhoto roundPhoto max-width-30 flex-grow-0 flex-shrink-0">
                        <img class="" src="${configuration.clueFoundResponse.owner.profile_image}">
                    </div>
                </div>`)

        //Animating clue show
        animateShow('.clue',configuration.animationMs)
        refreshBSTooltips();

        //Timeout to help
        if (clue.help) {
            showToast(`{{__('La ayuda estará disponible en')}} ${configuration.timeoutToHelp} {{__('segundos')}}`,'info',configuration.timeoutToHelp*1000)
            window.setTimeout(showClueHelpButton, configuration.timeoutToHelp * 1000)
        }
    }
    //Adds the clueHelpButton to UI
    const showClueHelpButton = () => {
        //Adding the button
        $('.floatingButtons').prepend(
            `<button class="clueHelpButton btn btn-primary d-none">
        <i class="fa-solid fa-life-ring"></i>
        <span>{{__('¿Ayuda?')}}</span>
    </button>`
        )
        animateShow($('.floatingButtons .clueHelpButton'),configuration.animationMs)
        $('.floatingButtons .clueHelpButton').focus()
        //Adding the listener to the button
        $('.floatingButtons .clueHelpButton').on("click", showHelp)
    }

    /**
     * Adds the clue help to view
     */
    const showHelp = () => {
        //Removing the clueHelpButton
        animateDestroy('.floatingButtons .clueHelpButton',configuration.animationMs)

        if(configuration.clueFoundResponse.clue.help){
            $('.cluePage').append(`
        @include('home.partials._clueHelp')
            `)
            animateShow('.clueHelpView',configuration.animationMs)
            scrollTo(".clueHelpView .textSection")
            refreshBSTooltips();
        }
    }

    //! Backend Query Functions
    /**
     * Gets if a clueKey really exists in backend
     * @returns The JSON returned by backend
     */
    const queryCheckClueDetails=async()=>{
        const response = await fetch(`${configuration.host}/${configuration.clueKey}?unlock_key=${configuration.unlockKey}`, {
            method: 'GET'
        })
        return await response.json()
    }
    /**
     * Gets all the clue details from backend using configuration.clueKey and configuration.unlockKey
     * @returns The JSON returned by backend
     */
    const queryGetClue=async()=>{
        console.log(`${configuration.host}/${configuration.clueKey}?unlock_key=${configuration.unlockKey}`);
        const response = await fetch(`${configuration.host}/${configuration.clueKey}?unlock_key=${configuration.unlockKey}`, {
            method: 'GET'
        })
        return await response.json()
    }

    //! unlockKey keyChain Functions
    /**
     * Stores the unlockKey for one clueKey in the keychain only if the unlockKey is different from 'default'
     * @param {*} clueKey
     * @param {*} unlockKey
     */
    const storeClueUnlockKey = (clueKey, unlockKey) => {
        if(unlockKey!='default'){
            let keyChain = [];
            //Retrieving the previous keyChain in case it's stored
            let previusKeyChain = localStorage.getItem("keyChain")
            if (previusKeyChain != null) {
                previusKeyChain = JSON.parse(decodeURI(previusKeyChain))
                keyChain = [...previusKeyChain];
            }
            //Removing old entries in order to overwrite
            keyChain = keyChain.filter(entry => entry.clueKey != clueKey)
            //Creating another entry
            keyChain.push(
                {
                    clueKey: clueKey,
                    unlockKey: unlockKey
                }
            )
            //Storing the updated keyChain
            localStorage.setItem("keyChain", encodeURI(JSON.stringify(keyChain)))
        }
    }

    /**
     * @returns null|string The unlockKey for one clueKey if it is stored in the keychain
     */
    const getStoredUnlockKey = () => {
        let retrievedKey = null;
        let previusKeyChain = localStorage.getItem("keyChain")
        if (previusKeyChain != null) {
            previusKeyChain = JSON.parse(decodeURI(previusKeyChain))
            let retrievedEntry = previusKeyChain.find(entry => entry.clueKey == configuration.clueKey)
            if (retrievedEntry != undefined) retrievedKey = retrievedEntry.unlockKey

        }
        return retrievedKey
    }

    /**
     *
     */
    const goToStart = ()=>{
        if (document.getElementById('videoPlayer').currentTime == 1){
            document.getElementById('videoPlayer').currentTime = 0;
        }
    }


</script>

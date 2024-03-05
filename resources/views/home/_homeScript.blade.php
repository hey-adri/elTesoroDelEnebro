<script>
    "use strict";
    //! Main Configuration
    const configuration = {
        clueKey: `{{$clueKey}}`,
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
            `
    <!-- ! Welcome Page -->
        <section class="welcomePage">
            <div class="row g-5">
                <div class="col-12 col-lg-8">
                    <article class="paperCard">
                        <h1 class="paperCardTitle">{{__('Bienvenido al Tesoro del Enebro')}}</h1>
                        <p>{{__('Para participar en el Tesoro del Enebro, podrás escanear los códigos QR de las pistas proporcionadas por tus anfitriones.')}}</p>
                        <p>{!!__('También podrás introducir manualmente la <b>clave indentificativa de tu pista</b> a continuación:')!!}</p>

                        <!-- ! clueKeyForm -->
                        <form method="post" action="#" class="clueKeyForm">
                            <!-- Clue Key Input  -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <!-- Input -->
                                    <input id="clueKeyInput" type="text"
                                        value="${configuration.clueKey}"
                                        class="form-control" name="clueKeyInput"
                                        placeholder=" " data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{__('Introduce aquí la clave de la pista encontrada si no puedes escanear su código QR')}}">
                                    <!-- Label -->
                                    <label for="clueKeyInput" class="form-label" for="clueKeyInput">
                                        <i class="fa-solid fa-qrcode m-1"></i>
                                        {{__('Clave Identificativa de Pista')}}
                                    </label>
                                </div>
                                <!-- Error -->
                                <div class="clueKeyErrors d-none">
                                    <div class="form-text text-danger">{{__('¡Vaya, no hemos encontrado ninguna pista asociada!')}}</div>
                                </div>
                            </div>
                            <!-- Submit -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col">
                                        <button id="analizeButton" type="submit"
                                            class="btn btn-primary w-100 btn-lg" disabled>
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span>{{__('Analizar Clave')}}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </article>
                </div>
                <div class="col-12 col-lg-4">
                    <article class="paperCard">
                        <h3 class="paperCardTitle display-5">{{__('¿Deseas Crear tu propia Búsqueda del Tesoro?')}}</h3>
                        <p>{{__('Podrás crear tu propia búsqueda del tesoro entrando en')}} <a href="#Todo">{{__('Tu Área Personal')}}</a>.
                        </p>
                    </article>
                </div>
            </div>
        </section>

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
        if ($(`#clueKeyInput`).val() != "") {
            $(`#clueKeyInput`).addClass("is-invalid");
        }
        else {
            $(`#clueKeyInput`).removeClass("is-invalid").removeClass("is-valid");
        }
        if ($(`#clueKeyInput`).hasClass('is-invalid') && $(`#analizeButton`).prop("disabled") && $('.clueKeyErrors').hasClass('d-none')) {
            animateShow('.clueKeyErrors',configuration.animationMs)
        } else if ($(`#clueKeyInput`).hasClass('is-valid')) {
            animateHide('.clueKeyErrors',configuration.animationMs)
        }
        $(`#analizeButton`).prop("disabled", true);

        //Updating the clueKey with the value in the input
        configuration.clueKey = $(`#clueKeyInput`).val()
        try {
            //Checking the value in backEnd, enabling button if correct
            const json = await queryCheckClueDetails()
            if (!json.error) {
                //Correct key found, enabling submit
                $(`#analizeButton`).prop("disabled", false);
                $(`#clueKeyInput`).removeClass("is-invalid").addClass("is-valid");
                animateHide('.clueKeyErrors',configuration.animationMs)
            }
        } catch (error) {
            showPopup(`{{__('Error en Conexión con BD')}}`,`{{__('Error')}}`,`{{__('error')}}`)
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
    <!-- ! unlockForm -->
    <section class="unlockForm">
        <div class="row g-5 justify-content-center">
            <div class="col-12 max-width-md">
                <article class="paperCard d-none">
                    <h1 class="paperCardTitle">{{__('!Pista Encontrada!')}}</h1>
                    <h2>${data.clue.title}</h2>
                    <div class='formSlot'>
                    </div>
                </article>
            </div>
        </div>
    </section>
    `;
        const customUnlockKeyForm =
            `
    <div>
        <p>{{__('Necesitarás introducir un código de desbloqueo para desbloquear esta pista:')}}</p>
        <form method="post">
            <!-- Custom Input unlockKeyInput -->
            <div class="mb-4">
                <div class="form-floating">
                    <!-- Input -->
                    <input id="unlockKeyInput" type="text" class="form-control" name="unlockKey"
                        placeholder=" " data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="${data.unlock_hint}">
                    <!-- Label -->
                    <label for="unlockKeyInput" class="form-label" for="unlockKey">
                        <i class="fa-solid fa-key"></i>
                        {{__('Código de Desbloqueo')}}
                    </label>
                </div>
                <!-- Error -->
                <div class="form-text text-danger d-none unlockKeyErrors mt-2">{{__('¡Vaya, Código de Desbloqueo incorrecto!')}}</div>
            </div>
            <!-- Submit -->
            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        <button id="unlockButton" type="submit"
                            class="btn btn-primary w-100 btn-lg" disabled>
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            {{__('Desbloquear')}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    `;

        const defaultUnlockKeyForm = `
    <div>
        <p>¿Deseas desbloquear esta clave?</p>
        <form method="post">
            <!-- Default unlockKeyInput -->
            <input type="hidden" name="unlockKey" id="unlockKeyInput" value="${configuration.unlockKey}">
            <!-- Submit -->
            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        <button id="unlockButton" type="submit"
                            class="btn btn-primary w-100 btn-lg">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <span>{{__('Desbloquear')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
    <!-- ! cluePage -->
    <div class="cluePage">
        <section class="clueView">
            <div class="row g-5 justify-content-center">
                <div class="col-12 max-width-md">
                    <article class="paperCard clue d-none">
                        <h1 class="paperCardTitle">${clue.title}</h1>
                        <h3>${configuration.clueFoundResponse.treasure_hunt.title}</h3>
                    </article>
                </div>
            </div>
        </section>
    </div>
    `;

        //Adding the clue to the view
        $('#mainContent').append(cluePageView);


        //Adding the textbody if set
        if(clue.body){
            $('.clue').append(`<div class="textSection mb-4">${formatAsParagraphs(clue.body)}</div>`)
        }
        //Adding the media section if necessary
        if(clue.image||clue.embedded_video){
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
                <div class="imageContainer col-12">
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
            if(clue.embedded_video){
                $('.mediaSection').append(`
            <div class="videoSection mb-4"><div class="row justify-content-center"></div></div>
            `);
                if(clue.embedded_video.title){
                    $(`.videoSection .row`).append(`<h4>${clue.embedded_video.title}</h4>`)
                }
                if(clue.embedded_video.src){
                    $(`.videoSection .row`).append(`
                <div class="videoContainer col-12">
                    <div class="ratio ratio-16x9">
                        <iframe src="${clue.embedded_video.src}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" class="rounded-4 shadow" allowfullscreen></iframe>
                    </div>
                </div>
                `)
                }
                if(clue.embedded_video.caption){
                    $(`.videoSection .row`).append(`
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
        $('.floatingButtons div').prepend(
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
        <section class="clueHelpView">
            <div class="row g-5 justify-content-center mt-2">
                <div class="col-12 max-width-md">
                    <article class="paperCard d-none">
                        <h3 class="paperCardTitle">Ayuda</h3>
                        <div class="textSection mb-4">
                            ${formatAsParagraphs(configuration.clueFoundResponse.clue.help)}
                        </div>
                    </article>
                </div>
            </div>
        </section>
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
     * Stores the unlockKey for one clueKey in the keychain
     * @param {*} clueKey
     * @param {*} unlockKey
     */
    const storeClueUnlockKey = (clueKey, unlockKey) => {
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


</script>

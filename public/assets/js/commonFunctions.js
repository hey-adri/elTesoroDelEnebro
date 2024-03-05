"use strict";



$(() => {
    //Enabling Tooltips
    refreshBSTooltips()
    enableTopOfThePageLink()
})

//! Messaging Functions
/**
 * Displays a Toast in the top end of the screen
 * @param {*} timer
 */
const showToast = (text, icon = 'success', timer = 5000) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showCloseButton: true,
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: icon,
        title: text
    });
}

/**
 * Displays a popup until the user clicks the close button
 * @param {*} text 
 * @param {*} title 
 * @param {*} icon 
 */
const showPopup = (text, title = null, icon = 'info', thenFunction = null, confirmButtonText = 'OK') => {
    Swal.fire({
        title,
        text,
        icon,
        confirmButtonText
    }).then(() => {
        thenFunction?.apply()
    }
    )
}

//! Animation Functions
//Animates the showing of an element
const animateShow = (element, duration = 1000) => {
    if ($(element).find('.paperCard').length > 0) element = $(element).find('.paperCard'); //Applying animation only to paperCards if any selected
    $(element).removeClass('d-none').css({ 'display': 'none' });
    $(element).slideDown(duration, () => {
        $(element).attr('style', '')
    });
}
//Animates the hiding of an element
const animateHide = (element, duration = 1000) => {
    if ($(element).find('.paperCard').length > 0) element = $(element).find('.paperCard'); //Applying animation only to paperCards if any selected
    $(element).slideUp(duration, () => {
        $(element).addClass('d-none');
        $(element).attr('style', '')
    });
}
//Animates the destroy of an element
const animateDestroy = (element, duration = 1000) => {
    if ($(element).find('>.paperCard').length > 0) animateDestroy($(element).find('.paperCard')) //Applying animation to animatable children
    $(element).slideUp(duration, () => {
        $(element).remove();
    });
}
//Scrolls Smoothly to an element
const scrollTo = (element) => {
    $(element).get(0).scrollIntoView({ behavior: 'smooth' })
}

/**
 * Enables all bootstrap tooltips
 */
const refreshBSTooltips = () => {
    $('.tooltip').remove()
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => {
        const tooltip = new bootstrap.Tooltip(tooltipTriggerEl)
        tooltip.disable();
        tooltip.enable()
    });
}

/**
 * Enables all bootstrap tooltips
 */
const disableBSTooltips = () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

//Shows or hide the scroll to top link
const enableTopOfThePageLink = () => {
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            if ($('#topOfThePageButton').hasClass('d-none')) {
                animateShow('#topOfThePageButton')
            }
        } else {
            if (!$('#topOfThePageButton').hasClass('d-none')) {
                animateHide('#topOfThePageButton')
            }
        }
    });
}

//! Helper Functions
/**
 * Generates a random number of seconds to wait for the next result
 * @param {*} dateFromWaitStart Date a the start of the wait, will be taken into account when generating the wait seconds, by default now
 * @returns
 */
function generateWaitSecs(minSecs, maxSecs, dateFromWaitStart = (new Date())) {
    let waitSecs = ((Math.random() * (minSecs - maxSecs)) + minSecs) * 1000
    //Substracting the seconds that passed from wait start
    waitSecs -= (new Date() - dateFromWaitStart)
    return waitSecs
}
//Returns whether a string contains html code
const isHtml = (string) => /<(br|basefont|hr|input|source|frame|param|area|meta|!--|col|link|option|base|img|wbr|!DOCTYPE).*?>|<(a|abbr|acronym|address|applet|article|aside|audio|b|bdi|bdo|big|blockquote|body|button|canvas|caption|center|cite|code|colgroup|command|datalist|dd|del|details|dfn|dialog|dir|div|dl|dt|em|embed|fieldset|figcaption|figure|font|footer|form|frameset|head|header|hgroup|h1|h2|h3|h4|h5|h6|html|i|iframe|ins|kbd|keygen|label|legend|li|map|mark|menu|meter|nav|noframes|noscript|object|ol|optgroup|output|p|pre|progress|q|rp|rt|ruby|s|samp|script|section|select|small|span|strike|strong|style|sub|summary|sup|table|tbody|td|textarea|tfoot|th|thead|time|title|tr|track|tt|u|ul|var|video).*?<\/\2>/i.test(string)
/**
 * Returns a raw text string as html paragraphs
 * @param {*} raw
 * @returns
 */
const formatAsParagraphs = (raw) => {
    return `<p>${raw.replace(/(\n)+/gm, `</p><p>`)}</p>`
}

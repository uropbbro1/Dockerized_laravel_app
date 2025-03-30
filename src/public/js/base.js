/** закрывать при клике вне */
function openPersonPopup() {
    let popupClasses = $("#person-popup").attr('class');
    if (popupClasses.indexOf('no-display') >= 0) {
        $("#person-popup").removeClass('no-display');
    } else {
        $("#person-popup").addClass('no-display');
    }
}

jQuery(function($){
    $(document).mouseup( function(e) {
        var div = $("#person-popup");
        if ( !div.is(e.target) && div.has(e.target).length === 0 ) {
            $("#person-popup").addClass('no-display');
        }
    });
});

function openPage(page) {
    window.location = './' + page;
}

function openPopup() {
    $('#add-comment').removeClass('no-display');
}

function openReviewUpdate(id) {
    $(`#review-update${id}`).removeClass('no-display');
}

function openChangeAvatar(){
    $(`#change-avatar-block`).removeClass('no-display');
}

function closePopup() {
    $('#add-comment').addClass('no-display');
    $('#popup-comment').addClass('no-display');
}

function closeReviewPopup(id) {
    $(`#popup-comment${id}`).addClass('no-display');
    $(`#review-update${id}`).addClass('no-display');
}

function closeChangeAvatar(){
    $(`#change-avatar-block`).addClass('no-display');
}

function isAuthorized () {
    setTimeout(function() {
        let authorized = false;
        if (authorized) {
            $('[authorized]').removeClass('no-display');
            $('[not-authorized]').addClass('no-display');
        } else {
            $('[authorized]').addClass('no-display');
            $('[not-authorized]').removeClass('no-display');
        }
    }, 100);
}

function showPassword(element) {
    let show = $(element).attr('class');
    if (show.indexOf('private-off') >= 0) {
        $(element).removeClass('private-off');
    } else {
        $(element).addClass('private-off');
    }
}

function changePassValue(element) {
    let passwordFieldValue = element.value;
    document.querySelector('#password_to_check').value = passwordFieldValue;
    return 1;
}

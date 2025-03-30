function updateComment() {
    console.log('здесь нужно получить полную информацию с бэка и впихнуть в попап. Удачи');
    openPopup();
}
function showAll(id) {
    $(`#popup-comment${id}`).removeClass('no-display');
}

function showReviewUpdateForm(id) {
    $(`#review-update${id}`).removeClass('no-display');
}

function updateSort() {
    let sort = $('#sort').attr('class');
    if (sort.indexOf('up') >= 0) {
        $('#sort').addClass('down');
        $('#sort').removeClass('up');
    } else {
        $('#sort').addClass('up');
        $('#sort').removeClass('down');
    }
}
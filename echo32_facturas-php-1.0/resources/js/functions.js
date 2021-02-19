function getNow() {
    const monthNames = ["Enero", "Febrero", "MArzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    const dateObj = new Date();
    const month = monthNames[dateObj.getMonth()];
    const day = String(dateObj.getDate()).padStart(2, '0');
    const year = dateObj.getFullYear();
    const hours = dateObj.getHours();
    const min = dateObj.getMinutes();
    const output = month + ' ' + day + ', ' + year + ' ' + hours + ":" + min;
    return output;
}

function getToast(text, color) {
    $('.toast').css("background-color", color);
    $('.toast-body').text(text);
    $('.text-muted').html(getNow());
    $('.toast').toast('show');
    $('nav').css("z-index", "99");
}

$('.toast').on('hidden.bs.toast', function () {
    $('nav').css("z-index", "1020");
});

$(document).on({
    ajaxStart: function () {
        $(".load").css("display", "inline");
        $("body").css("overflow", "hidden");
    },
    ajaxStop: function () {
        $(".load").css("display", "none");
        $("body").css("overflow", "auto");
    }
});
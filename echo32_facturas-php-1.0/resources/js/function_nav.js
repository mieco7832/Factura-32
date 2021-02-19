nav = $('nav');
var scrollState = 'top';

$(window).scroll(function () {
    let scrollPos = $(window).scrollTop();
    if ((scrollPos !== 0) && (scrollState === 'top')) {
        $(nav).css("opacity", "0.5");
        scrollState = 'scrolled';
    } else if ((scrollPos === 0) && (scrollState === 'scrolled')) {
        $(nav).css("opacity", "1");
        scrollState = 'top';
    }
});

$(nav).mouseenter(function () {
    $(this).css("opacity", "1");
}).mouseleave(function () {
    let scrollPos = $(window).scrollTop();
    if ((scrollPos !== 0) && (scrollState === 'scrolled')) {
        $(this).css("opacity", "0.5");
    }
});

$(nav).on("mousemove",function() {
    $(this).css("opacity", "1");
});
$(document).ready(function () {
    $(".search").focus(function () {
        $(".search-box").addClass("border-searching");
    });
    $(".search").blur(function () {
        $(".search-box").removeClass("border-searching");
    });
    
});

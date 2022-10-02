// $(document).on('click','.tabToggleBtn',function(){
//     $('.tabToggleBtn').removeClass('active');
//     $(this).addClass('active');
//     $('.profTabs').fadeOut();
//     $($(this).attr('data-bs-target')).fadeIn();
//     $('.profTabs').removeClass('show');
//     $($(this).addClass('show'));
// });

$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("sec")) {
        sec = urlParams.get("sec");
        $("#" + sec).trigger("click");
    }
});

$(document).on("click", ".viewType", function () {
    if ($(this).attr("data-view") == "list") {
        $(".prodMainBox").removeClass("gridbox");
    }
    if ($(this).attr("data-view") == "grid") {
        $(".prodMainBox").addClass("gridbox");
    }
});

$(document).on("click", ".shareBtn", function () {
    $(this).closest(".actionSec").find(".shareUI").toggle();
});

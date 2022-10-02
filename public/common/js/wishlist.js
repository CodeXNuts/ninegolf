$(document).on("click", ".wishlist", function () {
        //manage
        var dataURI = $(this).attr("data-add-URI") ?? null;
        var prod = $(this).attr("data-prod") ?? null;
        if (
            dataURI !== null &&
            dataURI !== "" &&
            dataURI !== undefined &&
            prod !== null &&
            prod !== "" &&
            prod !== undefined
        ) {
            manageWishList(dataURI, prod, $(this));
            // $(this).find('.eX72wL').attr('fill','#EB4949');
        }
    
});

function manageWishList(dataURI, prod, __e) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: dataURI,
        data: { club: prod },
        dataType: "json",
        // contentType: false,
        // processData: false,
        beforeSend: function () {
            $(".loader").fadeIn(100);
        },
        success: function (response) {
            if (response.key == "success") {
                if(response.type !== undefined && response.type == 0)
                {
                    __e.find(".eX72wL").attr("fill", "#fff");
                }
                if(response.type !== undefined && response.type == 1)
                {
                    __e.find('.eX72wL').attr('fill','#EB4949');
                }
                Toast.fire({
                    icon: "success",
                    title: response.msg,
                });
            } else {
                Toast.fire({
                    icon: "error",
                    title: response.msg,
                });
            }
        },
        error: function (request, status, error) {
            responses = jQuery.parseJSON(request.responseText);

            if (responses.errors) {
                var errorHtml = "<ul>";
                $.each(responses.errors, function (key, value) {
                    errorHtml += "<li>" + value + "</li>";
                });
                errorHtml += "</ul>";

                Toast.fire({
                    icon: "error",
                    title: errorHtml,
                });
            }
        },
        complete: function () {
            $(".loader").fadeOut(100);
        },
    });
}

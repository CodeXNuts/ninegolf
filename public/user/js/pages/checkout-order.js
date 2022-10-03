// store form HTML markup in a JS variable
var formTemplate = $("#login-form-template").clone()[0];

$("#login-form-template").remove();

// prepare SweetAlert configuration
var swalConfigCheckoutLogin = {
    title: "You need to login",
    html: formTemplate,
    confirmButtonText: "Log In",
    cancelButtonText: "Cancel",
    showCancelButton: true,
    showCloseButton: true,
    allowOutsideClick: false,
    onClose: $("#login-form-template").fadeOut(),
    showClass: {
        popup: "animate__animated animate__bounce",
    },
    hideClass: {
        popup: "animate__animated animate__fadeOutUp",
    },
    preConfirm: () => {
        const email = Swal.getPopup().querySelector("#checkOutEmail").value;
        const password = Swal.getPopup().querySelector("#checkOutPass").value;
        const emailRegX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (email == "" || email == undefined || !email.match(emailRegX)) {
            Swal.showValidationMessage(`Please Enter a valid email`);
        } else if (password == "" || password == undefined) {
            Swal.showValidationMessage(`Please Enter your password`);
        }

        return { email: email, password: password };
    },
};
// $(document).on("click", "#checkout", function () {
//     Swal.fire({
//         title: "Enter Payment Details",
//         html: $("#payment-form")[0],
//         showCancelButton: false,
//         showConfirmButton: false,
//         showCloseButton: false,
//         allowOutsideClick: false,
//     });
//     $("#payment-form").fadeIn();
// });

$(document).on("click", "#checkout", function () {

        var targetURI = $(this).attr("data-target-auth");

        var urlRegex = new RegExp(
            "^(https?:\\/\\/)?" + // validate protocol
                "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
                "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
                "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
                "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
                "(\\#[-a-z\\d_]*)?$",
            "i"
        );

        // var payLoad = {
        //     number: $(".card-number").val(),
        //     cvc: $(".card-cvc").val(),
        //     exp_month: $(".card-expiry-month").val(),
        //     exp_year: $(".card-expiry-year").val(),
        //     stripeToken: $("#stripeToken").val(),
        // };

        if (
            targetURI !== "" &&
            targetURI !== undefined &&
            targetURI.match(urlRegex)
        ) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: targetURI,
                data: {},
                dataType: "json",
                // contentType: false,
                // processData: false,
                beforeSend: function () {
                    $(".loader").fadeIn(100);
                },
                success: function (response) {
                    if(response.res !== '' && response.res !== undefined)
                    {
                            Swal.fire({
                                title: "Enter Payment Details",
                                html: $("#payment-form")[0],
                                showCancelButton: false,
                                showConfirmButton: false,
                                showCloseButton: false,
                                allowOutsideClick: false,
                            });
                            $("#payment-form").fadeIn();
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

                    if (request.status !== undefined && request.status == 401) {
                        Swal.fire(swalConfigCheckoutLogin).then((result) => {
                            if (result.isConfirmed) {
                                logGuestIn(
                                    result.value.email,
                                    result.value.password
                                );
                            }
                        });
                        $("#login-form-template").fadeIn();
                    }
                },
                complete: function () {
                    $(".loader").fadeOut(100);
                },
            });
        }
    
});

function procceedToOrder() { 

    var targetURI = $('.payBtn').attr("data-target");

        var urlRegex = new RegExp(
            "^(https?:\\/\\/)?" + // validate protocol
                "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
                "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
                "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
                "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
                "(\\#[-a-z\\d_]*)?$",
            "i"
        );

        var payLoad = {
            number: $(".card-number").val(),
            cvc: $(".card-cvc").val(),
            exp_month: $(".card-expiry-month").val(),
            exp_year: $(".card-expiry-year").val(),
            stripeToken: $("#stripeToken").val(),
        };

        if (
            targetURI !== "" &&
            targetURI !== undefined &&
            targetURI.match(urlRegex)
        ) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: targetURI,
                data: payLoad,
                dataType: "json",
                // contentType: false,
                // processData: false,
                beforeSend: function () {
                    $(".loader").fadeIn(100);
                },
                success: function (response) {
                    if(response.code!=='' && response.code!==undefined && response.code==200)
                    {
                        if(response.targetURI !=='' && response.targetURI!==undefined && response.targetURI.match(urlRegex))
                        {
                            Toast.fire({
                                icon: "success",
                                title:response.msg ?? 'Order has been placed successfully'
                            });
                            window.location.href = response.targetURI;

                        }
                        else
                        {
                            Toast.fire({
                                icon: "error",
                                title:'Something went wrong'
                            });
                        }
                    }
                    else
                    {
                        Toast.fire({
                            icon: "error",
                            title: response.msg ?? 'Order has not been placed'
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

                    if (request.status !== undefined && request.status == 401) {
                        Swal.fire(swalConfigCheckoutLogin).then((result) => {
                            if (result.isConfirmed) {
                                logGuestIn(
                                    result.value.email,
                                    result.value.password
                                );
                            }
                        });
                        $("#login-form-template").fadeIn();
                    }
                },
                complete: function () {
                    $(".loader").fadeOut(100);
                },
            });
        }
 }

function logGuestIn(email, password) {
    var emailRegX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var targetURI = $("#checkout-login-form").attr("data-target");

    var urlRegex = new RegExp(
        "^(https?:\\/\\/)?" + // validate protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    );
    if (email == "" || email == undefined || !email.match(emailRegX)) {
        Toast.fire({
            icon: "error",
            title: "Please enter a valid email id",
        });
        return false;
    } else if (password == "" || password == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter your password",
        });
        return false;
    } else {
        if (
            targetURI !== "" &&
            targetURI !== undefined &&
            targetURI.match(urlRegex)
        ) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: targetURI,
                data: { req: "return", email: email, password: password },
                dataType: "json",
                // contentType: false,
                // processData: false,
                beforeSend: function () {
                    $(".loader").fadeIn(100);
                },
                success: function (response) {
                    if (
                        response.key !== "" &&
                        response.key !== undefined &&
                        response.key == "success"
                    ) {
                        Toast.fire({
                            icon: "error",
                            title: response.msg ?? "Login success",
                        });

                        // $("html").load(location.href);
                        window.location.reload();
                        getCartCnt();
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

                    if (request.status !== undefined && request.status == 422) {
                        $("#login-form-template").removeClass("hidden");
                    }
                },
                complete: function () {
                    $(".loader").fadeOut(100);
                },
            });
        }
    }
}

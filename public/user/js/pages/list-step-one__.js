$(".clb").on("click", function () {
    var listType = $("#listType").val();

    if (listType !== "" && listType !== undefined) {
        if (listType == "individual") {
            $(".clb").removeClass("select-product");
            $(this).addClass("select-product");
        } else if (listType == "set") {
            $(this).toggleClass("select-product");
        }
    } else {
        $(".clb").removeClass("select-product");
    }
});

$(".listSetChecker").on("change", function () {
    if ($(this).is(":checked")) {
        $(".clb").removeClass("select-product");
        $(".listSetChecker").prop("checked", false);
        $(this).prop("checked", true);
        $("#listNamePlaceholder").prop("disabled", false);
        if ($(this).is("[data-disabled]")) {
            $("#listNamePlaceholder").prop("disabled", true);
        }
    } else {
        $("#listNamePlaceholder").prop("disabled", true);
        $("#listNamePlaceholder").attr("placeholder", "Not applicable");
        $("#listType").val("");
        $("#setHeading").html("");
        $(".clb").removeClass("select-product");
    }


});

$(document).on("click", "#listIndv,#listSet", function () {
 

    $("#listNamePlaceholder").attr(
        "placeholder",
        $(this).attr("data-placeholder")
    );
    $("#listType").val($(this).attr("data-val"));
    $("#setHeading").html($(this).attr("data-heading"));
});

$(document).on("click", ".nextStep", function () {
    var listType = $("#listType").val();
    var gender = $("input[name='gender']:checked").val();
    var dexterity = $("input[name='dexterity']:checked").val();
    var priorTime = $("input[name='priorTime']:checked").val();
    arr = [];

    $(".select-product").each(function (i, obj) {
        arr.push($(this).attr("dataval"));
    });

    if (listType == "" || listType == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please select one List type",
        });
    } else if (gender == "" || gender == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please select gender",
        });
    } else if (dexterity == "" || dexterity == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please select dexterity",
        });
    } 
    else if(priorTime =="" || priorTime == undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please select time required prior to rental",
        });
    }
    else if (arr == "" || arr == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please select at least one club",
        });
    } else if (
        listType == "set" &&
        ($("#listNamePlaceholder").val() == "" ||
            $("#listNamePlaceholder").val() == undefined)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please provide set name",
        });
    } else {
        $("#clubs").val(arr);
        $('.proceedStepTwo').trigger('click');
        // $.ajaxSetup({
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     },
        // });
        // $.ajax({
        //     type: "post",
        //     url: "/list-my-club-step-one",
        //     data: {
        //         listType: listType,
        //         gender: gender,
        //         dexterity: dexterity,
        //         clubs: arr,
        //     },
        //     dataType: "json",
        //     beforeSend: function () {
        //         $(".loader").fadeIn(100);
        //     },
        //     success: function (response) {},
        //     error: function (request, status, error) {
        //         responses = jQuery.parseJSON(request.responseText);

        //         if (responses.errors) {
        //             var errorHtml = "<ul>";
        //             $.each(responses.errors, function (key, value) {
        //                 errorHtml += "<li>" + value + "</li>";
        //             });
        //             errorHtml += "</ul>";

        //             Toast.fire({
        //                 icon: "error",
        //                 title: errorHtml,
        //             });
        //         }
        //     },
        //     complete: function () {
        //         $(".loader").fadeOut(100);
        //     },
        // });
    }
});

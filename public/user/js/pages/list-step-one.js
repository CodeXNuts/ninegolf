$('.listSetChecker').change(function (e) { 
    // e.preventDefault();
    // alert($('#listIndv').is(':checked'));
    // alert($('#listSet').is(':checked'))
    if($('#listIndv').is(':checked') && $('#listSet').is(":checked"))
    {
        proceedToSetAndIndividual($(this))
    }
    else if(($('#listIndv').is(':checked') && (!$('#listSet').is(":checked"))) || ((!$('#listIndv').is(':checked')) && ($('#listSet').is(":checked"))))
    {
        proceedToSetOrIndividual($(this));
    }
    else
    {
        $("#listNamePlaceholder").prop("disabled", true);
        $("#listNamePlaceholder").attr("placeholder", "Not applicable");
        $("#listType").val("");
        $("#setHeading").html("");
        $(".clb").removeClass("select-product");
    }
});

function proceedToSetOrIndividual(__e)
{
    $(".clb").removeClass("select-product");
    $('#isMix').val(false)
    // $(".listSetChecker").prop("checked", false);
    $("#listNamePlaceholder").prop("disabled", false);
    if($('#listIndv').is(':checked'))
    {
        $('#listIndv').prop("checked", true);
        if ($('#listIndv').is("[data-disabled]")) {
            $("#listNamePlaceholder").prop("disabled", true);
        }
        $("#setHeading").html($('#listIndv').attr("data-heading"));
        $("#listNamePlaceholder").attr(
            "placeholder",
            $('#listIndv').attr("data-placeholder")
        );
    
        $("#listType").val($('#listIndv').attr("data-val"));
    }
    else if($('#listSet').is(':checked'))
    {
        $('#listSet').prop("checked", true);
        $("#listNamePlaceholder").prop("disabled", false);
        $("#setHeading").html($('#listSet').attr("data-heading"));
        $("#listNamePlaceholder").attr(
            "placeholder",
            $('#listSet').attr("data-placeholder")
        );
    
        $("#listType").val($('#listSet').attr("data-val"));
    }
    
    
    
}


function proceedToSetAndIndividual(__e)
{
    $('#isMix').val(true)
    $('#listSet').prop("checked", true);
    $("#listNamePlaceholder").prop("disabled", false);
        $("#setHeading").html('Create set and individual post');
        $("#listNamePlaceholder").attr(
            "placeholder",
            $('#listSet').attr("data-placeholder")
        );
    
        $("#listType").val($('#listSet').attr("data-val"));
}

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
    } 
    else if (gender == "" || gender == undefined) {
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

$(document).ready(function () {
    $("#club_list_tbl").DataTable({ order: [] });
});

$(document).on("click", ".approveThis", function () {

    var uri = $(this).closest("td").attr("data-club-approve");
    if ((uri !== "") && (uri !== undefined)) {
        Swal.fire({
            title: "Are you sure to approve this club?",
            text: "Once approved, it'll be publicly visible",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Approve it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                approveThis(uri);
            }
        });
    }
});
$(document).on("click", ".suspendThis", function () {

    var uri = $(this).closest("td").attr("data-club-suspend");
    if ((uri !== "") && (uri !== undefined)) {
        Swal.fire({
            title: "Are you sure to suspend this club?",
            text: "Once suspended, it'll no longer be visible to the public",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Suspend it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                approveThis(uri);
            }
        });
    }
});

function approveThis(uri)
{
    if ((uri !== "") && (uri !== undefined))
    {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    
        $.ajax({
            type: "PUT",
            url: uri,
            data: {'__method':'PUT'},
            dataType: "json",
            beforeSend: function () {
                $(".loader").fadeIn(100);
            },
            success: function (response) {
    
                 if((response.key !== '') && (response.key !== undefined) && (response.key == 'success'))
                 {
                    Toast.fire({
                        icon: "success",
                        title: response.msg ?? 'Approved',
                    });

                    location.reload();
                 }
                 else
                 {
                    Toast.fire({
                        icon: "error",
                        title: response.msg ?? 'Pending',
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
}
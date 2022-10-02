$(document).on("click", ".removeItem", function () {
    var identifier = $(this).closest(".cartItem").attr("data-identifier");
    var target = $(this).closest(".cartItem").attr("data-targetURI");

    var urlRegex = new RegExp(
        "^(https?:\\/\\/)?" + // validate protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    );

    if (
        identifier !== "" &&
        identifier !== undefined &&
        target !== "" &&
        target !== undefined &&
        target.match(urlRegex)
    ) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: target,
            data: { _method: "delete" },
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
                        icon: "success",
                        title: response.msg ?? "Successfully removed",
                    });
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.msg ?? "Something went wrong",
                    });
                }
                console.log(response);
                
                if (response.crts !== "" && response.crts !== undefined) {
                    if (
                        response.crts.crtContents.cart_items !== "" &&
                        response.crts.crtContents.cart_items !== undefined &&
                        response.crts.crtContents.cart_items.length > 0
                    ) {
                        var appendableCartPart = "";
                        var subTotal = 0.0;
                        var pickUpCharges = 0.0;
                        $.each(response.crts.crtContents.cart_items, function (i, v) {
                            appendableCartPart +=
                                ' <div class="listbox cartItem" data-identifier="' +
                                v.id +
                                '" data-targetURI="' +
                                (v.delete ?? "") +
                                '">' +
                                '<img src="' +
                                v.club.club_lists[0].club_images[0].image_path +
                                '" alt="">' +
                                '<div class="listbox-dtl">';

                            if (
                                v.club.type !== "" &&
                                v.club.type !== undefined &&
                                v.club.type == "set"
                            ) {
                                appendableCartPart +=
                                    "<h2>" +
                                    (v.club.set_name ?? "N.A") +
                                    " </h2>" +
                                    "<h3>$" +
                                    (v.club.set_price ?? 0.0) +
                                    "</h3>";
                            } else if (
                                v.club.type !== "" &&
                                v.club.type !== undefined &&
                                v.club.type == "set"
                            ) {
                                appendableCartPart +=
                                    "<h2>" +
                                    (v.club.club_lists[0].name ?? "N.A") +
                                    "</h2>" +
                                    "<h3>" +
                                    (v.club.club_lists[0].price ?? "0.00") +
                                    "</h3>";
                            }

                            appendableCartPart +=
                                "<p>" +
                                (v.club_address.address ?? "N.A") +
                                "</p>" +
                                "<p>" +
                                (v.from_date !== ""
                                    ? new Date(v.from_date).toDateString()
                                    : "N.A") +
                                "</p>" +
                                "<p>" +
                                (v.to_date !== ""
                                    ? new Date(v.to_date).toDateString()
                                    : "N.A") +
                                "</p>" +
                                "</div>";
                            appendableCartPart +=
                                '<div class="listbox-dtl2 listbox-dtl">' +
                                " <h2>Total cost: </h2>";

                            if (
                                v.club.type !== "" &&
                                v.club.type !== undefined &&
                                v.club.type == "set"
                            ) {
                                subTotal =
                                    subTotal +
                                    (v.club.set_price !== ""
                                        ? parseFloat(v.club.set_price) *
                                          parseInt(v.days)
                                        : 0.0);

                                appendableCartPart +=
                                    "<h3>$" +
                                    (v.club.set_price !== ""
                                        ? (
                                              parseFloat(v.club.set_price) *
                                              parseInt(v.days)
                                          ).toFixed(2)
                                        : "0.00") +
                                    "</h3>" +
                                    "<p>*$" +
                                    (v.club.set_price ?? 0.0) +
                                    " x " +
                                    (v.days ?? 0) +
                                    " days</p>";
                            } else if (
                                v.club.type !== "" &&
                                v.club.type !== undefined &&
                                v.club.type == "individual"
                            ) {
                                subTotal =
                                    subTotal +
                                    (v.club.club_lists[0].price !== ""
                                        ? parseFloat(
                                              v.club.club_lists[0].price
                                          ) * parseInt(v.days)
                                        : 0.0);
                                appendableCartPart +=
                                    "<h3>$" +
                                    (v.club.club_lists[0].price !== ""
                                        ? (
                                              parseFloat(
                                                  v.club.club_lists[0].price
                                              ) * parseInt(v.days)
                                          ).toFixed(2)
                                        : "0.00") +
                                    "</h3>" +
                                    "<p>*$" +
                                    (v.club.club_lists[0].price ?? 0.0) +
                                    " x " +
                                    (v.days ?? 0) +
                                    " days</p>";
                            }
                            pickUpCharges =
                                pickUpCharges +
                                (v.club_address.price !== "" &&
                                v.club_address.price !== undefined
                                    ? parseFloat(v.club_address.price)
                                    : 0.0);
                            appendableCartPart +=
                                "<p>Pickup Charge: " +
                                (v.club_address.price !== "" &&
                                v.club_address.price !== undefined
                                    ? v.club_address.price == "0"
                                        ? "Free"
                                        : "$" + v.club_address.price.toFixed(2)
                                    : "Free") +
                                "</p>";
                            appendableCartPart +=
                                '<ul><li><li><a href="javascript:void(0)" class="removeItem">Remove from cart</a></li></ul></div></div>';
                        });

                        if (
                            response.crts.priceBox !== "" &&
                            response.crts.priceBox !== undefined &&
                            response.crts.priceBox.length > 0
                        ) {
                            var appendablePricePart = "";

                            $.each(
                                response.crts.priceBox,
                                function (indexInArray, valueOfElement) {
                                    appendablePricePart +=
                                        "<tr><td>" +
                                        valueOfElement["name"] +
                                        "</td><td>$" +
                                        valueOfElement["cost"] +
                                        "</td></tr>";
                                }
                            );
                            appendablePricePart +=
                                '<tr style="border-top: 1px solid #D1D1D1;"><td>Sub-Total </td><td>$' +
                                subTotal
                                    .toFixed(2)
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                "</td></tr>";
                            appendablePricePart +=
                                '<tr style="border-bottom: 1px solid #D1D1D1;"><td>Pickup Charges </td><td>' +
                                (pickUpCharges == 0
                                    ? "Free"
                                    : "$" +
                                      pickUpCharges
                                          .toFixed(2)
                                          .toString()
                                          .replace(
                                              /\B(?=(\d{3})+(?!\d))/g,
                                              ","
                                          )) +
                                "</td></tr>";
                            appendablePricePart +=
                                "<tr><td>Total </td><td>$" +
                                (subTotal + pickUpCharges)
                                    .toFixed(2)
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                "</td></tr>";
                            $(".priceSecTbl").html(appendablePricePart);
                        }

                        $(".cartItemSec").html(appendableCartPart);
                    } else {
                        $(".priceSecTbl").html("");
                        $(".cartItemSec").html(
                            "<img src='/user/images/empty-cart.gif' style='width:110px;height:110px'><p>You don't have any items in your cart</p>"
                        );
                    }
                }

                getCartCnt();
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
});

function loadCarts(data) {}

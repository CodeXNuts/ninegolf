function proceedToCheckOut(__e,shouldRedirect = false)
{
    var fromDate = $('input[name="rentFromDate"]').val();
    var fromTime = $('input[name="rentFromTime"]').val();
    var toDate = $('input[name="rentToDate"]').val();
    var toTime = $('input[name="rentToTime"]').val();
    var addr = $('#selectedLoc').val();

    if (fromDate == "" || fromDate == undefined || !isValidDate(fromDate)) {
        Toast.fire({
            icon: "error",
            title: "Please enter a valid start date",
        });
    } else if (toDate == "" || toDate == undefined || !isValidDate(toDate)) {
        Toast.fire({
            icon: "error",
            title: "Please enter a valid end date",
        });
    } else if (
        fromTime == "" ||
        fromTime == undefined ||
        !isValidTime(fromTime)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please enter a valid start time",
        });
    } else if (toTime == "" || toTime == undefined || !isValidTime(toTime)) {
        Toast.fire({
            icon: "error",
            title: "Please enter a valid end time",
        });
    } 
    else if(addr == "" || addr == undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please select pickup/drop off address",
        });
    }
    else {
        var priorTime = $("#priorTime").val().trim();
        if (
            priorTime !== "" &&
            priorTime !== undefined &&
            $.isNumeric(priorTime)
        ) {
            var fromDate = $("#rentFromDate").val().trim();
            var fromTime = $("#rentFromTime").val();

            var dateTimeFrom = fromDate + " " + fromTime;
            formDateFrmt = new Date(dateTimeFrom);
            nowDateFrmt = new Date();
            var ms = formDateFrmt.getTime() - nowDateFrmt.getTime();
            var hrs = ms / (1000 * 60 * 60);

            if (hrs > priorTime || priorTime == 0 ) {
                if (
                    $(__e).attr("data-prod") !== "" &&
                    $(__e).attr("data-prod") !== undefined &&
                    $(__e).attr('data-cart-uri') !== '' &&
                    $(__e).attr('data-cart-uri') !== undefined
                ) {
                    var dateTimeFrom = fromDate + " " + fromTime;
                    var dateTomeTo = toDate + " " + toTime;
                    date1 = new Date(dateTimeFrom);
                    date2 = new Date(dateTomeTo);
                    var diffMS = date2.getTime() -date1.getTime();
                    var days = Math.round(diffMS / (1000 * 3600 * 24));
                    if (days == 0) days = 1;
                    var payload = {
                        'club' : $(__e).attr("data-prod"),
                        'fromDate' : fromDate.split('-').join('/'),
                        'fromTime' : fromTime,
                        'toDate' : toDate.split('-').join('/'),
                        'toTime' : toTime,
                        'days' : days,
                        'loc' : addr,
                        'uri' : $(__e).attr('data-cart-uri')
                    };
                    addToCart(payload,shouldRedirect);
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Item can not be added to cart! Try again",
                    });
                }
            } else {
                Toast.fire({
                    icon: "error",
                    title:
                        "Time Required Prior To Rental: " + priorTime + "hrs",
                });
            }
        }
    }
}
$(document).on("click", ".addToCart", function () {
    proceedToCheckOut(this);
});

// $(document).on("change", "#rentToDate,#rentFromDate", function () {
//     alert($(this).val());
// });

$(".individualTimepicker").clockpicker({
    placement: "bottom",
    align: "left",
    autoclose: true,
    twelvehour: false,
    default: "now",
    donetext: "Select",
    init: function () {},
    afterDone: function () {
        renderCalculatedPrice();
    },
});

function renderCalculatedPrice() {

    var fromDate = $("#rentFromDate").val().trim();
    var toDate = $("#rentToDate").val().trim();

    var fromTime = $("#rentFromTime").val();
    var toTime = $("#rentToTime").val();
    // console.log("to: " + toDate);
    if (
        fromDate !== "" &&
        fromDate !== undefined &&
        isValidDate(fromDate) &&
        toDate !== "" &&
        toDate !== undefined &&
        isValidDate(toDate) &&
        fromTime !== "" &&
        fromTime !== undefined &&
        isValidTime(fromTime) &&
        toTime !== "" &&
        toTime !== undefined &&
        isValidTime(toTime)
    ) {
        var dateTimeFrom = fromDate + " " + fromTime;
        var dateTomeTo = toDate + " " + toTime;
        date1 = new Date(dateTimeFrom);
        date2 = new Date(dateTomeTo);

        var milli_secs = date2.getTime() - date1.getTime();

        // var hrs = milli_secs / (1000 * 60 * 60);
        var days = Math.round(milli_secs / (1000 * 3600 * 24));
        if (milli_secs < 0 || days < 0) {
            Toast.fire({
                icon: "error",
                title: "Rental end time should be greater than rental start time",
            });

            $("#rentToTime").val("");

            return false;
        }
        if(date1 < new Date().getTime())
        {
            Toast.fire({
                icon: "error",
                title: "Rental start time should be greater than current time",
            });

            $("#rentFromTime").val("");

            return false;
        }
        if (days == 0) days = 1;

        var clubID = $("#clubID").val();

        if (clubID !== "" && clubID !== undefined && days > 0 && days !== NaN) {
            getClubPrice(clubID, days, fromDate + " to " + toDate);
        }
        // console.log("days" + days);
    }
}

function addToCart(payload,shouldRedirect = false) { 

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: payload['uri'],
        data: payload,
        dataType: "json",
        // contentType: false,
        // processData: false,
        beforeSend: function () {
            $(".loader").fadeIn(100);
        },
        success: function (response) {

            // if(response.cnt.crtCnt !== '' && response.cnt.crtCnt !== undefined)
            // {
            //     $('.KK-o3G').html(response.cnt.crtCnt);
            // }
            getCartCnt();
            if(response.key == 'success')
            {
                flyIt();
                Toast.fire({
                    icon: "success",
                    title: response.msg,
                });
                
                $('.prodActionBtn .addToCart').replaceWith('<li><a href="/cart" class="" style="background-color: yellowgreen">Go to Cart</a></li>');

                if(shouldRedirect == true)
                {
                    window.location.href = '/cart'; 
                }
            }
            else if(response.key == 'info')
            {
                Toast.fire({
                    icon: "info",
                    title: response.msg,
                });

                 
                // Swal.fire({
                //     title: 'You already have added the same club for the same time slot. Want to add again?',
                //     // showDenyButton: true,
                //     showCancelButton: true,
                //     confirmButtonText: 'Add To Cart',
                //     // denyButtonText: `Don't add`,
                // }).then((result) => {
                //     /* Read more about isConfirmed, isDenied below */
                //     if (result.isConfirmed) {
                //     Swal.fire('Saved!', '', 'success')
                //     } else if (result.isDenied) {
                //     Swal.fire('Changes are not saved', '', 'info')
                //     }
                // });

                // Swal.fire({
                //     title: 'Are you sure to add this into cart?',
                //     text: "You already have added the same club for the same time slot. Want to add this as multiple?",
                //     icon: 'info',
                //     showCancelButton: true,
                //     confirmButtonText: 'Add To Cart',
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Yes, Add to cart!'
                //   }).then((result) => {
                //     if (result.isConfirmed) {
                //       Swal.fire(
                //         'Deleted!',
                //         'Your file has been deleted.',
                //         'success'
                //       )
                //     }
                //   })
            }
            else
            {
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

function getClubPrice(id, days, duration) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: "/getClubPrice/" + id,
        data: { club: id },
        dataType: "json",
        // contentType: false,
        // processData: false,
        beforeSend: function () {
            $(".loader").fadeIn(100);
        },
        success: function (response) {
            if (
                response.price !== "" &&
                response.price !== undefined &&
                $.isNumeric(response.price)
            ) {
                $("#totalRentalPrice").html(
                    "$" + (response.price * days).toFixed(2)
                );
                $("#rentalSpan").html("(" + duration + ")");
                Toast.fire({
                    icon: "info",
                    title:
                        "The rent for " +
                        days +
                        "days: $" +
                        (response.price * days).toFixed(2),
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

function initMap(latitude, longitude) {
    const myLatLng = {
        lat: latitude,
        lng: longitude,
    };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
    });
}

$(document).on("change", "#selectedLoc", function () {
    var lat = $("option:selected", this).attr("data-lat");
    var lng = $("option:selected", this).attr("data-lng");
    var title = $("option:selected", this).attr("data-title");
    var addr = $("option:selected", this).attr("data-addr");
    if (
        lat !== "" &&
        lat !== undefined &&
        lng !== "" &&
        lng !== undefined &&
        $(this).val() !== "" &&
        $(this).val() !== undefined
    ) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);

        const myLatLng = {
            lat: parseFloat(lat),
            lng: parseFloat(lng),
        };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
        });

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            title: title,
            icon: {
                url: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
            },
        });

        $('#selectedAddress').html(addr);
    }
    else
    {
        $('#selectedAddress').html('')
    }
});

function isValidDate(s) {
    var bits = s.split("/");
    // console.log(bits)
    var d = new Date(bits[2] + "/" + bits[0] + "/" + bits[1]);
    // console.log(d)
    return !!(
        d &&
        d.getMonth() + 1 == bits[0] &&
        d.getDate() == Number(bits[1])
    );
}

function isValidTime(s) {
    var dateTime = "08/09/2022 " + s+":00";

    return new Date(dateTime).getTime() > 0;
}

function msToHrs(ms) {
    let seconds = (ms / 1000).toFixed(1);
    let minutes = (ms / (1000 * 60)).toFixed(1);
    let hours = (ms / (1000 * 60 * 60)).toFixed(1);
    let days = (ms / (1000 * 60 * 60 * 24)).toFixed(1);
    if (seconds < 60) return seconds + " Sec";
    else if (minutes < 60) return minutes + " Min";
    else if (hours < 24) return hours + " Hrs";
    else return days + " Days";
}


function flyIt() { 
    var cart = $('.shopping-cart');
    var imgtodrag = $("#largeImage").eq(0);
    if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }

    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
            top: imgtodrag.offset().top,
            left: imgtodrag.offset().left
        })
            .css({
            'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
        })
            .appendTo($('body'))
            .animate({
            'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75
        }, 1000, 'easeInOutExpo');
        
        setTimeout(function () {
            cart.effect("shake", {
                times: 2
            }, 200);
        }, 1500);

        imgclone.animate({
            'width': 0,
                'height': 0
        }, function () {
            $(this).detach()
        });
    }
 }

 $(document).on('click','#buy',function(){
    proceedToCheckOut(this,true);
 })

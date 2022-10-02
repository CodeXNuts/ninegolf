$(document).on('click', '.addLocation', function () {
    if($('.clubAddressInput').length >= 10)
    {
        Toast.fire({
            icon: "error",
            title: "Max limit of 10 address reached",
        });

        return false;
    }
    var name = $('input[name="locationName"]').val();
    var price = $('input[name="price"]').val();
    var address = $('input[name="fullAddr"]').val();
    var priceUnit = $('.priceUnit option:selected').val();

    if (name == "" || name == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter location name",
        });
    } else if (address == "" || address == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter address",
        });
    }
    else {
        var modifiedPriceForShow = '';
        if (price == "" || price == undefined || parseInt(price) == 0) {
            price = 0.00;
            modifiedPriceForShow = 'Free';
            priceUnit = '';
        } else {
            price = parseFloat(price).toFixed(2);

            modifiedPriceForShow = priceUnit + price.toString();
        }

        var payLoad =
        {
            'name': '' + name + '',
            'priceUnit': priceUnit,
            'price': price,
            'modifiedPrice': modifiedPriceForShow,
            'address': address,
            'lat': $('#currentLat').val(),
            'lng': $('#currentLng').val()
        };

        var tempId = Math.random().toString(36).substr(2, 5);
        payLoad['tempId'] = tempId;
        if (
            // $(".baseLocation .address").html() == "" ||
            // $(".baseLocation .address").html() == undefined
            $('#isBaseLoc').is(':checked')
        ) {
            payLoad['locType'] = 'base';

            var appendableHtml = prepareLocationCard(payLoad);

            $('.baseLocation .heading').after(appendableHtml);
        }
        else {
            payLoad['locType'] = 'other';
            var appendableHtml = prepareLocationCard(payLoad);

            $('.otherLocation .heading').append(appendableHtml);
        }
        setMarkersOnMap();
        $('input[name="locationName"]').val("");
        $('input[name="price"]').val("");
        $('input[name="address"]').val("");
    }
});

$(document).on('click', '#removeThisLoc', function () {
    $(this).closest(".address").remove();
    setMarkersOnMap()
});

$(document).on('click', '#editThisLoc', function () {

    var prevAddress = $(this).closest(".address").find('.clubAddressInput').val();
    if (prevAddress !== '' || prevAddress !== undefined) {
        prevAddress = JSON.parse(prevAddress);

        $('input[name="editLocationName"]').val(prevAddress['name']);
        $('input[name="editPrice"]').val(prevAddress['price']);
        $('.editPriceUnit option[value="' + prevAddress['priceUnit'] + '"]').prop('selected', true)
        $('input[name="editAddress"]').val(prevAddress['address']);
        $('#editModalClubAddress').val(JSON.stringify(prevAddress));
        $('#editLocationModal').modal('show');
    }
    else {
        Toast.fire({
            icon: "error",
            title: "Something went wrong",
        });
    }

});

$(document).on('click', '.updateThisLoc', function () {
    var editedName = $('input[name="editLocationName"]').val();
    var editedPrice = $('input[name="editPrice"]').val();
    var editedPriceUnit = $('.editPriceUnit option:selected').val();
    var editedAddress = $('input[name="editAddress"]').val();
    var prevAddress = $('#editModalClubAddress').val()
    if (editedName == "" || editedName == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter location name",
        });
    } else if (editedAddress == "" || editedAddress == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter address",
        });
    }
    else if (prevAddress == '' || prevAddress == undefined) {
        Toast.fire({
            icon: "error",
            title: "Something went wrong",
        });
    }
    else {
        prevAddress = JSON.parse(prevAddress);
        var temmpId = prevAddress['tempId'] ?? null;
        if (temmpId !== null) {


            var modifiedPriceForShow = '';
            if (editedPrice == "" || editedPrice == undefined || parseInt(editedPrice) == 0) {
                editedPrice = 0.00;
                modifiedPriceForShow = 'Free';
                priceUnit = '';
            } else {
                editedPrice = parseFloat(editedPrice).toFixed(2);

                modifiedPriceForShow = editedPriceUnit + editedPrice.toString();
            }
        }

        var payLoad =
        {
            'name': editedName,
            'priceUnit': editedPriceUnit,
            'price': editedPrice.toString(),
            'modifiedPrice': modifiedPriceForShow,
            'address': editedAddress,
            'tempId': prevAddress['tempId'],
            'locType': prevAddress['locType']
        };

        var appendableHtml = prepareLocationCard(payLoad, true);

        $('.' + temmpId).html(appendableHtml);
        $('#editLocationModal').modal('hide');
    }

})

$(document).on('click','.proceedStepThree',function () { 
    if($('.clubAddressInput').length <= 0)
    {
        Toast.fire({
            icon: "error",
            title: "Select at least one drop/pick up location",
        });
        
    }
    else
    {
        proceedToStepThree();
    }
 });

function prepareLocationCard(payLoad, isEdit = false) {


    return (isEdit !== true ? '<div class="address ' + payLoad['tempId'] + '">' : '') +
        "<input type='hidden' class='clubAddressInput' name='clubAddress[]' value='" + JSON.stringify(payLoad) + "'>" +
        ' <div class="topadd">' +
        '<h3>' + payLoad['name'] + '</h3>' +
        '<ul>' +
        ' <li><a href="javascript:void[0]" id="editThisLoc" data-locType="' + payLoad['locType'] + '">Edit</a></li>' +
        ' <li><a href="javascript:void[0]" id="removeThisLoc" data-locType="' + payLoad['locType'] + '">Remove</a></li>' +
        '</ul>' +
        '</div>' +
        '<p>' + payLoad['address'] + ' </p>' +
        '<p>' + payLoad['modifiedPrice'] + '</p>' +
        (isEdit !== true ? '</div>' : '');

}

function setMarkersOnMap() {
    var arr = [];
    var values = $('input[name^=clubAddress]').map(function (idx, elem) {
        arr.push($(elem).val());
    });

    var markerlocations = [];

    $.each(arr, function (indexInArray, valueOfElement) {

        var thisVal = JSON.parse(valueOfElement)
        markerlocations.push([
            thisVal.lat,
            thisVal.lng,
            thisVal.name
        ])
    });

    const myLatLng = {
        lat: parseFloat($('#currentLat').val()),
        lng: parseFloat($('#currentLng').val())
    };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
    });

    for (i = 0; i < markerlocations.length; i++) {
        var lat = parseFloat(markerlocations[i][0]);
        var lng = parseFloat(markerlocations[i][
            1]);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            title: markerlocations[i][2],
            icon: {
                url: 'https://previewforclient.com/ninegolf/images/map_logo.png'
            }
        });
    }
}

function initMap(latitude, longitude) {
    const myLatLng = {
        lat: latitude,
        lng: longitude
    };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
    });

    var places = new google.maps.places.Autocomplete(document.getElementById('autocomplete'));
    google.maps.event.addListener(places, 'place_changed', function () {
        var place = places.getPlace();
        console.log(place);
        console.log(place.formatted_address);
        var address = place.formatted_address;
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();
        var mesg = "Address: " + address;
        mesg += "\nLatitude: " + latitude;
        mesg += "\nLongitude: " + longitude;
        $('#fullAddr').val(address);
        const myLatLng = {
            lat: latitude,
            lng: longitude
        };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
        });

        new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Test',
            type: 'parking'
        });

        document.getElementById('currentLat').value = latitude;
        document.getElementById('currentLng').value = longitude;

    });
    document.getElementById('currentLat').value = latitude;
    document.getElementById('currentLng').value = longitude;
}
$(".num").keypress(function (e) {
    var arr = [];
    var kk = e.which;

    for (i = 48; i < 58; i++) arr.push(i);

    arr.push(46); // to allow .
    if (!(arr.indexOf(kk) >= 0)) e.preventDefault();
});
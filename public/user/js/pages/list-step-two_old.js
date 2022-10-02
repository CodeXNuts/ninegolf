$(".addLocation").on("click", function () {
    var name = $('input[name="dropLocName"]').val();
    var price = $('input[name="price"]').val();
    var address = $('input[name="address"]').val();
    var priceUnit = $(".priceUnit").val();

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
    } else {
        if (price == "" || price == undefined || parseInt(price) == 0) {
            price = "Free";
        } else {
            price = parseFloat(price).toFixed(2);
        }
        appendableHtml = "";
        var clubAddress = $("#clubAddress").val();
        if (clubAddress !== "" && clubAddress !== undefined) {
            clubAddress = JSON.parse(clubAddress);
        }

        var tempId = Math.random().toString(36).substr(2, 5);
        
        if (
            $(".baseLocationDiv .address").html() == "" ||
            $(".baseLocationDiv .address").html() == undefined
        ) {

            clubAddress = [
                {
                    'locName': name,
                    'priceUnit': priceUnit,
                    'address': address,
                    'price': price == 'Free' ? '0.00' : price,
                    'tempId': tempId,
                    'isBase': true

            }
        ];

            appendableHtml =
                '<div class="address" data-temmpId='+tempId+' data-addrType="base">' +
                '<input type="hidden" name="clubLocation[]" valute='+JSON.stringify(clubAddress)+'>'+
                '<div class="topadd">' +
                '<h3 class="locName">' +
                name +
                "</h3>" +
                '<ul><li><a href="javascript:void(0)" id="editThisLoc" style="margin:2px">Edit</a></li><li><a href="javascript:void(0)" id="removeThisLoc" style="margin:2px">Remove</a></li></ul>' +
                " </div>" +
                "<p class='addressLoc'>" +
                address +
                '<p><p class="price_display_sec">' +
                price +
                "</p>" +
                "</div>";
           
            $(".baseLocationDiv").append(appendableHtml);
        } else {
            clubAddress = [
                {
                'locName': name,
                'priceUnit': priceUnit,
                'address': address,
                'price': price == 'Free' ? '0.00' : price,
                'tempId': tempId,
                'isBase': false

        }
    ];
            appendableHtml =
                '<div class="address" data-tempId='+tempId+' data-addrType="other">' +
                '<input type="hidden" name="clubLocation[]" valute='+JSON.stringify(clubAddress)+'>'+
                '<div class="topadd">' +
                "<h3 class='locName'>" +
                name +
                "</h3>" +
                "<ul>" +
                '<li><a href="javascript:void(0)" style="margin:2px" id="editThisLoc">Edit</a></li>' +
                '<li><a href="javascript:void(0)" style="margin:2px" id="removeThisLoc">Remove</a></li>' +
                "</ul>" +
                "</div>" +
                "<p class='addressLoc'>" +
                address +
                '</p><p class="price_display_sec">' +
                price +
                "</p>" +
                "</div>";
            

            $(".otherLocationDiv").append(appendableHtml);
        }

        // $("#clubAddress").val(JSON.stringify(clubAddress));
        $('input[name="dropLocName"]').val("");
        $('input[name="price"]').val("");
        $('input[name="address"]').val("");
    }
});

$(document).on("click", "#removeThisLoc", function () {
    // var clubAddress = $("#clubAddress").val();
    // var thisAddrTemp = $(this).closest(".address").attr('data-tempid');
    // var thisAddrType = $(this).closest(".address").attr('data-addrType');
    // alert(thisAddrType);
    // if(clubAddress!== '' && clubAddress !== undefined)
    // {
    //     clubAddress=JSON.parse(clubAddress);

    //     $.each(clubAddress, function (indexInArray, valueOfElement) {
    //         if(thisAddrType == 'base')
    //         {
    //             if(valueOfElement.tempId == thisAddrTemp)
    //             {
    //                 alert('found')
    //                 delete clubAddress[indexInArray];
    //             }
    //         }
    //         else
    //         {
    //             $.each(valueOfElement,function(index,val){
    //                 if(val.tempId == thisAddrTemp)
    //                 {
    //                     alert('found')
    //                     delete clubAddress[index];
    //                 }
    //             });
    //         }
    //     });

    //     clubAddress = JSON.stringify(clubAddress);
    //     $("#clubAddress").val(clubAddress);
    // }


    $(this).closest(".address").remove();
});

$(document).on("click", "#editThisLoc", function () {
    var locName = $(this).closest(".address").find('.locName').html();
    
    // var priceUnit = $(this).closest(".dropLocName").html();
    var price = $(this).closest('.address').find(".price_display_sec").html();
    var address = $(this).closest('.address').find(".addressLoc").html();
    var tempId = $(this).closest('.address').attr('data-temmpid');
    $('#editLocTempId').val(tempId);
    $('#editLocName').val(locName);
    // $(".editPriceUnit option[value="+priceUnit+"]").prop("selected", true);
    $('#editPrice').val(price);
    $('#editAddress').val(address);

    $('#exampleModal').modal('show');

});

$(document).on('click','.updateThisLoc',function(){
    var editedName =  $('#editLocName').val();
    var address = $('#editAddress').val();
    var price = $('#editPrice').val();
    var tempId = $('#editLocTempId').val();

    clubAddress = [
        {
            'locName': editedName,
            // 'priceUnit': priceUnit,
            'address': address,
            'price': price == 'Free' ? '0.00' : price,
            'tempId': tempId,
            'isBase': true

    }
];

    appendableHtml =
                '<input type="hidden" name="clubLocation[]" valute='+JSON.stringify(clubAddress)+'>'+
                '<div class="topadd">' +
                "<h3 class='locName'>" +
                editedName +
                "</h3>" +
                "<ul>" +
                '<li><a href="javascript:void(0)" style="margin:2px" id="editThisLoc">Edit</a></li>' +
                '<li><a href="javascript:void(0)" style="margin:2px" id="removeThisLoc">Remove</a></li>' +
                "</ul>" +
                "</div>" +
                "<p class='addressLoc'>" +
                address +
                '</p><p class="price_display_sec">' +
                price +
                "</p>";

    $("div").find(`[data-temmpid='`+tempId+`']`).html(appendableHtml);

    $("#exampleModal").modal('hide');


});

$(".num").keypress(function (e) {
    var arr = [];
    var kk = e.which;

    for (i = 48; i < 58; i++) arr.push(i);

    arr.push(46); // to allow .
    if (!(arr.indexOf(kk) >= 0)) e.preventDefault();
});

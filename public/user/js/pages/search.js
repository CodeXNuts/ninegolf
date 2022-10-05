$(document).ready(function () {

    $(".rentFromDate").datepicker({
        dateFormat: "mm/dd/yy",
        duration: "fast",
        minDate: new Date(),
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $(".rentToDate").datepicker("option", "minDate", selected);
            // renderCalculatedPrice();
        }
    });
    $(".rentToDate").datepicker({
        dateFormat: "mm/dd/yy",
        duration: "fast",
        onSelect: function (selected) {
            // var dt = new Date(selected);
            // dt.setDate(dt.getDate() - 1);
            // $("#rentFromDate").datepicker("option", "maxDate", selected);
            // renderCalculatedPrice();
        }
    });

    $(".timepicker").clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        twelvehour: false,
        default: 'now',
        donetext: "Select",
        init: function () {

        },
        afterDone: function () {
            // console.log("after done");
        }

    });
});

$(document).on('click','#searchBtn',function(){
    $('#clubSearch').submit();
});
<script src="{{ asset('common/js//jquery.min.js') }}"></script>
<script src="{{ asset('user/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('user/js/owl.carousel.js')}}"></script>
<script src="{{ asset('user/js/jquery.slimNav_sk78.min.js')}}"></script>
<script src="{{ asset('user/js/rating.js')}}"></script>
<script src="{{ asset('user/js/script.js')}}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="{{ asset('common/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('user/js/pages/search.js') }}"></script>

<script>
(function($) { // Begin jQuery
    $(function() { // DOM ready
        // If a link has a dropdown, add sub menu toggle.
        $('.dropdown a').click(function(e) {
            $(this).siblings('.nav-dropdown').toggle();
            // Close one dropdown when selecting another
            $('.nav-dropdown').not($(this).siblings()).hide();
            e.stopPropagation();
        });


        // Clicking away from dropdown will remove the dropdown class

        // $('html').click(function() {
        // $('.nav-dropdown').hide();
        // });

        $(document).click(function(e) {
            $('.dropdown a').not($('.dropdown a').has($(e.target)))
                .siblings('.nav-dropdown').not($(this).siblings()).hide();
        });





        // Toggle open and close nav styles on click
        $('#nav-toggle').click(function() {
            $('nav ul').slideToggle();
        });
        // Hamburger to X toggle
        $('#nav-toggle').on('click', function() {
            this.classList.toggle('active');
        });
    }); // end DOM ready
})(jQuery); // end jQuery

$(document).ready(function() {
    $('#navigation nav').slimNav_sk78();

    var owl = $('.clublist');
    owl.owlCarousel({
        autoPlay: 3000,
        nav: true,
        dots: false,
        items: 4,
        loop: false,
        autoplay: true,
        smartSpeed: 1500,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {

            0: {

                items: 3,

                nav: true,

                dots: false,

            },

            767: {


                nav: true,

                dots: false,

            },
            768: {

                items: 2,

                nav: true,

                dots: false,

            },

            1280: {

                items: 4,

                nav: true,

                dots: false,

            }

        }

    });

    var owl = $('.productimg');
    owl.owlCarousel({
        autoPlay: 3000,
        nav: true,
        dots: false,
        navText: ["<img src='{{ asset("user/images/arrow-circle-left.png") }}'>",
            "<img src='{{ asset("user/images/arrow-circle-right.png") }}"
        ],
        items: 1,
        loop: false,
        autoplay: true,
        smartSpeed: 1500,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {}

    });


    var owl = $('.reviw');
    owl.owlCarousel({
        autoPlay: 3000,
        nav: true,
        margin: 15,
        dots: false,
        items: 3,
        loop: false,
        autoplay: true,
        smartSpeed: 1500,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {


            0: {

                items: 1,

                nav: true,

                dots: false,

            },

            767: {

                items: 2,

                nav: true,

                dots: false,

            },
            768: {

                items: 2,

                nav: true,

                dots: false,

            },

            1280: {

                items: 3,

                nav: true,

                dots: false,

            }

        }
    });


    var owl = $('.manufac');
    owl.owlCarousel({
        autoPlay: 3000,
        nav: true,

        dots: false,
        items: 3,
        loop: false,
        autoplay: true,
        smartSpeed: 1500,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {

            1280: {

                items: 6,

                nav: true,

                dots: false,

            }
        }
    });

    $('#thumbs img').click(function() {
        $('#largeImage').attr('src', $(this).attr('src').replace('thumb', 'large'));
        $('#description').html($(this).attr('alt'));
    });
});

$(function(){
    $('#thumbs img').first().trigger('click');
})





// $(function() {
//     $('.datepicker').datepicker({
//         dateFormat: "dd-mm-yy",
//         duration: "fast"
//     });
//     $(".datepicker2").datepicker({
//         dateFormat: "dd-mm-yy",
//         duration: "fast"
//     });
// });

// $(".timepicker").clockpicker({
//     placement: 'bottom',
//     align: 'left',
//     autoclose: true,
//     twelvehour: true,
//     default: 'now',
//     donetext: "Select",
//     init: function() {
        
//     },
//     afterDone: function() {
//                             // console.log("after done");
//                         }

// });
$(window).scroll(function() {
    if ($(this).scrollTop() > 250) {
        $('form.form-inline').addClass("sticky");
    } else {
        $('form.form-inline').removeClass("sticky");
    }
});

$(function(){
   
   getCartCnt();
    
});

function getCartCnt()
{
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "GET",
        url: '/cart/count',
        data: {},
        dataType: "json",
        // contentType: false,
        // processData: false,
        beforeSend: function () {
            $(".loader").fadeIn(100);
        },
        success: function (response) {
            if((response.crtCnt !== '') && (response.crtCnt !== undefined) && ($.isNumeric(response.crtCnt)))
            {
                var isCartPopShown = localStorage.getItem("popCart");


                if( (parseInt(response.crtCnt) > 0) && (isCartPopShown == null))
                {
                    Swal.fire({
                    target: '#custom-target',
                    customClass: {
                    container: 'position-absolute'
                    },
                    toast: true,
                    position: 'bottom-right',
                    showConfirmButton: false,
                    showCloseButton:true,
                    icon: 'info',
                    title: '<a href="/cart">Hey &#128516, You have '+response.crtCnt+' items in your cart. Checkout &#128070 before it solds out</a>'
                });

                localStorage.setItem("popCart", "1");
                }
                $('.KK-o3G').html(response.crtCnt);
            }
            else
            {
                $('.KK-o3G').html(0);
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

var Toast = Swal.mixin({
    target: '#custom-target',
    customClass: {
      container: 'position-absolute'
    },
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });

</script>

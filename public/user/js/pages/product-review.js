$("#inputStarRating").rating({
    "value": 5,
    "click": function(e) {
        
        $("#inputRating").val(e.stars);
    }
});

$(document).on('click','#clubReviewbtn',function(){
    var rating = $('#inputRating').val();
    var comment = $('#reviewComment').val();

    if(rating =='' || rating == undefined || rating=='0' || isNaN(rating))
    {
        Toast.fire({
            icon: "error",
            title: "Please give some rating",
        });
    }
    else if(comment== '' || comment == undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please write something",
        });
    }
    else
    {
        $('#clubreviewForm').submit();
    }
});

$(document).on('change','#reviewFilter',function(){
    var term = $(this).val();
    var target = $(this).attr('data-target');
    var urlRegex = new RegExp(
        "^(https?:\\/\\/)?" + // validate protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    );

    if(term !== '' && term!== undefined && target.match(urlRegex))
    {

        window.location.href = target+"?sortBy="+term;
    }
});

$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("sortBy")) {
        sort = urlParams.get("sortBy");
        $("#reviewFilter").val(sort);
    }
});

$(document).on('click','.replyThis',function(){
    $(this).closest('.reviewbox').find('.replyBox').toggle();
    $(this).closest('.reviewbox').find('.replyShowBox').toggle();
});

$(document).on('click','.replyBtn',function(){
    var comment = $(this).closest('.reviewbox').find('.replyComment').val();
    
    if(comment=='' || comment==undefined)
    {
        Toast.fire({
            icon: "error",
            title: "Please write a reply",
        });
    }
    else
    {
        $(this).closest('form').submit();
    }
});
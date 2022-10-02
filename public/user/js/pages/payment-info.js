$(document).ready(function () {
    $("#acHolderDOB").datepicker({
        dateFormat: "mm/dd/yy",
        duration: "fast",
        maxDate: new Date(),
        onSelect: function (selected) {
            if (!isValidDate(selected)) {
                $("#acHolderDOB").html("");
                Toast.fire({
                    icon: "error",
                    title: "Please enter a valid date",
                });
            }
        },
    });

    $('#sync').trigger('click');
});


$(document).on('click','#sync',function () { 
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

    if(target !== '' && target !== undefined)
    {
        syncWithStripe(target);
    }

 });

$(document).on("click", "#stepOneBtn", function () {
    var email = $("#email").val();
    var companyCountry = $("#companyCountry").val();
    var companyState = $("#companyState").val();
    var companyCity = $("#companyCity").val();
    var companyPostalCode = $("#companyPostalCode").val();
    var companyAddrLine1 = $("#companyAddrLine1").val();
    var companyAddrLine2 = $("#companyAddrLine2").val();

    var emailRegX =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (email == "" || email == undefined || !email.match(emailRegX)) {
        Toast.fire({
            icon: "error",
            title: "Please provide a valid account email",
        });
        return;
    } else if (companyCountry == "" || companyCountry == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please select a country for company",
        });
        return;
    } else if (companyState == "" || companyState == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter state for company",
        });
        return;
    } else if (companyCity == "" || companyCity == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter city for company",
        });
        return;
    } else if (
        companyPostalCode == "" ||
        companyPostalCode == "" ||
        companyPostalCode.length != 5 ||
        isNaN(companyPostalCode)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please enter valid postal code for company",
        });
        return;
    } else if (companyAddrLine1 == "" || companyAddrLine1 == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter address line one for company",
        });
        return;
    } else if (companyAddrLine2 == "" || companyAddrLine2 == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter address line two for company",
        });
        return;
    } else {
        $(".stepDiv").fadeOut(600),
            $("#" + $(this).attr("data-target")).fadeIn(200);
    }
});

$(document).on("click", "#stepTwoBtn", function () {
    var businessProfileName = $("#businessProfileName").val();
    var businessProfileDesc = $("#businessProfileDesc").val();
    var acHolderDOB = $("#acHolderDOB").val();

    if (businessProfileName == "" || businessProfileName == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please provide your business name",
        });
    } else if (businessProfileDesc == "" || businessProfileDesc == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please provide your business description",
        });
    } else if (
        acHolderDOB == "" ||
        acHolderDOB == undefined ||
        !isValidDate(acHolderDOB)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please provide a valid DOB for account holder",
        });
    } else {
        $(".stepDiv").fadeOut(600),
            $("#" + $(this).attr("data-target")).fadeIn(200);
    }
});

$(document).on("click", "#finalSubBtn", function () {
    var acHolderState = $("#acHolderState").val();
    var acHolderCity = $("#acHolderCity").val();
    var acAddrLine1 = $("#acAddrLine1").val();
    var acAddrPostalCode = $("#acAddrPostalCode").val();
    var acHolderSSN = $("#acHolderSSN").val();
    var acHolderBankAC = $('#acHolderBankAC').val();
    var acHolderCurrency = $('#acHolderCurrency').val();
    var acHolderRouting = $('#acHolderRouting').val();

    var target = $(this).attr("data-targetURI");

    

    if (acHolderState == "" || acHolderState == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter state for account holder",
        });

        return;
    } else if (acHolderCity == "" || acHolderCity == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter city for account holder",
        });

        return;
    } else if (acAddrLine1 == "" || acAddrLine1 == undefined) {
        Toast.fire({
            icon: "error",
            title: "Please enter address line one for account holder",
        });

        return;
    } else if (
        acAddrPostalCode == "" ||
        acAddrPostalCode == "" ||
        acAddrPostalCode.length != 5 ||
        isNaN(acAddrPostalCode)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please enter postal code for account holder",
        });

        return;
    } else if (
        acHolderSSN == "" ||
        acHolderSSN == "" ||
        acHolderSSN.length != 4 ||
        isNaN(acHolderSSN)
    ) {
        Toast.fire({
            icon: "error",
            title: "Please enter SSN(last 4digits) for account holder",
        });

        return;
    } 
    else if(acHolderBankAC == '' || acHolderBankAC == undefined || isNaN(acHolderBankAC))
    {
        Toast.fire({
            icon: "error",
            title: "Please valid bank account number",
        });

        return; 
    }
    else if(acHolderCurrency == '' || acHolderCurrency == undefined )
    {
        Toast.fire({
            icon: "error",
            title: "Please enter bank account currency",
        });

        return; 
    }
    else if(acHolderRouting == '' || acHolderRouting == undefined || isNaN(acHolderRouting) || (!isValidRoutingNumber(acHolderRouting)))
    {
        Toast.fire({
            icon: "error",
            title: "Please enter valid routing number",
        });

        return; 
    }
    else {
        var payLoad = {
            email : $("#email").val(),
            companyCountry: $("#companyCountry").val(),
            companyState:  $("#companyState").val(),
            companyCity: $("#companyCity").val(),
            companyPostalCode: $("#companyPostalCode").val(),
            companyAddrLine1: $("#companyAddrLine1").val(),
            companyAddrLine2: $("#companyAddrLine2").val(),
            businessProfileName: $("#businessProfileName").val(),
            businessProfileDesc: $("#businessProfileDesc").val(),
            acHolderDOB: $("#acHolderDOB").val(),
            acHolderState: acHolderState,
            acHolderCity: acHolderCity,
            acAddrLine1: acAddrLine1,
            acAddrPostalCode: acAddrPostalCode,
            acHolderSSN: acHolderSSN,
            acHolderBankAC: acHolderBankAC,
            acHolderCurrency: acHolderCurrency,
            acHolderRouting: acHolderRouting
        }

        updateUserPaymentAccount(payLoad,target)
    }
});


function updateUserPaymentAccount(payLoad,target)
{
    var urlRegex = new RegExp(
        "^(https?:\\/\\/)?" + // validate protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // validate domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // validate OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // validate port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // validate query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    );
    if(payLoad !== '' || payLoad!== '' || payLoad.length > 0 || target!=='' || target.match(urlRegex))
    {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    
        $.ajax({
            type: "POST",
            url: target,
            data: payLoad,
            dataType: "json",
            // contentType: false,
            // processData: false,
            beforeSend: function () {
                $(".loader").fadeIn(100);
            },
            success: function (response) {
    
                 if(response.key !=='' && response.key !== undefined && response.key == 'success')
                 {
                    // var appentableHtml = 
                    // '<img src="/user/images/payment-status-active.png" alt="">'+
                    // '<h4>Your payment account status: <span class="badge badge-pill badge-success" style="background: chartreuse">Active</span></h4>'+
                    // '<h3 style="padding-bottom: 20px">You can always update your account info from here</h3>';
                    // $('.payStatCls').html(appentableHtml);
                    Toast.fire({
                        icon: "success",
                        title: response.msg ?? "Your payment account has been activated successfully",
                    });
                 }
                 else
                 {
                    // var appentableHtml = 
                    // '<h4>Your payment account status: <span class="badge badge-pill badge-success" style="background: #e1c29e">In-active</span></h4>'+
                    // '<h3 style="padding-bottom: 20px"><span style="color: red">***</span>Please provide the below informaton in'+
                    //     'order to active your payment account</h3>';

                    //     $('.payStatCls').html(appentableHtml);
                    Toast.fire({
                        icon: "error",
                        title: response.msg ?? 'Something went wrong try again',
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

$(document).on(
    "keypress",
    "#companyPostalCode,#acAddrPostalCode",
    function (e) {
        var arr = [];
        var kk = e.which;

        for (i = 48; i < 58; i++) arr.push(i);

        // arr.push(46); // to allow .
        if (!(arr.indexOf(kk) >= 0) || $(this).val().length >= 5)
            e.preventDefault();
    }
);
$(document).on("keypress", "#acHolderSSN", function (e) {
    var arr = [];
    var kk = e.which;

    for (i = 48; i < 58; i++) arr.push(i);

    // arr.push(46); // to allow .
    if (!(arr.indexOf(kk) >= 0) || $(this).val().length >= 4)
        e.preventDefault();
});
$(document).on("keypress", "#acHolderBankAC,#acHolderRouting", function (e) {
    var arr = [];
    var kk = e.which;

    for (i = 48; i < 58; i++) arr.push(i);

    // arr.push(46); // to allow .
    if (!(arr.indexOf(kk) >= 0))
        e.preventDefault();
});

$(document).on("click", ".backBtn", function () {
    $(".stepDiv").fadeOut(600),
        $("#" + $(this).attr("data-target")).fadeIn(200);
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

function isValidRoutingNumber(n) {
	if (n.length !== 9 || isNaN(n)) {
		return false;
	}
	else digits = n.split("");
	var sum = digits[0] * 7 + digits[1] * 3 + digits[2] 
		      + digits[3] * 7 + digits[4] * 3 + digits[5] 
			  + digits[6] * 7 + digits[7] * 3 + digits[8];
			  
	return sum % 10 === 0;
}


function syncWithStripe(target)
{
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: target,
        data: {},
        dataType: "json",
        // contentType: false,
        // processData: false,
        beforeSend: function () {
            $(".loader").fadeIn(100);
        },
        success: function (response) {
            console.log(response)
             if(response.key !=='' && response.key !== undefined && response.key == 'success')
             {
                if(response.data.is_completed !== '' && response.data.is_completed !== undefined && response.data.is_completed == true)
                {
                    var appentableHtml = 
                    '<img src="/user/images/payment-status-active.png" alt="">'+
                    '<h4>Your payment account status: <span class="badge badge-pill badge-success" style="background: chartreuse">Active</span><i class="fas fa-sync-alt" id="sync" title="Sync data with Stripe" data-target="/profile/payments/'+response.data.id+'/sync" style="margin-left: 20px;'+
                    'cursor: pointer;"></i></h4>'+
                    '<h3 style="padding-bottom: 20px">You can always update your account info from here</h3>';
                }
                else
                {
                    var appentableHtml = 
                '<h4>Your payment account status: <span class="badge badge-pill badge-success" style="background: #e1c29e">In-active</span><i class="fas fa-sync-alt" id="sync" title="Sync data with Stripe" data-target="/profile/payments/'+response.data.id+'/sync" style="margin-left: 20px;'+
                'cursor: pointer;"></i></h4>'+
                '<h3 style="padding-bottom: 20px"><span style="color: red">***</span>Please provide the below informaton in'+
                    'order to active your payment account</h3>';

                    Swal.fire({
                        target: '#custom-target',
                        customClass: 
                        // container: 'position-absolute',
                        'swal-payment-warning'
                        ,
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        showCloseButton:true,
                        icon: 'warning',
                        title: '<a href="/profile?sec=payment-info">Hey &#128533, You have not yet activated your payment account. Your product will not be visibile untill you complete the payment account</a>'
                    });

                }

                $('#email').val(response.data.email ?? '');
                $('#companyCountry').val(response.data.company_country ?? '');
                $('#companyState').val(response.data.company_state ?? '');
                $('#companyCity').val(response.data.company_city ?? '');
                $('#companyPostalCode').val(response.data.company_postal_code ?? '');
                $('#companyAddrLine1').val(response.data.company_addr_line_1 ?? '');
                $('#companyAddrLine2').val(response.data.company_addr_line_2 ?? '');
                $('#businessProfileName').val(response.data.business_profile_name ?? '');
                $('#businessProfileDesc').val(response.data.business_profile_desc ?? '');
                $('#acHolderDOB').val(response.data.ac_holder_dob ?? '');
                $('#acHolderState').val(response.data.ac_holder_state ?? '');
                $('#acHolderCity').val(response.data.ac_holder_city ?? '');
                $('#acAddrLine1').val(response.data.ac_addr_line_1 ?? '');
                $('#acAddrPostalCode').val(response.data.ac_addr_postal_code ?? '');
                $('#acHolderSSN').val(response.data.ac_holder_ssn ?? '');
                $('#acHolderBankAC').val(response.data.ac_holder_bank_ac ?? '');
                $('#acHolderCurrency').val(response.data.currency ?? '');
                $('#acHolderRouting').val(response.data.ac_holder_routing ?? '');

               
                $('.payStatCls').html(appentableHtml);
                // Toast.fire({
                //     icon: "success",
                //     title: response.msg ?? "Synced successfully",
                // });

                
             }
             else
             {
                Toast.fire({
                    icon: "error",
                    title: response.msg ?? 'Something went wrong try again',
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
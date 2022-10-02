function proceedToStepThree() {
    var clubs = $("#clubs").val();
    var listType = $("#listType").val();
    var isMix = $("#isMix").val();
    if (clubs !== "" || clubs !== undefined) {
        clubs = clubs.split(",");
        var appendableHtmlStepThree = "";
        for (let i = 0; i < clubs.length; i++) {
            var generatedClass =
                "prods-" + Math.random().toString(36).substr(5, 10);
            appendableHtmlStepThree +=
                '<div class="col-md-3 col-lg-3 mainListCard ' +
                generatedClass +
                '-image " data-cls-base="' +
                generatedClass +
                '">' +
                "<h2>" +
                clubs[i] +
                "</h2>" +
                '<input type="file" multiple id="' +
                generatedClass +
                '-image-multiple" name="clubImages[]" class="clubImages" style="display:none"/>' +
                '<div class="drog-drop" ondragover="allowDrop(event)">' +
                '<img src="/user/images/send-square.png" alt="" class="dropBox"></img>' +
                "<p>Drag & Drop files here<span>or</span></p>" +
                '<a href="javascript:void(0)" class="drag">Browse files</a>' +
                "</div>" +
                "</div>" +
                '<div class="col-md-3 col-lg-3 productDetailsCard " id="' +
                generatedClass +
                '-details">' +
                (listType == "individual" || isMix == "true"
                    ? '<div class="form-group">' +
                      '<label for=""> Price</label>' +
                      '<div class="form_sel">' +
                      '<select  name="productPriceUnit" class="pric">' +
                      '<option value="usd" selected>USD</option>' +
                      '<option value="cad">CAD</option>' +
                      "</select>" +
                      '<input type="text" name="productPrice" class="pricinput num">' +
                      "</div>" +
                      "</div>"
                    : "") +
                '<div class="form-group">' +
                '<label for=""> Brand</label>' +
                '<select id="brand" class="brand" name="brand[]">' +
                '<option value="">Select brand</option>' +
                '<option value="TaylorMade">TaylorMade</option>' +
                '<option value="Ping">Ping</option>' +
                '<option value="Callaway">Callaway</option>' +
                '<option value="Robin Golf">Robin Golf</option>' +
                '<option value="Cobra">Cobra</option>' +
                '<option value="Titleist">Titleist</option>' +
                '<option value="Adams">Adams</option>' +
                '<option value="Mizuno">Mizuno</option>' +
                '<option value="Wilson">Wilson</option>' +
                '<option value="Cleveland">Cleveland</option>' +
                '<option value="Srixon">Srixon</option>' +
                '<option value="Tour Edge">Tour Edge</option>' +
                '<option value="Honma">Honma</option>' +
                '<option value="PXG">PXG</option>' +
                '<option value="Sub 70">Sub 70</option>' +
                '<option value="Vega Golf">Vega Golf</option>' +
                '<option value="Ben Hogan Golf">Ben Hogan Golf</option>' +
                '<option value="Edel">Edel</option>' +
                '<option value="Stix">Stix</option>' +
                '<option value="other">other</option>' +
                "</select>" +
                "</div>" +
                '<div class="form-group">' +
                '<label for="">Length (inches ")</label>' +
                '<input type="text " class="length num" name="length[]">' +
                "</div>" +
                '<div class="form-group">' +
                '<label for="flex">Flex</label>' +
                '<select class="flex" name="flex[]">' +
                '<option value="">Select flex</option>' +
                '<option value="Extra Stiff">Extra Stiff</option>' +
                '<option value="Stiff Shaft">Stiff Shaft</option>' +
                '<option value="Regular Flex">Regular Flex</option>' +
                '<option value="Senior Flex">Senior Flex</option>' +
                '<option value="Ladies Flex">Ladies Flex</option>' +
                "</select>" +
                "</div>" +
                '<div class="form-group">' +
                '<label for="">Loft (degree &deg;)</label>' +
                '<input type="text" name="loft[]" class="num loft">' +
                "</div>" +
                '<div class="form-group check">' +
                '<label> <input type="checkbox" name="isAdjustable" class="isAdjustable"> Adjustable</label>' +
                "</div>" +
                "</div>";
        }

        if (listType == "set") {
            var appendableHtmlSet =
                '<div class="col-lg-4 col-md-4  p-0">' +
                '<input type="text" placeholder="Set 1 " id="finalListName" class="s1" value="' +
                $("#listNamePlaceholder").val() +
                '">' +
                "</div>" +
                '<div class="col-lg-6 col-md-6  d-flex">' +
                '<label for="">Set Price</label>' +
                '<select id="price" name="setProductPriceUnit">' +
                '<option value="usd" selected>USD</option>' +
                '<option value="cad">CAD</option>' +
                '</select><input type="text" name="setProductPrice" class="num">' +
                "</div>";
            $(".setTypeDiv").html(appendableHtmlSet);
        } else {
            $(".setTypeDiv").html("");
        }

        $(".selectedClubList").html(appendableHtmlStepThree);
    }
    $("#proceedStepThree").trigger("click");
}

$(document).on("click", ".drog-drop", function () {
    $(this).closest(".mainListCard").find(".clubImages").click();
});

$(document).on("drop", ".drog-drop", function (e) {
    e.preventDefault();
    var totalFile = e.originalEvent.dataTransfer.files.length;
    if (totalFile > 0) {
        $(this)
            .closest(".mainListCard")
            .find(".clubImages")
            .prop("files", e.originalEvent.dataTransfer.files);
        $(this).closest(".mainListCard").find(".clubImages").trigger("change");
    }
});

$(document).on("click", ".addOnImage", function () {
    // $(this).closest(".mainListCard").find(".addOnImageInput").trigger("click");
    var tempId = Math.random().toString(36).substr(2, 5);
    $(this).after(
        "<input type='file' id='" +
            tempId +
            "' style='display:none' name='addOnImageInputWithFile[]' class='addOnImageInputWithFile' />"
    );
    $("#" + tempId).trigger("click");
});

$(document).on("change", ".addOnImageInputWithFile", function (e) {
    var totalFile = e.target.files.length;
    if (totalFile > 0) {
        var newlyAppendableHtml =
            '<div class="item">' +
            '<img src="' +
            URL.createObjectURL(e.target.files[0]) +
            '" alt="">' +
            "</div>";

        $(this)
            .closest(".mainListCard")
            .find(".productimg")
            .append(newlyAppendableHtml);
        reInitOwl();
    } else {
        $(this).remove();
    }
});

$(document).on("change", ".addOnImageInput", function (e) {
    var totalFile = e.target.files.length;
    if (totalFile > 0) {
        var tempId = Math.random().toString(36).substr(2, 5);

        $(this).after(
            "<input type='file' id='" +
                tempId +
                "' style='display:none' name='addOnImageInputWithFile[]' class='addOnImageInputWithFile' />"
        );
        // __prevFiles = $(this).closest('.mainListCard').find('.clubImages').prop('files');
        // __prevFiles[__prevFiles.length] = e.target.files[0];
        // console.log(__prevFiles)
        $("#" + tempId).prop("files", new FileListItems(e.target.files[0]));
        var newlyAppendableHtml =
            '<div class="item">' +
            '<img src="' +
            URL.createObjectURL(e.target.files[0]) +
            '" alt="">' +
            "</div>";
        $(this)
            .closest(".mainListCard")
            .find(".productimg")
            .append(newlyAppendableHtml);
        reInitOwl();
    }
});

$(document).on("change", ".clubImages", function (e) {
    var totalFile = this.files.length;
    // return false;
    if (totalFile > 0) {
        var appendableHtmlForOwl = '<div class="productimg owl-carousel">';
        for (let index = 0; index < totalFile; index++) {
            appendableHtmlForOwl +=
                '<div class="item">' +
                '<img src="' +
                URL.createObjectURL(e.target.files[index]) +
                '" alt="">' +
                "</div>";
        }

        appendableHtmlForOwl += "</div>";
        appendableHtmlForOwl +=
            "<input type='file' style='display:none' class='addOnImageInput' />";
        appendableHtmlForOwl +=
            '<a href="javascript:void(0)" class="addOnImage"><img src="/user/images/add-circle.png"> Add Image</a>';
        $(this).closest(".mainListCard").find(".drog-drop").remove();
        $(this).after(appendableHtmlForOwl);
        reInitOwl();
    }
});

$(document).on("change", ".brand", function () {
    if ($(this).val() == "other") {
        var appendableHtmlForOther =
            '<div class="form-group other_brand_box"><label for="other">Other brand</label><input type="text" class="other_brand" name="other_brand[]" placeholder="Enter other brand name"></div>';
        $(this).closest(".form-group").after(appendableHtmlForOther);
    } else {
        $(this)
            .closest(".productDetailsCard")
            .find(".other_brand_box")
            .remove();
    }
});

$(document).on("click", ".uploadTheProduct", function () {
    var listType = $("#listType").val();
    var isMix = $("#isMix").val();
    var clubs = $("#clubs").val();
    clubs = clubs.split(",");
    var setName = $("#finalListName").val();
    var setProductPriceUnit = $(
        'select[name="setProductPriceUnit"] option:selected'
    ).val();
    var setProductPrice = $('input[name="setProductPrice"]').val();
    var gender = $("input[name='gender']:checked").val();
    var priorTime = $("input[name='priorTime']:checked").val();
    var dexterity = $("input[name='dexterity']:checked").val();
    var addresses = [];
    $("input[name^=clubAddress]").map(function (idx, elem) {
        addresses.push($(elem).val());
    });

    if (listType == "set") {
        if (setName == "" || setName == undefined) {
            Toast.fire({
                icon: "error",
                title: "Please enter the name for the set",
            });

            return false;
        }
        if (setProductPriceUnit == "" || setProductPriceUnit == undefined) {
            Toast.fire({
                icon: "error",
                title: "Please select the product unit for the set",
            });

            return false;
        }
        if (setProductPrice == "" || setProductPrice == undefined) {
            Toast.fire({
                icon: "error",
                title: "Please enter the product price for the set",
            });

            return false;
        }
    }

    var formData = new FormData();

    var elts = $('*[class*="prods-"]').filter(function () {
        return this.className.match(/(?:^|\s)prods-/);
    });

    var products = [];

    var hasError = false;
    $.each(elts, function (i, v) {
        var base = $(this).attr("data-cls-base");
        var prodImgClass = base + "-image";
        var prodDetailsId = base + "-details";
        var tempProdId = "prods-" + Math.random().toString(36).substr(5, 10);
        var productImagesArr = [];
        var addOnImagesArr = [];

        var productImages = $("." + prodImgClass)
            .find(".clubImages")
            .prop("files");

        if (productImages.length <= 0) {
            Toast.fire({
                icon: "error",
                title:
                    "Product image is missing for " +
                    toTitleCase(clubs[i]) +
                    " ",
            });
            hasError = true;
            return false;
        }
        var addOnImages = [];

        $("." + prodImgClass)
            .find("input[name^=addOnImageInputWithFile")
            .map(function (idx, elem) {
                var thisAddonImg = "addon_" + tempProdId + "_" + idx;
                addOnImagesArr.push(thisAddonImg);
                formData.append(thisAddonImg, $(elem).prop("files")[0]);
            });

        var productPriceUnit = $("#" + prodDetailsId)
            .find($('select[name="productPriceUnit"] option:selected'))
            .val();

        var productPrice = $("#" + prodDetailsId)
            .find($('input[name="productPrice"]'))
            .val();

        var brand = $("#" + prodDetailsId)
            .find(".brand option:selected")
            .val();

        var length = $("#" + prodDetailsId)
            .find(".length")
            .val();

        var flex = $("#" + prodDetailsId)
            .find(".flex option:selected")
            .val();

        var loft = $("#" + prodDetailsId)
            .find(".loft")
            .val();

        if (listType == "individual" || isMix == "true") {
            if (productPriceUnit == "" || productPriceUnit == undefined) {
                Toast.fire({
                    icon: "error",
                    title: "Please select the product unit",
                });
                hasError = true;
                return false;
            }
            if (productPrice == "" || productPrice == undefined) {
                Toast.fire({
                    icon: "error",
                    title: "Please enter the product price",
                });
                hasError = true;
                return false;
            }
        }

        if (brand == undefined || brand == "") {
            Toast.fire({
                icon: "error",
                title: "Product brand is missing for " + toTitleCase(clubs[i]),
            });
            hasError = true;
            return false;
        } else if (brand == "other") {
            if (
                $("#" + prodDetailsId)
                    .find(".other_brand")
                    .val() == "" ||
                $("#" + prodDetailsId)
                    .find(".other_brand")
                    .val() == undefined
            ) {
                Toast.fire({
                    icon: "error",
                    title:
                        "Product brand name is missing for " +
                        toTitleCase(clubs[i]),
                });
                hasError = true;
                return false;
            } else {
                brand = $("#" + prodDetailsId)
                    .find(".other_brand")
                    .val();
            }
        }

        if (length == "" || length == undefined) {
            Toast.fire({
                icon: "error",
                title: "Product length is missing for " + toTitleCase(clubs[i]),
            });
            hasError = true;
            return false;
        }

        if (flex == "" || flex == undefined) {
            Toast.fire({
                icon: "error",
                title: "Product flex is missing for " + toTitleCase(clubs[i]),
            });
            hasError = true;
            return false;
        }

        if (loft == "" || loft == undefined) {
            Toast.fire({
                icon: "error",
                title: "Product loft is missing for " + toTitleCase(clubs[i]),
            });
            hasError = true;
            return false;
        }

        $.each(productImages, function (p, q) {
            var thisImgName = "main_" + tempProdId + "_" + p;
            productImagesArr.push(thisImgName);
            formData.append(thisImgName, q);
        });

        var thisProd = {
            tempId: tempProdId,
            productPriceUnit: productPriceUnit,
            productPrice: productPrice,
            brand: brand,
            length: length,
            flex: flex,
            loft: loft,
            prodImg: $.merge(productImagesArr, addOnImagesArr),

            is_adjustable:
                $("#" + prodDetailsId)
                    .find(".isAdjustable")
                    .prop("checked") == true
                    ? true
                    : false,
        };

        products.push(thisProd);

        // productImagesArr.push({id: tempProdId , productImages: productImages});
        // addOnImagesArr.push({id: tempProdId , addOnImages: addOnImages});
    });

    if (hasError) {
        return;
    }

    var payload = {
        listType: listType,
        isMix: isMix,
        clubs: clubs,
        addresses: addresses,
        setName: setName,
        gender: gender,
        dexterity: dexterity,
        priorTime: priorTime,
        setProductPriceUnit: setProductPriceUnit,
        setProductPrice: setProductPrice,
        products: products,
    };

    formData.append("payload", JSON.stringify(payload));

    Swal.fire({
        title: "Are you suren publish this club?",
        text: "You can review your details by clicking the back",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: "/list-my-club",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(".loader").fadeIn(100);
                },
                success: function (response) {
                    if (response.key !== "" && response.key == "success") {
                        $("#spinner-loader").fadeOut(100);
                        Toast.fire({
                            icon: "success",
                            title: response.msg ?? "Success",
                        });
                        window.location.href = "/profile?sec=club-list";
                    } else {
                        Toast.fire({
                            icon: "error",
                            title:
                                response.msg ??
                                "Something went wrong. Please try again",
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
                    $("#spinner-loader").fadeOut(100);
                },
            });
        }
    });
});

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function reInitOwl() {
    var owl = $(".productimg");
    owl.trigger("destroy.owl.carousel"); //destroy first
    owl.owlCarousel({
        autoPlay: 3000,
        nav: true,
        dots: false,
        navText: [
            "<img src='/user/images/arrow-circle-left.png'>",
            "<img src='/user/images/arrow-circle-right.png'>",
        ],
        items: 1,
        loop: false,
        autoplay: true,
        smartSpeed: 1500,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {},
    });
}

$(document).on("keypress", ".num", function (e) {
    var arr = [];
    var kk = e.which;

    for (i = 48; i < 58; i++) arr.push(i);

    arr.push(46); // to allow .
    if (!(arr.indexOf(kk) >= 0)) e.preventDefault();
});

function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function (match) {
        return match.toUpperCase();
    });
}

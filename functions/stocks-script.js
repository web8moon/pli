$(document).ready(function () {


    $(".form-control").focus(function () {
        $(this).removeClass().addClass("form-control");
    });

    $(".form-control").blur(function () {
        let len = $(this).val().length;
        // Stock Name
        if ($(this).attr('id') == "user-stock-name") {
            if (len > 23 || len < 1) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // City
        if ($(this).attr('id') == "user-stock-city") {
            if (len > 19 || len < 2) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // Adress
        if ($(this).attr('id') == "user-stock-adress") {
            if (len > 48 || len < 4) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // E-Mail
        if ($(this).attr('id') == "user-stock-mail") {
            if ((len > 48 || len < 6) || !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($("#user-stock-mail").val())) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // Phone Country Code
        if ($(this).attr('id').indexOf("user-phone-country-code", 0) == 0) {
            if (len > 4 || len == 0 || $(this).val() == "00") {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // Phone Number
        if ($(this).attr('id').indexOf("user-stock-phone", 0) == 0) {
            if (len > 10 || len < 7) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
        // Ships Info
        if ($(this).attr('id') == "user-stock-ships") {
            if (len > 200 || len < 2) {
                $(this).removeClass().addClass("form-control is-invalid");
            }
        }
    });


    // Checkbox is the Stock is Active
    $("#stock-active-chk").click(function () {
        if (!$("#stock-active-chk").is(":checked")) {
            $("#stock-active-lbl").addClass("btn-danger");
        } else {
            $("#stock-active-lbl").removeClass("btn-danger");
        }
    });


    $("#save-stock").click(function () {
         fields = {};
        fields.phone = [];
        gatherFields(fields);

        if (checkForm(fields)) {
            $("#SconfirmForm")[0].reset();
            $("#msgSubmit").text('');
            $("#SconfirmModal").modal("show");
        }
    });


    $("#add-phone-number").click(function () {
	    var uri1 = document.getElementById("uri1").value;
        var stock = document.getElementById("stn").value;

        if (stock > 0) {
            if (uri1 == "stocks") {
				addPhoneN();
			}
		}

    });
/*
    $("label.del-phone-number").click(function () {
 var eid = this.id;
       var uri1 = document.getElementById("uri1").value;
       var stock = document.getElementById("stn").value;
alert("me");
        if (stock > 0) {
            if (uri1 == "stocks") {
				delPhoneN(eid);
            }
        }		

    });
*/

    $("#SconfirmForm").validator().on("submit", function (event) {

        if (event.isDefaultPrevented()) {
            // handle the invalid form...
            var errmsg = "Did you fill in the form properly?";
            formError();
            if ($("#uri2").val() == 'ru') errmsg = "Проверьте правильность ввода";
            submitMSG(false, errmsg);
        } else {
            // everything looks good!
            event.preventDefault();
            submitLoginForm();
        }

    });


});


function submitLoginForm() {

    var uri1 = document.getElementById("uri1").value;
    var uri2 = document.getElementById("uri2").value;
    fields.stn = Number(document.getElementById("stn").value);

    if (uri1 == "stocks" && fields.stn > 0) {
        fields.pwd = document.getElementById("conf-password").value;
        $.ajax({
            type: "POST",
            url: "/save-stock/" + uri2,
            //data: "formid=" + formid + "&active=" + active + "&plan=" + plan + "&name=" + name + "&mail=" + mail + "&passw=" + passw + "&uri1=" + uri1 + "&passwconf=" + passwconf,
            data: "json=" + JSON.stringify(fields),
            success: function (text) {
                if (text == "success") {
                    confirmFormSuccess();
                    void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
                } else {
                    formError();
                    submitMSG(false, text);
                }
            }
        });
    }
}

function formError() {

    $("#SconfirmForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        $(this).removeClass();
    });
}

function submitMSG(valid, msg) {
    if (valid) {
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}

function confirmFormSuccess() {
    $("#conf-password").removeClass().addClass("form-control is-valid");
    $("#SconfirmForm")[0].reset();
    submitMSG(true, "Ok!");
}

function checkForm(fields) {
    var checkStatus = true;

    // Stock Name
    if ($("#user-stock-name").val().length > 23 || $("#user-stock-name").val().length < 1) {
        checkStatus = false;
        $("#user-stock-name").removeClass().addClass("form-control is-invalid");
    }
    // City
    if ($("#user-stock-city").val().length > 19 || $("#user-stock-city").val().length < 2) {
        checkStatus = false;
        $("#user-stock-city").removeClass().addClass("form-control is-invalid");
    }
    // Adress
    if ($("#user-stock-adress").val().length > 48 || $("#user-stock-adress").val().length < 4) {
        checkStatus = false;
        $("#user-stock-adress").removeClass().addClass("form-control is-invalid");
    }
    // E-mail
    if (( $("#user-stock-mail").val().length > 48 || $("#user-stock-mail").val().length < 6 ) || !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($("#user-stock-mail").val())) {
        checkStatus = false;
        $("#user-stock-mail").removeClass().addClass("form-control is-invalid");
        //void(setTimeout('$("#user-stock-mail").removeClass().addClass("form-control")', 1500));
    }
    for (var i = 0; i < fields.Ntels; i++) {
        // Phone Country Code
        if ($("#user-phone-country-code-" + fields.phone[i]).val().length > 4 || $("#user-phone-country-code-" + fields.phone[i]).val().length == 0 || $("#user-phone-country-code-" + fields.phone[i]).val() == "00") {
            checkStatus = false;
            $("#user-phone-country-code-" + fields.phone[i]).removeClass().addClass("form-control is-invalid");
        }
        // Phone Number
        if ($("#user-stock-phone-" + fields.phone[i]).val().length > 20 || $("#user-stock-phone-" + fields.phone[i]).val().length < 7) {
            checkStatus = false;
            $("#user-stock-phone-" + fields.phone[i]).removeClass().addClass("form-control is-invalid");
        }

    }
    // Ships Info
    if ($("#user-stock-ships").val().length > 200 || $("#user-stock-ships").val().length < 2) {
        checkStatus = false;
        $("#user-stock-ships").removeClass().addClass("form-control is-invalid");
    }

    return checkStatus;
}

function addPhoneN() {
	    var uri1 = document.getElementById("uri1").value;
        var uri2 = document.getElementById("uri2").value;
        var stock = document.getElementById("stn").value;

        if (stock > 0) {
            if (uri1 == "stocks") {
                $.ajax({
                    type: "POST",
                    url: "/add-phone/" + uri2,
                    data: "st=" + stock,
                    success: function (text) {

                        echo = text.substring(0, 7);
                        newID = text.substring(7);

                        if (echo == "success" && newID > 0) {
                            //confirmFormSuccess();
                            putEmptyPhoneNumber(newID);
								//void( setTimeout(location.reload(), 500) );

                        } else {
                            //formError();
                            $("#add-phone-number-error").css("display", "inline-block");
                        }
                    }
                });
            }
        }
}

function delPhoneN(eid) {

	if ( eid.indexOf("del-phone-number") !=-1 ) {
        var uri1 = document.getElementById("uri1").value;
        var uri2 = document.getElementById("uri2").value;
        var stock = document.getElementById("stn").value;
        var img1 = document.getElementById(eid).getElementsByTagName("img")[0];
        var img1src = img1.getAttribute("src");

       img1.src = "../views/preloader.gif";

        if (stock > 0) {
            if (uri1 == "stocks") {

                $.ajax({
                    type: "POST",
                    url: "/del-phone/" + uri2,
                    // data: "st=" + stock + "&phn=" + eid + "&max=" + fields.Ntels,
					  data: "st=" + stock + "&phn=" + eid,
                    success: function (text) {
                        if (text == "success") {
                            //void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
                            img1.src = img1src;
                            void( setTimeout(location.reload(), 500) );
                        } else {
                            img1.src = img1src;
                            alert(text);
                        }
                    }
                });

            }
        }
	}
}

function putEmptyPhoneNumber(id) {
    var a = "";
    var phLbl = document.getElementById("phLbl").innerHTML;
    var HasViber = document.getElementById($("input[id^='has-viber-']")[0].getAttribute("id")).getAttribute('title');
    var HasWhatsapp = document.getElementById($("input[id^='has-whatsapp-']")[0].getAttribute("id")).getAttribute('title');
    var tooltipCountryCode = $("input[id^='user-phone-country-code']")[0].getAttribute("title");

/*
    //a = document.getElementById("three").innerHTML + "<div class=\"form-group row\">\
		<label for=\"user-stock-phone\" class=\"col-sm-3 col-form-label\" id=\"phLbl\">" + phLbl + "</label>\
		<div class=\"col col-1\"><input class=\"form-control\" type=\"text\" value=\"00\"\
		data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + tooltipCountryCode + "\"\
		id=\"user-phone-country-code-" + id + "\"></div>\
		<div class=\"col col-3\"><input class=\"form-control\" type=\"tel\" value=\"\" id=\"user-stock-phone-" + id + "\"></div>\
		<div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\" id=\"has-viber-" + id + "\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasViber + "\">\
		<img src=\"../views/icon_viber.png\" alt=\"Viber\" width=\"22\" height=\"22\">\
		</label></div><div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\"  id=\"has-whatsapp-" + id + "\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasWhatsapp + "\">\
		<img src=\"../views/icon_whatsapp.png\" alt=\"Whatsapp\" width=\"24\" height=\"24\"></label></div>&nbsp;\
		<div class=\"form-check\"><label class=\"form-check-label del-phone-number\" id=\"del-phone-number-" + id + "\">\
        <img src=\"../views/del.bmp\" alt=\"Del\" width=\"22\" height=\"22\"></label></div></div>";
		//$("#three").html(a);
*/

		a = "<div class=\"form-group row\">\
		<label for=\"user-stock-phone\" class=\"col-sm-3 col-form-label\" id=\"phLbl\">" + phLbl + "</label>\
		<div class=\"col col-1\"><input class=\"form-control\" type=\"text\" value=\"00\"\
		data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + tooltipCountryCode + "\"\
		id=\"user-phone-country-code-" + id + "\"></div>\
		<div class=\"col col-3\"><input class=\"form-control\" type=\"tel\" value=\"\" id=\"user-stock-phone-" + id + "\"></div>\
		<div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\" id=\"has-viber-" + id + "\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasViber + "\">\
		<img src=\"../views/icon_viber.png\" alt=\"Viber\" width=\"22\" height=\"22\">\
		</label></div><div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\"  id=\"has-whatsapp-" + id + "\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasWhatsapp + "\">\
		<img src=\"../views/icon_whatsapp.png\" alt=\"Whatsapp\" width=\"24\" height=\"24\"></label></div>&nbsp;\
		<div class=\"form-check\"><label   onclick=\"delPhoneN('del-phone-number-" + id + "')\"    class=\"form-check-label del-phone-number\" id=\"del-phone-number-" + id + "\">\
        <img src=\"../views/del.bmp\" alt=\"Del\" width=\"22\" height=\"22\"></label></div></div>";
		$("#three").append(a);
		$("#three").on('click', 'label', delPhoneN);
}



function gatherFields(fields) {

    var Ntels = $('div#three > div.row').length;
    // FIRST SECTION
    var stname = document.getElementById("user-stock-name").value;
    var currencyList = document.getElementById("user-stock-currency");
    var currencyId = currencyList.options[currencyList.selectedIndex].value;
    var active = $("#stock-active-chk").prop('checked');
    // SECOND SECTION
    var counrtyList = document.getElementById("user-stock-country");
    var countryId = counrtyList.options[counrtyList.selectedIndex].value;
    var stcity = document.getElementById("user-stock-city").value;
    var stadres = document.getElementById("user-stock-adress").value;
    // THIRD SECTION
    var stmail = document.getElementById("user-stock-mail").value;
    var ships = document.getElementById("user-stock-ships").value;

    fields.Ntels = Ntels;
    // FIRST SECTION
    fields.stname = stname;
    fields.currencyId = currencyId;
    fields.stactive = active;
    // SECOND SECTION
    fields.countryId = countryId;
    fields.stcity = stcity;
    fields.stadres = stadres;
    // THIRD SECTION
    fields.stmail = stmail;
    for (var i = 0; i < Ntels; i++) {
        var fId = $("input[id^='user-phone-country-code']")[i].getAttribute("id");
        // Getting Phone ID
        fields.phone[i] = fId.substr(24);
        // Getting Country Code
        fields.phone[i + Ntels] = document.getElementById(fId).value;
        // Getting Phone Number
        //fId = $("input[id^='user-stock-phone']")[i].getAttribute("id");
        fields.phone[i + Ntels * 2] = document.getElementById("user-stock-phone-" + fields.phone[i]).value;
        // Getting Viber && Wtsp
        fields.phone[i + Ntels * 3] = $("#has-viber-" + fields.phone[i]).is(":checked");
        fields.phone[i + Ntels * 4] = $("#has-whatsapp-" + fields.phone[i]).is(":checked");
    }
    fields.ships = ships;

}

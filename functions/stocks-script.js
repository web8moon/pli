$(document).ready(function(){
    
	// Checkbox is the Stock is Active
	$("#stock-active-chk").click(function() {
        if(!$("#stock-active-chk").is(":checked")) {
            $("#stock-active-lbl").addClass("btn-danger");
        } else {
            $("#stock-active-lbl").removeClass("btn-danger");
        }
	});
	
	
	$("#save-stock").click(function() {
		var fields = [];
		gatherFields(fields);
		alert( fields.Ntels );
		//$("#SconfirmForm")[0].reset();
		//$("#msgSubmit").text('');
		// if (checkForm()){
			// $("#SconfirmModal").modal("show");
		// }
	});

	
	$("#add-phone-number").click(function() {
		
		var uri1 = $("#uri1").val();
		var uri2 = $("#uri2").val();
		var stock = $("#stn").val();
		
		if (stock > 0) {
			if(uri1 == "stocks"){
				$.ajax({
					type: "POST",
					url: "/add-phone/" + uri2,
					data: "st=" + stock,
					success : function(text){

						echo = text.substring(0, 7);
						newID = text.substring(7);

						if (echo == "success" && newID > 0	){
							//confirmFormSuccess();
							putEmptyPhoneNumber(newID);
							//void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
						} else {
							//formError();
							$("#add-phone-number-error").css("display", "inline-block");
						}
					}
				});
			}
		}
	});	
	
/*  
	
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
  
*/

});
/*
function submitLoginForm(){

    var formid = $("#user-account-id").val();
	var active = $("#accountactivechk").prop('checked');
	var plan = $("#planSelect").val();

	var name = $("#user-text-input").val();
	var mail = $("#user-email-input").val();
	var passw = $("#user-password-input").val();
	
	var passwconf = $("#conf-password").val();

	var uri1 = $("#uri1").val();
	var uri2 = $("#uri2").val();
	
	
	if(uri1 == "profile"){
		$.ajax({
			type: "POST",
			url: "/save-profile/" + uri2,
			data: "formid=" + formid + "&active=" + active + "&plan=" + plan + "&name=" + name + "&mail=" + mail + "&passw=" + passw + "&uri1=" + uri1 + "&passwconf=" + passwconf,
			success : function(text){
				if (text == "success"){
					confirmFormSuccess();
					void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
				} else {
					formError();
					submitMSG(false,text);
				}
			}
		});
	}
}

function formError(){
	
	$("#PconfirmForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function submitMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}

function confirmFormSuccess(){
    $("#conf-password").removeClass().addClass("form-control is-valid");
	$("#PconfirmForm")[0].reset();
    submitMSG(true, "Ok!");
}
*/
function checkForm(){
	var checkStatus = true;
	
	if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($("#user-email-input").val()) ){
		checkStatus = false;
		$("#user-email-input").removeClass().addClass("form-control is-invalid");
		void(setTimeout('$("#user-stock-mail").removeClass().addClass("form-control")', 1500));
	}
/*
	if($("#user-password-input").val().length<2 || $("#user-password-input").val().length>50){
		checkStatus = false;
		$("#user-password-input").removeClass().addClass("form-control is-invalid");
		void(setTimeout('$("#user-password-input").removeClass().addClass("form-control")', 1500));
	}
*/	
	return checkStatus;
}


function putEmptyPhoneNumber(id) {
	var a = "";
	var phLbl = document.getElementById("phLbl").innerHTML;
	var HasViber = document.getElementById("has-viber-").getAttribute("title");
	var HasWhatsapp = document.getElementById("has-whatsapp-").getAttribute("title");
	var tooltipCountryCode = $("input[id^='user-phone-country-code']")[0].getAttribute("title");

	
	a = document.getElementById("three").innerHTML + "<div class=\"form-group row\">\
		<label for=\"user-stock-phone\" class=\"col-sm-3 col-form-label\" id=\"phLbl\">" + phLbl + "</label>\
		<div class=\"col col-1\"><input class=\"form-control\" type=\"text\" value=\"00\"\
		data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + tooltipCountryCode + "\"\
		id=\"user-phone-country-code-" + id + "\"></div>\
		<div class=\"col col-3\"><input class=\"form-control\" type=\"tel\" value=\"\" id=\"user-stock-phone-" + id + "\"></div>\
		<div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\" id=\"has-viber-\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasViber + "\">\
		<img src=\"../views/icon_viber.png\" alt=\"Viber\" width=\"22\" height=\"22\">\
		</label></div><div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\"  id=\"has-whatsapp-\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasWhatsapp + "\">\
		<img src=\"../views/icon_whatsapp.png\" alt=\"Whatsapp\" width=\"24\" height=\"24\"></label></div></div>";
		
	$("#three").html(a);
}

function gatherFields(fields) {
	
	var Ntels = $('div#three > div.row').length;
	// FIRST SECTION
	var stname = $("user-stock-name").val();
	var currencyList = document.getElementById("user-stock-currency");
	var currencyId = currencyList.options[currencyList.selectedIndex].value;
	var active = $("#stock-active-chk").prop('checked');
	// SECOND SECTION
	var counrtyList = document.getElementById("user-stock-country");
	var countryId = counrtyList.options[counrtyList.selectedIndex].value;
	var stcity = $("user-stock-city").val();
	var stadres = $("user-stock-adress").val();
	// THIRD SECTION
	var stmail = $("user-stock-mail").val();
	var phCCodeid = $("input[id^='user-phone-country-code']")[0].getAttribute("id");
	
	var ships = $("user-stock-ships").val();
	
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
	
}

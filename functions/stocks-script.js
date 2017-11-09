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
		$("#SconfirmForm")[0].reset();
		$("#msgSubmit").text('');
		// if (checkForm()){
			$("#SconfirmModal").modal("show");
		// }
	});

	
	$("#add-phone-number").click(function() {
		
		/*
		//Show Error badge
		$("#add-phone-number-error").css("display", "inline-block");
		*/
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

function putPhoneNumbers() {

	$("#three").html("<div class=\"form-group row\">");
	$("#three").html("<label for=\"user-stock-phone\" class=\"col-sm-3 col-form-label\">" + label + "</label>");
	$("#three").html("<div class=\"col col-1\"><input class=\"form-control\" type=\"text\" value=\"\"></div>");
	$("#three").html("</div");

}

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


function putPhoneNumber(label, tooltipCountryCode, HasViber, HasWhatsapp, phonesArr) {
	var a = "";

	// alert (phonesArr.CountryCode);
	
	a = "<div class=\"form-group row\">\
		<label for=\"user-stock-phone\" class=\"col-sm-3 col-form-label\">" + label + "</label>\
		<div class=\"col col-1\"><input class=\"form-control\" type=\"text\" value=\"" + phonesArr.CountryCode + "\"\
		data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + tooltipCountryCode + "\"\
		id=\"user-phone-country-code-" + phonesArr.ID + "\"></div>\
		<div class=\"col col-3\"><input class=\"form-control\" type=\"tel\" value=\"" + phonesArr.Phone + "\"></div>\
		<div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasViber + "\">\
		<img src=\"../views/icon_viber.png\" alt=\"Viber\" width=\"22\" height=\"22\">\
		</label></div><div class=\"form-check\"><label class=\"form-check-label\"><input type=\"checkbox\" class=\"form-check-input\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + HasWhatsapp + "\">\
		<img src=\"../views/icon_whatsapp.png\" alt=\"Whatsapp\" width=\"24\" height=\"24\"></label></div></div>";
		
		return a;

}

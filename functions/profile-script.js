$(document).ready(function(){
    $("#accountactivechk").click(function() {
        if(!$("#accountactivechk").is(':checked')) {
            //$("#accountactivelbl").css('backgroundColor', 'red');
            $("#accountactivelbl").addClass('btn-danger');
        } else {
            $("#accountactivelbl").removeClass('btn-danger');
        }
	});
	
	
	$("#save-profile").click(function() {
		$("#PconfirmForm")[0].reset();
		$("#msgSubmit").text('');
		$("#PconfirmModal").modal('show');
	});
  
	
	$("#PconfirmForm").validator().on("submit", function (event) {
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
    $("#PconfirmForm")[0].reset();
    submitMSG(true, "Ok!")
}
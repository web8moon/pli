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
    // Initiate Variables With Form Content
    var passw = $("#password").val();
	var uri1 = $("#uri1").val();
	var uri2 = $("#uri2").val();
    $.ajax({
        type: "POST",
        url: "/save-profile/" + uri2,
        data: "name=" + name + "&passw=" + passw,
        success : function(text){
            if (text == "success"){
                loginFormSuccess();
				void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
            } else {
                formError();
                submitMSG(false,text);
            }
        }
    });
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
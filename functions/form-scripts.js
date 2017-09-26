$(document).ready(function(){
  $("#loginbtn").click(function() {
	//открыть модальное окно с id="myModal"
	$("#loginModal").modal('show');
  });

  $("#registerme").click(function () {
      $("#loginForm")[0].reset();
      $("#loginModal").modal('hide');
      $("#registerModal").modal('show');
  });

    $("#loginme").click(function () {
        $("#registerForm")[0].reset();
        $("#registerModal").modal('hide');
        $("#loginModal").modal('show');
    });
});

$("#loginForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        //formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitLoginForm();
    }
});


$("#registerForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        //formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitRegForm();
    }
});

function submitLoginForm(){
    // Initiate Variables With Form Content
    var name = $("#name").val();
    var passw = $("#password").val();
	var uri1 = $("#uri1").val();
	var uri2 = $("#uri2").val();
	
    //var message = $("#message").val();
    $.ajax({
        type: "POST",
        url: "/functions/login-process.php",
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

function submitRegForm(){
    // Initiate Variables With Form Content
    var name = $("#regname").val();
    var passw = $("#regpassword").val();
    var uri1 = $("#uri1").val();
    var uri2 = $("#uri2").val();

    //var message = $("#message").val();
    $.ajax({
        type: "POST",
        url: "/register/" + uri2,
        data: "name=" + name + "&passw=" + passw,
        success : function(text){
            if (text == "success"){
                regFormSuccess();
                void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
            } else {
                formError();
                submitMSG(false,text);
            }
        }
    });
}

function loginFormSuccess(){
    $("#loginForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function regFormSuccess(){
    $("#registerForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function formError(){
    //$("#loginForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
    //    $(this).removeClass();
    //});
}

function submitMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    $("#regSubmit").removeClass().addClass(msgClasses).text(msg);
}
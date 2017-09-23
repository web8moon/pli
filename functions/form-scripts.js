$(document).ready(function(){
  $("#loginbtn").click(function() {
	//открыть модальное окно с id="myModal"
	$("#loginModal").modal('show');
  });

  $("#registerme").click(function () {
      alert("Reg");
  });
});

$("#contactForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        //formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitForm();
    }
});


function submitForm(){
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
                formSuccess();
				void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
            } else {
                formError();
                submitMSG(false,text);
            }
        }
    });
}

function formSuccess(){
    $("#contactForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function formError(){
    //$("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
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
}
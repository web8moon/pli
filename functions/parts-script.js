$(document).ready( function () {

	$("#eraseparts").click( function () {
       var stockPartsConfirmErase = document.getElementById("stockPartsConfirmErase").value;
		var btnhtml = document.getElementById("eraseparts").innerHTML;

		if ( btnhtml.indexOf("<span ") != -1 ) {
			var btnspan = btnhtml.substring( btnhtml.indexOf("<span ") ).trim();
			var pn = btnspan.substring( btnspan.indexOf(">",2)+1, btnspan.indexOf("</") ).trim();
			if ( confirm(stockPartsConfirmErase + pn) ) {

				$("#PconfirmForm")[0].reset();
				$("#msgSubmit").text('');
				$("#PconfirmModal").modal("show");
				
		}
	}
	});
	
	$(".form-check-input").click( function (event) {
		var descr = this.getAttribute("descr");
		var id = this.getAttribute("id");
		var nr = this.getAttribute("nr");
		var status = id.is(":checked");
		event.preventDefault();
		checkaction(descr, id, nr, status);
		
	});
	
	$("#update-stock-date").click( function () {
		var uri1 = document.getElementById("uri1").value;
		var uri2 = document.getElementById("uri2").value;
		var stock = document.getElementById("stn").value;

		$("#updateDat")
			.stop()
			.css( "opacity", 1 )
			//.text( lbl + " " + text.substring(9) )
			.fadeIn( 30 )
			.fadeOut( 1000 );
		
		$.ajax({
		type: "POST",
		url: "/update-stock-date/" + uri2,
		data: "stn=" + stock + "&uri1=" + uri1,
		success: function (text) {
			text = JSON.parse(text);
			if (text[0] == "successzz") {
				document.getElementById("updateDat").innerHTML = text[2] + text[1];
				$("#updateDat")
					.stop()
					.css( "opacity", 1 )
					//.text( lbl + " " + text.substring(9) )
					.fadeOut( 1000 )
					.fadeIn( 30 );
					
			} else {
				lbl = document.getElementById("updateDat").innerHTML;
				document.getElementById("updateDat").innerHTML = text[0];
				$("#updateDat")
					.stop()
					.css( "opacity", 1 )
					//.text( lbl + " " + text.substring(9) )
					.fadeOut( 1000 )
					.fadeIn( 30 );
           }
			
		}
		});
	
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
            submitConfirmForm();
        }
    });

});


function checkaction(descr, id, nr, status) {
		var uri1 = document.getElementById("uri1").value;
		var uri2 = document.getElementById("uri2").value;
		var stock = document.getElementById("stn").value;
		
		$.ajax({
		type: "POST",
		url: "/check-action-parts/",
			data: "descr=" + descr + "&id=" + id + "&nr=" + nr + "&uri1=" + uri1 + "&stn=" + stock + "&status=" + status,
			success: function (text) {
				
				alert(text);
				
				if (text == "successzz") {

				} else {

				}
			
		}
	});
}

// ERASE Functions

function submitConfirmForm() {
	
	var clause = document.getElementById("qsearchclause").value;
    var uri1 = document.getElementById("uri1").value;
    var uri2 = document.getElementById("uri2").value;
	var stock = document.getElementById("stn").value;

	var btnhtml = document.getElementById("eraseparts").innerHTML;
	var btnlbl = btnhtml.substring(0, btnhtml.indexOf("<span ")).trim();
	var btnspan = btnhtml.substring( btnhtml.indexOf("<span ") ).trim();
	var pn = btnspan.substring( btnspan.indexOf(">",2)+1, btnspan.indexOf("</") ).trim();
	var btnwidth = document.getElementById("eraseparts").clientWidth;
	pwd = document.getElementById("conf-password").value;

	// Show Preloader
	//document.getElementById("eraseparts").textContent = " ";
	//document.getElementById("eraseparts").style = "background: transparent url('/views/preloader.gif') no-repeat center top;";
	//document.getElementById("eraseparts").style.width = btnwidth + "px";



	$.ajax({
		type: "POST",
		url: "/erase-parts/",
			data: "stn=" + stock + "&pn=" + pn + "&clause=" + clause + "&pwd=" + pwd + "&uri1=" + uri1,
		success: function (text) {
			if (text == "successzz") {
					confirmFormSuccess();
					void(setTimeout('window.location.replace ("/' + uri1 + '/' + uri2 + '");', 1000));
			} else {
                formError();
                submitMSG(false,text);

            }
			
		}
	});


    /*
    // Return previous state
    document.getElementById("eraseparts").textContent = btnlbl;
    document.getElementById("eraseparts").style.background = "";
    eraseparts.appendChild(document.createElement('span'));
    document.getElementById("eraseparts").style.width = btnwidth + "px";
    */
	

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

function confirmFormSuccess() {
    $("#conf-password").removeClass().addClass("form-control is-valid");
    $("#PconfirmForm")[0].reset();
    submitMSG(true, "Ok!");
}

// /ERASE Functions

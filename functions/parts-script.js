$(document).ready( function () {

	$("#eraseparts").click( function () {

		var btnhtml = document.getElementById("eraseparts").innerHTML;
		// Change the innerHTML if Button
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


function submitLoginForm() {
	
	var clause = document.getElementById("qsearchclause").value;
    var uri1 = document.getElementById("uri1").value;
    var uri2 = document.getElementById("uri2").value;
	var stock = document.getElementById("stn").value;
	var stockPartsConfirmErase = document.getElementById("stockPartsConfirmErase").value;
	var btnhtml = document.getElementById("eraseparts").innerHTML;
	var btnlbl = btnhtml.substring(0, btnhtml.indexOf("<span ")).trim();
	var btnspan = btnhtml.substring( btnhtml.indexOf("<span ") ).trim();
	var pn = btnspan.substring( btnspan.indexOf(">",2)+1, btnspan.indexOf("</") ).trim();
	var btnwidth = document.getElementById("eraseparts").clientWidth;
	pwd = document.getElementById("conf-password").value;

	// Show Preloader
	document.getElementById("eraseparts").textContent = " ";
	document.getElementById("eraseparts").style = "background: transparent url('/views/preloader.gif') no-repeat center top;";
	document.getElementById("eraseparts").style.width = btnwidth + "px";



	$.ajax({
		type: "POST",
		url: "/erase-parts/",
			data: "stn=" + stock + "&pn=" + pn + "&clause=" + clause, + "&pwd=" + pwd
		success: function (text) {
			if (text == "successzz") {
					void( setTimeout(location.reload(), 500) );
			} else {
				alert(text);
					void( setTimeout(location.reload(), 500) );
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

$(document).ready( function () {

	$("#eraseparts").click( function () {
		var clause = document.getElementById("qsearchclause").value;
       var uri1 = document.getElementById("uri1").value;
       var uri2 = document.getElementById("uri2").value;
	   var stock = document.getElementById("stn").value;

		
		var btnhtml = document.getElementById("eraseparts").innerHTML;
		// Change the innerHTML if Button
		if ( btnhtml.indexOf("<span ") != -1 ) {
			var btnlbl = btnhtml.substring(0, btnhtml.indexOf("<span ")).trim();
			var btnspan = btnhtml.substring( btnhtml.indexOf("<span ") ).trim();
			var btnwidth = document.getElementById("eraseparts").clientWidth;
			var pn = btnspan.substring( btnspan.indexOf(">",2)+1, btnspan.indexOf("</") ).trim();
			
			// Show Preloader
			document.getElementById("eraseparts").textContent = " ";
			document.getElementById("eraseparts").style = "background: transparent url('/views/preloader.gif') no-repeat center top;";
			document.getElementById("eraseparts").style.width = btnwidth + "px";
		



           $.ajax({
               type: "POST",
               url: "/erase-parts/",
				data: "stn=" + stock + "&pn=" + pn + "&clause=" + clause,
               success: function (text) {
                   if (text == "successzz") {
                       void( setTimeout(location.reload(), 500) );
                   } else {
                       alert(text);
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
		
		
	});

});

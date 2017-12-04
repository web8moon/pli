$(document).ready( function () {

	$("#eraseparts").click( function () {
		var clause = document.getElementById("qsearchclause").value;
		$().button('toggle');
		alert(clause);
		$().button('toggle');
	});

});

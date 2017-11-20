$(document).ready(function () {

    $("#go").click(function () {
        var n = $("#search").val();
        var uri2 = $("#uri2").val();

        document.getElementById("progress").style.display = "";
        document.getElementById("progress").style.width = "10%";
        document.getElementById("progress").setAttribute("aria-valuenow", "10");

        if (n != '') {
            if (n.length <= 3) {
                document.getElementById("errorMsg").style.display = '';
                setTimeout('document.getElementById("errorMsg").style.display = \'none\';', 1500);
            } else {

                document.getElementById("progress").style.width = "50%";
                document.getElementById("progress").setAttribute("aria-valuenow", "50");

                void (window.location.replace('/' + n + '/' + uri2));
            }
        }
        document.getElementById("progress").style.width = "100%";
        document.getElementById("progress").setAttribute("aria-valuenow", "100");
        document.getElementById("progress").style.display = "none";
    });


});

$(document).ready(function () {

    $("#go").click(function () {
        var n = $("#search").val();
        var uri2 = $("#uri2").val();

        if (n != '') {
            if (n.length <= 3) {
                document.getElementById("errorMsg").style.display = '';
                setTimeout('document.getElementById("errorMsg").style.display = \'none\';', 1500);
            } else {
                void (window.location.replace('/' + n + '/' + uri2));
            }
        }
    });


});

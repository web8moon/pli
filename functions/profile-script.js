$(document).ready(function(){
    $("#accountactivechk").click(function() {
        if(!$("#accountactivechk").is(':checked')) {
            //$("#accountactivelbl").css('backgroundColor', 'red');
            $("#accountactivelbl").addClass('btn-danger');
        } else {
            $("#accountactivelbl").removeClass('btn-danger');
        }
});
});
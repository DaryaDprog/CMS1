$(document).ready(function () {


    // function slideout(){
    //     setTimeout(function () {
    //         $("#response").slideUp("slow", function(){
    //
    //         });
    //     },2000);
    // }
    // $("#response").hide();
    $(function () {
        $("#table tbody").sortable({
            opacity: 0.8, cursor: 'move', update: function (event, ui) {

                $(this).children().each(function (index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass('updated');
                    }
                });

                saveNewPositions();
                // var order = $(this).sortable("serialize") + '&update=update';
                // $.post("updateList.php", order, function(theResponse) {
                //     $("#response").html(theResponse);
                //     $("#response").slideDown('slow');
                //     slideout();
                // });
            }
        });
    });
});

function saveNewPositions() {
    var positions = [];
    $('.updated').each(function () {
        positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
        $(this).removeClass('updated');
    });
    $.ajax({
        url: 'admin.php',
        method: 'POST',
        dataType: 'text',
        data: {
            update: 1,
            positions: positions
        }, success: function (response) {
            console.log(response);
        }
    });

}


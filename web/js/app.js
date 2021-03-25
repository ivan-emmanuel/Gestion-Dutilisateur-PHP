$(document).ready(function() {

    $(".dataTable").DataTable({
        "language":{
            url: window.location.host+"/vendor/datatables/french.json",
        }
    });

    $('a').each(function(key,val){
        var tag = $(val);
        if ( $(val).data('animated-modal') !== undefined ) {
            tag.animatedModal({
                color:'#fff',
                animatedIn:'bounceInUp',
                animatedOut:'bounceOutDown',
            });
        }
    });

    $('select').each(function () {
        $(this).select2({
            theme: 'bootstrap4',
            width: 'style',
            placeholder: $(this).attr('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    });

});
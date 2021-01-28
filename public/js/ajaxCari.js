jQuery(document).ready(function(){
    $("#submit").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            nomor: jQuery('#nomorCari').val()
        };
        var state = jQuery('#submit').val();
        var type = "POST";
        var ajaxurl = '/cari';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});
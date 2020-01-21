var getUrl = window.location;
var BASE_URL = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];


function delete_product(emri){
    if(!confirm("A jeni i sigurt te fshini kete "+emri+" ?")){
        event.preventDefault();
    }
}


$('.edit_product').click(function () {
    var id =  $(this).attr('data-id');

        $('#edit_emertimi').attr('disabled', true);
        $('#edit_sasia').attr('disabled', true);
        $('#edit_cmim_blerje').attr('disabled', true);
        $('#edit_cmim_shitje').attr('disabled', true);

    $.get(BASE_URL+'/product/'+id)
        .done(function( data ) {
            var cat = data[0]["cat_id"];
            $('#edit_emertimi').attr('disabled', false);
            $('#edit_sasia').attr('disabled', false);
            $('#edit_cmim_blerje').attr('disabled', false);
            $('#edit_cmim_shitje').attr('disabled', false);
            $('#edit_emertimi').val(data[0]['emri']);
            $('#edit_sasia').val(data[0]['sasia']);
            $('#edit_cmim_blerje').val(data[0]['cmim_blerje']);
            $('#edit_cmim_shitje').val(data[0]['cmim_shitje']);
            $('#product_id').val(data[0]['id']);
            $('#edit_kategoria option[value='+cat+']').attr('selected','selected');
        });
});


$('.edit_category').click(function () {
    var id =  $(this).attr('data-id');
    $('#category_name').attr('disabled', true);
    $.get(BASE_URL+'/categories/'+id)
        .done(function( data ) {
            $('#category_name').attr('disabled', false);
            var emri = data[0]['emertimi'];
            var id = data[0]['id'];
            $('#category_name').val(emri);
            $('#categoty_id').val(id);
        });
});

$('.edit_agent').click(function () {
    var id =  $(this).attr('data-id');
    $('#edit_emri').attr('disabled', true);
    $('#edit_mbiemri').attr('disabled', true);
    $.get(BASE_URL+'/agent/'+id)
        .done(function( data ) {
            $('#edit_emri').attr('disabled', false);
            $('#edit_mbiemri').attr('disabled', false);
            var emri = data[0]['emri'];
            var mbiemri = data[0]['mbiemri'];
            var id = data[0]['id'];
            $('#edit_emri').val(emri);
            $('#edit_mbiemri').val(mbiemri);
            $('#adent_id').val(id);
        });
});

function notifySuccess(data) {
    toastr.success(data);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function notifyError(data) {
    toastr.error(data);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

$('#changeMonth').click(function() {
    var month = $( "#monthPicker option:selected" ).val();
    var redirectURL = BASE_URL + '/arka/' +month;
    window.location.href = redirectURL;
});

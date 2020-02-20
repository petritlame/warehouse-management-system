var getUrl = window.location;
var BASE_URL = getUrl .protocol + "//" + getUrl.host + "/";


function delete_product(emri){
    if(!confirm("A jeni i sigurt te fshini kete "+emri+" ?")){
        event.preventDefault();
    }
}

function update_product(){
    if(!confirm("A jeni i sigurt te shlyeni kete borxh ?")){
        event.preventDefault();
    }
}


$('.edit_product').click(function () {
    var id =  $(this).attr('data-id');

        $('#edit_emertimi').attr('disabled', true);
        $('#edit_sasia').attr('disabled', true);
        $('#edit_cmim_blerje').attr('disabled', true);
        $('#edit_cmim_shitje').attr('disabled', true);

    $.get(BASE_URL+'/show_product/'+id)
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

$('#category_select').change(function () {
   var category_id = $(this).val();
    var dropdown = $("#product_select");
    dropdown.empty()
        .append('<option disabled selected>Zgjidh Produktin</option>');
    dropdown.attr('disabled', true);
    $.get(BASE_URL+'/products/makina/category/'+category_id)
            .done(function( data ) {
                dropdown.attr('disabled', false);
                $.each(data, function(i, item) {
                    dropdown.append($("<option />").val(item.id).text(item.emertimi));
                });
        });
});

$('#dyqani_category_select').change(function () {
    var category_id = $(this).val();
    var dropdown = $("#product_select_dyqani");
    dropdown.empty()
        .append('<option disabled selected>Zgjidh Produktin</option>');
    dropdown.attr('disabled', true);
    $.get(BASE_URL+'/products/makina/category/'+category_id)
        .done(function( data ) {
            dropdown.attr('disabled', false);
            $.each(data, function(i, item) {
                dropdown.append($("<option />").val(item.id).text(item.emertimi));
            });
        });
});



$(document).on('click', '.shto_ne_makine', function() {
    var dataId = $(this).attr('data-id');
    var array = dataId.split(",");
    var itemId = array[0];
    var productId = array[1];
    $('#shto_product_id').val(productId);
    $('#shto_item_id').val(itemId);

});

$(document).on('click', '.hiq_nga_makine', function() {
    var dataId = $(this).attr('data-id');
    var array = dataId.split(",");
    var itemId = array[0];
    var productId = array[1];
    $('#hiq_product_id').val(productId);
    $('#hiq_item_id').val(itemId);
});

$('#makina').change(function () {
        getItems();
});

$('#invoiceDate').change(function () {
        getItems();
});

function getItems() {
    var makinaId = $('#makina').val();
    var data = $('#invoiceDate').val();
    if (makinaId !== null && JSON.stringify(data) !== 'null') {
        $('#generateInvoice').removeClass('disabled');
    }
    var html = '';
    $('#carProductsBody').html('<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">Prisni...</td></tr>');
    $.get(BASE_URL+'/products/makina/'+makinaId+'?data='+data)
        .done(function( data ) {
            if(data.length > 0) {
                $.each(data, function (i, item) {
                    var color = (item.status !== 0) ? '#00ca0052' : '#ff00006b';
                    html = html + '<tr role="row" class="odd">' +
                        '<td class="sorting_1">' + item.id + '</td>' +
                        '<td>' + item.data + '</td>' +
                        '<td>' + item.emertimi + '</td>' +
                        '<td>' + item.targa + '</td>' +
                        '<td>' + item.emri + ' ' + item.mbiemri + '</td>' +
                        '<td>' + item.sasia + '</td>' +
                        '<td>' +
                        '<p style="text-align: center">' +
                        '<a href="#" class="btn btn-cyan btn-sm shto_ne_makine" data-id="'+item.id+', '+item.product_id+'" data-toggle="modal" data-target="#carProductAdd">+</a>' +
                        '<a href="#" class="btn btn-cyan btn-sm hiq_nga_makine" data-id="'+item.id+', '+item.product_id+'" data-toggle="modal" data-target="#carProductRemove">-</a>' +
                        '<a href="#" class="btn btn-success btn-sm dalje" id="dalje_invoice" data-id="'+item.id+'" data-toggle="modal" data-target="#carPassToInvoice">Dalje</a>'+
                        '<a href="'+BASE_URL+'/product/makina/delete/'+item.id+'" class="btn btn-danger btn-sm" onclick="return delete_product(`produkt`);">Hiqe</a>' +
                        '</p>' +
                        '</td>';
                });
                $('#carProductsBody').html(html)
            }else{
                $('#carProductsBody').empty();
                $('#carProductsBody').html('<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No data available in table</td></tr>');
            }
        });
}

$('#generateInvoice').click(function () {
    var makinaId = $('#makina').val();
    var data = $('#invoiceDate').val();
    var url = BASE_URL+'/product/makina/invoice?data='+data+'&carId='+makinaId;
    window.location.href=url;
});

$('.dalje_invoices').click(function () {
    var id = $(this).attr('data-id');
    console.log(id);
    $('#product_invoice').val('');
    $('#product_invoice').val(id);
});


$('#submit_date_search').click(function () {
    var start = $('#agent_start_date').val();
    var end = $('#agent_end_date').val();
    var agent_id = $('#agent_id').val();
    var today = new Date();
    var start_date = new Date(start);
    var end_date = new Date(end);
    if (start_date > end_date){
        alert('Data e Fillimit me e madhe se data e mbarimit')
    }else{
        var html = '';
        $('#agent_sales').html('<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">Prisni...</td></tr>');
        $.get(BASE_URL+'agents/search?strDt='+start+'&endDt='+end+'&agent_id='+agent_id)
            .done(function( data ) {
                $.each(data.items, function (i, item) {
                    html = html + '<tr>'+
                    '<td>'+item.id+'</td>'+
                    '<td>'+item.data+'</td>'+
                    '<td><a href="'+BASE_URL+'/invoices/salesInvoices/'+item.invoice+'" target="_blank">'+item.invoice+'</a></td>'+
                    '<td><b>'+item.total+'</b></td>'+
                    '</tr>';
                });
                $('#agent_sales').html(html);
                $('#totalShitje').html('');
                $('#totalShitje').html(data.total);
            });
    }
});

$('.clientProduct').click(function () {
    var id = $(this).attr('data-id');
    var html = '';
    $.get(BASE_URL+'/client/products/'+id)
        .done(function( data ) {
            $.each(data, function (i, item) {
                html = html + '<tr>'+
                               '<td>'+item.replace(/\s/g, '')+'</td>'+
                            '</tr>';
            });
            $('#clientProductsBody').html(html);
            $('#clientProducts').modal('show');
        });
});

$('.edit_client').click(function () {
    var id = $(this).attr('data-id');
    $('#edit_client_name').attr('disabled', true);
    $('#edit_client_adresa').attr('disabled', true);
    $('#edit_client_phone').attr('disabled', true);
    $('#edit_client_pershkrimi').attr('disabled', true);
    $('#edit_client_products').attr('disabled', true);

    $.get(BASE_URL+'/client/'+id)
        .done(function( data ) {

            $('#edit_client_name').attr('disabled', false);
            $('#edit_client_adresa').attr('disabled', false);
            $('#edit_client_phone').attr('disabled', false);
            $('#edit_client_pershkrimi').attr('disabled', false);
            $('#edit_client_products').attr('disabled', false);

            $('#edit_client_name').val(data.emri);
            $('#edit_client_adresa').val(data.adressa);
            $('#edit_client_phone').val(data.phone);
            $('#edit_client_pershkrimi').html(data.pershkrimi);
            $('#edit_client_products').html(data.produktet);

            $('#client_id').val(data.id)
        })

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

function delete_product(){
    if(!confirm("A jeni i sigurt te fshini kete produkt?")){
        event.preventDefault();
    }
}

$('.edit_product').click(function () {
    var id =  $(this).attr('data-id');

        $('#edit_emertimi').attr('disabled', true);
        $('#edit_sasia').attr('disabled', true);
        $('#edit_cmim_blerje').attr('disabled', true);
        $('#edit_cmim_shitje').attr('disabled', true);

    $.get('/product/'+id)
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

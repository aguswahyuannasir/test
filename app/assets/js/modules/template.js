$(document).ready(function () {
    $('select[name=module]').change(function (e) {
        location.href = site_url + 'settings/templates?module=' + $(this).val()
    });
    var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
    elems.forEach(function (html) {
        new Switchery(html);
    });


//    $('.insert-code').on('click', function (e) {
//        var text = $(this).data('text');
//        var mod = $(this).data('id');
//        var mod_input = $('input[name=' + mod + ']');
//        mod_input.val(mod_input.val() + text);
//    });
//    $('.choose-file-signature').click(function (e) {
//        var id = $(this).data('id');
//        $('#signature-image-' + id + '-file').click();
//    });
//    initialize_signature_image(0);
});
function initialize_signature_image(id) {
    $.uploadPreview({
        input_field: "#signature-image-" + id + "-file",
        preview_box: "#signature-image-" + id,
        success_callback: function () {
            $('#signature-image-' + id + ' .text-img-signature').addClass('d-none');
            $('#signature-image-' + id + ' .icon-x').removeClass('d-none');
            $('#signature-image-' + id + '-delete').val(0);
        }
    });
}
function signature_image_delete(id) {
    $('#signature-image-' + id + "-file").val('');
    $('#signature-image-' + id).css('background-image', '');
    $('#signature-image-' + id + ' .text-img-signature').removeClass('d-none');
    $('#signature-image-' + id + ' .icon-x').addClass('d-none');
    $('#signature-image-' + id + '-delete').val(1);
}
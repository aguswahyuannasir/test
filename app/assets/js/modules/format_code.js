$(document).ready(function () {
    $('.insert-code').on('click', function (e) {
        var text = $(this).data('text');
        var mod = $(this).data('id');
        var mod_input = $('input[name=' + mod + ']');
        mod_input.val(mod_input.val() + text);
    })
})
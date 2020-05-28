url.get_terms = site_url + 'ajax/get_terms';
$(document).ready(function () {
    initialize_select2_ajax($('#term'), url.get_terms);

    $('#term').change(function () {
        if ($(this).val()) {
            $.ajax({
                type: 'post',
                url: site_url + 'ajax/get_due_date',
                data: {
                    id: $(this).val(),
                    date: $('#date').val()
                },
                success: function (res) {
                    if (res) {
                        $('#due-date').val(res);
                    }
                }
            });
        }
    });
    $('#date').change(function () {
        $('#term').trigger('change');
    });
    $('#due-date').change(function () {
        $('#term').val(null).trigger('change');
    });
});
url.get_terms  = site_url + 'ajax/get_terms';
url.get_quotes = site_url + 'ajax/get_quotes';
$(document).ready(function () {
    initialize_select2_ajax($('#term'), url.get_terms);
    initialize_select2_ajax($('#quotes'), url.get_quotes);
    if (typeof productKey !== 'undefined') {
        $.each(productKey, function(index, val) {
            if (index > 1) {
                initialize_change_price(index);
            }
        });
    }

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

    var config_validate_add_contact = config_validate;
    config_validate_add_contact.submitHandler = function (form) {
        $(form).ajaxSubmit({
            success: function (data) {
                response_form(data);
                data = JSON.parse(data);
                $('#vendor').html(data.data);
                $('#vendor').trigger('change');
                $('#form-add-contact')[0].reset();
                $('#modal-add-contact').modal('hide');
            }
        });
        return false;
    }
    $('#form-add-contact').validate(config_validate_add_contact);
});
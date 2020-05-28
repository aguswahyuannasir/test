/*var url = {
    get_customers: site_url + 'ajax/get_customers',
    get_currencies: site_url + 'ajax/get_currencies',
    get_products: site_url + 'ajax/get_products',
    get_taxes: site_url + 'ajax/get_taxes',
    get_charges_fees: site_url + 'ajax/get_charges_fees',
}
$(document).ready(function () {
    initialize_select2_ajax($('#customer'), url.get_customers);
    initialize_select2_ajax($('#currency'), url.get_currencies);
    initialize_select2_ajax($('.product'), url.get_products);
    initialize_select2_ajax($('.taxes'), url.get_taxes);
    initialize_select2_ajax($('.charges-fees'), url.get_charges_fees);

    initialize_change_contact('customer');
    initialize_change_product(0);
    initialize_change_product(1);
    initialize_change_qty(0);
    initialize_change_qty(1);
    initialize_change_price(0);
    initialize_change_price(1);
    initialize_change_charges_fee(0);
    initialize_change_charges_fee(1);
    initialize_change_tax(0);
    initialize_change_tax(1);

    if (edit) {
        calc_total();
    }

    var config_validate_add_contact = config_validate;
    config_validate_add_contact.submitHandler = function (form) {
        $(form).ajaxSubmit({
            success: function (data) {
                response_form(data);
                data = JSON.parse(data);
                $('#customer').html(data.data);
                $('#customer').trigger('change');
                $('#form-add-contact')[0].reset();
                $('#modal-add-contact').modal('hide');
            }
        });
        return false;
    }
    $('#form-add-contact').validate(config_validate_add_contact);
});*/

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
                        $('#due_date').val(res);
                    }
                }
            });
        }
    });

    $('#date').change(function () {
        $('#term').trigger('change');
    });
    $('#due_date').change(function () {
        $('#term').val(null).trigger('change');
    });

    var config_validate_add_contact = config_validate;
    config_validate_add_contact.submitHandler = function (form) {
        $(form).ajaxSubmit({
            success: function (data) {
                response_form(data);
                data = JSON.parse(data);
                $('#customer').html(data.data);
                $('#customer').trigger('change');
                $('#form-add-contact')[0].reset();
                $('#modal-add-contact').modal('hide');
            }
        });
        return false;
    }
    $('#form-add-contact').validate(config_validate_add_contact);
});
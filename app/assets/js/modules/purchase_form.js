var url = {
    get_vendors: site_url + 'ajax/get_vendors',
    get_currencies: site_url + 'ajax/get_currencies',
    get_products: site_url + 'ajax/get_products',
    get_taxes: site_url + 'ajax/get_taxes',
    get_charges_fees: site_url + 'ajax/get_charges_fees',
    get_unit: site_url + 'ajax/get_product_units',
}
var transaction_type = 'sale';
$(document).ready(function () {
    initialize_select2_ajax($('#vendor'), url.get_vendors);
    initialize_select2_ajax($('#currency'), url.get_currencies);
    initialize_select2_ajax($('.product'), url.get_products);
    initialize_select2_ajax($('.taxes'), url.get_taxes);
    initialize_select2_ajax($('.charges-fees'), url.get_charges_fees);
    initialize_select2_ajax($('.unit'), url.get_unit);

    initialize_change_contact('vendor');
    initialize_change_currency();
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
    initialize_isNumber();

    if (edit) {
        calc_total();
    }

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
var url = {
    get_terms: site_url + 'ajax/get_terms',
    get_customers: site_url + 'ajax/get_customers',
    get_currencies: site_url + 'ajax/get_currencies',
    get_products: site_url + 'ajax/get_products',
    get_taxes: site_url + 'ajax/get_taxes',
    get_quotes: site_url + 'ajax/get_quotes',
}
var config_select2 = {
    ajax: {
        url: '',
        type: 'post',
        data: function (params) {
            var query = {
                q: params.term,
                page: params.page || 1
            }
            return query;
        },
        processResults: function (data) {
            data = JSON.parse(data);
            return {results: data.results};
        }
    },
};
var table_trx = $('#table-transaction');
function initialize_select2_ajax(el, url) {
    var config = config_select2;
    config.ajax.url = url;
    el.select2(config);
}
function initialize_change_tax() {
    $('.tax').change(function (e) {
        var tr = $(this).closest('tr');
        if ($(this).val()) {
            $.ajax({
                type: 'post',
                url: site_url + 'ajax/get_tax',
                data: {id: $(this).val()},
                success: function (res) {
                    if (res) {
                        res = JSON.parse(res);
                        tr.find('.tax-name').val(res.name);
                        tr.find('.tax-rate').val(res.rate);
                        calc_product(tr);
                    }
                }
            });
        } else {
            tr.find('.tax-name').val('');
            tr.find('.tax-rate').val(0);
            calc_product(tr);
        }
    })
}
function initialize_change_qty() {
    $('.qty').change(function (e) {
        calc_product($(this).closest('tr'));
    });
}
function initialize_change_price() {
    $('.price-format').change(function (e) {
        calc_product($(this).closest('tr'));
        $(this).closest('td').find('.price').val($(this).val());
        $(this).val(money($(this).val()));
    });
}
function initialize_change_product() {
    $('.product').change(function (e) {
        var tr = $(this).closest('tr');
        $.ajax({
            type: 'post',
            url: site_url + 'ajax/get_product',
            data: {id: $(this).val(), currency: $('#currency').val()},
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    tr.find('.unit').val(res.unit_name);
                    tr.find('.price').val(res.price);
                    tr.find('.price-format').val(res.price_format);
                    var qty = tr.find('.qty').val();
                    if (!qty) {
                        tr.find('.qty').val(1);
                    }
                    calc_product(tr);
                }
            }
        })
    });
}

function product_add() {
    product++;
    alert("hello");
    var html = '<tr id="product-' + product + '">' +
            '<td>' +
            '   <select name="products[' + product + '][id]" class="product" data-placeholder="" data-allow-clear="true"></select>' +
            '</td>' +
            '<td>' +
            '   <textarea name="products[' + product + '][description]" class="form-control" rows="1"></textarea>' +
            '</td>' +
            '<td>' +
            '    <input type="number" name="products[' + product + '][qty]" class="form-control text-right qty" autocomplete="off">' +
            '</td>' +
            '<td>' +
            '    <input type="text" disabled="disabled" class="form-control unit">' +
            '</td>' +
            '<td>' +
            '    <input type="text" class="form-control text-right price-format" autocomplete="off">' +
            '    <input type="hidden" name="products[' + product + '][price]" class="price" value="0">' +
            '</td>' +
            '<td>' +
            '    <select name="products[' + product + '][tax]" class="tax" data-placeholder="" data-allow-clear="true"></select>' +
            '    <input type="hidden" class="tax-rate" value="0">' +
            '    <input type="hidden" class="tax-name" value="">' +
            '</td>' +
            '<td>' +
            '    <input type="text" disabled="" class="form-control text-right amount">' +
            '</td>' +
            '<td><a href="javascript:void(0);" onclick="product_remove(' + product + ')"><i class="icon-x"></i></a></td>' +
            '</tr>';
    table_trx.append(html);
    initialize_select2_ajax(table_trx.find(".product").last(), url.get_products);
    initialize_select2_ajax(table_trx.find(".tax").last(), url.get_taxes);
    initialize_change_product();
    initialize_change_qty();
    initialize_change_price();
    initialize_change_tax();
}

function product_remove(id) {
    if ($('#table-transaction tbody tr').length < 3) {
        return false;
    }
    $('#product-'+id).remove();
    calc_total();
}

function calc_product(tr) {
    var price = parseFloat(tr.find('.price').val());
    var qty = parseFloat(tr.find('.qty').val());
    if (!isNaN(price) && !isNaN(qty)) {
        var amount = price * qty;
        tr.find('.amount').val(money(amount));
        calc_total();
    }
}

function calc_total() {
    var subtotal = 0;
    var taxes = [];
    $('#table-transaction tbody tr').each(function (i, el) {
        var price = parseFloat($(el).find('.price').val());
        var qty = parseFloat($(el).find('.qty').val());
        if (!isNaN(price) && !isNaN(qty)) {
            var amount = price * qty;
            subtotal += amount;
            var tax = $(el).find('.tax').val();
            if (tax) {
                var tax_exist = 'undefined';
                if (taxes.length) {
                    $.each(taxes, function (i, e) {
                        if (e.id == tax) {
                            tax_exist = i;
                            return false;
                        }
                    });
                }
                if (tax_exist == 'undefined') {
                    var arr_tax = {
                        id: $(el).find('.tax').val(),
                        name: $(el).find('.tax-name').val(),
                        rate: parseFloat($(el).find('.tax-rate').val()),
                    };
                    arr_tax.amount = (amount * arr_tax.rate) / 100;
                    taxes.push(arr_tax);
                } else {
                    taxes[tax_exist].amount += (amount * taxes[tax_exist].rate) / 100;
                }
            }
//            console.log(taxes);
        }
    });
    $('#subtotal td.text-right').text(money(subtotal));
    $('tr.tax').remove();
    var tax = 0;
    var tax_html = '';
    if (taxes.length) {
        $.each(taxes, function (i, e) {
            tax_html += '<tr class="tax"><th>' + e.name + '</th><td class="text-right">' + money(e.amount) + '</td></tr>';
            tax += e.amount;
        })
        $('#subtotal').after(tax_html);
    }
    var total = subtotal + tax;
    $('#total h5').text(money(total));
}

$(document).ready(function () {
    initialize_select2_ajax($('#customer'), url.get_customers);
    initialize_select2_ajax($('#term'), url.get_terms);
    initialize_select2_ajax($('#currency'), url.get_currencies);
    initialize_select2_ajax($('.product'), url.get_products);
    initialize_select2_ajax($('.tax'), url.get_taxes);
    initialize_select2_ajax($('#quotes'), url.get_quotes);

    initialize_change_product();
    initialize_change_qty();
    initialize_change_price();
    initialize_change_tax();

    $('#term').change(function () {
        if ($(this).val()) {
            $.ajax({
                type: 'post',
                url: site_url + 'ajax/get_due_date',
                data: {id: $(this).val(), date: $('#date').val()},
                success: function (res) {
                    if (res) {
                        $('#due-date').val(res);
                    }
                }
            });
        }
    });
    $('#date').change(function(){
        $('#term').trigger('change');
    });
    $('#due-date').change(function () {
        $('#term').val(null).trigger('change');
    });
    $('.price-format').click(function(){
        var tr = $(this).closest('tr');
        $(this).val(tr.find('.price').val()).select();
    });
});
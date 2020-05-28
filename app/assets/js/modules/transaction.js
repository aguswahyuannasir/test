var config_select2 = {
    ajax: {
        url: '',
        type: 'post',
        delay: 250,
        data: function (params) {
            var query = {
                q: params.term,
                page: params.page || 1,
            }
            return query;
        },
        processResults: function (data) {
            data = JSON.parse(data);
            return data;
        }
    },
    tags: false
};

function initialize_select2_ajax(el, url) {
    var config = config_select2;
    config.ajax.url = url;
    el.select2(config);
}

function initialize_select2_product(el) {
    var config = config_select2;
    config.ajax.url = url.get_products;
    config.processResults = function (data) {
        data = JSON.parse(data);
        return data;
    }
    $.each(el, function (i, e) {
//        console.log(e);
        $(e).select2(config);
        $(e).on('select2:open', () => {
            $(".select2-results:not(:has(a))").prepend('<a href="#" class="select2-add-new select2-results__option">' + lang.add_new + '</a>').hover(function () {
                $('.select2-results__option').removeClass('select2-results__option--highlighted');
            }).click(function () {
//                console.log(e);
                $(e).select2('close');
                add_product($(e).attr('id'));
            });
        });
    })
}

function initialize_isNumber(){
    $('.isNumber').number( true,0,'', '' );
}

function initialize_change_contact(el) {
    $('#' + el).change(function (e) {
        $.ajax({
            type: 'post',
            url: site_url + 'ajax/get_contact',
            data: {
                id: $(this).val()
            },
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    $('#address').val(res.address);
                }
            }
        })
    });
}
function initialize_change_currency() {
    $('#currency').change(function (e) {
        $.ajax({
            type: 'post',
            url: site_url + 'ajax/get_currency',
            data: {
                id: $(this).val()
            },
            success: function (res) {
                res = JSON.parse(res);
                curr_prefix = res.prefix;
                curr_suffix = res.suffix;
                curr_decimal_digit = res.decimal_digit;
                curr_decimal_separator = res.decimal_separator;
                curr_thousand_separator = res.thousand_separator;
                if (Object.keys(products).length > 0) {
                    $.each(products, function (i, product) {
                        product_remove(i);
                    });
                } else {
                    $('#subtotal td.text-right').text(money(0));
                    $('#total h5').text(money(0));
                }
            }
        })
    });
}

function initialize_change_tax(id) {
    $('#product-' + id + ' .taxes').change(function (e) {
        var taxes = {};
        if ($(this).val()) {
            if (products[id]) {
                $.ajax({
                    type: 'post',
                    url: site_url + 'ajax/get_tax',
                    data: {
                        id: $(this).val()
                    },
                    success: function (res) {
                        res = JSON.parse(res);
                        products[id].taxes = res;
                        $.each(res, function (i, v) {
                            var t = Object();
                            t = v;
                            taxes[i] = t;
                        });
                        products[id].taxes = taxes;
                        calc_product(id);
                    }
                });
            }
        } else {
            if (products[id]) {
                products[id].taxes = {};
                calc_product(id);
            }
        }
    })
}

function initialize_change_charges_fee(id) {
    $('#product-' + id + ' .charges-fees').change(function (e) {
        products[id].charges_fees = {};
        var charges_fees = {};
        if ($(this).val()) {
            if (products[id]) {
                $.ajax({
                    type: 'post',
                    url: site_url + 'ajax/get_charges_fee',
                    data: {
                        id: $(this).val()
                    },
                    success: function (res) {
                        res = JSON.parse(res);
                        $.each(res, function (i, v) {
                            var c = Object();
                            c = v;
                            charges_fees[i] = c;
                        });
                        products[id].charges_fees = charges_fees;
                        calc_product(id);
                    }
                });
            }
        } else {
            if (products[id]) {
                products[id].charges_fees = {};
                calc_product(id);
            }
        }
    })
}

function initialize_change_qty(id) {
    $('#product-' + id + ' .qty').change(function (e) {
        calc_product(id);
    });
}

function initialize_change_price(id) {
    $('#product-' + id + ' .price-format').focus(function () {
        $(this).val($('#product-' + id + ' .price').val()).select();
    });
    $('#product-' + id + ' .price-format').focusout(function (e) {
        $('#product-' + id + ' .price').val($(this).val());
        $(this).val(money($(this).val()));
        calc_product(id);
    });
}

function initialize_change_product(id) {
    $('#product-' + id + ' .product').change(function (e) {
        $.ajax({
            type: 'post',
            url: site_url + 'ajax/get_product',
            data: {
                id: $(this).val(),
                currency: $('#currency').val(),
                type: transaction_type
            },
            success: function (res) {
                console.log(res);
                if (res) {
                    res = JSON.parse(res);
                    console.log(res);
                    if (products[id]) {
                        product = products[id];
                    } else {
                        product = Object();
                    }
                    //                    $('#product-' + id + ' .unit').val(res.unit_name);
                    $('#product-' + id + ' .price').val(res.price);
                    $('#product-' + id + ' .price-format').val(res.price_format);
                    var qty = $('#product-' + id + ' .qty').val();
                    if (!qty) {
                        $('#product-' + id + ' .qty').val(1);
                        qty = 1;
                    }
                    product.taxes = {};
                    product.charges_fees = {};
                    $('#product-' + id + ' .taxes').val(null).select2('destroy');
                    $('#product-' + id + ' .charges-fees').val(null).select2('destroy');
                    //$('#product-' + id + ' .unit').val(res.unit).select2('destroy');
                    if (res.unit !== "") {
                        var _html_unit = "<option value='"+res.unit+"'>"+res.unit_name+"</option>";
                    }else{
                        var _html_unit = "";
                    }
                    var _html_unit = "<option value='"+res.unit+"'>"+res.unit_name+"</option>";

                    $('#product-' + id + ' .unit').html(_html_unit);

                    initialize_select2_ajax($('#product-' + id + ' .taxes'), url.get_taxes);
                    initialize_select2_ajax($('#product-' + id + ' .charges-fees'), url.get_charges_fees);
                    // initialize_select2_ajax($('#product-' + id + ' .unit'), url.get_unit);

                    product.price        = res.price;
                    product.price_format = res.price_format;
                    product.qty          = qty;
                    products[id] = product;
                    calc_product(id);
                    calc_total();
                    if ($("#changeitem-type-"+id).length) {
                        var _param_item = $("#product-product-"+id).val();
                        var _item_desc  = $("#product-description"+id).val();
                        var _item_val   = $("#select2-product-product-"+id+"-container").html();
                        if (_item_val == '<span class="select2-selection__placeholder"></span>') {
                            _item_val = "";
                        }
                        var _tochange = {
                                "id": _param_item,
                                "item_val": _item_val,
                                "description": _item_desc,
                                "price":0
                            };
                        initchangeitemid(id, _tochange)
                    }else{
                        createChangeinput(id, "update")
                    }
                }
            }
        });
    });
}

function product_add(_type = "", _rowpar = "") {
    row++;
    var html = '<tr id="product-' + row + '">' +
            '<td>\
                <div class="list-icons item-drag">\
                    <div class="dropdown">\
                        <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="fa fa-plus-circle"></i></a>\
                        <div class="dropdown-menu dropdown-menu-right">\
                            <a class="dropdown-item" href="javascript:void(0);" onclick="product_add(\'before\', '+row+')">\
                                <i class="fa fa-level-up-alt"></i> Add Before me\
                            </a>\
                            <a class="dropdown-item" href="javascript:void(0);" onclick="product_add(\'after\', '+row+')">\
                                <i class="fa fa-level-down-alt"></i> Add After me\
                            </a>\
                        </div>\
                    </div>\
                </div>\
            </td>' +
            '<td>' +
            '   <select name="products[' + row + '][id]" id="product-product-' + row + '" class="product" data-placeholder=""></select>' +
            '</td>' +
            '<td>' +
            '   <textarea name="products[' + row + '][description]" onchange="changeitemtext('+row+',\'description\')" id="product-description-' + row + '" class="form-control item-form" rows="1" placeholder="Enter Description"></textarea>' +
            '</td>' +
            '<td>\
                <select  name="products[' + row + '][unit]" class="unit" onchange="changeitemtext('+row+',\'unit\')" id="product-unit-'+row+'" data-place-holder="" readonly="readonly"></select>\
            </td>'+
            '<td>' +
            '    <input type="text" name="products[' + row + '][qty]" onchange="changeitemtext('+row+',\'qty\')" id="product-qty-'+row+'" class="form-control text-right qty isNumber" autocomplete="off">' +
            '</td>' +
            '<td>' +
            '    <input type="text" class="form-control text-right price-format" onchange="changeitemtext('+row+',\'price\')" autocomplete="off">' +
            '    <input type="hidden" name="products[' + row + '][price]" id="product-price-'+row+'" class="price" value="0">' +
            '</td>' +
            '<td>' +
            '    <select name="products[' + row + '][taxes][]" class="taxes" multiple="multiple" data-placeholder=""></select>' +
            '</td>' +
            '<!--<td>' +
            '    <select name="products[' + row + '][charges_fees][]" class="charges-fees" multiple="multiple" data-placeholder=""></select>' +
            '</td> -->' +
            '<td>' +
            '    <input type="text" disabled="" class="form-control text-right amount">' +
            '</td>' +
            '<td><a href="javascript:void(0);" onclick="product_remove(' + row + ')"><i class="icon-x"></i></a></td>' +
            '</tr>';
            
    if (_type == "before" && _rowpar !== "") {
        console.log("ke Before");
        // $("#product-"+_rowpar).prepend(html);
        $(html).insertBefore("#product-"+_rowpar);
    }else if(_type == "after" && _rowpar !== ""){
        console.log("ke After");
        $(html).insertAfter("#product-"+_rowpar);
    }else{
        console.log("ke baru");
        $('#table-transaction').append(html);
    }

    initialize_select2_product($("#product-" + row + " .product").last());
    initialize_select2_ajax($("#product-" + row + " .taxes").last(), url.get_taxes);
    initialize_select2_ajax($("#product-" + row + " .charges-fees").last(), url.get_charges_fees);
    initialize_select2_ajax($("#product-" + row + " .unit").last(), url.get_unit);
    initialize_change_product(row);
    initialize_change_qty(row);
    initialize_change_price(row);
    initialize_change_charges_fee(row);
    initialize_change_tax(row);
    initialize_isNumber();

    createChangeinput(row, 'add');
}

function createChangeinput(id, idval = "added"){
    var _param_item        = $("#product-product-"+id).val()
    var _item_val          = $("#select2-product-product-"+id+"-container").html();
    var _item_desc         = $("#product-description-"+id).val();
    var _item_qty          = $("#product-qty-"+id).val();
    var _name_before       = $("#product-itembefore-"+id).val();
    var _qty_before        = $("#product-qtybefore-"+id).val();
    var _descriptionbefore = $("#product-descriptionbefore-"+id).val();
    var _unit_before       = $("#product-unitbefore-"+id).val();
    var _price_before      = $("#product-pricebefore-"+id).val();
    if (_item_val == '<span class="select2-selection__placeholder"></span>') {
        _item_val = "";
    }

    /*var _change_html = '<input type="text" id="changeitem-type-'+id+'" name="changeitem['+id+'][type]" value="'+idval+'">'+
                    '<input type="text" id="changeitem-id-'+id+'" name="changeitem['+id+'][id]" value="'+_param_item+'">'+
                    '<input type="text" id="changeitem-item-'+id+'" name="changeitem['+id+'][item]" value="'+_item_val+'">'+
                    '<textarea id="changeitem-description-item-'+id+'" name="changeitem['+id+'][description]">'+_item_desc+'</textarea>'+
                    '<input type="text" id="changeitem-qty-'+id+'" name="changeitem['+id+'][qty]" value="'+_item_qty+'">';
    $("#edit_change").append(_change_html);
    setTimeout(function() {
        var _item_price = $("#product-price-"+id).val();
        var _price_html = '<input type="text" id="changeitem-price-'+id+'" name="changeitem['+id+'][qty]" value="'+_item_price+'">'
        $("#edit_change").append(_price_html);
    }, 500);*/

    var _change_html = '<input type="hidden" id="changeitem-type-'+id+'" name="changeitem['+id+'][type]" value="'+idval+'">'+
                    '<input type="hidden" id="changeitem-id-'+id+'" name="changeitem['+id+'][id]" value="'+_param_item+'">'+
                    '<input type="hidden" id="changeitem-item-'+id+'" name="changeitem['+id+'][item]" value="'+_item_val+'">'+
                    '<input type="hidden" id="changeitem-itembefore-'+id+'" name="changeitem['+id+'][before][itembefore]" value="'+_name_before+'">'+
                    '<textarea class="ds-none" id="changeitem-descriptionbefore-'+id+'" name="changeitem['+id+'][before][descriptionbefore]">'+_descriptionbefore+'</textarea>'+
                    '<input type="hidden" id="changeitem-qtybefore-'+id+'" name="changeitem['+id+'][before][qtybefore]" value="'+_qty_before+'">' +
                    '<input type="hidden" id="changeitem-pricebefore-'+id+'" name="changeitem['+id+'][before][pricebefore]" value="'+_price_before+'">' +
                    '<input type="hidden" id="changeitem-unitbefore-'+id+'" name="changeitem['+id+'][before][unitbefore]" value="'+_unit_before+'">';
    $("#edit_change").append(_change_html);
    setTimeout(function() {
        var _item_price = $("#product-price-"+id).val();
        var _price_html = '<input type="hidden" id="changeitem-price-'+id+'" name="changeitem['+id+'][price]" value="'+_item_price+'">'
        $("#edit_change").append(_price_html);
    }, 500);

}

function changeitemtext(id, name){
    console.log(id, name);
    var _myval = $("#product-"+name+"-"+id).val();
    if($("#changeitem-"+name+"-"+id).length){
        var _myitem = {[name]:_myval};
        initchangeitemid(id, _myitem)
    }else{
        if($("#changeitem-type-"+id).length < 1){
            createChangeinput(id, "update");
        }
        setTimeout(function() {
            var _myval = $("#product-"+name+"-"+id).val();
            if (name =="description") {
                var _add_html = '<textarea class="ds-none" id="changeitem-description-'+id+'" name="changeitem['+id+'][description]">'+_myval+'</textarea>';
            }else{
                var _add_html = '<input type="hidden" id="changeitem-'+name+'-'+id+'" name="changeitem['+id+']['+name+']" value="'+_myval+'">';
            }
            $("#edit_change").append(_add_html);
        }, 500);
    }
    
}

function initchangeitemid(id, item = {}){
    console.log(item)
    if("id" in item) { $("#changeitem-id-"+id).val(item.id); }
    if("item_val" in item){ $("#changeitem-item-"+id).val(item.item_val); }    
    if("description" in item){ $("#changeitem-description-"+id).val(item.description); }
    if("qty" in item){ $("#changeitem-qty-"+id).val(item.qty); }
    if("unit" in item){ $("#changeitem->unit-"+id).val(item.unit); }
    setTimeout(function() {
        if("price" in item){ 
            var _item_price = $("#product-price-"+id).val();
            console.log(_item_price);
            $("#changeitem-price-"+id).val(_item_price); 
        }
    }, 500);
    
}

function product_remove(id) {
    delete products[id];
    $('#product-' + id).remove();
    if ($('#table-transaction tbody tr').length == 0) {
        row = -1;
        product_add();
    }
    calc_total();
}

function calc_product(id) {
    var price = parseFloat($('#product-' + id + ' .price').val());
    var qty = parseFloat($('#product-' + id + ' .qty').val());
    if (!isNaN(price) && !isNaN(qty) && price && qty) {
        var amount = price * qty;
        $('#product-' + id + ' .amount').val(money(amount));
        products[id].qty = qty;
        products[id].price = price;
        products[id].amount = amount;
        calc_total();
    }
}

function calc_total() {
    var subtotal = 0;
    var taxes = {};
    var charges_fees = {};
    if (Object.keys(products).length > 0) {
        $.each(products, function (key, product) {
            // console.log(product);
            var id = product.id;
            var amount = parseFloat(product.qty) * parseFloat(product.price);
            subtotal += amount;
            var charge_fee = 0;
            if (Object.keys(product.charges_fees).length > 0) {
                $.each(product.charges_fees, function (i, e) {
                    var amount_cf = (amount * e.value) / 100;
                    charge_fee += amount_cf;
                    if (charges_fees[e.id]) {
                        charges_fees[e.id].amount += amount_cf;
                    } else {
                        e.amount = amount_cf;
                        charges_fees[e.id] = e;
                    }
                });
                amount += charge_fee;
            }
            if (Object.keys(product.taxes).length > 0) {
                var non_ppn = 0;
                $.each(product.taxes, function (i, e) {
                    if (e.is_ppn != 1) {
                        if (taxes[e.id]) {
                            var non_ppn_amount = (amount * e.rate) / 100;
                            taxes[e.id].amount += non_ppn_amount;
                            non_ppn            += non_ppn_amount;
                        } else {
                            var non_ppn_amount = (amount * e.rate) / 100;
                            non_ppn            += non_ppn_amount;
                            e.amount           = non_ppn_amount;
                            taxes[e.id] = e;
                        }
                    }
                });

                $.each(product.taxes, function (i, e) {
                    if (e.is_ppn == 1) {
                        if (taxes[e.id]) {
                            var ppn_amount     = ((amount+non_ppn) * e.rate) / 100;
                            taxes[e.id].amount += ppn_amount;
                        } else {
                            var ppn_amount = ((amount+non_ppn) * e.rate) / 100;
                            e.amount       = ppn_amount
                            taxes[e.id]    = e;

                        }
                        // console.log("AMOUNT = ",i," = ",amount);
                    }
                });
            }
        })
    }
    $('#subtotal td.text-right').text(money(subtotal));
    var charges_fee = 0;
    var charges_fee_html = '';
    $('tr.charges_fee').remove();
    if (Object.keys(charges_fees).length > 0) {
        $.each(charges_fees, function (i, e) {
            charges_fee_html += '<tr class="charges_fee"><th>' + e.name + ' (' + e.value + '%)</th><td class="text-right">' + money(e.amount) + '</td></tr>';
            charges_fee += e.amount;
        });
        $('#subtotal').after(charges_fee_html);
    }
    $('tr.tax').remove();
    var tax = 0;
    var tax_html = '';
    if (Object.keys(taxes).length > 0) {
        $.each(taxes, function (i, e) {
            if (e.is_ppn != 1) {
                tax_html += '<tr class="tax"><th>' + e.name + ' (' + e.rate + '%)</th><td class="text-right">' + money(e.amount) + '</td></tr>';
                tax += e.amount;
            }
        });

        $.each(taxes, function (i, e) {
            if (e.is_ppn == 1) {
                tax_html += '<tr class="tax"><th>' + e.name + ' (' + e.rate + '%)</th><td class="text-right">' + money(e.amount) + '</td></tr>';
                tax += e.amount;
            }
        });
        $('#total').before(tax_html);
    }
    var total = subtotal + charges_fee + tax;
    $('#total h5').text(money(total));
}

function add_product(id) {
    var type = $('input[name=type]:checked').val();
    if (type == 'product') {
        $('#box-cost').show();
    } else {
        $('#box-cost').hide();
    }
    $('input[name=type]').change(function () {
        if (this.value == 'service') {
            $('#box-cost').hide();
        } else {
            $('#box-cost').show();
        }
    });
//    console.log(id);
    el = $('#' + id);
    initialize_select2_ajax($('#category'), site_url + 'ajax/get_product_categories');
    initialize_select2_ajax($('#unit'), site_url + 'ajax/get_product_units');
    var config_validate_add_contact = config_validate;
    config_validate_add_contact.submitHandler = function (form) {
        $(form).ajaxSubmit({
            success: function (data) {
//                console.log(el);
                response_form(data);
                data = JSON.parse(data);
                el.html(data.data);
                el.trigger('change');
                $('#form-add-product')[0].reset();
                $.uniform.update();
                $('#modal-add-product').modal('hide');
            }
        });
        return false;
    }
    $('#form-add-product').validate(config_validate_add_contact);
    $('#modal-add-product').modal('show');
}


$(document).ready(function() {
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    },
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i+1);
        });
        /*$('input[type=text]', ui.item.parent()).each(function (i) {
            
        });*/
    };

    $("#table-transaction tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();
    
    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function() {}
    });
});
var url = {
    get_customers: site_url + 'ajax/get_customers',
    get_currencies: site_url + 'ajax/get_currencies',
    get_products: site_url + 'ajax/get_products',
    get_taxes: site_url + 'ajax/get_taxes',
    get_charges_fees: site_url + 'ajax/get_charges_fees',
    get_unit: site_url + 'ajax/get_product_units',
}
var transaction_type = 'sale';

var invoice_before_head = {
    "title" : $("#title").val(),
    "customer": $("#customer").val(),
    "address": $("#address").val(),
    "date": $("#date").val(),
    "term": $("#term").val(),
    "due-date": $("#due-date").val(),
    "quotes": $("#quotes").val(),
    "code": $("#code").val(),
    "currency": $("#currency").val(),
    "purchase_order_number": $("#purchase_order_number").val(),
    "brand": $("#brand").val(),
    "project": $("#project").val(),
    "project_desc": $("#project_desc").val(),
    "cs_rec_dt": $("#cs_rec_dt").val(),
    "note" : $("#note").val(),
    "payment_advice" : $("#payment_advice").val()
};

var quote_before_head = {
    "subject" : $("#subject").val(),
    "customer": $("#customer").val(),
    "address" : $("#address").val(),
    "date"    : $("#date").val(),
    "due_date": $("#due_date").val(),
    "code"    : $("#code").val(),
    "currency": $("#currency").val(),
    "message" : $("#message").val()
}

function init_changelog(){
    console.log(invoice_before_head);
}


$(document).ready(function () {
    /*QUOTE BEFORE HEAD SPECIAL PARSE DATA*/
    // Add other parameter to quote before head
    setTimeout(function() {
        quote_before_head['customer_name'] = $("#select2-customer-container").attr('title');
        quote_before_head['currency_name'] = $("#select2-currency-container").attr('title');
    }, 1000);
    /*QUOTE BEFORE HEAD SPECIAL PARSE DATA*/

    initialize_select2_ajax($('#customer'), url.get_customers);
    initialize_select2_ajax($('#currency'), url.get_currencies);
    initialize_select2_product($('.product'));
    initialize_select2_ajax($('.taxes'), url.get_taxes);
    initialize_select2_ajax($('.charges-fees'), url.get_charges_fees);
    initialize_select2_ajax($('.unit'), url.get_unit);

    initialize_change_contact('customer');
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

    if (edit) {
        $(".occ").change(function(event) {
            // Note, if class occ change check value here
            var _myid  = $(this).attr('id');
            var _myval = $(this).val();

            var _getValBfr = invoice_before_head[_myid];
            if (_getValBfr !== _myval) {
                $("#change_"+_myid).remove();
                if (_myid == 'address'|| _myid=="project_desc") {
                    var _myhtml = "<textarea class='ds-none' name='change_log["+_myid+"]' id='change_"+_myid+"'>"+_getValBfr+"";
                }else if (_myid == "date") {
                    var _myhtml = "<input type='hidden' name='change_log["+_myid+"]' value='"+_getValBfr+"' id='change_"+_myid+"'>";
                    setTimeout(function() {
                        var _duedate = $("#due-date").val();
                        $("#change_due-date").remove();
                        // console.log(invoice_before_head['due-date'], "////", _duedate);
                        if (invoice_before_head['due-date'] != _duedate) {
                            var _myhtml_sc = "<input type='hidden' name='change_log[due-date]' value='"+invoice_before_head['due-date']+"' id='change_due-date'>";
                            $("#edit_change").append(_myhtml_sc);
                        }else{
                            $("#change_due-date").remove();
                        }
                        
                    }, 1000);
                }else if(_myid == "term"){
                    setTimeout(function() {
                        var _duedate = $("#due-date").val();
                        $("#change_due-date").remove();
                        console.log(invoice_before_head['due-date'], "////", _duedate);
                        if (invoice_before_head['due-date'] != _duedate) {
                            var _myhtml_sc = "<input type='hidden' name='change_log[due-date]' value='"+invoice_before_head['due-date']+"' id='change_due-date'>";
                            $("#edit_change").append(_myhtml_sc);
                        }else{
                            $("#change_due-date").remove();
                        }
                        
                    }, 1000);

                    var _myhtml = "<input type='hidden' name='change_log["+_myid+"]' value='"+_getValBfr+"' id='change_"+_myid+"'>";
                }else{
                    var _myhtml = "<input type='hidden' name='change_log["+_myid+"]' value='"+_getValBfr+"' id='change_"+_myid+"'>";
                }
                $("#edit_change").append(_myhtml);
            }else{
                if (_myid == "term") {
                    setTimeout(function() {
                        var _duedate = $("#due-date").val();
                        $("#change_due-date").remove();
                        // console.log(invoice_before_head['due-date'], "////", _duedate);
                        if (invoice_before_head['due-date'] != _duedate) {
                            var _myhtml_sc = "<input type='hidden' name='change_log[due-date]' value='"+invoice_before_head['due-date']+"' id='change_due-date'>";
                            $("#edit_change").append(_myhtml_sc);
                        }else{
                            $("#change_due-date").remove();
                        }
                        
                    }, 1000);
                }
                $("#change_"+_myid).remove();
            }
            // console.log(_getValBfr, "----", _myid, "----", _myval);
            init_changelog();
        });


        $(".qcc").change(function(event) {
            var _qid       = $(this).attr('id');
            var _qval      = $(this).val();
            var _getValBfr = quote_before_head[_qid];
            console.log(_getValBfr);
            if (_qval != _getValBfr) {
                if($("#changelog_"+_qid).length < 1){
                    if (_qid == "address" || _qid == "message") {
                        var _bfr_html = '<textarea class="ds-none" name="changelog['+_qid+']" id="changelog_'+_qid+'" readonly="">'+_getValBfr+'</textarea>';
                    }else{
                        var _bfr_html = '<input type="hidden" value="'+_getValBfr+'" name="changelog['+_qid+']" id="changelog_'+_qid+'" readonly="">';
                    }

                    /*==== CUSTOMER SPECIAL CONDITION ====*/
                    if (_qid == "customer") {
                        _bfr_html+= '<input type="hidden" value="'+quote_before_head['customer_name']+'" name="changelog[customer_name]" id="changelog_customer_name" readonly="">';
                    }
                }
                $("#changelog").append(_bfr_html);
            }else{
                console.log($("#changelog_"+_qid).length);
                if($("#changelog_"+_qid).length >= 1){
                    $("#changelog_"+_qid).remove();
                    /*==== CUSTOMER SPECIAL CONDITION ====*/
                    if (_qid == "customer") {
                        $("#changelog_customer_name").remove();
                    }
                }
            }
        });
    }
});


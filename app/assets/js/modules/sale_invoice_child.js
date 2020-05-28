function init_invoice_child() {
    $('#term').select2({
        ajax: {
            url: site_url + 'ajax/get_terms',
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
                return data;
            }
        },
    });

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

    var $modal = $('#modal-form-invoice-child');
    var $form = $('#form-invoice-child');
    var config_validate_invoice_child = config_validate;
    config_validate_invoice_child.submitHandler = function (form) {
        $(form).ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    success_message(data.message);
                    $modal.modal('hide');
                    if (data.isReload == 1) {
                        setTimeout(function() {
                            showDetail(invoice_url);
                        }, 1000);
                    }else{
                        $('#invoice-child .card-body').html(data.html);
                        reset_form();
                        total_child_amount = data.total_child.total_amount;
                        total_child_percent = data.total_child.total_percent;
                        check_total();
                        init_form_invoice_child();
                    }
                } else {
                    error_message(data.message);
                }
            }
        });
        return false;
    }
    $form.validate(config_validate_invoice_child);

    var $rem_on_total = $('#remaining-on-total');
    var $rem_on_child = $('#remaining-on-child');
    var $total_child = $('#total-child');
    var $payment = $('#payment');

    $('#add-invoice-child').click(function () {
        total_on_edit = 0;
        $modal.find('.modal-title #add').show();
        $modal.find('.modal-title #edit').hide();
        reset_form();
        $rem_on_total.text(money(total - total_child_amount));
        $rem_on_child.text(money(total - total_child_amount));
        $total_child.text(money(0));
        $modal.modal('show');

        setTimeout(function() {
            $( ".date" ).datepicker({
                format : "yyyy-mm-dd"
            });
        }, 500);
    });
    init_form_invoice_child();
    function init_form_invoice_child() {
        $('#payment-type, #payment').on('change keyup', function () {
            var type = $('#payment-type').val();
            var payment = parseFloat($payment.val());
            if (isNaN(payment) || payment < 1) {
                payment = 0;
            }
            var rem_child_amount = total - total_child_amount + total_on_edit;
            if (type == 'percent') {
                var payment_amount = total * payment / 100;
            } else if (type == 'fixed_amount') {
                var payment_amount = payment;
            }
            if (payment_amount > rem_child_amount) {
                $payment.val('').change();
                return false;
            }
            var remaining = rem_child_amount - payment_amount;
            $total_child.text(money(payment_amount));
            $rem_on_child.text(money(remaining));

        });

        $('#invoice-child .edit').click(function () {
            var id = $(this).data('id');
            $.ajax({
                url: site_url + 'sale/invoices/get_invoice_child',
                type: 'post',
                data: {id: id},
                success: function (res) {
                    res = JSON.parse(res);
                    total_on_edit = parseFloat(res.payment_amount);
                    $form.find('input[name=id]').val(res.id);
                    $form.find('input[name=code]').val(res.code);
                    $('#date').val(res.date);
                    if (res.term > 0) {
                        $('#term').html('<option value="' + res.term + '">' + res.term_name + '</option>');
                    }
                    $('#due-date').val(res.due_date);
                    var type = $('#payment-type').val();
                    if (type == 'percent') {
                        $('#payment').val(res.payment_percentage).change();
                    } else if (type == 'fixed_amount') {
                        $('#payment').val(res.payment_amount).change();
                    }
                    $rem_on_total.text(money(total - total_child_amount + total_on_edit));
                    $modal.find('.modal-title #add').hide();
                    $modal.find('.modal-title #edit').show();
                    $modal.modal('show');
                }
            });
        });

        $('#invoice-child .delete').click(function (e) {
            var url = $(this).attr('href');
            e.preventDefault();
            swal({
                text: "Are you sure yout want to delete this invoice child?",
                icon: "warning",
                buttons: {
                    cancel: {
                        visible: true
                    },
                    confirm: {
                        text: 'Yes',
                        closeModal: false
                    }
                },
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: url,
                        success: function (res) {
                            res = JSON.parse(res);
                            if (res.status == 'success') {
                                success_message(res.message);
                                $('#invoice-child .card-body').html(res.html);
                                total_child_amount = res.total_child.total_amount;
                                total_child_percent = res.total_child.total_percent;
                                check_total();
                                init_form_invoice_child();
                            } else {
                                error_message(res.message);
                            }
                        }
                    });
                    swal.close();
                }
            });
        });
    }

    function reset_form() {
        $('#form-invoice-child')[0].reset();
        $form.find('input[name=id]').val('');
        $('#term').html('<option value=""></option>');
    }

    function check_total() {
        if (total_child_amount == total) {
            $('#add-invoice-child').addClass('d-none');
        } else {
            $('#add-invoice-child').removeClass('d-none');
        }
    }
}
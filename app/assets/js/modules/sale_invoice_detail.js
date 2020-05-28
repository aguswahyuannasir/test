function init_invoice_detail() {
    $('#modal-share-link').click(function () {
        var url = $('#customer-view').attr('href');
        $('#modal-share #share-link').val(url);
        $('#link-copy').text('');
    })

    $('#btn-copy').click(function () {
        var value_text = $('#modal-share #share-link').select().val()
        document.execCommand('copy');
        $('#link-copy').text('Link Copied');
    })

    $('#modal-share #share-link').focus(function () {
        $(this).select().val();
    })
    $('#modal-share #share-link').keypress(function (evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        console.log(charCode)
        if (charCode < 400)
            return false;
        return true;
    })

    $('#delete').click(function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            text: "Are you sure yout want to delete this invoice?",
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
                        window.location = res.redirect;
                    }
                });
            }
        });
    });

    $("#doPaymentBtn").click(function(event) {
        $("#main_invoice_code").html($("#inv-code-main").html());
        $("#main_parameter").val(main_parameter);
        setTimeout(function() {
            $( ".date" ).datepicker({
                format : "yyyy-mm-dd"
            });
        }, 500);

        $("#payment-main-modal").modal('show');

        $("#main_paymethod").change(function(event) {
            if ($("#main_paymethod").val() != "") {
                var myval = $("#main_paymethod").val();
                if (main_p[myval] == 1) {
                    $("#main-ch-account").removeClass("ds-none");
                    $("#main-ch-account-sel").attr({
                        required: ''
                    });
                }else{
                    $("#main-ch-account").addClass("ds-none");
                    $("#main-ch-account-sel").removeAttr('required');
                }
                $("#main_pm_type").val(main_p[myval]);
            }else{
                $("#main-ch-account").addClass("ds-none");
                $("#main-ch-account-sel").removeAttr('required');
                $("#main_pm_type").val("");
            }
        });

        var $main_form = $('#form-payment-main-invoice');
        var config_validate_invoice_main = config_validate;
        config_validate_invoice_main.submitHandler = function (form) {
            $(form).ajaxSubmit({
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data)
                    if (data.status == 'success') {
                        $("#payment-main-modal").modal("toggle");
                        setTimeout(function() {
                            // Create loading here later timeout then fill html
                            $('#content-detail').html(data.html);    
                        }, 1000);
                        console.log("Success");
                        success_message(data.message);
                    } else {
                        console.log("Failed");
                        error_message(data.message);
                    }
                }
            });
            return false;
        }
        $main_form.validate(config_validate_invoice_main);
    });

    $("#doCloseBtn").click(function(event) {
        $("#main_invoice_code_close").html($("#inv-code-main").html());
        $("#main_parameter_close").val(main_parameter);
        $("#invoice-close-modal").modal('show');

        var $close_form = $('#form-close-invoice');
        var config_validate_invoice_close = config_validate;
        config_validate_invoice_close.submitHandler = function (form) {
            $(form).ajaxSubmit({
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data)
                    if (data.status == 'success') {
                        $("#invoice-close-modal").modal("toggle");
                        setTimeout(function() {
                            // Create loading here later timeout then fill html
                            $('#content-detail').html(data.html);    
                        }, 1000);
                        console.log("Success");
                        success_message(data.message);
                    } else {
                        console.log("Failed");
                        error_message(data.message);
                    }
                }
            });
            return false;
        }
        $close_form.validate(config_validate_invoice_close);
    });

    var _myseq = $("#seq").text();
    var _mytr  = $("#list-data-"+_myseq);
    if (_mytr.length) {
        $("#table_invoice2 tr").removeClass("active");
        _mytr.closest('tr').addClass('active');
    }else{
        console.log("Sequence not loaded yet, run to next one");
    }

    $("#log_history-tab").click(function(event) {
        $("#result-tab-log").fadeOut('fast', function() {
            $("#loading-tab-log").fadeIn('fast', function() {
                $.ajax({
                    url: base_url+'sale/invoices/getHistory/',
                    type: 'GET',
                    dataType: 'html',
                    data: {_parameter: main_parameter},
                    async: true,
                    processData: true
                })
                .done(function(e) {
                    $("#loading-tab-log").fadeOut('fast', function() {
                        $("#result-tab-log").html(e);
                        $("#result-tab-log").fadeIn('fast', function() {});
                    });
                })
                .fail(function() {
                    alert("Something went wrong, please try again after few second.");
                    $("#loading-tab-log").fadeOut('fast', function() {
                        $("#result-tab-log").fadeIn('fast', function() {});
                    });
                });
            });
        });
    });

    $("#payment_history-tab").click(function(event) {
        $("#result-tab-log-payment").fadeOut('fast', function() {
            $("#loading-tab-log-payment").fadeIn('fast', function() {
                $.ajax({
                    url: base_url+'sale/invoices/getPaymentHistory/',
                    type: 'GET',
                    dataType: 'html',
                    data: {_parameter: main_parameter},
                    async: true,
                    processData: true
                })
                .done(function(e) {
                    $("#loading-tab-log-payment").fadeOut('fast', function() {
                        $("#result-tab-log-payment").html(e);
                        $("#result-tab-log-payment").fadeIn('fast', function() {
                            
                        });
                    });
                })
                .fail(function() {
                    alert("Something went wrong, please try again after few second.");
                    $("#loading-tab-log-payment").fadeOut('fast', function() {
                        $("#result-tab-log-payment").fadeIn('fast', function() {});
                    });
                })
                .always(function() {
                    console.log("complete");
                });
            });
        });
    });
}
function init_quotes_detail(){
    $('#delete').click(function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            text: "Are you sure yout want to delete this quote?",
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true
                },
                confirm: {
                    text:'Yes',
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
    })
    $('#convert-to-invoice').click(function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            text: "Convert this quote to invoice?",
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true
                },
                confirm: {
                    text:'Yes',
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
    })

    var _myseq = $("#seq").text();
    var _mytr  = $("#list-data-"+_myseq);
    if (_mytr.length) {
        $("#table_inv_quote_list tr").removeClass("active");
        _mytr.closest('tr').addClass('active');
    }else{
        console.log("Sequence not loaded yet, run to next one");
    }

    $("#log_history-tab").click(function(event) {
        $("#result-tab-log").fadeOut('fast', function() {
            $("#loading-tab-log").fadeIn('fast', function() {
                $.ajax({
                    url: base_url+'sale/quotes/getHistory/',
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
}
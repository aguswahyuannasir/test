$(document).ready(function () {
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
    })
});
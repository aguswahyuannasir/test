$(document).ready(function () {

    var start = moment();
    var end = moment();


    function cb(start, end) {
        $('input[name="start-date"]').val(start.format('DD/MM/YYYY'))
        $('input[name="end-date"]').val(end.format('DD/MM/YYYY'))
        $('input[name="periode"]').val('')
    }


    $('.periode').change(function () {

        $('#periode option[class="custom"]').removeAttr('selected');
        if ($(this).val() == 'today') {
            cb(moment(), moment());
        } else if ($(this).val() == 'this-week') {
            cb(moment().startOf('isoWeek'), moment().endOf('isoWeek'))
        } else if ($(this).val() == 'this-month') {
            cb(moment().startOf('month'), moment().endOf('month'))
        } else if ($(this).val() == 'this-year') {
            cb(moment().startOf('year'), moment().endOf('year'))
        } else if ($(this).val() == 'yesterday') {
            cb(moment().subtract(1, 'days'), moment().subtract(1, 'days'))
        } else if ($(this).val() == 'last-week') {
            cb(moment().subtract(1, 'week').startOf('isoWeek'), moment().subtract(1, 'week').endOf('isoWeek'))
        } else if ($(this).val() == 'last-month') {
            cb(moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month'))
        } else if ($(this).val() == 'last-year') {
            cb(moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year'))
        }
    })

    $(".datepicker").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
    });

    $('.datepicker').click(function () {
        $('#periode option[class="custom"]').attr('selected', 'selected');
    })


    $('#end-calendar').click(function () {
        $('#end-date').data("datepicker").show();
        $('#periode option[class="custom"]').attr('selected', 'selected');
    })

    $('#start-calendar').click(function () {
        $('#start-date').data("datepicker").show();
        $('#periode option[class="custom"]').attr('selected', 'selected');
    })



    // Datatables
    var columns = [];
    $('.column th').each(function () {
        columns.push({
            data: $(this).attr('data-data')
        });
    });

    var filter = {};

    var table = $('#table').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#table').attr('data-url'),
            type: 'post',
            data: function (d) {
                $('#report-invoices input').each(function () {
                    filter[$(this).attr("name")] = $(this).val();
                });
                d.filter = filter;
                return d;
            }
        },

        autoWidth: false,
        columns: columns,
        columnDefs: [{
                orderable: false,
                targets: 'no-sort'
            },
            {
                className: 'text-center',
                targets: 'text-center'
            },
            {
                className: 'text-right',
                targets: 'text-right'
            }
        ],
        order: [
            [$('th.default-sort').index(), $('th.default-sort').attr('data-sort')]
        ],
        orderCellsTop: true,
        dom: '<"datatable-scroll"t><"datatable-footer"ipl>',
        language: {
            paginate: {
                'next': '<i class="icon-arrow-right15"></i>',
                'previous': '<i class="icon-arrow-left15"></i>'
            }
        },
        pagingType: 'listbox',


        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
                data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\Rp.]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var angka = money_formating(total)


            // Total over this page
            pageTotal = api
                .column(4, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            if (total == 0) {

                $(api.column(4).footer()).html(
                    0
                );
            } else {
                $(api.column(4).footer()).html(
                    'Rp. ' + money_formating(pageTotal)
                );
            }
        }


    });

    // function money(amount) {
    //     return curr_prefix + $.number(amount, curr_decimal_digit, curr_decimal_separator, curr_thousand_separator) + curr_suffix;
    // }

    function money_formating(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            return rupiah += separator + ribuan.join('.');
        }
    }

    $('#btn-filter').click(function (e) {
        e.preventDefault;
        table.ajax.reload();
    })

    $('body').on('click', '.filter button', function (e) {
        e.preventDefault;
        table.ajax.reload();
    });
    $('body').on('keyup', '.filter input', function (e) {
        if (e.keyCode == 13) {
            // alert('ha');
            // e.preventDefault;
            table.ajax.reload();
        }
    });
    $('body').on('click', '.delete', function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            text: "Are you sure want to delete?",
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true
                },
                confirm: {
                    closeModal: false
                }
            },
        }).then((value) => {
            if (value) {
                $.ajax({
                    url: url,
                    success: function (data) {
                        data = JSON.parse(data);
                        table.ajax.reload();
                        swal('', data.message, data.status);
                    }
                });
            }
        });
    });
});
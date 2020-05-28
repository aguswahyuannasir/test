var filter = {};
var table_config = {
    responsive: {
        details: {
            type: 'column'
        }
    },
    buttons: [{
            extend: 'colvis',
            text: '<i class="icon-grid3"></i>',
            className: 'btn btn-sm btn-link dropdown-toggle p-0',
            columns: ':not(.novis)'
        }],
//    stateSave: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: $('#table').attr('data-url'),
        type: 'post',
        data: function (d) {
            $('.filter select, .filter input').each(function () {
                filter[$(this).attr("name")] = $(this).val();
            });
            d.filter = filter;
            return d;
        },
    },

    autoWidth: false,
    columnDefs: [{
            orderable: false,
            targets: 'no-sort'
        }, {
            className: 'text-center',
            targets: 'text-center'
        }, {
            className: 'text-right',
            targets: 'text-right'
        }, {
            visible: false,
            targets: 'hide'
        }
    ],
    order: [
        [$('th.default-sort').index(), $('th.default-sort').attr('data-sort')]
    ],
    orderCellsTop: true,
//    dom: '<"datatable-scroll"t><"datatable-footer"ipl>',
    dom: '<"datatable-scroll-wrap"t>B<"datatable-footer"ipl>',
    language: {
        paginate: {
            'next': '<i class="icon-arrow-right15"></i>',
            'previous': '<i class="icon-arrow-left15"></i>'
        }
    },
    pagingType: 'listbox',
};
$(document).ready(function () {
    var columns = [];
    $('.column th').each(function () {
        columns.push({
            data: $(this).attr('data-data')
        });
    });
    table_config.columns = columns;
    var table = $('#table').DataTable(table_config);
    $('.buttons-colvis').detach().appendTo('#action');
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
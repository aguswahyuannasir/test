$(document).ready(function () {
    $('body').on('click', '.view-invoice', function (e) {
        e.preventDefault();
        var invoice_url = $(this).attr('href');

        $('#content-detail').removeClass('hidden');
        $('#content-detail').load(invoice_url);

        $('#table').DataTable().clear().destroy();
        table_config.aoColumnDefs = [
            {
                render: function (data, type, row) {
                    return '<div class="list-primary"><span class="float-right text-right">'+row[5]+'</span><div class="name">'+row[3]+'</div></div><div class="list-secondary"><span class="float-right text-right text-muted">'+data+'</span>'+row[1]+'</div>';
                },
                targets: 0
            }, {
                visible: false,
                targets: [1,2,3,4,5,6,7]
            }
        ];
        table_config.sDom = '<"datatable-scroll"t><"datatable-footer"pl>';
        $('#table').DataTable(table_config);
        $('#table thead').hide();
        $('.dataTables_length').addClass('ml-0').addClass('float-left');
    });
    $('body').on('click', '#exit-view-invoice', function () {
        $('#table').DataTable().clear().destroy();
        table_config.aoColumnDefs = [{
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
    ];
        table_config.sDom = '<"datatable-scroll-wrap"t>B<"datatable-footer"ipl>';
        $('#table').DataTable(table_config);
        $('.buttons-colvis').detach().appendTo('#action');
        $('#table thead').show();
        $('.dataTables_length').removeClass('ml-0').removeClass('float-left');
        $('#content-detail').addClass('hidden');
        $('#content-detail').html('');
    });

});
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
        url: $('#table_invoice2').attr('data-url'),
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
        // [$('th.default-sort').index(), $('th.default-sort').attr('data-sort')]
        [7,"desc"]
    ],
    orderCellsTop: true,
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
    initLoad(invoice_url);
    $('body').on('click', '.view-invoice', function (e) {
        e.preventDefault();
        var invoice_url = $(this).attr('href');
        showDetail(invoice_url);
    });
    $('.dataTable').on('click', 'tbody tr', function() {
        var data =  $('#table_invoice2').DataTable().row(this).data()
        invoice_url = base_url+'sale/invoices/detail/'+data[8]
        showDetail(invoice_url);
      })
    $('body').on('click', '#exit-view-invoice', function () {
        loadTable();
    });
});

function initLoad(invoice_url){
    //$('#content-table').html();
    if(last_id){
        showDetail(invoice_url);
    }else{
        loadTable();
    }
    $('#content-table').show();
    //$('#content-table').removeClass('hidden');
}
function showDetail(invoice_url){
    $("#content-detail").html('<div style="width:100%; text-align:center;"><img width="100px;" src="/app/assets/images/loading-block.gif"></div>');
    if (last_id != "") {
        $('#table_invoice2').DataTable().clear().destroy();
        table_config.aoColumnDefs = [
            {
                render: function (data, type, row) {
                    return '<div id="list-data-'+row[8]+'" class="list-dt" style="width:100%; cursor:pointer;">\
                        <div class="list-primary">\
                            <span class="float-right text-right">'+row[5]+'</span>\
                            <div class="name">'+row[3]+'</div>\
                        </div>\
                        <div class="list-secondary">\
                            <span class="float-right text-right text-muted">'+data+'</span>'+row[1]+'\
                        </div>\
                    </div>';

                },
                targets: 0
            }, {
                visible: false,
                targets: [1,2,3,4,5,6,7, 8]
            }
        ];

        table_config.sDom = '<"datatable-scroll"t><"datatable-footer"pl>';
        $('#table_invoice2').DataTable(table_config);
        $('#table_invoice2 thead').hide();
        $('.datatable-footer').addClass('fixed_bottom');
        $('.dataTables_length').addClass('ml-0').addClass('float-left');

        // Redeclare last_id
        last_id = "";
    }
    

    setTimeout(function() {
        $('#content-detail').removeClass('hidden');
        $('#content-detail').load(invoice_url);
    }, 100);
}

function loadTable_old(){
    $('#table_invoice2').DataTable().clear().destroy();
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
    last_id = "ok";
    table_config.aoColumnDefs = [{
        visible:false,
        targets:[8]
    }];
    table_config.sDom = '<"datatable-scroll-wrap"t>B<"datatable-footer"ipl>';
    $('#table_invoice2').DataTable(table_config);
    $('.buttons-colvis').detach().appendTo('#action');
    $('#table_invoice2 thead').show();
    $('.dataTables_length').removeClass('ml-0').removeClass('float-left');
    $('#content-detail').addClass('hidden');
    $('.datatable-footer').removeClass('fixed_bottom');
    $('#content-detail').html('');
}

function loadTable(){
    $('#table_invoice2').DataTable().clear().destroy();
    table_config.aoColumnDefs = [
        {
            render: function (data, type, row) {
                return '<div id="list-data-'+row[8]+'" class="list-dt" style="width:100%; cursor:pointer;">\
                    <div class="list-primary">\
                        <span class="float-right text-right">'+row[5]+'</span>\
                        <div class="name">'+row[3]+'</div>\
                    </div>\
                    <div class="list-secondary">\
                        <span class="float-right text-right text-muted">'+data+'</span>'+row[1]+'\
                    </div>\
                </div>';

            },
            targets: 0
        }, {
            visible: false,
            targets: [1,2,3,4,5,6,7, 8]
        }
    ];

    table_config.sDom = '<"datatable-scroll"t><"datatable-footer"pl>';
    $('#table_invoice2').DataTable(table_config);
    $('#table_invoice2 thead').hide();
    $('.datatable-footer').addClass('fixed_bottom');
    $('.dataTables_length').addClass('ml-0').addClass('float-left');

    // Redeclare last_id
    last_id = "";
}

function viewhistory(_parameter){
    //alert(_parameter);
    $("#history-result").fadeOut('fast', function() {
        $("#loading-history").fadeIn('fast', function() {
            $("#invoice-history-modal").modal("show");
            $.ajax({
                url: base_url+'sale/invoices/getHistory/',
                type: 'GET',
                dataType: 'html',
                data: {_parameter: _parameter},
                async: true,
                processData: true
            })
            .done(function(e) {
                $("#loading-history").fadeOut('fast', function() {
                    $("#history-result").fadeIn('fast', function() {
                        $("#history-result").html(e);
                    });
                });
            })
            .fail(function() {
                $("#loading-history").fadeOut('fast', function() {
                    $("#history-result").fadeIn('fast', function() {
                        alert("Something went wrong.");     
                    });
                });
            })
            .always(function() {
                console.log("complete");
            });
        });
    });    
}

function viewhistoryTab(_parameter){
    alert(_parameter);
}

function viewpaymentHistory(_parameter){
    $("#history-payment-result").fadeOut('fast', function() {
        $("#loading-payment-history").fadeIn('fast', function() {
            $("#invoice-payment-history-modal").modal("show");
            $.ajax({
                url: base_url+'sale/invoices/getPaymentHistory/',
                type: 'GET',
                dataType: 'html',
                data: {_parameter: _parameter},
                async: true,
                processData: true
            })
            .done(function(e) {
                $("#loading-payment-history").fadeOut('fast', function() {
                    $("#history-payment-result").fadeIn('fast', function() {
                        $("#history-payment-result").html(e);
                    });
                });
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            
        });
    });
}
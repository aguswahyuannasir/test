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
        url: $('#table_inv_quote_list').attr('data-url'),
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
        [6,"desc"]
    ],
    orderCellsTop: true,
    dom: '<"datatable-scroll-wrap"t>B<"datatable-footer"ipl>',
    language: {
        paginate: {
            'next': '<i class="icon-arrow-right15"></i>',
            'previous': '<i class="icon-arrow-left15"></i>'
        }
    },
    pagingType: 'listbox'
};



$(document).ready(function () {
    initLoad(detail_url);
    $('body').on('click', '.view-invoice', function (e) {
        e.preventDefault();
        var detail_url = $(this).attr('href');
        showDetail(detail_url);
    });
    $('.dataTable').on('click', 'tbody tr', function() {
        var data =  $('#table_inv_quote_list').DataTable().row(this).data()
        detail_url = base_url+'sale/quotes/detail/'+data[6]
        showDetail(detail_url);
    })
    $('body').on('click', '#exit-view-invoice', function () {
        loadTable();
    });
});

function initLoad(order_url){
    //$('#content-table').html();
    if(last_id){
        showDetail(order_url);
    }else{
        loadTable();
    }
    $('#content-table').show();
    //$('#content-table').removeClass('hidden');
}

function showDetail(order_url){
    $("#content-detail").html('<div style="width:100%; text-align:center;"><img width="100px;" src="/app/assets/images/loading-block.gif"></div>');
    if (last_id != "") {
        $('#table_inv_quote_list').DataTable().clear().destroy();
        table_config.aoColumnDefs = [
            {
                render: function (data, type, row) {
                    return '<div id="list-data-'+row[6]+'" style="width:100%; cursor:pointer;" conclick>\
                        <div class="list-primary">\
                            <span class="float-right text-right">'+row[4]+'</span>\
                        <div class="name">'+row[2]+'</div>\
                        </div>\
                        <div class="list-secondary">\
                            <span class="float-right text-right text-muted">'+row[0]+'</span>'+row[1]+'\
                        </div>\
                    </div>';
                },
                targets: 0
            }, {
                visible: false,
                targets: [1,2,3,4,5,6]
            }
        ];

        table_config.sDom = '<"datatable-scroll"t><"datatable-footer"pl>';

        $('#table_inv_quote_list').DataTable(table_config);
        $('#table_inv_quote_list thead').hide();

        $('.datatable-footer').addClass('fixed_bottom');
        $('.dataTables_length').addClass('ml-0').addClass('float-left');
        
        // Redeclare last_id
        last_id = "";
    }
    

    setTimeout(function() {
        $('#content-detail').removeClass('hidden');
        $('#content-detail').load(order_url);
    }, 100);
}

function loadTable_old(){
    $('#table_inv_quote_list').DataTable().clear().destroy();
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
        targets:[6]
    }];
    table_config.sDom = '<"datatable-scroll-wrap"t>B<"datatable-footer"ipl>';
    $('#table_inv_quote_list').DataTable(table_config);
    $('.buttons-colvis').detach().appendTo('#action');
    $('#table_inv_quote_list thead').show();
    $('.dataTables_length').removeClass('ml-0').removeClass('float-left');
    $('#content-detail').addClass('hidden');
    $('.datatable-footer').removeClass('fixed_bottom');
    $('#content-detail').html('');
}

function loadTable(){
    $('#table_inv_quote_list').DataTable().clear().destroy();
    table_config.aoColumnDefs = [
        {
            render: function (data, type, row) {
                return '<div id="list-data-'+row[6]+'" style="width:100%; cursor:pointer;" conclick>\
                    <div class="list-primary">\
                        <span class="float-right text-right">'+row[4]+'</span>\
                    <div class="name">'+row[2]+'</div>\
                    </div>\
                    <div class="list-secondary">\
                        <span class="float-right text-right text-muted">'+row[0]+'</span>'+row[1]+'\
                    </div>\
                </div>';
            },
            targets: 0
        }, {
            visible: false,
            targets: [1,2,3,4,5,6]
        }
    ];

    table_config.sDom = '<"datatable-scroll"t><"datatable-footer"pl>';

    $('#table_inv_quote_list').DataTable(table_config);
    $('#table_inv_quote_list thead').hide();

    $('.datatable-footer').addClass('fixed_bottom');
    $('.dataTables_length').addClass('ml-0').addClass('float-left');
    
    // Redeclare last_id
    last_id = "";
}

function viewhistory(_parameter){
    //alert(_parameter);
    $("#history-result").fadeOut('fast', function() {
        $("#loading-history").fadeIn('fast', function() {
            $("#quotes-history-modal").modal("show");
            $.ajax({
                url: base_url+'sale/quotes/getHistory/',
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
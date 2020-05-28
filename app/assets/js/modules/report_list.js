var filter = {};
var table_config = {
    responsive: {
        details: {
            type: 'column'
        }
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: $('#table-report').attr('data-url'),
        type: 'post',
        data: function (d) {
            $('#filter input').each(function () {
                filter[$(this).attr("name")] = $(this).val();
            });
            d.filter = filter;
            return d;
        }
    },
    searching: false,
    pageLength: 101,
    dom: '<"datatable-scroll"t><"datatable-footer"ip>',
};
$(document).ready(function () {
    $('#filter-submit').click(function (e) {
        e.preventDefault;
        $('#' + table_el).DataTable().ajax.reload();
    });
});
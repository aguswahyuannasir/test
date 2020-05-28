$(function () {
    table_config.footerCallback = function (tfoot, data, start, end, display) {
        var response = this.api().ajax.json();
        if (response.total) {
            console.log(response.total);
            $(tfoot).removeClass('d-none');
            var $th = $(tfoot).find('th');
            $th.eq(0).html('');
            $th.eq(1).html('');
            $th.eq(2).html('');
            $th.eq(3).html(response.total);
        }else{
            $(tfoot).addClass('d-none');
        }
    }
    var table = $('#' + table_el).DataTable(table_config);
});
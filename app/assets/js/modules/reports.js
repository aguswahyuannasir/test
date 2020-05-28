$(document).ready(function () {
    if ($('#period').length > 0) {
        $('#period').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: moment(),
            endDate: moment(),
            dateLimit: {days: 60},
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right',
            applyButtonClasses: 'btn-sm bg-slate',
            cancelButtonClasses: 'btn-sm btn-light',
//        }, function (start, end, label) {
//            $('#period').html(label);
//            $('#from').val(start.format('YYYY-MM-DD'));
//            $('#to').val(end.format('YYYY-MM-DD'));
        });
    }
});
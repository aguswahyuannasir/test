var config_validate = {
    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
    errorClass: 'validation-invalid-label',
    successClass: 'validation-valid-label',
    validClass: 'validation-valid-label',
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
        $(element).closest('.form-group').removeClass('has-error');
    },
    // Different components require proper error label placement
    errorPlacement: function (error, element) {
        //            console.log(error);
        //            console.log(element);
        //            error_message('Please')
        // Unstyled checkboxes, radios
        if (element.parents().hasClass('form-check')) {
            error.appendTo(element.parents('.form-check').parent());
        }

        // Input with icons and Select2
        else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
            error.appendTo(element.parent());
        }

        // Input group, styled file input
        else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
            error.appendTo(element.parent().parent());
        }

        // Other elements
        else {
            error.insertAfter(element);
        }
    },
    //        showErrors: function (errorMap, errorList) {
    //            console.log(errorMap);
    //            console.log(errorList);
    //            console.log('error');
    ////            $("#summary").html("Your form contains "
    ////                    + this.numberOfInvalids()
    ////                    + " errors, see details below.");
    ////            this.defaultShowErrors();
    //        },
    success: function (label) {
        label.remove();
        label.closest('.form-group').removeClass('has-error');
    },
    //        rules: rules_form,
    //        messages: messages_form,
    submitHandler: function (form) {
        if ($(form).hasClass('no-ajax')) {
            if ($(form).hasClass('target-blank')) {
                $(form).attr('target', "javascript:window.open('','targetNew')")
            }
            $('#form')[0].submit();
        } else {
            $(form).ajaxSubmit({
                success: function (data) {
                    response_form(data);
                }
            });
            return false;
        }
    }
};
$(document).ready(function () {
    //    $(".styled").uniform({
    //        radioClass: 'choice'
    //    });
    //uniform
    $('.styled').uniform({
        //        fileButtonClass: 'action btn bg-blue'
    });

    //select2
    $('.select2').select2();
    $('.select2-with-clear').select2({
        placeholder: '',
        allowClear: true,
        debug: true
    });

    //number
    //    $('.number').number(true, decimal_digit, decimal_separator, thousand_separator);
    //    $('.number').attr('autocomplete', 'off');

    //datepicker
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $("#form").validate(config_validate);
});

function money(amount) {
    return curr_prefix + $.number(amount, curr_decimal_digit, curr_decimal_separator, curr_thousand_separator) + curr_suffix;
}
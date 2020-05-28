<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class Template {

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function _init($template = 'default') {
        $this->ci->output->set_template($template);
        /*===== START CSS =====*/
        $this->ci->load->css('assets/main/css/bootstrap.min.css');
        // $this->ci->load->css('app/assets/css/bootstrap_limitless.min.css');
        $this->ci->load->css('assets/main/css/app.css');
        $this->ci->load->css('assets/main/css/styles.css');
        $this->ci->load->css('assets/main/css/light_blue.css');
        $this->ci->load->css('app/assets/fontawesome/css/all.css');


        $this->ci->load->css('assets/main/js/daterangepicker/daterangepicker.css');
        $this->ci->load->css('assets/main/css/components.min.css');
        $this->ci->load->css('app/assets/css/icons/icomoon/styles.min.css');

        $this->ci->load->css('assets/main/css/main_custom.css');

        
        /*===== START JS =====*/
        $this->ci->load->js('app/assets/js/core/libraries/jquery.min.js');
        $this->ci->load->js('assets/main/js/bootstrap.min.js');
        // $this->ci->load->js('assets/main/js/moment.min.js');
        $this->ci->load->js('assets/main/js/daterangepicker/moment.min.js');
        $this->ci->load->js('assets/main/js/daterangepicker/daterangepicker.js');


        $this->ci->load->js('app/assets/js/plugins/tables/datatables/datatables.min.js');
        $this->ci->load->js('app/assets/js/plugins/tables/datatables/extensions/buttons.min.js');
        $this->ci->load->js('app/assets/js/plugins/tables/table.js');
        $this->ci->load->js('app/assets/js/plugins/forms/datepicker.min.js');

        $this->ci->load->js('app/assets/js/plugins/forms/jquery.form.min.js');
        $this->ci->load->js('app/assets/js/plugins/forms/uniform.min.js');
        $this->ci->load->js('app/assets/js/plugins/forms/select2.min.js');
        $this->ci->load->js('app/assets/js/plugins/forms/validation/validate.min.js');
        $this->ci->load->js('app/assets/js/plugins/forms/form.js');
        $this->ci->load->js('app/assets/js/plugins/sweetalert.min.js');

        /*$this->ci->load->js('assets/main/js/app.js');*/
    }

    public function auth() {
        $this->ci->output->set_template('auth');

        $this->ci->load->css('assets/auth/css/bootstrap.min.css');
        $this->ci->load->css('assets/auth/css/styles.css');
        $this->ci->load->css('assets/auth/css/responsive.css');

        $this->ci->load->js('assets/auth/js/vendors/jquery.min.js');
        $this->ci->load->js('assets/auth/js/vendors/bootstrap.bundle.min.js');
        $this->ci->load->js('assets/auth/js/custom.js');
    }

    public function form() {
        $this->ci->load->css('assets/css/datepicker.min.css');
        $this->ci->load->css('assets/js/plugins/forms/bootstrap-fileinput/bootstrap-fileinput.css');
//        $this->ci->load->css('assets/css/plugins/jquery.timepicker.min.css');

        $this->ci->load->js('assets/js/plugins/forms/uniform.min.js');
        $this->ci->load->js('assets/js/plugins/forms/jquery.number.min.js');
        $this->ci->load->js('assets/js/plugins/forms/tinymce/tinymce.min.js');
        // $this->ci->load->js('assets/js/plugins/forms/select2.min.js');
//        $this->ci->load->js('assets/js/plugins/forms/tagsinput.min.js');
//        $this->ci->load->js('assets/js/plugins/forms/bootstrap-typeahead.min.js');
//        $this->ci->load->js('assets/js/plugins/forms/styling/switch.min.js');
//        $this->ci->load->js('assets/js/plugins/forms/pickadate/picker.js');
//        $this->ci->load->js('assets/js/plugins/forms/pickadate/picker.date.js');
//        $this->ci->load->js('assets/js/plugins/forms/pickadate/legacy.js');
//        $this->ci->load->js('assets/js/plugins/forms/daterangepicker.js');
        $this->ci->load->js('assets/js/plugins/forms/validation/validate.min.js');
        $this->ci->load->js('assets/js/plugins/forms/jquery.form.min.js');
        $this->ci->load->js('assets/js/plugins/forms/datepicker.min.js');
//        $this->ci->load->js('assets/js/plugins/forms/jquery.timepicker.min.js');
        $this->ci->load->js('assets/js/plugins/forms/uniform.min.js');
        $this->ci->load->js('assets/js/plugins/forms/bootstrap-fileinput/bootstrap-fileinput.js');
        $this->ci->load->js('assets/js/plugins/forms/form.js');
    }

}

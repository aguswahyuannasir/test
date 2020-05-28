<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><?php echo lang('heading'); ?></h4>
        </div>

        <div class="header-elements d-none text-center text-md-left mb-3 mb-md-0">
            <?php echo $btn_option; ?>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <?php $this->load->view('default/table'); ?>
    </div>
</div>
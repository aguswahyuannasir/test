<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><?php echo ($data ? lang('edit') : lang('add')) . ' ' . lang('heading'); ?></h4>
        </div>

        <div class="header-elements d-none text-center text-md-left mb-3 mb-md-0">
            <a href="<?php echo $module_url; ?>" class="btn bg-grey"><?php echo lang('back_w_icon'); ?></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <form id="form" action="<?php echo $form['action']; ?>" method="post" enctype="multipart/form-data">
                <?php echo $form['build']; ?>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="<?php echo $module_url; ?>" class="btn btn-light"><?php echo lang('cancel_w_icon'); ?></a>
                    <button type="submit" class="btn btn-primary ml-3"><?php echo lang('save_w_icon'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
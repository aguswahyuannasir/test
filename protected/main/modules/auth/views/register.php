<div class="ui-container ui-small">
    <div class="mb-50">
        <h3>Feel the greatness </h3>
        <p>Hiss and stare at nothing then run suddenly away. Lick human with sandpaper.</p>
    </div>

    <?php if ($error) { ?>
        <div class="alert alert-danger ks-solid ks-active-border">
            <button class="close" data-dismiss="alert">
                ×
            </button>
            <i class="fa-fw fa fa-times"></i>
            <?php echo $error_message; ?>
        </div> 
    <?php } else { ?>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success ks-solid ks-active-border">
                <button class="close" data-dismiss="alert">
                    ×
                </button>
                <i class="fa-fw fa fa-times"></i>
                <?php echo $success_message; ?>
            </div> 
        <?php } ?>
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label><?php echo lang('name'); ?></label>
            <input type="text" name="name" class="form-control" placeholder="Alex Smith">
        </div>
        <div class="form-group">
            <label><?php echo lang('email'); ?></label>
            <input type="email" name="email" class="form-control" placeholder="your@email.com">
        </div>

        <div class="form-group">
            <label><?php echo lang('password'); ?></label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <label><?php echo lang('confirm_password'); ?></label>
            <input type="password" name="confpassword" class="form-control" placeholder="Password confirmation">
        </div>
        <div class="form-group">
            <button class="btn btn-primary w-100 form-button" type="submit">Get Started</button>
        </div>
    </form>

    <div class="text-center">
        <span>Already have an account?
            <a href="<?php echo site_url('login'); ?>">Login</a>
        </span>
    </div>

</div>
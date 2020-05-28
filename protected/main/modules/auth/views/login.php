<div class="ui-container ui-small">
    <?php if ($error) { ?>
        <div class="alert alert-danger ks-solid ks-active-border">
            <button class="close" data-dismiss="alert">
                ×
            </button>
            <i class="fa-fw fa fa-times"></i>
            <?php echo lang('login_error'); ?>
        </div> 
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="identity" class="form-control" placeholder="your@email.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="password">
<!--            <a href="reset.html" class="form-help">
                Forgot password?
            </a>-->
        </div>
        <div class="form-group">
            <button class="btn btn-primary w-100 form-button" type="submit">Login</button>
        </div>
    </form>

    <div class="text-center">
        <span>Don't have account?
            <a href="<?php echo site_url('register'); ?>">Signup for free</a>
        </span>
    </div>

</div>
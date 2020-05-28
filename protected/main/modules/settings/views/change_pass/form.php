<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php if (isset($error)) { ?>
              <div class="alert alert-danger">
                  <?php echo $error_msg; ?>
              </div> 
          <?php } ?>
            <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center"><?php echo lang('change_pass'); ?></h3>
                    <div class="hr-line-dashed"></div>
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required="">
                        </div>

                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" class="form-control" name="password_conf" required="">
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
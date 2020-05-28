<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center"><?php echo lang('add_organization'); ?></h3>
                    <div class="hr-line-dashed"></div>
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="name" required="">
                        </div>
                        <div class="form-group">
                            <label>Package</label>
                            <select class="form-control" name="package" required="">
                                <option value="">Select Package</option>
                                <?php 
                                if($packages) {
                                    foreach($packages as $package) {
                                    // if($package->price == 0) {
                                    //     $pricing = 'Free';
                                    // } else {
                                        $pricing = rupiah($package->price);
                                    //}
                                    ?>
                                    <option value="<?php echo $package->package_id?>"><?php echo $package->package_name.' - '.$pricing;?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
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
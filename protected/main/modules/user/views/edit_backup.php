<div class="col-md-12">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="content-box-header">
        <div class="panel-title">Edit User</div>
        <div class="panel-options">
            
        </div>
    </div>
    <div class="content-box box-with-header box-with-footer">
        <form class="form-horizontal" role="form" method="POST" action="/doupdate-user">
        	<div class="panel-body">
                    <input type="hidden" name="parameter" value="<?= isset($_GET['parameter'])?$_GET['parameter']:''; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="user_name" class="form-control" placeholder="Name" required="" value="<?= $userData->fullname ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="text" name="user_email" class="form-control" placeholder="Email" required="" value="<?= $userData->email ?>">
                            <input type="hidden" name="current_email" class="form-control" placeholder="Email" required="" value="<?= $userData->email ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" name="user_password" class="form-control" placeholder="Password">
                            *) Fill form above to change password
                        </div>
                    </div>
        	</div>
            <div class="panel-body" style="border-top: 1px solid #ccc;">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Organization</label>
                    <div class="col-sm-10">
                        <!-- <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                            <label class="custom-control-label" for="customControlAutosizing">Remember my preference</label>
                        </div> -->
                        <?php foreach ($list_org as $lkey => $lvalue) { ?>
                            <div class="checkbox ">
                                <label>
                                    <input type="checkbox" name="org[]" value="<?= $lvalue->id ?>" <?= isset($insOrg[$lvalue->id]) ? "checked":""; ?>> <?= $lvalue->name; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="border-top: 1px solid #ccc;">
                <h5 style="margin-left: -15px;">
                    Custom Organization Previlage<br>
                    <!-- <button type="button" class="btn btn-primary btn-sm" id="alllowall">Allow All Permission</button> -->
                </h5>
                <div class="form-group">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>
                                    <input type="checkbox" id="alllowall">
                                    Permission
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_listmodule as $ukey => $uvalue) { ?>
                                <?php if($uvalue->is_parent == 1){ ?>
                                    <tr>
                                        <td colspan="2" style="background-color: #ecf0f1;"><b><?= $uvalue->module_name; ?></b></td>
                                    </tr>
                                    <?php foreach ($uvalue->child as $skey => $svalue) { ?>
                                        <?php if ($svalue->is_parent == 1) { ?>
                                            <tr>
                                                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $svalue->sub_name; ?></b></td>
                                            </tr>
                                            <?php foreach ($svalue->child as $sckey => $scvalue) { ?>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $scvalue->sub_name; ?></td>
                                                    <td>
                                                        <div class="checkbox ">
                                                            <label>
                                                                <input type="checkbox" class="checkpermission" name="module_sub[<?= $uvalue->id ?>][<?= $svalue->id ?>][<?= $scvalue->id ?>]" value="" <?= isset($insSub[$svalue->id]) ? "checked":""; ?>> Allow
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?= $svalue->sub_name; ?></td>
                                                <td>
                                                    <div class="checkbox ">
                                                        <label>
                                                            <input type="checkbox" class="checkpermission" name="module_sub[<?= $uvalue->id ?>][<?= $svalue->id ?>]" value="" <?= isset($insSub[$svalue->id]) ? "checked":""; ?>> Allow
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <tr>
                                        <td><b><?= $uvalue->module_name ?></b></td>
                                        <td>
                                            <div class="checkbox ">
                                                <label>
                                                    <input type="checkbox" class="checkpermission" name="module[<?= $uvalue->id ?>]" value="" <?= isset($insModule[$uvalue->id]) ? "checked":""; ?>> Allow
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-action">
                    <div class="row">
                        <button class="btn btn-primary">Save</button>
                    </div>  
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#alllowall").click(function(event) {
        if ($(this).prop("checked")) {
            $(".checkpermission").prop('checked',true);
        }else{
            $(".checkpermission").prop('checked',false);
        }
    });
    $(".checkpermission").click(function(event) {
        if (!$(this).prop("checked")) {
            $("#alllowall").prop('checked',false);
        }
    });
</script>
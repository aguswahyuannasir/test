<div class="col-md-12">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="content-box-header">
        <div class="panel-title">Edit Invited User Permission</div>
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
                        <input type="text" name="" class="form-control" placeholder="Name" required="" value="<?= $userData->fullname ?>" disabled="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-5">
                        <input type="text" name="" class="form-control" placeholder="Email" required="" value="<?= $userData->email ?>" disabled="">
                    </div>
                </div>
        	</div>
            <hr>
            <div class="to-show" id="div-org">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php foreach ($list_org as $lkey => $lvalue) { ?>
                        <li class="nav-item <?= ($lkey == 0)? 'active':''; ?>">
                            <a class="nav-link" id="<?= encode($lvalue->id); ?>-tab" data-toggle="tab" href="#tabs_<?= encode($lvalue->id); ?>" role="tab" aria-selected="true">
                                <i class="fa fa-check ds-none" style="color: #27ae60;" id="checklist_<?= encode($lvalue->id); ?>"></i><?= $lvalue->name; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php foreach ($list_org as $ltkey => $ltvalue) { ?>
                        <div class="tab-pane fade <?= ($ltkey == 0)? 'active in':''; ?>" id="tabs_<?= encode($ltvalue->id); ?>" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group">
                                <br>
                                <div class="col-md-6" style="margin-left: 10px;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check-assign" id="org_<?= encode($ltvalue->id); ?>" name="org[<?= encode($ltvalue->id); ?>]" value="<?= $ltvalue->id ?>">
                                        <label class="custom-control-label" for="org_<?= encode($ltvalue->id); ?>">Assign to this organization</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group ds-none" id="custom_org_<?= encode($ltvalue->id); ?>">
                                <div class="col-md-12">
                                    <h5 style="">Custom Organization Previlage <br><br></h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Module Name</th>
                                                <th>
                                                    <input type="checkbox" onClick="allowall('<?= encode($ltvalue->id); ?>')" id="allowall_<?= encode($ltvalue->id) ?>">
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
                                                                                <input type="checkbox" class="checkpermission_<?= encode($ltvalue->id); ?>" name="module_sub[<?= encode($ltvalue->id); ?>][<?= $uvalue->id ?>][<?= $svalue->id ?>][<?= $scvalue->id ?>]" value="" <?= isset($insSub[$ltvalue->id][$svalue->id]) ? "checked":""; ?> > Allow
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
                                                                            <input type="checkbox" class="checkpermission_<?= encode($ltvalue->id); ?>" name="module_sub[<?= encode($ltvalue->id); ?>][<?= $uvalue->id ?>][<?= $svalue->id ?>]" value="" <?= isset($insSub[$ltvalue->id][$svalue->id]) ? "checked":""; ?> > Allow
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
                                                                    <input type="checkbox" class="checkpermission_<?= encode($ltvalue->id); ?>" name="module[<?= encode($ltvalue->id); ?>][<?= $uvalue->id ?>]" value=""> Allow
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body" style="border-top: 1px solid #ccc;">
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
    $(document).ready(function() {
        setTimeout(function() {
            <?php foreach ($insOrg as $inkey => $invalue) { ?>
                $("#org_<?= encode($inkey); ?>").click();
            <?php } ?>
        }, 500);
    });
</script>

<script type="text/javascript">
    $(".check-assign").click(function(event) {
        var _orgparam = $(this).attr('id');
        _orgparam = _orgparam.replace("org_",'');
        if ($(this).prop("checked")) {
            $("#checklist_"+_orgparam).fadeIn('fast', function() {});
            $("#custom_org_"+_orgparam).fadeIn('fast', function() {});
        }else{
            $("#checklist_"+_orgparam).fadeOut('fast', function() {});
            $("#custom_org_"+_orgparam).fadeOut('fast', function() {});
        }
    });

    function allowall(_parameter){
        if ($("#allowall_"+_parameter).prop("checked")) {
            $(".checkpermission_"+_parameter).prop('checked',true);
        }else{
             $(".checkpermission_"+_parameter).prop('checked',false);
        }
    }
    
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
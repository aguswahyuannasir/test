<div class="col-md-12">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="content-box-header">
        <div class="panel-title">Add User</div>
        <div class="panel-options">
        
        </div>
    </div>
    <div class="content-box box-with-header box-with-footer">
        <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url('user/doadd/');?>">
        	<div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="text" name="user_email" class="form-control" placeholder="Email" required="" id="input-email">
                            <div style="margin-top: 5px; display: none;" id="loading-check-email">
                                <i class="fas fa-spinner fa-spin"></i> checking email, please wait.
                            </div>
                            <div class="alert alert-success" role="alert" style="margin-top: 5px; margin-bottom: 0px; display: none;" id="result-check-email">
                              This is a success alert—check it out!
                            </div>
                        </div>
                    </div>

                    <div class="form-group to-show ds-none">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="user_name" class="form-control" placeholder="Name" required="">
                        </div>
                    </div>
                    
                    <div class="form-group to-show ds-none">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" name="user_password" class="form-control" placeholder="Password" required="">
                        </div>
                    </div>

                    <div class="form-group to-show ds-none">
                        <label class="col-sm-2 control-label">User Group</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="usr_group" id="usr_group" required="">
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                                                            
                            </select>
                        </div>
                    </div>

    


        	</div>
            <div class="to-show ds-none" id="div-org">
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
                                                                                <input type="checkbox" class="checkpermission_<?= encode($ltvalue->id); ?>" name="module_sub[<?= encode($ltvalue->id); ?>][<?= $uvalue->id ?>][<?= $svalue->id ?>][<?= $scvalue->id ?>]" value=""> Allow
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
                                                                            <input type="checkbox" class="checkpermission_<?= encode($ltvalue->id); ?>" name="module_sub[<?= encode($ltvalue->id); ?>][<?= $uvalue->id ?>][<?= $svalue->id ?>]" value=""> Allow
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

            <div class="panel-body ds-none" style="border-top: 1px solid #ccc; display: none;">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Organization</label>
                    <div class="col-sm-10">
                        <!-- <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                            <label class="custom-control-label" for="customControlAutosizing">Remember my preference</label>
                        </div> -->
                        <!-- <?php foreach ($list_org as $lkey => $lvalue) { ?>
                            <div class="checkbox ">
                                <label>
                                    <input type="checkbox" name="org[]" value="<?= $lvalue->id ?>" <?= ($default_org == $lvalue->id)?"checked":''; ?>> <?= $lvalue->name; ?>
                                </label>
                            </div>
                        <?php } ?> -->
                    </div>
                </div>
            </div>
            <div class="panel-body to-show ds-none" style="border-top: 1px solid #ccc;">
                <div class="form-action">
                    <div class="row">
                        <button class="btn btn-primary">Save</button>
                    </div>  
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="invitationmodal" tabindex="-1" role="dialog" aria-labelledby="invitationmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="invitation-form" action="<?= site_url('user/sendInvitation'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display: inline-block;">INVITATION</h5>
                    <button type="button" class="close close_confirm" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email_invitation" id="invite-email" required="">
                            <small id="sm-1" class="ds-none tohide">
                                <div style="margin-top: 10px;">
                                    <i class="fas fa-spinner fa-spin"></i> Please wait, Checking email availability.
                                </div>
                            </small>
                            <small id="sm-2" class="ds-none tohide">
                                <div style="margin-top: 10px;" class="alert alert-danger" role="alert" id="msg_invitation">This is a danger alert—check it out!</div>
                            </small>
                        </div>
                        <div class="form-group" id="additional_invitation">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="loading-confirmation" class="ds-none">
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-spinner fa-spin"></i> Sending Invitation
                        </button>
                    </div>
                    <div id="button-confirmation">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="send-invitation" href="#" type="submit" class="btn btn-primary" disabled=""><i class="fa fa-check" style="color: white;"></i>  Invite User</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if($default_org != ""){ ?>
<script type="text/javascript">
    var default_org = '<?= encode($default_org) ?>';
    $(document).ready(function() {
        $("#div-org").fadeIn('fast', function() {
            setTimeout(function() {
                $("#"+default_org+"-tab").click();
                setTimeout(function() {
                    $("#org_"+default_org).click();
                }, 300);
            }, 500);
            
        });
    });
</script>
<?php } ?>

<script type="text/javascript">
    $(".check-assign").click(function(event) {
        var _orgparam = $(this).attr('id');
        _orgparam = _orgparam.replace("org_",'');
        var usr_group = $("#usr_group").val();
        if ($(this).prop("checked")) {
            $("#checklist_"+_orgparam).fadeIn('fast', function() {});
            $("#custom_org_"+_orgparam).fadeIn('fast', function() {});
            if(usr_group == 'admin'){
                $("#allowall_"+_orgparam).prop('checked',true);
                $(".checkpermission_"+_orgparam).prop('checked',true);
            }else{
                
                $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][1][1]']").prop('checked',true);
                $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][2][3]']").prop('checked',true);
                $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][3][4]']").prop('checked',true);
                $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][3][5]']").prop('checked',true);

            }
        }else{
            $("#checklist_"+_orgparam).fadeOut('fast', function() {});
            $("#custom_org_"+_orgparam).fadeOut('fast', function() {});
        }

    });

    // $("#usr_group").change(function(event) {
    //     var usr_group = $("#usr_group").val();

    //     var record = $.map($(".check-assign:checked"),function(e,i){
    //         return e.id;
    //     });
    //     var _orgparam='';
    //     for (var i = 0; i < record.length; ++i) {
            
    //         _orgparam = record[i].replace("org_","");
    //         if ($("#org_"+_orgparam).prop("checked")) {
    //             $("#checklist_"+_orgparam).fadeIn('fast', function() {});
    //             $("#custom_org_"+_orgparam).fadeIn('fast', function() {});
    //             if(usr_group == 'admin'){
    //                 $("#allowall_"+_orgparam).prop('checked',true);
    //                 $(".checkpermission_"+_orgparam).prop('checked',true);
    //             }else{
                    
    //                 $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][1][1]']").prop('checked',true);
    //                 $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][2][3]']").prop('checked',true);
    //                 $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][3][4]']").prop('checked',true);
    //                 $("input[name='module_sub[WTE1UmZLVnhsRitYdmVxY1lJMTlJZz09][3][5]']").prop('checked',true);

    //             }
    //         }
    //         else{
    //             $("#checklist_"+_orgparam).fadeOut('fast', function() {});
    //             $("#custom_org_"+_orgparam).fadeOut('fast', function() {});
    //         }

    //     }
        
    // });

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

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    $("#input-email").change(delay(function(event) {
        if ($("#input-email").val() != "") {
            checkEmailUser();
        }
    }, 800));

    function checkEmailUser(){
        var _email = $("#input-email").val();
        $(".to-show").fadeOut('fast', function() {});
        $("#result-check-email").fadeOut('fast', function() {
            $("#loading-check-email").fadeIn("fast", function() {
                $.ajax({
                    url: site_url + 'user/checkEmailAdd',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {email: _email},
                    async: true
                })
                .done(function(e) {
                    console.log(e.status);
                    if (e.status == "OK") {
                        $(".to-show").fadeIn('fast', function() {});
                    }else{
                        $(".to-show").fadeOut('fast', function() {});
                        setTimeout(function() {
                            _init_invitation();
                        }, 100);
                    }
                    $("#result-check-email").removeClass().addClass(e.alert).html(e.message);
                    $("#loading-check-email").fadeOut('fast', function() {
                        $("#result-check-email").fadeIn('fast', function() {});
                    });
                })
                .fail(function() {
                    $("#result-check-email").removeClass().addClass('alert alert-danger').html("Something went wrong.!");
                    $("#loading-check-email").fadeOut('fast', function() {
                        $("#result-check-email").fadeIn('fast', function() {});
                    });
                })
                .always(function() {
                    console.log("complete");
                });
                
            });
        });
    }

    function small_switch(_hide_id, _show_id){
        $("#"+_hide_id).fadeOut('fast', function() {
            $("#"+_show_id).fadeIn('fast', function() {
            });
        });
    }

    $("#invite-email").keyup(delay(function(event) {
        if ($("#invite-email").val() != "") {
            checkEmail()
        }
    }, 800));

    function checkEmail(){
        var email_form = $("#invite-email").val();
        $("#send-invitation").attr('disabled', '');
        small_switch("sm-2", "sm-1");
        setTimeout(function() {
            $.ajax({
                url: site_url+"user/checkemailinvitation",
                type: 'GET',
                dataType: 'JSON',
                data: {email: email_form},
                async: true,
                processData: true
            })
            .done(function(e) {
                if (e.status == "OK") {
                    $("#msg_invitation").removeClass().addClass(e.alert).html(e.message);
                    $("#send-invitation").removeAttr('disabled');
                    $("#additional_invitation").html(e.additional);
                }else{
                    $("#send-invitation").attr('disabled', '');
                    $("#msg_invitation").removeClass().addClass(e.alert).html(e.message);
                    $("#additional_invitation").html(e.additional);
                }
                small_switch("sm-1","sm-2");
            })
            .fail(function() {
                $("#send-invitation").attr('disabled', '');
                small_switch("sm-1","sm-2")
            })
            .always(function() {
                console.log("complete");
            });
        }, 500);
    }
    function _init_invitation(){
        $("#sendInvite").click(function(event) {
            $("#invitationmodal").modal("show");
            $(".tohide").fadeOut('fast', function() {});
            $("#send-invitation").attr('disabled', '');
            $("#additional_invitation").html('');
            $("#invite-email").val($("#input-email").val());
            setTimeout(function() {
                if ($("#invite-email").val() != "") {
                    checkEmail()
                }
            }, 500);
            
        });
    }

    $(document).ready(function() {
        var $main_form = $('#invitation-form');
        var config_validate_invoice_main = config_validate;
        config_validate_invoice_main.submitHandler = function (form) {
            $("#button-confirmation").fadeOut('fast', function() {
                $("#loading-confirmation").fadeIn('fast', function() {
                    $(form).ajaxSubmit({
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status == "OK") {
                                swal("Success", data.message, "success");

                                setTimeout(function() {
                                    window.location.href = data.next_url;
                                }, 3000);
                            }else{
                                swal("Failed", data.message, "error");
                            }
                            $("#loading-confirmation").fadeOut('fast', function() {
                                $("#button-confirmation").fadeIn('fast', function() {});
                            });
                        },
                        error: function(data){
                            $("#loading-confirmation").fadeOut('fast', function() {
                                $("#button-confirmation").fadeIn('fast', function() {});
                            });
                            console.log("error");
                            swal("Failed","Something went wrong", "error");
                        }
                    });
                    return false;
                });
            });
        }
        $main_form.validate(config_validate_invoice_main); 
    });
</script>
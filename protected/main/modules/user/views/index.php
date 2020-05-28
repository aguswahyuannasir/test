<div class="col-md-12">
	<?php echo $this->session->flashdata('msg'); ?>
    <div class="content-box-header">
        <div class="panel-title">User Management</div>
        <div class="panel-options">
            
        </div>
    </div>
    <div class="content-box box-with-header">
    	<div class="panel-heading">
    		<div class="col-md-12">
    			<div class="form-group f-right">
		        	<a href="<?= base_url('add-user') ?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add User</a>
                    <button type="button" class="btn btn-success" id="sendInvite">
                        <i class="fa fa-envelope-open"></i> Send Invitation
                    </button>
		        </div>
    		</div>
    	</div>
    	<div class="panel-body">
            <h3>Personal Member</h3>
    		<table class="table table-bordered table-hover">
    			<thead>
    				<tr>
    					<th style="width: 1px;">No</th>
    					<th>Name</th>
    					<th>Email</th>
    					<th>Organizations</th>
    					<th></th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php $no=1; foreach ($listUser as $key => $value) { ?>
    					<tr>
    						<td><?= $no++; ?></td>
    						<td><?= $value->fullname ?></td>
    						<td><?= $value->email ?></td>
    						<td>
                                <ul>
    								<?php foreach ($value->listOrg as $zkey => $zvalue) { ?>
    									<li><?= $zvalue->name ?></li>
    								<?php } ?>
                                </ul>
    						</td>
    						<td>
    							<a href="<?= base_url('edit-user?parameter=').encode($value->id); ?>" class="btn btn-xs btn-primary" alt="Edit"><i class="glyphicon glyphicon-edit"></i></a>
    							<a href="<?= base_url('delete-user?parameter=').encode($value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" alt="Delete"><i class="glyphicon glyphicon-remove"></i></a>
    						</td>
    					</tr>
    				<?php } ?>
    			</tbody>
    		</table>
            <br>
            <br>
            <h3>Invitation Member</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organizations</th>
                        <th>Invited at</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no_inv = 1; foreach ($listInvited as $likey => $livalue) { ?>
                        <tr>
                            <td><?= $no_inv++ ?></td>
                            <td><?= $livalue->fullname ?></td>
                            <td><?= $livalue->email ?></td>
                            <td>
                                <ul>
                                    <?php foreach ($livalue->listOrg as $zxkey => $zxvalue) { ?>
                                        <li><?= $zxvalue->name ?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                            <td><?= date("d F Y, H:i", strtotime($livalue->invited_date)); ?></td>
                            <td>
                                <?php 
                                if ($livalue->status == 0) {
                                    echo '<span class="label label-info">Pending</span>';
                                }elseif($livalue->status == 1){
                                    echo '<span class="label label-success">Accepted</span>';
                                }else{
                                    echo '<span class="label label-danger">Revoked</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('edit-user?parameter=').encode('invited-'.$livalue->member_id); ?>" class="btn btn-primary btn-sm">Edit Access</a>
                                <a href="<?= base_url('revoke-user?parameter=').encode('invited-'.$livalue->invitation_id.'-'.$livalue->member_id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Revoke Access</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    	</div>
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

<script type="text/javascript">
    $("#sendInvite").click(function(event) {
        $("#invitationmodal").modal("show");
        $(".tohide").fadeOut('fast', function() {});
        $("#send-invitation").attr('disabled', '');
        $("#additional_invitation").html('');
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

    $("#send-invitation").click(function(event) {

    });
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
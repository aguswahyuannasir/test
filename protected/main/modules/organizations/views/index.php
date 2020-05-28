<?php 
    // Custom to populate JS
$listOrganizationsID=[]; 
?>
<div class="row">
    <div class="col-md-12">

        <div class="ibox float-e-margins">
            <div class="ibox-title ibox-title-main">
                
                <div class="col-md-2">
                    <label>Total Receivables</label>
                    
                </div>

                <div class="col-md-4">
                    <?php if($filter_org){ $i = 0; foreach($filter_org as $rs) { ?>
                        <input type="hidden" class="val_org" name="val_org[]" value="<?=$rs?>">
                    <?php $i++; };} ?>

                    <form id="form_org" method="post">
                    <select class="select2" id="filter_org" name="filter_org[]" required="" multiple>
                        <?php 
                        if($get_list_filter) {
                            foreach($get_list_filter as $key => $org) {
                            ?>
                            <option value="<?php echo $org->id?>"> <?php echo $org->name ?> </option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                    </form>
                </div>
                
            </div>
       
            <div class="container" style="margin: 0px;padding: 11px; display: flex;">
                <div class="col-md-2" style="border-right: 1px solid #ccc;">
                    <label style="color: #2ecc71;">Current</label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['current'],2,',','.' ); ?>
                    </div>
                </div>
                <div class="col-md-2" class="col-md-2" style="border-right: 1px solid #ccc;">
                    <label style="color: #3498db;">Draft</label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['draft'],2,',','.' ); ?>
                    </div>
                    
                </div>

                <div class="col-md-2">
                    <label style="color: #e67e22;">Overdue</label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['overdue'][0]['total'],2,',','.' ); ?>
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d;">1-15 days</div>
                </div>

                <div class="col-md-2">
                    <label></label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['overdue'][1]['total'],2,',','.' ); ?>
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d;">16-30 days</div>
                </div>

                <div class="col-md-2">
                    <label></label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['overdue'][2]['total'],2,',','.' ); ?>
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d;">30-45 days</div>
                </div>

                <div class="col-md-2">
                    <label></label>
                    <div style="font-size: 14px; font-weight: 600;">
                        IDR <?= number_format($dashboard['overdue'][3]['total'],2,',','.' ); ?>
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d;">Above 45 days</div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link active" id="org-tab" data-toggle="tab" href="#org" role="tab" aria-controls="org" aria-selected="true">Organization</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link active" id="dash-tab" data-toggle="tab" href="#dash" role="tab" aria-controls="dash" aria-selected="true">Dashboard</a>
            </li> -->
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- ################################################### START TAB 1 ################################################### -->
            <div class="tab-pane fade active in" id="org" role="tabpanel" aria-labelledby="org-tab">
                <div class="ibox float-e-margins">
                    <div class="ibox-title ibox-title-main">
                        
                        <div class="ibox-tools">
                            <a href="<?php echo site_url('org-new'); ?>" class="btn btn-primary"><?php echo lang('add_organization'); ?></a>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered table-hover sys_table">
                            <thead>
                                <tr>
                                    <th><?php echo lang('name'); ?></th>
                                    <th colspan="2" style="text-align: center;"><?php echo lang('package'); ?></th>
                                    <th><?php echo lang('valid_from'); ?></th>
                                    <th><?php echo lang('valid_until'); ?></th>
                                    <th><?php echo lang('status'); ?></th>
                                    <th><?php echo lang('group'); ?></th>
                                    <th width="120px;"><?php echo lang('actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($organizations) { ?>
                                    <?php if($organizations){ ?>
                                        <?php foreach ($organizations as $key => $org) { ?>
                                            <tr>
                                                <td><?php echo $org->organization_name; ?></td>
                                                <td><?php echo $org->package_name; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?php echo site_url('upgrade?cid=').encode($org->id).'&pid='.encode($org->package); ?>">
                                                        <span class = "label label-default">Upgrade</span>
                                                    </a>
                                                </td>
                                                <td><?php echo date('d/m/Y',strtotime($org->start_from)); ?></td>
                                                <td><?php echo date('d/m/Y',strtotime($org->valid_until)); ?></td>
                                                <td><?php echo lang('status_'.$org->organization_status); ?></td>
                                                <td><?php echo $org->role; ?></td>
                                                <td style="white-space: nowrap">
                                                    <a href="<?php echo site_url('organizations/delete/' . $org->organization); ?>" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                                    &nbsp;|&nbsp;<a href="<?= site_url('add-user?default=').encode($org->organization); ?>">Add User</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else {?>
                                        <tr></tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ################################################### END TAB 1 ################################################### -->

            <!-- ################################################### START TAB 1 ################################################### -->
            <!-- <div class="tab-pane fade" id="dash" role="tabpanel" aria-labelledby="dash-tab">
                
            </div> -->
            <!-- ################################################### END TAB 1 ################################################### -->
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    var select  = new Array();
    var i = 0;
    $("input[name='val_org[]']").each(function(){
        var cekval  = $(this).val();
        select[i]   = cekval;
        i++;
    });

    console.log(select);
    // $("#filter_org").select2("val",select);
    $("#filter_org").select2().val(select).trigger('change');


    $("#filter_org").change(function(event) {

        var cek = $(this).val();
        document.forms["form_org"].submit();

    });
    
});


</script>
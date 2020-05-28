<div class="page-title">
    <h3 class="ibilling-page-header"><?php echo lang('heading'); ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <!-- <div class="ibox-title">
                <div class="ibox-tools">
                    <a href="<?php echo site_url('org-new'); ?>" class="btn btn-primary"><?php echo lang('add_organization'); ?></a>
                </div>
            </div> -->
            <div class="ibox-content">
                <table class="table table-bordered table-hover sys_table">
                    <thead>
                        <tr>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('package'); ?></th>
                            <th><?php echo lang('valid_from'); ?></th>
                            <th><?php echo lang('valid_until'); ?></th>
                            <th><?php echo lang('status'); ?></th>
                            <th width="120px;"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($members_filter) { ?>
                            <?php foreach ($members_filter as $key => $member) { ?>
                                <tr style="background-color:#f0f0f0;">
                                    <th colspan="6"><?php echo $member->fullname?></th>
                                </tr>
                                <?php if($organizations[$member->id]){ ?>
                                    <?php foreach ($organizations[$member->id] as $key => $org) { ?>
                                    <tr>
                                        <td><?php echo $org->organization_name; ?></td>
                                        <td><?php echo $org->package_name; ?> <a href="javascript:void(0);"><span class = "label label-default">Upgrade</span></a></td>
                                        <td><?php echo date('d/m/Y',strtotime($org->start_from)); ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($org->valid_until)); ?></td>
                                        <td><?php echo lang('status_'.$org->organization_status); ?></td>
                                        <td style="white-space: nowrap">
                                            <a href="<?php echo site_url('launch?cid=' . encode($org->organization)); ?>">Open</a>
                                            &nbsp;|&nbsp;<a href="<?php echo site_url('organizations/delete/' . $org->organization); ?>" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php } else {?>
                                    <tr><td colspan="6">No Organization</td></tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="col-md-4">
                    <select class="">
                        <option value="0">All Organization</option>
                        <?php foreach ($organizations as $orgkey => $orgvalue) { ?>
                            
                            <option>asdf</option>
                        <?php } ?>
                    </select>

                </div>
                <table id="invTable" class="table table-hover datatable-responsive no-footer dataTable">
                    <thead>
                        <th style="width: 5px;"></th>
                        <th>Corporate Name</th>
                        <th>Inv. Month</th>
                        <th>Status</th>
                        <th>Clients</th>
                        <th>Title</th>
                        <th>Invoice Date</th>
                        <th>Inv B.PPN</th>
                        <th>Inv. A.PPN</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div> -->
</div>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        var dataTable = $("#invTable").DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "paging":false,
            "bFilter":false,
            "ajax": {   
                url: "<?php echo base_url('organizations/getListInvoice'); ?>", 
                type: "POST",
                data: function (d) {
                    // d.stat    = $("#stat").val();
                },
                error: function () {
                }
            },
        });

        function reload_table(){
            dataTable.ajax.reload(null,false); 
        }

        $('.och').change(function(event) {
            reload_table();
        });
    });
</script> -->
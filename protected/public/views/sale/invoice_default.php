<div class="container-fluid" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="row mt-2 justify-content-center">
        <div class="col-md-10 d-print-none">
            <a href="javascript:void(0)" id="btn-print" class="btn btn-secondary"><?php echo lang('print'); ?></a>
            <a href="<?php echo base_url('pdf/invoice/invoice/' . encode($data->id) . '/' . encode($data->organization) . '/1'); ?>" class="btn btn-primary"><?php echo lang('download_pdf'); ?></a>
        </div>
    </div>
    <div class="row mt-2 justify-content-center">
        <div class="col-md-6">

            <div class="card border-0 shadow-lg card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <?php if (isset($template->logo) && $org->image) { ?>
                                <img width="120" src="<?php echo base_url($org->image); ?>" alt="" class="item-logo img-fluid">
                            <?php } ?>
                        </div>
                        <div class="col-6">
                            <div class="text-right" style="vertical-align: middle;">
                                <b><?php echo isset($template->organization_name) ? $org->name . '<br>' : ''; ?></b>
                                <div style="font-size: 12px; line-height: 1.3;"><?php echo isset($template->organization_address) ? implode(", ", array_filter(explode("\n", ($org->address)))) : ''; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="pcs-entity-title">
                                <span class="item-invoice">Invoice</span>
                            </div>
                        </div>
                    </div> -->

                    <table class="border-0" style="clear:both;width:100%;margin-top:20px;table-layout:fixed;" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td valign="top" class="w-print-50 w-25 table-bill" style="vertical-align:top;word-wrap: break-word;line-height: 18px;">
                                    <div style="margin-bottom: 20px;">
                                        <div id="tmp_billing_address_label" class="pcs-label" style="margin-bottom: 1px !important;display: block;font-size: 12px !important;">Bill To : </div>
                                        <span style="" id="tmp_billing_address">
                                            <div class="pcs-customer-name" id="zb-pdf-customer-detail">
                                                <?php
                                                $this->db->where("id", $data->customer);
                                                $company_data = $this->db->get("contacts")->row();
                                                $address      = ($data->address)?implode(", ", array_filter(explode("\n", $data->address))):'';

                                                if($address == ""){
                                                    $adr= [
                                                        "city"     => $company_data->city,
                                                        "province" => $company_data->province,
                                                        "country"  => $company_data->country,
                                                    ];
                                                    $adr_additional = [
                                                        "phone" => ($company_data->phone)?"Ph : ".$company_data->phone:'',
                                                        "email" => ($company_data->email)?"Email : ".$company_data->email:''
                                                    ];

                                                    $nt_address = implode(", ", array_filter(explode("\n", ($company_data->address))));
                                                    
                                                    $address = $nt_address."<br>".implode(", ",array_filter($adr));
                                                    $address.= "<br>".implode("<br>", array_filter($adr_additional));
                                                }
                                                echo ($data->customer_company) ? '<div stle="font-size: 12px;">' . $data->customer_company . '</div>' : '';
                                                echo '<div class="customer-name font-weight-bold" style="font-size: 12px;"><b>' . $data->customer_name . '</b></div>';
                                                ?>
                                                <table style="padding: 0px; margin: 0px;">
                                                    <tr style="padding: 0px; margin: 0px;">
                                                        <td style="padding: 0px; margin: 0px; font-size: 12px !important;"><?php echo '' . $address . ''; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </span>
                                        <table style="margin-top: 15px;">
                                            <tr>
                                                <td style="padding: 0; font-size: 12px;"><b>Project : </b> </td>
                                                <td style="font-size: 12px;"><?= ($data->type == "invoice")?$data->project:$data->subject; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td valign="top" class="text-right">
                                    <h4 style="margin-bottom: 0px;"><?php echo strtoupper(lang('invoice')); ?></h4>
                                    <div class="font-weight-bold" id="tmp_entity_number">#<?php echo $data->code; ?></div>
                                    <div style="float: right;">
                                        <table style="font-size: 12px; margin-top: 8px;">
                                            <tr>
                                                <th><?= lang('date'); ?></th>
                                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                                <td><?= date("d M Y", strtotime(get_date($data->date))); ?></td>
                                            </tr>
                                            <?php if (isset($template->term)) { ?>
                                                <tr>
                                                    <th><?php echo lang('term'); ?></th>
                                                    <td>&nbsp;&nbsp;:&nbsp;</td>
                                                     <?php if ($data->term) : ?>
                                                        <td><?php echo $data->term_name; ?></td>
                                                    <?php else : ?>
                                                        <td>-</td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th><?php echo lang('due_date'); ?></th>
                                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                                <td>
                                                    <?php if($data->due_date == $data->date){ ?>
                                                        <?php
                                                        
                                                        $this->db->where("organization", $data->organization);
                                                        $this->db->where("is_default", 1);
                                                        $this->db->where("is_deleted !=", 1);
                                                        $terms_def = $this->db->get("terms")->row();
                                                        if(!empty($terms_def)){
                                                            echo date("d M Y", strtotime("+".$terms_def->length." days", strtotime($data->due_date)));
                                                        }else{
                                                            date("d M Y", strtotime(get_date($data->due_date)));
                                                        }
                                                        ?>
                                                    <?php }else{ ?>
                                                        <?php echo date("d M Y", strtotime(get_date($data->due_date))); ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row mt-3" style="display: none;">
                        <div class="col-md-12">
                            <table class="table table-bordered items">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('date'); ?></th>
                                        <?php if (isset($template->term)) { ?>
                                        <th><?php echo lang('term'); ?></th>
                                        <?php } ?>
                                        <th><?php echo lang('due_date'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo get_date($data->date); ?></td>
                                        <?php if (isset($template->term)) { ?>
                                            <?php if ($data->term) : ?>
                                                <td><?php echo $data->term_name; ?></td>
                                            <?php else : ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                        <?php } ?>

                                        <td><?php echo get_date($data->due_date); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-0">
                        <div class="col-md-12">
                            <div>
                                <?php if ($data->message != "" AND $data->type == "invoice") { ?>
                                    <div style="white-space: pre-wrap;word-wrap: break-word; font-size: 12px;" class="pcs-notes"><?php echo nl2br($data->message); ?></div>
                                <?php } ?>
                            </div>
                            <table class="table items" style="font-size: 12px;">
                                <thead class="">
                                    <tr style="font-size: 12px;">
                                        <th style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding: 10px 0px 10px 0px;">Item</th>
                                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding: 10px 0px 10px 0px;"><?php echo lang('qty'); ?></th>
                                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding: 10px 0px 10px 0px;"><?php echo lang('price'); ?></th>
                                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding: 10px 0px 10px 0px;"><?php echo lang('total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($products->result() as $product) {
                                        ?>
                                        <tr>
                                            <td style="padding: 12px 5px 12px 5px; border-bottom: 1px solid #ccc; font-size: 12px; padding-left: 0px;">
                                                <?php echo '<b>'.($product->code ? $product->code . ' - ' : '') . ($product->name ? $product->name . ' ' : '').'</b>';  ?>
                                                <?php if($product->description){ ?>
                                                    <table style="width: 100%; padding: 0px; margin: 0px; line-height: 15px; margin-top: 5px; font-size: 12px;">
                                                        <tr style="padding: 0px; margin: 0px;">
                                                            <td style="padding: 0px; margin: 0px;"><?php echo "<i>". nl2br($product->description)."</i>"; ?></td>
                                                        </tr>
                                                    </table>
                                                <?php } ?>
                                            </td>
                                            <td align="right" style="padding: 12px 5px 12px 5px; border-bottom: 1px solid #ccc; font-size: 12px;">
                                                <?php echo number_format($product->qty,0, '', '.') . ' ' . $product->unit_name; ?>
                                            </td>
                                            <td align="right" style="padding: 12px 5px 12px 5px; border-bottom: 1px solid #ccc; font-size: 12px;">
                                                <?php echo money_formating($product->price, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix, TRUE); ?>
                                            </td>
                                            <td align="right" style="padding: 12px 5px 12px 5px; border-bottom: 1px solid #ccc; font-size: 12px;">
                                                <?php echo money_formating($product->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix, TRUE); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5 justify-content-between">
                        <div class="col-4">
                            <?php if ($data->message AND $data->type != "invoice") { ?>
                                <div class="item-message">
                                    <?php echo $data->message; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-4" style="font-size: 12px;">
                            <table class="table" id="customer-subtotal">
                                <tr>
                                    <td class="text-right"><?php echo lang('subtotal'); ?></td>
                                    <td class="text-right"><?php echo money_formating($data->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                                </tr>
                                <?php if ($charges_fees->num_rows()) { ?>
                                    <?php foreach ($charges_fees->result() as $charges_fee) { ?>
                                        <tr>
                                            <td class="text-right"><?php echo $charges_fee->name  . ' ' . $charges_fee->value; ?>%</td>
                                            <td class="text-right"><?php echo money_formating($charges_fee->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($taxes->num_rows()) { ?>
                                    <?php foreach ($taxes->result() as $tax) { ?>
                                        <tr>
                                            <td class="text-right"><?php echo $tax->name . ' ' . $tax->rate; ?>%</td>
                                            <td class="text-right"><?php echo money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <tr style="border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
                                    <th class="text-right font-weight-bold"><?php echo lang('total'); ?></th>
                                    <th class="text-right font-weight-bold"><?php echo money_formating($data->total, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></th>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <?php if($template->signature_count > 0 AND $template->signature == 1){ ?>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <table width="<?php echo $template->signature_count * 25; ?>%" style="float: right;">
                                    <tr>
                                        <?php $number = 1; for ($i=count($signatures)-1; $i >=0;  $i--) { if($number++ > $template->signature_count) { break; } ?>
                                            <?php if($signatures[$i]['as'] != ""){ ?>
                                                <td style="width: 25%; text-align: center;"><?= $signatures[$i]['as']; ?></td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php $number = 1; for ($i=count($signatures)-1; $i >=0;  $i--) { if($number++ > $template->signature_count) { break; } ?>
                                            <?php if($signatures[$i]['as'] != ""){ ?>
                                                <td style="height: 150px; padding: 0px; text-align: center;">
                                                    <div style="height: 100%; margin-left: 10%; margin-right: 10%; border-bottom: 1px solid #ccc; position: relative;">
                                                        <?php if($signatures[$i]['image'] != ""){ ?>
                                                            <img src="<?= base_url("../".$signatures[$i]['image']); ?>" style="max-width: 100%;">
                                                        <?php } ?>
                                                        <span style="width: 100%; position: absolute; bottom: 0; right: 0;"><?= $signatures[$i]['name']; ?></span>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php $number = 1; for ($i=count($signatures)-1; $i >=0;  $i--) { if($number++ > $template->signature_count) { break; } ?>
                                            <?php if($signatures[$i]['as'] != ""){ ?>
                                                <td style="text-align: center;"><?= $signatures[$i]['job_title']; ?></td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php } ?>  
                </div>
            </div>

        </div>
    </div>
</div>
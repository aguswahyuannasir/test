<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $namesave . '.pdf'; ?></title>
    <style>
        @page {
            size: 8.5in 11in;
            margin-left: 3%;
            margin-right: 3%;
            margin-top: 0%;
        }

        body {
            font-size: 14px;
            color: #333333;
        }

        .item-message {
            font-size: 14px;
        }

        .pcs-orgname {
            font-weight: bold;
            font-size: 9pt;
            color: #333333;
        }

        .pcs-entity-title {
            text-transform: uppercase;
            font-size: 13pt;
            color: #333333;
            background: #fff;
            padding: 0 20px;
            position: absolute !important;
            left: 43%;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table {
            width: 100%;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            /* border-top: 1px solid #dee2e6; */
        }


        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        thead th {
            background-color: #eee !important;
        }

        .item-invoice {
            background: white;
            position: relative;
            padding: 0 20px;
        }

        .row {
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-wrap: wrap !important;
            flex-wrap: wrap !important;
            margin-right: -15px !important;
            margin-left: -15px !important;
        }

        .col-6 {
            -ms-flex: 0 0 50% !important;
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mt-0,
        .my-0 {
            margin-top: 0 !important;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0 !important;
        }

        .m-1 {
            margin: 0.25rem !important;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem !important;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem !important;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem !important;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem !important;
        }

        .m-2 {
            margin: 0.5rem !important;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem !important;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem !important;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem !important;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5rem !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        .mt-3,
        .my-3 {
            margin-top: 1rem !important;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1rem !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1rem !important;
        }

        .m-4 {
            margin: 1.5rem !important;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem !important;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem !important;
        }

        .m-5 {
            margin: 3rem !important;
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem !important;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3rem !important;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem !important;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3rem !important;
        }


        .total-number-section {
            width: 40%;
            padding-top: 20px;
            float: left;
        }

        .total-center-section {
            width: 20%;
        }

        .total-section {
            width: 40%;
            padding-top: 20px;
            float: right;
        }

        .total-section-label {
            padding: 5px 10px 5px 0;
            vertical-align: middle;
        }

        .total-section-value {
            width: 50%;
            vertical-align: middle;
            padding: 10px 10px 10px 5px;
        }

        .pcs-bdr-top {
            border-top: 1px solid #eeeeee;
            border-bottom: 1px solid #eeeeee;
        }

        .pcs-balance {
            background-color: #ffffff;
            font-size: 9pt;
            color: #333333;
        }

        .item-customer {
            width: 50% !important;
            vertical-align: top !important;
            word-wrap: break-word !important;
            line-height: 20px !important;
        }

        #tmp_billing_address_label {
            font-size: 9pt !important;
            margin-bottom: 3px !important;
            display: block !important;
        }

        .item-address {
            vertical-align: middle;
        }

        .text-primary {
            color: #007bff !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .customer-address {
            font-size: 8pt !important;
        }

        hr {
            color: #eee;
        }

        thead th {
            font-weight: 500;
        }

        #tmp_entity_number {
            font-weight: bold;
            font-size: 15pt;
        }

        .customer-name {
            font-size: 16px;
        }

        #signature {
            text-align: center;
            margin-top: 20px;
            width: 100%;
        }

        #signature td {
            border: none;
            word-wrap: break-word;
            font-size: 14px !important;
        }

        #signature img {
            height: 100px;
            width: 100px;
        }

        #signature hr {
            width: 95%;
            margin: 0 auto;
        }
    </style>
</head>

<body class="container-fluid" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
    <table style="width: 100%; font-size: 12px;" border="0">
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <?php if (isset($template->logo) && $org->image) { ?>
                        <img  width="120"  src="<?php echo str_replace(['app/','public/'], '', base_url($org->image)); ?>">
                    <?php } ?>
                </td>
                <td valign="top" class="text-right item-address" style="vertical-align: top;">
                    <b><?php echo isset($template->organization_name) ? $org->name . '<br>' : ''; ?></b>
                    <?php echo isset($template->organization_address) ? implode(", ", array_filter(explode("\n", ($org->address)))) : ''; ?>

                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 25px;width: 100%; font-size: 12px;" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td valign="top" style="" class="item-customer" style="font-size: 12px;">
                    <div style="">
                        <!-- <?php if($data->type == "invoice"){ ?>
                            <h2 style="font-weight: 500; margin-bottom: 20px;"><?= $data->project; ?></h2>
                        <?php }else{ ?>
                            <div style="font-weight: 500; margin-bottom: 20px; font-size: 20px;"><?= $data->subject; ?></div>
                        <?php } ?> -->
                        <div style="font-size: 12px;margin-bottom: 3px;display: block;" id="tmp_billing_address_label" class="pcs-label">Bill To : </div>
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
                                echo ($data->customer_company) ? '<div stle="font-size:12px;">' . $data->customer_company . '</div>' : '';
                                echo '<div class="customer-name font-weight-bold"><b>' . $data->customer_name . '</b></div>';
                                ?>
                                <table style="padding: 0px; margin: 0px;">
                                    <tr style="padding: 0px; margin: 0px;">
                                        <td style="padding: 0px; margin: 0px; font-size: 12px;"><?php echo '' . $address . ''; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </span>
                        <table style="margin-top: 15px;">
                            <tr>
                                <td style="padding: 0; font-size: 14px;"><b>Project : </b> </td>
                                <td style="font-size: 14px;"><?= ($data->type == "invoice")?$data->project:$data->subject; ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td valign="top" class="text-right">
                    <h2 style="font-weight: 500;"><?= ($data->type == "invoice")?strtoupper($data->type):"QUOTATION"; ?></h2>
                    <span id="tmp_entity_number">#<?php echo $data->code; ?></span>
                    <div style="float: right;">
                        <table style="font-size: 12px; margin-top: 8px;">
                            <tr>
                                <th style="text-align: left;"><?= lang('date'); ?></th>
                                <td>&nbsp;&nbsp;:&nbsp;</td>
                                <td><?= date("d M Y", strtotime(get_date($data->date))); ?></td>
                            </tr>
                            <?php if (isset($template->term)) { ?>
                                <tr>
                                    <th style="text-align: left;"><?php echo lang('term'); ?></th>
                                    <td>&nbsp;&nbsp;:&nbsp;</td>
                                     <?php if ($data->term) : ?>
                                        <td><?php echo $data->term_name; ?></td>
                                    <?php else : ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th style="text-align: left; font-size: 12px;">
                                    <?php
                                    if ($data->type == "invoice") {
                                        echo lang('due_date'); 
                                     } else {
                                        echo "Expired Date";
                                     }
                                    ?>
                                </th>
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

    <!-- <div class="">
        <div class="">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="text-left"><?php echo lang('date'); ?></th>
                        <?php if (isset($template->term)) { ?>
                        <th class="text-left"><?php echo lang('term'); ?></th>
                        <?php } ?>
                        <th class="text-left"><?php echo lang('due_date'); ?></th>
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
    </div> -->
    <br>
    <div class="">
        <div class="col-md-12">
            <div>
                <?php if ($data->message != "" AND $data->type == "invoice") { ?>
                    <div style="white-space: pre-wrap;word-wrap: break-word; font-size: 12px;" class="pcs-notes"><?php echo nl2br($data->message); ?></div>
                <?php } ?>
            </div>
            <table class="table items" style="font-size: 12px;">
                <thead class="">
                    <tr style="font-size: 12px;">
                        <th style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; text-align: left; padding-left:0px;">Item</th>
                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding-right:5px;"><?php echo lang('qty'); ?></th>
                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding-right:5px;"><?php echo lang('price'); ?></th>
                        <th class="text-right" style="font-weight: bold; border-bottom: 3px solid #636e72; background-color: #fff; padding-right:5px;"><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products->result() as $pkeys => $product) {
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

    <div style="width: 100%;margin-top: 1px;">
        <div class="total-number-section v-top">
            <?php if ($data->message AND $data->type != "invoice") { ?>
                <div style="white-space: pre-wrap;word-wrap: break-word; font-size: 12px;" class="pcs-notes"><?php echo nl2br($data->message); ?></div>
            <?php } ?>
        </div>
        <div class="total-center-section"></div>
        <div class="pcs-totals total-section v-top">
            <table class="pcs-bdr-bottom" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="total-section-label pcs-label text-right" style="padding-bottom: 5px; padding-top: 5px; font-size: 12px;"><?php echo lang('subtotal'); ?></td>
                        <td id="tmp_subtotal" class="text-right total-section-value" style="padding-bottom: 5px; padding-top: 5px; font-size: 12px;">
                            <?php echo money_formating($data->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?>
                        </td>
                    </tr>
                    <?php if ($charges_fees->num_rows()) { ?>
                        <?php foreach ($charges_fees->result() as $charges_fee) { ?>
                            <tr style="height:0px;">
                                <td class="total-section-label text-right" style="font-size: 12px !important;padding-bottom: 3px; padding-top: 5px;"><?php echo $charges_fee->name  . ' ' . $charges_fee->value; ?>%</td>
                                <td class="text-right total-section-value" style="font-size: 12px !important;padding-bottom: 3px; padding-top: 5px;"><?php echo money_formating($charges_fee->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($taxes->num_rows()) { ?>
                        <?php foreach ($taxes->result() as $tax) { if($tax->is_ppn != 1){ ?>
                            <tr style="height:0px;">
                                <td class="total-section-label text-right pcs-bdr-top" style="padding-bottom: 3px; padding-top: 5px; font-size: 12px;"><?php echo $tax->name . ' ' . $tax->rate; ?>%</td>
                                <td class="text-right total-section-value pcs-bdr-top" style="padding-bottom: 3px; padding-top: 5px; font-size: 12px;"><?php echo money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            </tr>
                        <?php } } ?>

                        <?php foreach ($taxes->result() as $tax) { if($tax->is_ppn == 1){ ?>
                            <tr style="height:0px;">
                                <td class="total-section-label text-right pcs-bdr-top" style="padding-bottom: 3px; padding-top: 5px;font-size: 12px;"><?php echo $tax->name . ' ' . $tax->rate; ?>%</td>
                                <td class="text-right total-section-value pcs-bdr-top" style="padding-bottom: 3px; padding-top: 5px;font-size: 12px;"><?php echo money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            </tr>
                        <?php } } ?>

                    <?php } ?>

                    <tr>
                        <th class="total-section-label text-right pcs-bdr-top" style="font-size: 12px;"><?php echo lang('total'); ?></th>
                        <th id="tmp_total" class="text-right total-section-value pcs-bdr-top" style="font-size: 12px;"><?php echo money_formating($data->total, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></th>
                    </tr>

                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>
    </div>

    <?php if (isset($template->signature)) { ?>
        <br>        
        <table id="signature">
            <tr>
                <td width="25%"><?php echo ($template->signature_count > 3) ? $signatures[0]['as'] : ''; ?></td>
                <td width="25%"><?php echo ($template->signature_count > 2) ? $signatures[1]['as'] : ''; ?></td>
                <td width="25%"><?php echo ($template->signature_count > 1) ? $signatures[2]['as'] : ''; ?></td>
                <td width="25%"><?php echo ($template->signature_count > 0) ? $signatures[3]['as'] : ''; ?></td>
            </tr>
            <tr>
                <td><?php echo ($template->signature_count > 3) ? $signatures[0]['image'] ? '<img src="' . str_replace(['app/','public/'], '', base_url($signatures[0]['image'])) . '" width="100" height="100">' : '' : ''; ?></td>
                <td><?php echo ($template->signature_count > 2) ? $signatures[1]['image'] ? '<img src="' . str_replace(['app/','public/'], '', base_url($signatures[1]['image'])) . '" width="100" height="100">' : '' : ''; ?></td>
                <td><?php echo ($template->signature_count > 1) ? $signatures[2]['image'] ? '<img src="' . str_replace(['app/','public/'], '', base_url($signatures[2]['image'])) . '" width="100" height="100">' : '' : ''; ?></td>
                <td><?php echo ($template->signature_count > 0) ? $signatures[3]['image'] ? '<img src="' . str_replace(['app/','public/'], '', base_url($signatures[3]['image'])) . '" width="100" height="100">' : '' : ''; ?></td>
            </tr>
            <tr>
                <td><?php echo ($template->signature_count > 3) ? $signatures[0]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                <td><?php echo ($template->signature_count > 2) ? $signatures[1]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                <td><?php echo ($template->signature_count > 1) ? $signatures[2]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                <td><?php echo ($template->signature_count > 0) ? $signatures[3]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
            </tr>
            <tr>
                <td style="padding-top: 0;"><?php echo ($template->signature_count > 3) ? $signatures[0]['job_title'] : ''; ?></td>
                <td style="padding-top: 0;"><?php echo ($template->signature_count > 2) ? $signatures[1]['job_title'] : ''; ?></td>
                <td style="padding-top: 0;"><?php echo ($template->signature_count > 1) ? $signatures[2]['job_title'] : ''; ?></td>
                <td style="padding-top: 0;"><?php echo ($template->signature_count > 0) ? $signatures[3]['job_title'] : ''; ?></td>
            </tr>
        </table>
    <?php } ?>
</body>

</html>
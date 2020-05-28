<html>

<head>
    <title><?php echo $data->id . '.pdf'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font: 14px/1.4 dejavusanscondensed;
        }

        #page-wrap {
            width: 800px;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 5px;
        }


        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            margin-top: 25px;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #meta {
            margin-top: 1px;
            width: 100%;
            float: right;
        }

        #meta td {
            text-align: right;
        }

        #meta td.meta-head {
            text-align: left;
            background: #eee;
        }

        #meta td textarea {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 0 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea,
        #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 10px;
            text-align: right;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: left;
            margin: 20px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px dejavusanscondensed;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }

        #signature {
            text-align: center;
            margin-top: 20px;
            width: 100%;
        }

        #signature td {
            border: none;
            word-wrap: break-word;
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

<body style="font-family:dejavusanscondensed">
    <div id="page-wrap">
        <table width="100%">
            <tr>
                <td style="border: 0;  text-align: left" width="62%">
                    <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo lang('invoice') . ' # ' . $data->code; ?></strong></span>
                </td>
                <td style="border: 0;  text-align: right" width="62%">
                    <div id="logo" style="font-size:18px">
                        <?php if (isset($template->logo) && $org->image && file_exists('../' . $org->image)) { ?>
                            <img id="image" src="<?php echo base_url('../' . $org->image); ?>" style="max-width:180px" /> <br> <br>
                        <?php } ?>
                        <?php echo isset($template->organization_name) ? $org->name . '<br>' : ''; ?>
                        <?php echo isset($template->organization_address) ? $org->address : ''; ?>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
        <div style="clear:both"></div>
        <br>
        <div id="customer">
            <table id="meta">
                <tr>
                    <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%">
                        <strong><?php echo lang('customer'); ?></strong> <br>
                        <?php
                        echo ($data->customer_company) ? $data->customer_company . '<br>' : '';
                        echo $data->customer_name . '<br>';
                        echo $data->address . '<br>';
                        ?>
                    </td>
                    <td class="meta-head"><?php echo lang('invoice'); ?> #</td>
                    <td><?php echo $data->code; ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo lang('date'); ?></td>
                    <td><?php echo get_date($data->date); ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo lang('expiry_date'); ?></td>
                    <td><?php echo get_date($data->due_date); ?></td>
                </tr>
            </table>
        </div>
        <br>
        <?php if ($data->quote_message) { ?>
            <hr>
            <div>
                <?php echo $data->quote_message; ?>
            </div>
            <hr>
            <br>
        <?php } ?>
        <table id="items">
            <tr>
                <th><?php echo lang('product'); ?></th>
                <th align="right"><?php echo lang('qty'); ?></th>
                <th align="right"><?php echo lang('price'); ?></th>
                <th align="right"><?php echo lang('total'); ?></th>
            </tr>
            <?php foreach ($products->result() as $product) { ?>
                <tr>
                    <td><?php echo ($product->code ? $product->code . ' - ' : '') . ($product->name ? $product->name . ' ' : '') . $product->description; ?></td>
                    <td align="right"><?php echo $product->qty . ' ' . $product->unit_name; ?></td>
                    <td align="right"><?php echo money_formating($product->price, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                    <td align="right"><?php echo money_formating($product->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="blank"> </td>
                <td colspan="2" class="total-line"><?php echo lang('subtotal'); ?></td>
                <td class="total-value">
                    <div id="subtotal"><?php echo money_formating($data->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></div>
                </td>
            </tr>
            <?php
            if ($charges_fees->num_rows()) {
                foreach ($charges_fees->result() as $charges_fee) {
                    echo '<tr><td class="blank"> </td><td colspan="2" class="total-line">' . $charges_fee->name . ' ' . $charges_fee->value . '%</td><td class="total-value">' . money_formating($charges_fee->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix) . '</td></tr>';
                }
            }
            if ($taxes->num_rows()) {
                foreach ($taxes->result() as $tax) {
                    echo '<tr><td class="blank"> </td><td colspan="2" class="total-line">' . $tax->name . ' ' . $tax->rate . '%</td><td class="total-value">' . money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix) . '</td></tr>';
                }
            }
            ?>
            <tr>
                <td class="blank"> </td>
                <td colspan="2" class="total-line balance"><?php echo lang('total'); ?></td>
                <td class="total-value balance">
                    <div class="due"><?php echo money_formating($data->total, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></div>
                </td>
            </tr>
        </table>
        <?php if (isset($template->signature)) { ?>
            <br>
            <table id="signature">
                <tr>
                    <td width="25%"><?php echo ($template->signature_count > 3) ? $signatures[3]['as'] : ''; ?></td>
                    <td width="25%"><?php echo ($template->signature_count > 2) ? $signatures[2]['as'] : ''; ?></td>
                    <td width="25%"><?php echo ($template->signature_count > 1) ? $signatures[1]['as'] : ''; ?></td>
                    <td width="25%"><?php echo ($template->signature_count > 0) ? $signatures[0]['as'] : ''; ?></td>
                </tr>
                <tr>
                    <td><?php echo ($template->signature_count > 3) ? $signatures[3]['image'] ? '<img src="' . base_url($signatures[3]['image']) . '">' : '' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 2) ? $signatures[2]['image'] ? '<img src="' . base_url($signatures[2]['image']) . '">' : '' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 1) ? $signatures[1]['image'] ? '<img src="' . base_url($signatures[1]['image']) . '">' : '' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 0) ? $signatures[0]['image'] ? '<img src="' . base_url($signatures[0]['image']) . '">' : '' : ''; ?></td>
                </tr>
                <tr>
                    <td><?php echo ($template->signature_count > 3) ? $signatures[3]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 2) ? $signatures[2]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 1) ? $signatures[1]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                    <td><?php echo ($template->signature_count > 0) ? $signatures[0]['name'] . '<hr style="padding: 0; margin-top:0; margin-bottom:0; width: 90%;">' : ''; ?></td>
                </tr>
                <tr>
                    <td style="padding-top: 0;"><?php echo ($template->signature_count > 3) ? $signatures[3]['job_title'] : ''; ?></td>
                    <td style="padding-top: 0;"><?php echo ($template->signature_count > 2) ? $signatures[2]['job_title'] : ''; ?></td>
                    <td style="padding-top: 0;"><?php echo ($template->signature_count > 1) ? $signatures[1]['job_title'] : ''; ?></td>
                    <td style="padding-top: 0;"><?php echo ($template->signature_count > 0) ? $signatures[0]['job_title'] : ''; ?></td>
                </tr>
            </table>
        <?php } ?>
    </div>
</body>

</html>
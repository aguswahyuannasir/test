<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $data->code . '.pdf'; ?></title>


</head>

<body>

    <table style="width: 100%;" border="0">
        <tbody>
            <tr>
                <td class="item-logo" style="">
                    <?php if (isset($template->logo) && $org->image) { ?>
                        <img width="140" src="<?php echo 'http://localhost/test/' . $org->image; ?>" alt="" class="img-fluid" id="logo_content">
                    <?php } ?>
                </td>
                <td valign="bottom" class="text-right item-address">
                    <?php echo isset($template->organization_name) ? $org->name . '<br>' : ''; ?>
                    <?php echo isset($template->organization_address) ? $org->address : ''; ?>

                </td>
            </tr>
        </tbody>
    </table>


    <div class="pc-entity-title">
        Invoice
        <!-- <span class="pc-right-border">
            <hr></span>
        <span class="item-invoice">Invoice </span> -->
    </div>
    <hr>


    <table style="margin-top: 25px;width: 100%;" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td valign="top" style="" class="item-customer">
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 12pt;margin-bottom: 3px;display: block;" id="tmp_billing_address_label" class="pcs-label">Bill To</div>
                        <span style="" id="tmp_billing_address">
                            <div class="pcs-customer-name" id="zb-pdf-customer-detail">
                                <?php
                                echo ($data->customer_company) ? '<div class="customer-company text-primary">' . $data->customer_company . '</div>' : '';
                                echo '<div class="customer-name text-primary font-weight-bold">' . $data->customer_name . '</div>';
                                echo '<div class="customer-address">' . $data->address . '</div>';
                                ?>
                            </div>
                        </span>
                    </div>
                </td>
                <td valign="top" class="text-right">
                    <div class="pcs-title">Invoice#</div>
                    <div style="font-size: 10pt; font-weight: bold;" id="tmp_entity_number"><?php echo $data->code; ?></div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="">
        <div class="">
            <table class="table table-bordered mt-4 items">
                <thead>
                    <tr>
                        <th class="text-left"><?php echo lang('date'); ?></th>
                        <th class="text-left"><?php echo lang('term'); ?></th>
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
    </div>

    <div class="">
        <div class="col-md-12">
            <table class="table table-bordered items mt-4">
                <thead class="">
                    <tr>
                        <th class="text-left"><?php echo lang('product'); ?></th>
                        <th class="text-right"><?php echo lang('qty'); ?></th>
                        <th class="text-right"><?php echo lang('price'); ?></th>
                        <th class="text-right"><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products->result() as $product) {
                        ?>
                        <tr>
                            <td><?php echo ($product->code ? $product->code . ' - ' : '') . ($product->name ? $product->name . ' ' : '') . $product->description; ?></td>
                            <td align="right"><?php echo $product->qty . ' ' . $product->unit_name; ?></td>
                            <td align="right"><?php echo money_formating($product->price, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            <td align="right"><?php echo money_formating($product->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="width: 100%;margin-top: 1px;">
        <div class="total-number-section v-top">
            <?php if ($data->message) { ?>
                <div style="white-space: pre-wrap;word-wrap: break-word; font-size: 12px;" class="pcs-notes"><?php echo $data->message; ?></div>
            <?php } ?>
        </div>
        <div class="total-center-section"></div>
        <div class="pcs-totals total-section v-top">
            <table class="pcs-bdr-bottom" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="total-section-label pcs-label text-right"><?php echo lang('subtotal'); ?></td>
                        <td id="tmp_subtotal" class="text-right total-section-value"><?php echo money_formating($data->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                    </tr>
                    <?php if ($charges_fees->num_rows()) { ?>
                        <?php foreach ($charges_fees->result() as $charges_fee) { ?>
                            <tr style="height:10px;">
                                <td class="total-section-label text-right"><?php echo $charges_fee->name  . ' ' . $charges_fee->value; ?>%</td>
                                <td class="text-right total-section-value"><?php echo money_formating($charges_fee->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($taxes->num_rows()) { ?>
                        <?php foreach ($taxes->result() as $tax) { ?>
                            <tr style="height:10px;">
                                <td class="total-section-label text-right"><?php echo $tax->name . ' ' . $tax->rate; ?>%</td>
                                <td class="text-right total-section-value"><?php echo money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    <tr>
                        <th class="total-section-label text-right pcs-bdr-top"><?php echo lang('total'); ?></th>
                        <th id="tmp_total" class="text-right total-section-value pcs-bdr-top"><?php echo money_formating($data->total, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></th>
                    </tr>

                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>
    </div>



</body>

</html>
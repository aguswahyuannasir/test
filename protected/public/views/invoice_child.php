<div class="container-fluid">
    <div class="row justify-content-center my-2 d-print-none">
        <div class="col-md-9">
            <a href="javascript:void(0)" id="btn-print" class="btn btn-secondary"><?php echo lang('print'); ?></a>
            <a href="<?php echo base_url('pdf/invoice_child/invoice/' . encode($invoice_child->id) . '/' . encode($data->organization) . '/1'); ?>" class="btn btn-primary"><?php echo lang('download_pdf'); ?></a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow card-content">
                <div class="card-body">
                    <table width="100%">
                        <tr>
                            <td style="border: 0;  text-align: left" width="62%">
                                <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo lang('invoice') . ' # ' . $data->code; ?></strong></span>
                            </td>
                            <td style="border: 0;  text-align: right" width="62%">
                                <div id="logo" style="font-size:18px">
                                    <?php if (isset($template->logo) && $org->image) { ?>
                                        <img id="image" src="<?php echo base_url($org->image); ?>" style="max-width:180px" /> <br> <br>
                                    <?php } ?>
                                    <?php echo isset($template->organization_name) ? $org->name . '<br>' : ''; ?>
                                    <?php echo isset($template->organization_address) ? $org->address : ''; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div id="customer">
                        <table id="meta" class="">
                            <tr>
                                <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%">
                                    <?php echo ($data->subject) ? '<h4 class="font-weight-bold">' . $data->subject . '</h4><br>' : ''; ?>
                                    <span class="font-weight-bold"><?php echo lang('customer'); ?></span> <br>
                                    <?php
                                    echo ($data->customer_company) ? $data->customer_company . '<br>' : '';
                                    echo $data->customer_name . '<br>';
                                    echo $data->address . '<br>';
                                    ?>
                                </td>
                                <td class="meta-head" style="background: red;"><?php echo lang('invoice'); ?> #</td>
                                <td><?php echo $data->code; ?></td>
                            </tr>
                            <tr>
                                <td class="meta-head"><?php echo lang('date'); ?></td>
                                <td><?php echo get_date($invoice_child->date); ?></td>
                            </tr>
                            <?php if (isset($template->term)) { ?>
                                <tr>
                                    <td class="meta-head"><?php echo lang('term'); ?></td>
                                    <td><?php echo ($invoice_child->term) ? $invoice_child->term_name : '-'; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="meta-head"><?php echo lang('due_date'); ?></td>
                                <td><?php echo get_date($invoice_child->due_date); ?></td>
                            </tr>
                        </table>
                    </div>

                    <table id="items">
                        <tr>
                            <th class="text-center font-weight-bold"><?php echo lang('product'); ?></th>
                            <th class="text-right"><?php echo lang('qty'); ?></th>
                            <th class="text-right"><?php echo lang('price'); ?></th>
                            <th class="text-right"><?php echo lang('total'); ?></th>
                        </tr>
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
                        <tr>
                            <td class="blank"> </td>
                            <td colspan="2" class="total-line"><?php echo lang('subtotal'); ?></td>
                            <td class="total-value"><?php echo money_formating($data->subtotal, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></td>
                        </tr>
                        <?php
                        if ($charges_fees->num_rows()) {
                            foreach ($charges_fees->result() as $charges_fee) {
                                echo '<tr><td class="blank"></td><td colspan="2" class="total-line">' . $charges_fee->name . ' ' . $charges_fee->value . '%</td><td class="total-value">' . money_formating($charges_fee->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix) . '</td></tr>';
                            }
                        }
                        if ($taxes->num_rows()) {
                            foreach ($taxes->result() as $tax) {
                                echo '<tr><td class="blank"></td><td colspan="2" class="total-line">' . $tax->name . ' ' . $tax->rate . '%</td><td class="total-value">' . money_formating($tax->amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix) . '</td></tr>';
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
                        <tr>
                            <td class="blank"> </td>
                            <td colspan="2" class="total-line balance"><?php echo lang('payment'); ?></td>
                            <td class="total-value balance">
                                <div class="due"><?php echo money_formating($invoice_child->payment_amount, $data->currency_prefix, $data->currency_decimal_digit, $data->currency_decimal_separator, $data->currency_thousand_separator, $data->currency_suffix); ?></div>
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
            </div>
        </div>
    </div>
</div>
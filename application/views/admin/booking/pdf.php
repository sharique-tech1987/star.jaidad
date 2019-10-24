<?php
/**
* Adnan Bashir
* E: developer.adnan@gmail.com
* P: +92-332-3103324
* S: developer.adnan
*/
?>
<div class="m-portlet__body m-portlet__body--no-padding p-0">


    <style>
        .payment-table tfoot td{
            font-weight: bold;
            font-size: 14px;
        }
        body{
            /*font-family: "Courier New";*/
        }
        .table {
            border-collapse: collapse;
        }
        .table td, .table th{
            padding: 2px 4px;
        }
        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table-bordered td, .table-bordered th {
            font-size: 14px;
        }

    </style>
    <div class="m-invoice-2">

        <div class="">
            <table width="100%">
                <tr>
                    <td align="center"><img src="<?php echo _img(asset_url('img/' . get_option('logo'), true), 0, 65); ?>" class="img-fluid" /></td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td>
                        <h1>INVOICE</h1>
                        <table>
                            <tr>
                                <td><b><?php echo number_format($booking->area);?></b> <?php echo $row->area_unit;?></td>
                                <td><b><?php echo number_format($booking->bedrooms);?></b> Bedrooms</td>
                                <td><b><?php echo number_format($booking->bathrooms);?></b> Bathroom</td>
                            </tr>
                        </table>
                    </td>
                    <td align="right"><img src="<?php echo _img(asset_url("front/projects/{$booking->logo}"), 0, 50);?>"></td>
                </tr>
                <tr>
                    <td>Property type: <b><?php echo $booking->property_type;?></b></td>
                    <td align="right"><span><?php echo $booking->full_address;?></span></td>
                </tr>
            </table>

            <table width="100%" class="table payment-table table-bordered">
                <thead>
                <tr>
                    <th>DESCRIPTION</th>
                    <th>Due Amount</th>
                    <th>Due Date</th>
                    <th>Paid Amount</th>
                    <th>Paid On</th>
                    <th>Transaction ID</th>
                    <th>Out Stand</th>
                    <th>Surcharge</th>

                </tr>
                </thead>
                <tbody>
                <?php
                //echo '<pre>'; print_r($payments); echo '</pre>';
                $_total = [];
                $i = -1;
                foreach ($payments as $payment) {$i++;

                    $_total = [
                        'total_amount' => ($_total['total_amount'] + $payment['amount']),
                        'paid_amount' => ($_total['paid_amount'] + $payment['paid_amount']),
                        'out_stand' => ($_total['out_stand'] + $payment['balance']),
                        'late_charges' => ($_total['late_charges'] + ($payment['late_charges'])),
                    ];
                    ?>
                    <tr>
                        <td><?php echo $payment['particulars']; ?></td>
                        <td><?php echo number_format($payment['amount']); ?></td>
                        <td><?php echo mysql2date($payment['date']); ?></td>
                        <td class="m--font-danger"><?php echo number_format($payment['paid_amount']); ?></td>
                        <td><?php echo if_null(mysql2date($payment['paid_date']), '-', '0000-00-00'); ?></td>
                        <td class="text-center"><?php echo $payment['income_id']; ?></td>
                        <td><?php echo number_format($payment['balance']); ?></td>
                        <td><?php echo number_format($payment['late_charges']); ?></td>

                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <td><?php echo number_format($_total['total_amount']);?></td>
                    <td>&nbsp;</td>
                    <td><?php echo number_format($_total['paid_amount']);?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><?php echo number_format($_total['out_stand']);?></td>
                    <td><?php echo number_format($_total['late_charges']);?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!--<div class="m-invoice__footer">
                <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>BANK</th>
                            <th>ACC.NO.</th>
                            <th>DUE DATE</th>
                            <th>TOTAL AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>BARCLAYS UK</td>
                            <td>12345678909</td>
                            <td><?php /*echo mysql2date(date('Y-m-d'));*/?></td>
                            <td class="m--font-danger"><?php /*echo number_format($_total['total_amount']);*/?></td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>-->
    </div>


</div>
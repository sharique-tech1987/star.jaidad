<?php
/**
* Adnan Bashir
* E: developer.adnan@gmail.com
* P: +92-332-3103324
* S: developer.adnan
*/
if(!$cron) {
    $form_buttons = ['print', 'back'];
    $status_column_data = get_enum_values($this->table, 'status');

    include __DIR__ . "/../includes/module_header.php";
}
?>
<div class="m-portlet__body m-portlet__body--no-padding p-0">


    <style>
        .property-info {
            padding: 0;
            margin: 0;
        }
        .property-info li {
            list-style: none;
            position: relative;
            float: left;
            padding-right: 25px;
            font-size: 14px;
            line-height: 45px;
            color: #777777;
            cursor: default;
            font-weight: 400;
        }
        .property-info li i{
            color: #03a84e;
        }
        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__logo {
            padding-top: 2rem;
        }
        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items{
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__desc{
            padding: 1rem 0 2rem 0;
        }
        .payment-table tfoot td{
            font-weight: bold;
            font-size: 14px;
        }
        @media print {
            .table{
                background: transparent !important;
            }
            .table th, .table td {
                padding: 0.30rem;
                font-size: 12px;
            }
        }
    </style>
    <div class="m-invoice-2">
        <div class="m-invoice__wrapper">
            <div class="text-center bg-dark m--padding-20">
                <img src="<?php echo asset_url('img/' . get_option('admin_logo'), true); ?>" class="img-fluid">
            </div>
            <div class="m-invoice__head">
                <div class="m-invoice__container m-invoice__container--centered">
                    <div class="m-invoice__logo">
                        <a href="<?php echo current_url();?>">
                            <h1>INVOICE</h1>
                            <ul class="property-info clearfix">
                                <li><i class="la la-arrows-alt"></i> <?php echo number_format($booking->area);?> <?php echo $row->area_unit;?></li>
                                <li><i class="la la-bed"></i> <?php echo number_format($booking->bedrooms);?> Bedrooms</li>
                                <li><i class="la la-mercury"></i> <?php echo number_format($booking->bathrooms);?> Bathroom</li>
                            </ul>
                        </a>
                        <a href="#">
                            <img src="<?php echo _img(asset_url("front/projects/{$booking->logo}"), 0, 50);?>">
                        </a>
                    </div>
                    <span class="m-invoice__desc">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                Property type: <b><?php echo $booking->property_type;?></b>
                            </div>
                            <div class="col-md-6">
                                <span><?php echo $booking->full_address;?></span>
                            </div>
                        </div>
                    </span>

                    <div class="m-invoice__items">
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">DATE</span>
                            <span class="m-invoice__text"><?php echo mysql2date(date('Y-m-d'));?></span>
                        </div>
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">INVOICE</span>
                            <span class="m-invoice__text">
                                #: <?php echo str_pad($row->id, 8, 0, STR_PAD_LEFT);?>
                                <br> Area: <?php echo number_format($booking->area) . ' ' . $booking->area_unit;?>
                                <br> Plot #: <?php echo $booking->plot;?>
                            </span>
                        </div>
                        <div class="m-invoice__item">
                            <span class="m-invoice__subtitle">INVOICE TO.</span>
                            <span class="m-invoice__text">
                                <?php echo strtoupper($member->full_name);?>
                                <br>MOB: <?php echo $member->phone;?>
                                <br>ADD: <?php echo $member->full_address;?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m--padding-20 -m-invoice__body m-invoice__body--centered">
                <div class="table-responsive">
                    <table class="table payment-table table-bordered">
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
                            <?php if(!$cron) { ?>
                            <th class="text-center" data-print="false">Action's</th>
                            <?php } ?>
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
                                <?php if(!$cron) { ?>
                                <td class="text-center" data-print="false">
                                    <?php if($payment['balance'] > 0) { ?>
                                    <a
                                        data-title="<?php echo $payment['particulars']; ?>"
                                        data-amount="<?php echo $payment['amount']; ?>"
                                        data-balance="<?php echo $payment['balance']; ?>"
                                        class="btn btn-success m-btn m-btn--icon btn-sm -m-btn--icon-only m-btn--pill m-btn--air" href="#" data-toggle="modal" data-target="#receive-payment-modal">
                                        <i class="la la-dollar"></i> Receive
                                    </a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
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
            </div>

            <div class="m-invoice__footer">
                <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>DISCOUNT COUPON</th>
                            <th>DISCOUNT</th>
                            <th>TOTAL AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="coupon_code" value="<?php echo $coupon->coupon_code;?>" class="form-control" placeholder="Discount Coupon">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">Apply</button>
                                    </div>
                                </div>
                            </td>
                            <td>

                            </td>
                            <td class="m--font-danger"><?php echo number_format($_total['total_amount']);?></td>
                        </tr>
                        </tbody>

                    </table>
                </div>
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


</div>
<?php if(!$cron) { ?>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>


<div class="modal fade" id="receive-payment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog -modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="la la-dollar"></i>Receive Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo admin_url($this->_route . '/get_payment/' . $booking->id);?>" method="post" class="form-horizontal validate">
                        <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $booking->id;?>"/>
                        <input type="hidden" name="income_by" id="income_by" value="<?php echo $booking->member_id;?>"/>
                        <input type="hidden" name="income_head" id="income_head" value=""/>

                        <div class="form-group m-form__group -row">
                            <label class="control-label">Title :</label>
                            <input type="text" name="title" id="title" class="form-control" value=""/>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-md-6">
                                <label class="control-label">Receive Amount :</label>
                                <input type="text" name="amount" id="amount" class="form-control" value=""/>
                                <span class="m-form__help">
                                    <b>Total Amount: <span style="color: #F00;" class="balance-amount"></span></b>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Receiving Date :</label>
                                <input type="text" name="date" id="date" class="form-control datepicker" style="width: 100%" value="<?php echo date('Y-m-d');?>" readonly/>
                            </div>
                        </div>
                        <!--<div class="form-group m-form__group row">
                            <div class="col-md-6">
                                <label class="control-label">Tax Amount :</label>
                                <input type="text" name="tax" id="tax" class="form-control" value=""/>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">$ Rate:</label>
                                <input type="text" name="usd_rate" id="usd_rate" class="form-control" value="106"/>
                            </div>
                        </div>-->
                        <div class="form-group m-form__group row">
                            <div class="col-md-12">
                                <label class="control-label">Note:</label>
                                <textarea name="note" id="note" class="form-control" cols="30" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-md-6 offset-md-3 text-center">
                                <button type="submit" class="btn btn-warning m-btn m-btn--icon -btn-sm m-btn--pill m-btn--air">
                                    <i class="la la-cc-mastercard"></i> &nbsp;&nbsp;Submit
                                </button>
                            </div>
                        </div>


                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(document).ready(function () {

            $('#receive-payment-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var _data = button.data();
                console.log(_data);

                var modal = $(this);
                modal.find('#title').val(_data.title);
                modal.find('#income_head').val(_data.title);
                modal.find('#amount').val(_data.balance);
                modal.find('.balance-amount').html(numeral(_data.balance).format('0,0'));
            })

        });
    });
</script>
<?php } ?>
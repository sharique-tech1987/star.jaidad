<br>
<h3 class="m-section__heading">Payment Schedule
    <span class="pull-right">
        <a href="javascript: void(0);" class="btn btn-lg btn-primary m-btn m-btn--icon m-btn--icon-only  m-btn--pill m-btn--air add-plane">
            <i class="la la-th-list -la-ellipsis-v"></i>
        </a>
    </span>
</h3>

<style>
    .payment-schedule-table td{
        padding: 2px;
    }
    .clone-table tr td .add-row{
        display: none;
        margin-right: 10px;
    }
    .clone-table tr:last-child td .add-row{
        display: inline-block;
    }
    .input-group-text {
        padding: 5px;
    }
    /*.remove-row{
        position: absolute !important;
        margin: 4px 0 0 -20px;
    }*/
</style>
<?php
if($row->id > 0) {
    $_payments = $this->m_project_properties->payments($row->id);
}

if($_payments == null){
    //$_payments = json_decode('{["1-1":[{"floors":"1-1"}]]}');
    $_payments = json_decode('{"1-1":[{"id":"34"}]}', true);
}
$keys = array_keys($_payments);
?>
<table class="table -table-striped table-hover -table-responsive grid-table payment-schedule-table clone-table">
    <thead class="thead-default">
    <tr>
        <th width="50" class="text-center">Actions</th>
        <th width="260" class="text-center">PARTICULARS</th>
        <th class="text-center">Payment Terms</th>
        <th class="text-center">Installment Plan</th>
        <?php
        foreach ($keys as $i => $key) {
                $floors = explode('-', $key);
        ?>
        <th width="150" class="clone-plane">
            <div class="input-group m-input-group">
                <input type="text" class="form-control m-input" name="payment[floors][<?php echo $i;?>][]" placeholder="Units" value="<?php echo $floors[0];?>" aria-describedby="basic-addon1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><a href="javascript: void(0);" class="remove-v-column btn btn-sm btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air"><i class="la la-trash"></i></a></span>
                </div>
                <input type="text" class="form-control m-input" name="payment[floors][<?php echo $i;?>][]" placeholder="Units" value="<?php echo $floors[1];?>" aria-describedby="basic-addon1">
            </div>
        </th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $sub_total = [];
    $i = -1;
    foreach ($_payments[$keys[0]] as $payment) {$i++;
    ?>
    <tr>
        <td class="text-center" width="50">
            <a href="#"  class="btn btn-sm btn-success m-btn m-btn--icon m-btn--icon-only  m-btn--pill m-btn--air add-row"><i class="la la-plus"></i></a>
            <a href="#"  class="btn btn-sm btn-danger m-btn m-btn--icon m-btn--icon-only  m-btn--pill m-btn--air remove-row"><i class="la la-trash"></i></a>
        </td>
        <td>
            <input type="text" name="payment[particulars][]" value="<?php echo $payment->particulars;?>" class="form-control">
        </td>

        <td>
            <div class="input-group m-input-group">
            <input type="text" name="payment[payment_interval][]" value="<?php echo $payment->payment_interval;?>" class="form-control">
                <div class="input-group-prepend">
                    <select name="payment[interval_type][]" id="interval_type" class="form-control"><?php echo selectBox(get_enum_values('payment_schedule', 'interval_type'), $payment->interval_type);?></select>
                </div>
            </div>
        </td>

        <td>
            <div class="input-group m-input-group">
                <input type="text" name="payment[installment_interval][]" value="<?php echo $payment->installment_interval;?>" class="form-control">
                <div class="input-group-prepend">
                    <select name="payment[installment_interval_type][]" id="installment_interval_type" class="form-control"><?php echo selectBox(get_enum_values('payment_schedule', 'installment_interval_type'), $payment->installment_interval_type);?></select>
                </div>
                <input type="text" name="payment[installment_duration][]" value="<?php echo $payment->installment_duration;?>" class="form-control">
            </div>
        </td>

        <?php foreach ($keys as $n => $key) {
            $sub_total[$key] += $_payments[$key][$i]->amount;
            ?>
            <td class="clone-plane"><input type="text" name="payment[amount][<?php echo $n;?>][]" value="<?php echo $_payments[$key][$i]->amount;?>" class="form-control"></td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot style="display: none;">
        <tr>
            <td colspan="4"><b>TOTAL CASH</b></td>
            <?php
            foreach ($keys as $key) { ?>
                <td class="text-center"><b><?php echo number_format($sub_total[$key]);?></b></td></td>
            <?php } ?>
        </tr>
    </tfoot>

</table>
<br>

<script>
    $(function () {
        $(document).ready(function () {
            $(document).on('click', '.add-plane', function (e) {
                e.preventDefault();
                var th_clone = $('th.clone-plane').eq(0);
                var n = $('th.clone-plane').length;

                th_clone.closest('tr').append(th_clone.clone().addClass('new-clone-plane'));
                th_clone.closest('tr').find('th:last').find('input').val('');
                th_clone.closest('tr').find('th:last').find('input[name*=payment\\[floors\\]]').attr('name', 'payment[floors]['+n+'][]');

                $('.clone-table tbody tr').each(function (i, v) {
                    var td_clone = $('td.clone-plane', v).not('.new-clone-plane');
                    //$(v).append('<td class="new-clone-plane"><input type="text" name="amount['+th_clone.length+'][]" value="" class="form-control"></td>');
                    $(v).append('<td class="new-clone-plane">'+td_clone.html()+'</td>');
                    $(v).find('td:last input').val('');
                    $(v).find('td:last input[name*=payment\\[amount\\]]').attr('name', 'payment[amount]['+n+'][]');
                });
            });


            $(document).on('click', '.remove-v-column', function (e) {
                e.preventDefault();
                if($('.clone-table th.clone-plane').length <= 1){
                    return false;
                }
                var th = $(this).closest('.clone-plane');
                var th_index = th[0].cellIndex;
                th.remove();
                $('tbody tr td:nth-child('+(th_index + 1)+')').remove();

            });
            $(document).on('click', '.add-row', function (e) {
                e.preventDefault();
                var tr_clone = $('.clone-table tbody tr:last').eq(0);
                var n = $('th.clone-plane').length;
                //tr_clone = tr_clone.clone().find('input,select').val('');
                tr_clone.closest('tbody').append('<tr>' + tr_clone.html() + '</tr>');
                $('.clone-table tbody tr:last').find('input').val('');
                $(v).find('td:last input[name*=payment\\[amount\\]]').attr('name', 'payment[amount]['+n+'][]');
            });

            $(document).on('click', '.remove-row', function (e) {
                e.preventDefault();
                if($('.clone-table tbody tr').length <= 1){
                    return false;
                }
                var th = $(this).closest('tr').remove();
            });
        });
    });
</script>
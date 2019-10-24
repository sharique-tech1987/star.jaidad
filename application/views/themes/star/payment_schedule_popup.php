<?php
$keys = array_keys($_payments);
?>
<h4 class="text-center">Payment Schedule</h4>
<table class="table -table-striped table-hover -table-responsive grid-table payment-schedule-table clone-table">
    <thead class="thead-default">
    <tr>
        <th width="260" class="text-center">PARTICULARS</th>
        <?php
        foreach ($keys as $i => $key) {
            $floors = explode('-', $key);
            ?>
            <th width="150" class="text-center">
                <?php echo $floors[0] . ordinal_suffix($floors[0]);?> to <?php echo $floors[1] . ordinal_suffix($floors[1]);?>
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
            <td>
                <?php echo $payment->particulars;?>
                <?php
                if($payment->installment_duration > 0) {
                    echo "($payment->installment_duration x ".number_format($payment->amount).")";
                }
                ?>
            </td>
            <?php foreach ($keys as $key) {
                ?>
                <td class=" text-center">
                    <?php
                    if($payment->installment_duration > 0){
                        $sub_total[$key] += ($payment->installment_duration * $payment->amount);
                        echo number_format($payment->installment_duration * $payment->amount);
                    } else{
                        $sub_total[$key] += $_payments[$key][$i]->amount;
                        echo number_format($_payments[$key][$i]->amount);
                    }?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td><b>TOTAL CASH</b></td>
        <?php
        foreach ($keys as $key) { ?>
            <td class="text-center">
                <b><?php echo number_format($sub_total[$key]);?></b><br><br>
                <a href="<?php echo site_url("project/booking/{$row->id}");?>" class="theme-btn btn-style-one">Book Now</a>
            </td>
        <?php } ?>
    </tr>
    </tfoot>
</table>

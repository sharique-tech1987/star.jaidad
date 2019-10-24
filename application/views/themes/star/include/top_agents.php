<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_agents');

$limit = 4;
$offset = 0;
//$order = 'users.id DESC';
$order = 'total_properties DESC';
$where = " AND users.status='Active' AND users.user_type_id='" . get_option('agent_type_id') . "'";

$ci->m_agents->property_count = true;
$rows = $ci->m_agents->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_agents->num_rows;
$total_rows = $ci->m_agents->total_rows;
?>

<?php
if($total_rows > 0){
?>
<h4 class="widget-title"><span>Top Agents</span></h4>
<div class="ere-list-top-agents-wrap">
    <div class="ere-list-top-agents">
        <?php
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                //$total = $ci->db->query("SELECT count(id) AS total FROM properties WHERE created_by='{$row->id}'")->row()->total;
                ?>
                <div class="agent-item">
                    <div class="agent-avatar">
                        <a title="<?php echo $row->full_name;?>" href="<?php echo site_url("agent/{$row->id}");?>">
                            <img class="img-circle" width="370" height="475" src="<?php echo _img("assets/front/users/{$row->photo}", 270, 270, USER_IMG_NA);?>" alt="<?php echo $row->full_name;?>" title="<?php echo $row->full_name;?>">
                        </a>
                    </div>
                    <div class="agent-info">
                        <h2 class="agent-name">
                            <a title="<?php echo $row->full_name;?>" href="<?php echo site_url("agent/{$row->id}");?>"><?php echo $row->full_name;?></a>
                        </h2>
                        <!--<span class="agent-position">Real Estate Broker</span>-->
                        <div class="agent-total-properties">
                            <span class="total-properties"><?php echo number_format($row->total_properties);?></span> Properties
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?php } ?>
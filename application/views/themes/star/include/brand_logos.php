<?php
$ci = &get_instance();
$ci->load->model(ADMIN_DIR . "m_clients_logo");
$limit = 20;
$offset = 0;
$order = 'clients_logo.ordering ASC';
$where = " AND clients_logo.status='Active' ";

$LOGO_SQL = "SELECT * FROM (SELECT 'clients_logo' as logo_type, clients_logo.logo, clients_logo.client_name, clients_logo.status  FROM clients_logo WHERE status='Active' AND clients_logo.logo IS NOT NULL 
UNION DISTINCT
SELECT 'users' as logo_type, users.`logo`, users.logo_alt_name, users.`logo_status`  FROM `users` WHERE logo_status='Active' AND users.`logo` IS NOT NULL ) ds
LIMIT 0, 20";

$rows = $this->db->query($LOGO_SQL)->result();
//$rows = $ci->m_clients_logo->rows($where, $limit, $offset, $order);
/*$num_rows = $ci->m_clients_logo->num_rows;
$total_rows = $ci->m_clients_logo->total_rows;*/
if (count($rows) > 0) {

    ?>
    <div data-vc-full-width="true" data-vc-full-width-init="false"
         class="vc_row wpb_row vc_row-fluid vc_custom_1521514185224 vc_row-has-fill vc-row-has-fill-custom ">
        <div vc_row wpb_row vc_row-fluid vc_custom_1521514185224 vc_row-has-fill vc-row-has-fill-customclass="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner">
                <div class="wpb_wrapper">
                    <div class="g5plus-clients owl-carousel" data-plugin-options='{
                                     "autoHeight": true, "dots": false, "nav": true, "responsive": {"0" : {"items" : 1}, "481" : {"items" : 2}, "768" : {"items" : 3}, "992" : {"items" : 4}, "1200" : {"items" : 5}}, "autoplay": true, "autoplaySpeed":250,"autoplayHoverPause":false}'>
                        <?php
                        foreach ($rows as $row) {
                            $img_url = asset_url("front/clients_logo/" . $row->logo);
                            ?>
                            <div class='clients-item ' style="opacity: 1;">
                                <div class="clients-item-inner "><img
                                            src="<?php echo _img(asset_url("front/{$row->logo_type}/" . $row->logo), 204, 136); ?>"
                                            alt="<?php echo $row->client_name; ?>"></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="vc_row-full-width vc_clearfix"></div>
<?php } ?>

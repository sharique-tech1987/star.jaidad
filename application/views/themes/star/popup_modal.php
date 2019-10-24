<?php
$popups = $this->cms->get_banners("type IN('Popup')");
if (count($popups) > 0) {
    ?>
    <div class="modal fade" id="popup-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body padding-0">
                    <div class="popup-carousel owl-carousel owl-theme">
                        <?php
                        foreach ($popups as $item) {
                            ?>
                            <div class="item">
                                <a href="<?php echo $item->link; ?>" target="_blank">
                                    <img src="<?php echo _img(asset_url("front/banner_management/{$item->image}"), 800); ?>"
                                         class="" alt="<?php echo $item->title; ?>">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $(document).ready(function () {
                /*$('#popup-modal').on('shown.bs.modal', function () {
                 $('body').removeClass('modal-open');
                 });*/



            });
        });


    </script>
<?php } ?>

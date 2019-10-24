<?php
if($g_area_id > 0) {
$reviews =  get_area_reviews(['area_id' => $g_area_id, 'limit' => 5]);
if(!empty($reviews)) {
?>
    <aside id="g5plus-recent-properties-2" class="widget widget-recent-properties">
    <h4 class="widget-title"><span>Area Review's</span></h4>
        <div class="g5-recent-properties" style="padding: 5px; position: relative;">
            <?php echo $reviews;?>
        </div>

        <div class="" style="display: none;">
            <form action="" class="form-horizontal" method="post">
                <div class="form-group">
                    <br>
                    <!--<b class="col-md-12">Nickname : <span class="mandatory">*</span></b>-->
                    <div class="col-md-12">
                        <input type="text" name="nickname" id="nickname" placeholder="Nickname" class="form-control  validate[required]" value="<?php echo $row->nickname ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <!--<b class="col-md-12">Email : <span class="mandatory">*</span></b>-->
                    <div class="col-md-12">
                        <input type="text" name="email" placeholder="Email" id="email" class="form-control  validate[required,custom[email]]" value="<?php echo $row->email ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <!--<b class="col-md-12">Review : <span class="mandatory">*</span></b>-->
                    <div class="col-md-12">
                        <textarea name="review" id="review" placeholder="Review" class="form-control validate[required]" cols="50" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <!--<b class="col-md-12">Review : <span class="mandatory">*</span></b>-->
                    <div class="col-md-12">
                        <div class="rating-types" data-field="score" data-readonly="false" data-score="0" id="area-rating"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="submit" name="submit" id="submit" class="theme-btn btn-style-one btn-block" value="Post comment"/>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </aside>

<?php } }?>
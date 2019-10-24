<?php
//return;
$params = json_decode($item['params']);
/*name="params[icon]"*/
?>
<div class="form-group row">
    <div class="col-sm-6">
        <label>Alt Tag</label>
        <input type="text" class="form-control params" name="params[alt]" placeholder="Alt tag" value="<?php echo $params->alt; ?>">
    </div>
    <div class="col-sm-6">
        <label>Icon</label>
        <div class="input-group m-input-group">
            <input type="text" name="params[icon]" id="icon" class="form-control icon-class" placeholder="Icon" value="<?php echo ($params->icon);?>" />
            <div class="input-group-append">
                <a class="input-group-text" data-toggle="modal" role="button"  data-toggle="modal" data-target="#icon_modal">
                    <span class="icon-show">Pick</span>
                </a>
            </div>
        </div>
    </div>
</div>

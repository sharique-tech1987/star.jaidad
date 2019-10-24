<!-- Property Search Section -->
<section class="property-search-section">
    <div class="auto-container">
        <div class="property-search-tabs tabs-box">
            <ul class="tab-buttons">
                <li data-tab="#sale" class="tab-btn active-btn">Sale</li>
                <li data-tab="#rent" class="tab-btn">Rent</li>
            </ul>

            <div class="tabs-content">
                <!--Tab / Active Tab-->
                <div class="tab active-tab" id="sale">
                    <div class="property-search-form">
                        <form method="get" action="<?php echo site_url('properties');?>">
                            <div class="row">

                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Purpose</b> <br>
                                    <select class="custom-select-box" name="purpose">
                                        <?php echo selectBox(get_enum_values('properties', 'purpose'));?>
                                    </select>
                                </div>

                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>City</b> <br>
                                    <select class="select2" name="city_id" id="search_city_id">
                                        <?php echo selectBox("SELECT id, city FROM cities", ($row->city_id));?>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-8 col-md-8 col-sm-12">
                                    <b>Location</b> <br>
                                    <select class="select2-tags-area" id="search_area_id" name="area_ids[]" multiple>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Property Type</b><br>
                                    <select class="custom-select-box" name="type_id">
                                        <option>Property Type</option>
                                        <?php
                                        $this->multilevels->type = 'select';
                                        $this->multilevels->id_Column = 'id';
                                        $this->multilevels->title_Column = 'type';
                                        $this->multilevels->link_Column = 'module';
                                        $this->multilevels->type = 'select';
                                        $this->multilevels->level_spacing = 7;
                                        //$this->multilevels->spacing_str = '-';
                                        $this->multilevels->selected = $row->type_id;
                                        $this->multilevels->query = "SELECT * FROM `property_types` WHERE 1 ORDER BY ordering ASC";
                                        echo $multiLevelComponents = $this->multilevels->build();
                                        ?>
                                    </select>
                                </div>


                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <b>Price (PKR)</b><br>
                                    <div class="row">
                                        <div class="col-md-6 padding-r-2">
                                            <input type="text" name="price[min]" class="form-control" placeholder="Price Min">
                                        </div>
                                        <div class="col-md-6 padding-l-0">
                                            <input type="text" name="price[max]" class="form-control" placeholder="Price Max">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <b>Area (Marla)</b><br>
                                    <div class="row">
                                        <div class="col-md-6 padding-r-2">
                                            <input type="text" name="area[min]" class="form-control" placeholder="Area Min">
                                        </div>
                                        <div class="col-md-6 padding-l-0">
                                            <input type="text" name="area[max]" class="form-control" placeholder="Area Max">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Bedrooms</b><br>
                                    <select class="custom-select-box" name="bedrooms">
                                        <option value="">Any</option>
                                        <?php
                                        foreach (range(1, 10) as $item) {
                                            echo '<option value="'.$item.'">'.$item.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <!--<div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <div class="range-slider-one clearfix">
                                        <label>Price Filter</label>
                                        <div class="price-range-slider"></div>
                                        <div class="input"><input type="text" class="price-amount" name="field-name" readonly></div>
                                        <div class="title">US Doller</div>
                                    </div>
                                </div>-->

                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <button type="submit" class="theme-btn btn-style-two">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--Tab -->
                <div class="tab" id="rent">
                    <div class="property-search-form">
                        <form method="get" action="<?php echo site_url('properties');?>">
                            <div class="row">

                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Purpose</b> <br>
                                    <select class="custom-select-box" name="purpose">
                                        <?php echo selectBox(get_enum_values('properties', 'purpose'));?>
                                    </select>
                                </div>

                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>City</b> <br>
                                    <select class="select2" name="city_id" id="search_city_id">
                                        <?php echo selectBox("SELECT id, city FROM cities", ($row->city_id));?>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-8 col-md-8 col-sm-12">
                                    <b>Location</b> <br>
                                    <select class="select2-tags-area" id="search_area_id" name="area_ids[]" multiple>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Property Type</b><br>
                                    <select class="custom-select-box" name="type_id">
                                        <option>Property Type</option>
                                        <?php
                                        $this->multilevels->type = 'select';
                                        $this->multilevels->id_Column = 'id';
                                        $this->multilevels->title_Column = 'type';
                                        $this->multilevels->link_Column = 'module';
                                        $this->multilevels->type = 'select';
                                        $this->multilevels->level_spacing = 7;
                                        //$this->multilevels->spacing_str = '-';
                                        $this->multilevels->selected = $row->type_id;
                                        $this->multilevels->query = "SELECT * FROM `property_types` WHERE 1 ORDER BY ordering ASC";
                                        echo $multiLevelComponents = $this->multilevels->build();
                                        ?>
                                    </select>
                                </div>


                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <b>Price (PKR)</b><br>
                                    <div class="row">
                                        <div class="col-md-6 padding-r-2">
                                            <input type="text" name="price[min]" class="form-control" placeholder="Price Min">
                                        </div>
                                        <div class="col-md-6 padding-l-0">
                                            <input type="text" name="price[max]" class="form-control" placeholder="Price Max">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <b>Area (Marla)</b><br>
                                    <div class="row">
                                        <div class="col-md-6 padding-r-2">
                                            <input type="text" name="area[min]" class="form-control" placeholder="Area Min">
                                        </div>
                                        <div class="col-md-6 padding-l-0">
                                            <input type="text" name="area[max]" class="form-control" placeholder="Area Max">
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                    <b>Bedrooms</b><br>
                                    <select class="custom-select-box" name="bedrooms">
                                        <option value="">Any</option>
                                        <?php
                                        foreach (range(1, 10) as $item) {
                                            echo '<option value="'.$item.'">'.$item.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Form Group -->
                                <!--<div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <div class="range-slider-one clearfix">
                                        <label>Price Filter</label>
                                        <div class="price-range-slider"></div>
                                        <div class="input"><input type="text" class="price-amount" name="field-name" readonly></div>
                                        <div class="title">US Doller</div>
                                    </div>
                                </div>-->

                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                    <button type="submit" class="theme-btn btn-style-two">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Property Search Section -->
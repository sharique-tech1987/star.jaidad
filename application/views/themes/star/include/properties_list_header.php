<div class="above-archive-property">
    <div class="ere-heading">
        <h2>Recommended</h2>
    </div>
    <div class="archive-property-action property-status-filter">
        <div class="archive-property-action-item">
            <div class="property-status property-filter">
                <ul>

                    <!--<li class="<?php /*echo empty($purpose) ? 'active' : '';*/?>"><a data-status="all" href="" title="All">All</a></li>-->
                    <li class="<?php echo ($purpose == 'Sale') ? 'active' : '';?> property-status-cust"><a href="javascript:void(0)" data-href="<?php echo generate_url('purpose');?>&purpose=Sale" title="For Sale">For Sale</a></li>
                    <li class="<?php echo ($purpose == 'Rent') ? 'active' : '';?> property-status-cust"><a href="javascript:void(0)" data-href="<?php echo generate_url('purpose');?>&purpose=Rent" title="For Rent">For Rent</a></li>

                </ul>
            </div>
        </div>
        <div class="archive-property-action-item sort-view-property">
            <div class="sort-property property-filter">
                <span class="property-filter-placeholder"><?php echo empty($_is_order) ? 'Sort By' : $_is_order;?></span>

                <ul class="property-filter-placeholder-custom">

                    <li class="<?php echo ($_is_order == 'Newest') ? 'active' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_id=DESC">Newest</a></li>
                    <li class="<?php echo ($_is_order == 'ASC') ? 'Lowest Price' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_price=ASC">Lowest Price</a></li>
                    <li class="<?php echo ($_is_order == 'Highest Price') ? 'active' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_price=DESC">Highest Price</a></li>
                </ul>
            </div>
            <div class="view-as">
                                            <span data-view-as="property-list" class="view-as-list" title="View as List">
                                                <i class="fa fa-list-ul"></i>
                                            </span>
                <span class="view-as-grid" title="View as Grid">
                                                <i class="fa fa-th-large"></i>
                                            </span>
            </div>
        </div>
    </div>
</div>
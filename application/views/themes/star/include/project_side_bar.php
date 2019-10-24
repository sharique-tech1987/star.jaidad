<aside class="sidebar default-sidebar">

    <!--search box-->
    <div class="sidebar-widget sort-by">
        <select class="custom-select-box">
            <option>Sort By</option>
            <option>Residential</option>
            <option>Commercial</option>
            <option>Industrial</option>
            <option>Apartments</option>
        </select>
    </div>

    <!-- Categories -->
    <div class="sidebar-widget search-properties">
        <div class="sidebar-title"><h2>Search Projects</h2></div>
        <!-- Property Search Form -->
        <div class="property-search-form style-three">
        <?php include "left_search_box.php"?>
        </div>
        <!-- End Form -->
    </div>

    <!-- Categories -->
    <!--<div class="sidebar-widget categories">
        <div class="sidebar-title"><h2>Category Project</h2></div>
        <ul class="cat-list">
            <li><a href="#">Apartments <span>22</span></a></li>
            <li><a href="#">Villas <span>45</span></a></li>
            <li><a href="#">Open Houses <span>62</span></a></li>
            <li><a href="#">Offices <span>70</span></a></li>
            <li><a href="#">Residentals <span>90</span></a></li>
            <li><a href="#">Co-Working <span>65</span></a></li>
            <li><a href="#">Flat <span>48</span></a></li>
            <li><a href="#">Cottage <span>24</span></a></li>
        </ul>
    </div>-->

    <!-- Recent project -->
    <?php include "property_recent.php"?>


</aside>
function numDifferentiation (value) {
    var val = Math.abs(value)
    if (val >= 10000000) {
        val = (val / 10000000).toFixed(2) + ' Crore';
    } else if (val >= 100000) {
        val = (val / 100000).toFixed(2) + ' Lac';
    }
    else if(val >= 1000) val = (val/1000).toFixed(2) + ' K';
    return val;
}

(function ($) {

    "use strict";

    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(200).fadeOut(500);
        }
    }

    //Open Main Menu
    if($('.main-header .nav-toggler .toggler-btn').length){
        $('.main-header .nav-toggler .toggler-btn').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $('body').toggleClass('side-content-visible');
        });

        //Hide Form
        $('.hidden-bar .cross-icon').on('click', function(e) {
            e.preventDefault();
            $('body').removeClass('side-content-visible');
            $(".main-header .nav-toggler .toggler-btn").removeClass('active');
        });
    }



    //Update Header Style and Scroll to Top
    function headerStyle() {
        if ($('.main-header').length) {
            var windowpos = $(window).scrollTop();
            var siteHeader = $('.main-header');
            var sticky_header = $('.main-header .sticky-header');
            var scrollLink = $('.scroll-to-top');
            if (windowpos > 200) {
                siteHeader.addClass('fixed-header');
                sticky_header.addClass("animated slideInDown");
                scrollLink.fadeIn(300);
            } else {
                siteHeader.removeClass('fixed-header');
                sticky_header.removeClass("animated slideInDown");
                scrollLink.fadeOut(300);
            }
        }
    }

    headerStyle();


    //Submenu Dropdown Toggle
    if ($('.main-header li.dropdown ul').length) {
        $('.main-header li.dropdown').append('<div class="dropdown-btn"><span class="la la-angle-down"></span></div>');

        //Dropdown Button
        $('.main-header li.dropdown .dropdown-btn').on('click', function () {
            $(this).prev('ul').slideToggle(500);
        });

        //Megamenu Toggle
        $('.main-header .main-menu li.dropdown .dropdown-btn').on('click', function () {
            $(this).prev('.mega-menu').slideToggle(500);
        });

        //Disable dropdown parent link
        $('.main-header .navigation li.dropdown > a,.hidden-bar .side-menu li.dropdown > a').on('click', function (e) {
            e.preventDefault();
        });
    }

    //Banner Carousel
    if ($('.banner-carousel').length) {
        $('.banner-carousel').owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            loop: true,
            /*margin: 30,*/
            nav: true,
            smartSpeed: 15000,
            mouseDrag: false,
            touchDrag: false,
            autoHeight: true,
            autoplay: true,
            autoplayTimeout: 10000,
            navText: ['<span class="la la-long-arrow-left"></span>', '<span class="la la-long-arrow-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1024: {
                    items: 1
                },
            }
        });
    }

    //Recent Property Carousel
    if ($('.recent-property-carousel').length) {
        $('.recent-property-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 700,
            autoplay: false,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    }

    //Single Item Carousel
    if ($('.single-item-carousel').length) {
        $('.single-item-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            smartSpeed: 700,
            autoplay: true,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
    }

    //Property Carousel
    if ($('.property-carousel').length) {
        $('.property-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 1000,
            autoplay: true,
            navText: ['<span class="la la-caret-square-o-left"></span>', '<span class="la la-caret-square-o-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
    }

    //Popular Places Carousel
    if ($('.popular-places-carousel').length) {
        $('.popular-places-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            smartSpeed: 1000,
            autoplay: true,
            navText: ['<span class="la la-caret-square-o-left"></span>', '<span class="la la-caret-square-o-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1800: {
                    items: 5
                }
            }
        });
    }

    //Testimonial Carousel
    if ($('.testimonial-carousel').length) {
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            smartSpeed: 700,
            autoplay: true,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 2
                }
            }
        });
    }

    //Testimonial Carousel
    if ($('.testimonial-carousel-two').length) {
        $('.testimonial-carousel-two').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 700,
            autoplay: true,
            navText: ['<span class="la la-caret-square-o-left"></span>', '<span class="la la-caret-square-o-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                800: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
    }

    //Agents Carousel
    if ($('.agents-carousel').length) {
        $('.agents-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 700,
            autoplay: false,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    }

    //Agents Property Carousel
    if ($('.agent-property-carousel').length) {
        $('.agent-property-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 700,
            autoplay: false,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    }

    //Clients Carousel
    if ($('.sponsors-carousel').length) {
        $('.sponsors-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            smartSpeed: 700,
            autoplay: true,
            navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            }
        });
    }

    // Product Carousel Slider
    if ($('.property-detail .image-carousel').length && $('.property-detail .thumbs-carousel').length) {

        var $sync1 = $(".property-detail .image-carousel"),
            $sync2 = $(".property-detail .thumbs-carousel"),
            flag = false,
            duration = 500;

        $sync1
            .owlCarousel({
                loop: false,
                items: 1,
                margin: 0,
                nav: false,
                navText: ['<span class="icon fa fa-angle-left"></span>', '<span class="icon fa fa-angle-right"></span>'],
                dots: false,
                autoplay: true,
                autoplayTimeout: 5000
            })
            .on('changed.owl.carousel', function (e) {
                if (!flag) {
                    flag = false;
                    $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            });

        $sync2
            .owlCarousel({
                loop: false,
                margin: 10,
                items: 1,
                nav: true,
                navText: ['<span class="icon la la-arrow-circle-o-left"></span>', '<span class="icon la la-arrow-circle-o-right"></span>'],
                dots: false,
                center: false,
                autoplay: true,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 2,
                        autoWidth: false
                    },
                    400: {
                        items: 2,
                        autoWidth: false
                    },
                    600: {
                        items: 3,
                        autoWidth: false
                    },
                    800: {
                        items: 5,
                        autoWidth: false
                    },
                    1024: {
                        items: 4,
                        autoWidth: false
                    }
                },
            })

            .on('click', '.owl-item', function () {
                $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
            })
            .on('changed.owl.carousel', function (e) {
                if (!flag) {
                    flag = true;
                    $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            });

    }

    //Sortable Masonary with Filters
    function enableMasonry() {
        if ($('.sortable-masonry').length) {

            var winDow = $(window);
            // Needed variables
            var $container = $('.sortable-masonry .items-container');
            var $filter = $('.filter-btns');

            $container.isotope({
                filter: '*',
                masonry: {
                    columnWidth: '.masonry-item.small-column'
                },
                animationOptions: {
                    duration: 500,
                    easing: 'linear'
                }
            });


            // Isotope Filter
            $filter.find('li').on('click', function () {
                var selector = $(this).attr('data-filter');

                try {
                    $container.isotope({
                        filter: selector,
                        animationOptions: {
                            duration: 500,
                            easing: 'linear',
                            queue: false
                        }
                    });
                } catch (err) {

                }
                return false;
            });


            winDow.on('resize', function () {
                var selector = $filter.find('li.active').attr('data-filter');

                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 500,
                        easing: 'linear',
                        queue: false
                    }
                });
            });


            var filterItemA = $('.filter-btns li');

            filterItemA.on('click', function () {
                var $this = $(this);
                if (!$this.hasClass('active')) {
                    filterItemA.removeClass('active');
                    $this.addClass('active');
                }
            });
        }
    }

    enableMasonry();

    //Default Masonary
    function defaultMasonry() {
        if ($('.masonry-items-container').length) {

            var winDow = $(window);
            // Needed variables
            var $container = $('.masonry-items-container');

            $container.isotope({
                itemSelector: '.masonry-item',
                masonry: {
                    columnWidth: 1
                },
                animationOptions: {
                    duration: 500,
                    easing: 'linear'
                }
            });

            winDow.on('resize', function () {

                $container.isotope({
                    itemSelector: '.masonry-item',
                    animationOptions: {
                        duration: 500,
                        easing: 'linear',
                        queue: false
                    }
                });
            });
        }
    }

    defaultMasonry();

    //Price Range Slider
    if ($('.price-range-slider').length) {
        $(".price-range-slider").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [1000, 8000],
            slide: function (event, ui) {
                $("input.price-amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });

        $("input.price-amount").val($(".price-range-slider").slider("values", 0) + " - $" + $(".price-range-slider").slider("values", 1));
    }

    //Price Range Slider
    if ($('.area-range-slider').length) {
        $(".area-range-slider").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [100, 900],
            slide: function (event, ui) {
                $("input.property-amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });

        $("input.property-amount").val($(".area-range-slider").slider("values", 0) + " - " + $(".area-range-slider").slider("values", 1));
    }


    //Custom Seclect Box
    if ($('.custom-select-box').length) {
        $('.custom-select-box').selectmenu().selectmenu('menuWidget').addClass('overflow');
    }

    //Gallery Filters
    if ($('.filter-list').length) {
        $('.filter-list').mixItUp({});
    }


    //Fact Counter + Text Count
    if ($('.count-box').length) {
        $('.count-box').appear(function () {

            var $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);

            if (!$t.hasClass("counted")) {
                $t.addClass("counted");
                $({
                    countNum: $t.find(".count-text").text()
                }).animate({
                    countNum: n
                }, {
                    duration: r,
                    easing: "linear",
                    step: function () {
                        $t.find(".count-text").text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        $t.find(".count-text").text(this.countNum);
                    }
                });
            }

        }, {accY: 0});
    }

    //Progress Bar
    if ($('.progress-line').length) {
        $('.progress-line').appear(function () {
            var el = $(this);
            var percent = el.data('width');
            $(el).css('width', percent + '%');
        }, {accY: 0});
    }

    //Tabs Box
    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).attr('data-tab'));

            if ($(target).is(':visible')) {
                return false;
            } else {
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
                $(target).fadeIn(300);
                $(target).addClass('active-tab');
            }
        });
    }

    //Accordion Box
    if ($('.accordion-box').length) {
        $(".accordion-box").on('click', '.acc-btn', function () {

            var outerBox = $(this).parents('.accordion-box');
            var target = $(this).parents('.accordion');

            if ($(this).hasClass('active') !== true) {
                $(outerBox).find('.accordion .acc-btn').removeClass('active ');
            }

            if ($(this).next('.acc-content').is(':visible')) {
                return false;
            } else {
                $(this).addClass('active');
                $(outerBox).children('.accordion').removeClass('active-block animated fadeInUp');
                $(outerBox).find('.accordion').children('.acc-content').slideUp(300);
                target.addClass('active-block animated fadeInUp');
                $(this).next('.acc-content').slideDown(300);
            }
        });
    }

    //Event Countdown Timer
    if ($('.time-countdown').length) {
        $('.time-countdown').each(function () {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                var $this = $(this).html(event.strftime('' + '<div class="counter-column"><span class="count">%D</span>Days</div> ' + '<div class="counter-column"><span class="count">%H</span>Hours</div>  ' + '<div class="counter-column"><span class="count">%M</span>Mints</div>  ' + '<div class="counter-column"><span class="count">%S</span>Sec</div>'));
            });
        });
    }


    //LightBox / Fancybox
    if ($('.lightbox-image').length) {
        $('.lightbox-image').fancybox({
            openEffect: 'fade',
            closeEffect: 'fade',
            helpers: {
                media: {}
            }
        });
    }

    //Contact Form Validation
    if ($('#contact-form').length) {
        $('#contact-form').validate({
            rules: {
                username: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            }
        });
    }

    // Scroll to a Specific Div
    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function () {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1500);

        });
    }

    // Elements Animation
    if ($('.wow').length) {
        var wow = new WOW(
            {
                boxClass: 'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 0,          // distance to the element when triggering the animation (default is 0)
                mobile: false,       // trigger animations on mobile devices (default is true)
                live: true       // act on asynchronously loaded content (default is true)
            }
        );
        wow.init();
    }

    function fullHeight() {
        $('.full-height').css("height", $(window).height());
    }

    fullHeight()

    /* ==========================================================================
        When document is resize, do
       ========================================================================== */
    $(window).on('resize', function () {
        fullHeight();
    });

    /* ==========================================================================
       When document is Scrollig, do
       ========================================================================== */

    $(window).on('scroll', function () {
        headerStyle();
    });

    /* ==========================================================================
       When document is loading, do
       ========================================================================== */

    $(window).on('load', function () {
        handlePreloader();
        enableMasonry();
        defaultMasonry();
    });
    console.log($('.select2,.m-select2'));
    $('.select2,.m-select2').select2({
        //
    });

    function format(state) {
        if (!state.id) return state.text; // optgroup
        var icon = $(state.element).data('icon');
        var img = $(state.element).data('img');
        if(icon && icon.length > 0){
            return "<i class='" + icon + "'></i> &nbsp;" + state.text;
        }else if(img && img.length > 0){
            return "<img class='option-img' src='" + img + "'/>&nbsp;&nbsp;" + state.text;
        }else{
            return state.text;
        }
        //return "<img class='flag' src='" + MyFILEPATH() + "flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
    }


    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.value + "</div>";
        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.value + "</div>";
        }
        /* markup += "<div class='select2-result-repository__statistics'>" +
             "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
             "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
             "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
             "</div>" +
             "</div></div>";*/
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.text || repo.text;
    }

    $('.select2-tags-area').select2({
        tags: true,
        minimumInputLength: 1,
        ajax: {
            url: site_url + 'property/ajax/search_area',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var city_id = $('#search_city_id').val();
                return {
                    q: params.term, // search term
                    city_id: city_id, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        // escapeMarkup: function (markup) {
        //     return markup;
        // }, // let our custom formatter work
        // templateResult: formatRepo, // omitted for brevity, see the source of this page
        // templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

    $(document).on('change', '#search_city_id', function (e) {
        $('#search_area_id').val(null).trigger('change');
    });

    $('.select2-tags').select2({
        tags: true
    });

    $(".rating-types").each(function () {
        var i = $(this).data("score"), n = $(this).data("readonly"), s = $(this).data("field");

        $(this).raty({
            score: i,
            readOnly: n,
            starHalf: media_url + "/images/raty/star-half.png",
            starOff: media_url + "/images/raty/star-off.png",
            starOn: media_url + "/images/raty/star-on.png",
            scoreName: s,
            path: "",
        })
    })


    $(".m-select2-ajax").select2({
        ajax: {
            url: function (params) {
                return $(this).data('url') + '/?term=' + params.term;
            },
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var postData = {
                    q: params.term, // search term
                    page: params.page
                };
                var formData = $($(this).data('data_ele')).serializeArray();
                $.each(formData, function( index, e ) {
                    postData[e.name] = e.value
                });
                //console.log(postData);
                return postData;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        //dropdownParent: $('.modal'),
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: format,
        templateSelection: format,
    });

    $(document).on('change', '[load-select]', function (e) {
        e.preventDefault();
        var _this = $(this);
        var next_select = $(_this.attr('load-select'));
        next_select.each(function (index, ele) {
            load_select(_this, $(ele));
        });
    });

    function load_select(ele, select_ele){

        var url = select_ele.attr('load-url');
        var selected_val = select_ele.val();
        select_ele.html('<option value="">Loading...</option>');

        $.get(url, {id : ele.val(), selected: selected_val})
            .done(function (data) {
                select_ele.html(data);
            })
            .fail(function () {
                var notify = $.notify('Record not found!', {type: 'danger', newest_on_top: true, allow_dismiss: true,});
            });
    }


    $(document).on('click', '[remove-el]', function (e) {
        e.preventDefault();
        var _this = $(this);
        var ele = _this.attr('remove-el').split('.');
        var rm_name = _this.data('rm-name');
        var rm_value = _this.data('rm-value');
        if(rm_name != '') {
            _this.closest('form').append('<input type="hidden" name="' + rm_name + '" value="' + rm_value + '">');
        }

        if(ele[0] == 'parent' || ele[0] == 'parents' || ele[0] == 'closest'){
            _this.closest('.' + ele[1]).remove();
        } else if(ele[0] == ''){
            $('.' + ele[1]).remove();
        } else{
            ele = $(this).attr('remove-el').split('#');

            if(ele[0] == 'parent' || ele[0] == 'parents' || ele[0] == 'closest'){
                _this.closest('#' + ele[1]).remove();
            } else if(ele[0] == ''){
                $('#' + ele[1]).remove();
            }
        }
    });



})(window.jQuery);
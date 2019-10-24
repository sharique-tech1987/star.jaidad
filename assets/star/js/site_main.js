var G5Plus = G5Plus || {};
(function ($) {
	"use strict";
	
	var $window = $(window),
		$body = $('body'),
		isRTL = $body.hasClass('rtl'),
		deviceAgent = navigator.userAgent.toLowerCase(),
		isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
		isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
		isAppleDevice = deviceAgent.match(/(iphone|ipod|ipad)/),
		isIEMobile = deviceAgent.match(/(iemobile)/);
	
	G5Plus.common = {
		init: function () {
			this.retinaLogo();
			this.owlCarousel();
			this.lightGallery();
			this.canvasSidebar();
			this.adminBarProcess();
			setTimeout(G5Plus.common.owlCarouselRefresh, 1000);
			setTimeout(G5Plus.common.owlCarouselCenter, 1000);
			this.count_down();
			this.singlePropertyMoveInfoToTop();
		},
		windowResized: function () {
			this.canvasSidebar();
			this.adminBarProcess();
			setTimeout(G5Plus.common.owlCarouselRefresh, 1000);
			setTimeout(G5Plus.common.owlCarouselCenter, 1000);
		},
		lightGallery: function () {
			$("[data-rel='lightGallery']").each(function () {
				var $this = $(this),
					galleryId = $this.data('gallery-id');
				$this.on('click', function (event) {
					event.preventDefault();
					var _data = [];
					var $index = 0;
					var $current_src = $(this).attr('href');
					var $current_thumb_src = $(this).data('thumb-src');
					
					if (typeof galleryId != 'undefined') {
						$('[data-gallery-id="' + galleryId + '"]').each(function (index) {
							var src = $(this).attr('href'),
								thumb = $(this).data('thumb-src'),
								subHtml = $(this).attr('title');
							if (src == $current_src && thumb == $current_thumb_src) {
								$index = index;
							}
							if (typeof(subHtml) == 'undefined')
								subHtml = '';
							_data.push({
								'src': src,
								'downloadUrl': src,
								'thumb': thumb,
								'subHtml': subHtml
							});
						});
						$this.lightGallery({
							hash: false,
							galleryId: galleryId,
							dynamic: true,
							dynamicEl: _data,
							thumbWidth: 80,
							index: $index
						})
					}
				});
			});
			$('a.view-video').on('click', function (event) {
				event.preventDefault();
				var $src = $(this).attr('data-src');
				$(this).lightGallery({
					dynamic: true,
					dynamicEl: [{
						'src': $src,
						'thumb': '',
						'subHtml': ''
					}]
				});
			});
		},
		owlCarousel: function () {
			$('.owl-carousel:not(.manual):not(.owl-loaded)').each(function () {
				var slider = $(this);
				var defaults = {
					items: 4,
					nav: false,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					dots: false,
					loop: false,
					center: false,
					mouseDrag: true,
					touchDrag: true,
					pullDrag: true,
					freeDrag: false,
					margin: 0,
					stagePadding: 0,
					merge: false,
					mergeFit: true,
					autoWidth: false,
					startPosition: 0,
					rtl: isRTL,
					smartSpeed: 250,
					fluidSpeed: false,
					dragEndSpeed: false,
					autoplayHoverPause: true
				};
				var config = $.extend({}, defaults, slider.data("plugin-options"));
				// Initialize Slider
				slider.owlCarousel(config);
				
				slider.on('changed.owl.carousel', function (e) {
					G5Plus.blog.masonryLayoutRefresh();
					G5Plus.page.gallerymasonryRefresh();
				});
				
			});
		},
		owlCarouselRefresh: function () {
			$('.owl-carousel.owl-loaded').each(function () {
				var $this = $(this),
					$slider = $this.data('owl.carousel');
				if (typeof ($slider) != 'undefined') {
					if ($slider.options.autoHeight) {
						var maxHeight = 0;
						$('.owl-item.active', $this).each(function () {
							if ($(this).outerHeight() > maxHeight) {
								maxHeight = $(this).outerHeight();
							}
						});
						
						$('.owl-height', $this).css('height', maxHeight + 'px');
					}
				}
			});
		},
		canvasSidebar: function () {
			var canvas_sidebar_mobile = $('.sidebar-mobile-canvas');
			var changed_class = 'changed';
			if (canvas_sidebar_mobile.length > 0) {
				if (!$('body').find('#wrapper').next().hasClass('overlay-canvas-sidebar')) {
					$('#wrapper').after('<div class="overlay-canvas-sidebar"></div>');
				}
				if (!G5Plus.common.isDesktop()) {
					canvas_sidebar_mobile.css('height', $(window).height() + 'px');
					canvas_sidebar_mobile.css('overflow-y', 'auto');
					if ($.isFunction($.fn.perfectScrollbar)) {
						canvas_sidebar_mobile.perfectScrollbar({
							wheelSpeed: 0.5,
							suppressScrollX: true
						});
					}
				} else {
					canvas_sidebar_mobile.css('overflow-y', 'hidden');
					canvas_sidebar_mobile.css('height', 'auto');
					canvas_sidebar_mobile.scrollTop(0);
					if ($.isFunction($.fn.perfectScrollbar) && canvas_sidebar_mobile.hasClass('ps-active-y')) {
						canvas_sidebar_mobile.perfectScrollbar('destroy');
					}
					canvas_sidebar_mobile.removeAttr('style');
					$('.overlay-canvas-sidebar').removeClass(changed_class);
					$('.sidebar-mobile-canvas', '#wrapper').removeClass(changed_class);
					$('.sidebar-mobile-canvas-icon', '#wrapper').removeClass(changed_class);
					
				}
				$('.sidebar-mobile-canvas-icon').on('click', function () {
					var $canvas_sidebar = $(this).parent().children('.sidebar-mobile-canvas');
					$(this).addClass(changed_class);
					$canvas_sidebar.addClass(changed_class);
					$('.overlay-canvas-sidebar').addClass(changed_class);
					
				});
				$('.overlay-canvas-sidebar').on('click', function () {
					if ($('.sidebar-mobile-canvas-icon').hasClass(changed_class)) {
						$(this).removeClass(changed_class);
						$('.sidebar-mobile-canvas', '#wrapper').removeClass(changed_class);
						$('.sidebar-mobile-canvas-icon', '#wrapper').removeClass(changed_class);
					}
				});
			}
		},
		isDesktop: function () {
			var responsive_breakpoint = 991;
			var $menu = $('.x-nav-menu');
			if (($menu.length > 0) && (typeof ($menu.attr('responsive-breakpoint')) != "undefined" ) && !isNaN(parseInt($menu.attr('responsive-breakpoint'), 10))) {
				responsive_breakpoint = parseInt($menu.attr('responsive-breakpoint'), 10);
			}
			return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
		},
		adminBarProcess: function () {
			if (window.matchMedia('(max-width: 600px)').matches) {
				$('#wpadminbar').css('top', '-46px');
			}
			else {
				$('#wpadminbar').css('top', '');
			}
		},
		retinaLogo: function () {
			if (window.matchMedia('only screen and (min--moz-device-pixel-ratio: 1.5)').matches
				|| window.matchMedia('only screen and (-o-min-device-pixel-ratio: 3/2)').matches
				|| window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.5)').matches
				|| window.matchMedia('only screen and (min-device-pixel-ratio: 1.5)').matches) {
				$('img[data-retina]').each(function () {
					$(this).attr('src', $(this).attr('data-retina'));
				});
			}
		},
		count_down: function () {
			$('.g5plus-countdown').each(function () {
				var date_end = $(this).data('date-end');
				var $this = $(this);
				$this.countdown(date_end, function (event) {
					count_down_callback(event, $this);
				}).on('update.countdown', function (event) {
					count_down_callback(event, $this);
				}).on('finish.countdown', function (event) {
					$('.countdown-seconds', $this).html(0);
					var $url_redirect = $this.attr('data-url-redirect');
					if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
						window.location.href = $url_redirect;
					}
				});
			});
			
			function count_down_callback(event, $this) {
				var seconds = parseInt(event.offset.seconds);
				var minutes = parseInt(event.offset.minutes);
				var hours = parseInt(event.offset.hours);
				var days = parseInt(event.offset.totalDays);
				
				if ((seconds == 0) && (minutes == 0) && (hours == 0) && (days == 0)) {
					var $url_redirect = $this.attr('data-url-redirect');
					if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
						window.location.href = $url_redirect;
					}
					return;
				}
				if (days < 10) days = '0' + days;
				if (hours < 10) hours = '0' + hours;
				if (minutes < 10) minutes = '0' + minutes;
				if (seconds < 10) seconds = '0' + seconds;
				
				$('.countdown-day', $this).text(days);
				$('.countdown-hours', $this).text(hours);
				$('.countdown-minutes', $this).text(minutes);
				$('.countdown-seconds', $this).text(seconds);
			}
		},
		singlePropertyMoveInfoToTop: function () {
			var elm = $('.property-info-action', '.content-single-property');
			if (elm.length > 0) {
				elm.insertBefore(elm.closest('#primary-content > .container > div'));
				elm.removeClass('hidden');
			}
		}
	};
	G5Plus.util = {
		init: function () {
		
		},
		getAdminBarOffset: function () {
			var adminBarOffset = 0,
				$adminBar = $('#wpadminbar');
			if ($adminBar.length > 0 && ($adminBar.css('position') == 'fixed')) {
				adminBarOffset = $adminBar.outerHeight();
			}
			return adminBarOffset;
		},
		getHeaderStickyOffset: function () {
			var headerStickyOffset = 0,
				$header = $('.is-sticky');
			if ($header.length > 0) {
				headerStickyOffset = 82;
			}
			return headerStickyOffset;
		},
		getScrollOffset: function () {
			var scroll_offset = 0;
			scroll_offset += this.getAdminBarOffset();
			scroll_offset += this.getHeaderStickyOffset();
			return scroll_offset;
		},
		isDesktop: function () {
			var responsive_breakpoint = 991;
			return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
		}
	};
	G5Plus.sticky = {
		init: function () {
			this.initSticky();
			setTimeout(function () {
				G5Plus.sticky.initSticky();
			}, 1000);
			this.responsive();
		},
		initSticky: function ($wrapper) {
			// disabled on mobile screens
			if (!$.fn.hcSticky) {
				return;
			}
			
			if (typeof $wrapper === 'undefined') {
				$wrapper = $body;
			}
			
			var _top = G5Plus.util.getScrollOffset();
			var defaults = {
				top: _top
			};
			
			$('.gf-sticky', $wrapper).each(function () {
				var $this = $(this);
				if (G5Plus.util.isDesktop()) {
					if ($this.data('hcSticky')) {
						$this.hcSticky('reinit');
					} else {
						var _top = G5Plus.util.getScrollOffset();
						var defaults = {
							top: _top
						};
						var config = $.extend({}, defaults, $this.data("sticky-options"));
						$this.hcSticky(config);
					}
				}
			});
		},
		responsive: function () {
			$body.on('resized.hcSticky', function (event, target) {
				if (!G5Plus.util.isDesktop()) {
					var $this = $(target);
					if ($this.data('hcSticky')) {
						$this.hcSticky('destroy');
					}
					$this.removeAttr('style');
				}
			});
		}
	};
	G5Plus.page = {
		init: function () {
			this.parallax();
			this.parallaxDisable();
			this.pageTitle();
			this.footerParallax();
			this.footerWidgetCollapse();
			this.pageTransition();
			this.backToTop();
			this.events();
			this.gallerymasonry();
			this.erepropertygallery();
			setTimeout(this.gallerymasonry, 300);
		},
		events: function () {
			$(document).on('vc-full-width-row', function (event, $elements) {
				$('.owl-carousel.owl-loaded', $('[data-vc-full-width="true"]')).each(function () {
					$(this).data('owl.carousel').onResize();
				});
			});
		},
		windowLoad: function () {
			this.fadePageIn();
		},
		windowResized: function () {
			this.parallaxDisable();
			this.pageTitle();
			this.footerParallax();
			this.footerWidgetCollapse();
			this.wpb_image_grid();
			this.erepropertygallery();
			G5Plus.page.gallerymasonryRefresh();
		},
		parallax: function () {
			$.stellar({
				horizontalScrolling: false,
				scrollProperty: 'scroll',
				positionProperty: 'position',
				responsive: false
			});
		},
		parallaxDisable: function () {
			if (G5Plus.common.isDesktop()) {
				$('.parallax').removeClass('parallax-disabled');
			} else {
				$('.parallax').addClass('parallax-disabled');
			}
		},
		pageTitle: function () {
			var $this = $('.page-title-layout-normal'),
				$container = $('.container', $this),
				$pageTitle = $('h1', $this),
				$breadcrumbs = $('.breadcrumbs', $this);
			$this.removeClass('left');
			if (($pageTitle.width() + $breadcrumbs.width()) > $container.width()) {
				$this.addClass('left');
			}
		},
		footerParallax: function () {
			if (window.matchMedia('(max-width: 767px)').matches) {
				$body.css('margin-bottom', '');
			}
			else {
				setTimeout(function () {
					var $footer = $('footer.main-footer-wrapper');
					if ($footer.hasClass('enable-parallax')) {
						var headerSticky = $('header.main-header .sticky-wrapper').length > 0 ? 55 : 0,
							$adminBar = $('#wpadminbar'),
							$adminBarHeight = $adminBar.length > 0 ? $adminBar.outerHeight() : 0;
						if (($window.height() >= ($footer.outerHeight() + headerSticky + $adminBarHeight))) {
							$body.css('margin-bottom', ($footer.outerHeight()) + 'px');
							$footer.removeClass('static');
						} else {
							$body.css('margin-bottom', '');
							$footer.addClass('static');
						}
					}
				}, 100);
			}
			
		},
		footerWidgetCollapse: function () {
			if (window.matchMedia('(max-width: 767px)').matches) {
				$('footer.footer-collapse-able aside.widget').each(function () {
					var $title = $('h4.widget-title', this);
					var $content = $title.next();
					$title.addClass('title-collapse');
					if ($content.length > 0) {
						$content.hide();
					}
					$title.off();
					$title.on('click', function () {
						var $content = $(this).next();
						
						if ($(this).hasClass('title-expanded')) {
							$(this).removeClass('title-expanded');
							$title.addClass('title-collapse');
							$content.slideUp();
						}
						else {
							$(this).addClass('title-expanded');
							$title.removeClass('title-collapse');
							$content.slideDown();
						}
						
					});
					
				});
			} else {
				$('footer aside.widget').each(function () {
					var $title = $('h4.widget-title', this);
					$title.off();
					var $content = $title.next();
					$title.removeClass('collapse');
					$title.removeClass('expanded');
					$content.show();
				});
			}
		},
		fullWidthRow: function () {
			$('[data-vc-full-width="true"]').each(function () {
				var $this = $(this),
					$wrapper = $('#wrapper');
				$this.addClass("vc_hidden");
				$this.attr('style', '');
				if (!$body.hasClass('has-sidebar')) {
					var $el_full = $this.next(".vc_row-full-width");
					$el_full.length || ($el_full = $this.parent().next(".vc_row-full-width"));
					var el_margin_left = parseInt($this.css("margin-left"), 10),
						el_margin_right = parseInt($this.css("margin-right"), 10),
						offset = $wrapper.offset().left - $el_full.offset().left - el_margin_left,
						width = $wrapper.width();
					$this.css({
						position: "relative",
						left: offset,
						"box-sizing": "border-box",
						width: $wrapper.width()
					});
					
					if (!$this.data("vcStretchContent")) {
						var padding = -1 * offset;
						if (padding < 0) {
							padding = 0;
						}
						var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
						if (paddingRight < 0) {
							paddingRight = 0;
						}
						$this.css({
							"padding-left": padding + "px",
							"padding-right": paddingRight + "px"
						});
					}
				}
				$this.removeClass("vc_hidden");
			});
		},
		wpb_image_grid: function () {
			$(".wpb_gallery_slides.wpb_image_grid .wpb_image_grid_ul").each(function (index) {
				var $imagesGrid = $(this);
				setTimeout(function () {
					$imagesGrid.isotope('layout');
				}, 1000);
			});
		},
		pageTransition: function () {
			if ($body.hasClass('page-transitions')) {
				var linkElement = '.animsition-link, a[href]:not([target="_blank"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([class*="no-animation"]):not([class*="prettyPhoto"]):not([class*="add_to_wishlist"]):not([class*="add_to_cart_button"]):not([class*="compare"])';
				$(linkElement).on('click', function (event) {
					if ($(event.target).closest($('b.x-caret', this)).length > 0) {
						event.preventDefault();
						return;
					}
					event.preventDefault();
					var $self = $(this);
					var url = $self.attr('href');
					
					// middle mouse button issue #24
					// if(middle mouse button || command key || shift key || win control key)
					if (event.which === 2 || event.metaKey || event.shiftKey || navigator.platform.toUpperCase().indexOf('WIN') !== -1 && event.ctrlKey) {
						window.open(url, '_blank');
					} else {
						G5Plus.page.fadePageOut(url);
					}
					
				});
			}
		},
		fadePageIn: function () {
			if ($body.hasClass('page-loading')) {
				var preloadTime = 1000,
					$loading = $('.site-loading');
				$loading.css('opacity', '0');
				setTimeout(function () {
					$loading.css('display', 'none');
				}, preloadTime);
			}
		},
		fadePageOut: function (link) {
			
			$('.site-loading').css('display', 'block').animate({
				opacity: 1,
				delay: 200
			}, 600, "linear");
			
			$('html,body').animate({scrollTop: '0px'}, 800);
			
			setTimeout(function () {
				window.location = link;
			}, 600);
		},
		backToTop: function () {
			var $backToTop = $('.back-to-top');
			if ($backToTop.length > 0) {
				$backToTop.on('click', function (event) {
					event.preventDefault();
					$('html,body').animate({scrollTop: '0px'}, 800);
				});
				$window.on('scroll', function (event) {
					var scrollPosition = $window.scrollTop();
					var windowHeight = $window.height() / 2;
					if (scrollPosition > windowHeight) {
						$backToTop.addClass('in');
					}
					else {
						$backToTop.removeClass('in');
					}
				});
			}
		},
		gallerymasonry: function () {
			var $container = $('.g5plus-gallery.gallery-masonry ');
			$container.imagesLoaded({background: true}, function () {
				$container.isotope({
					itemSelector: 'div.gf-gallery-item',
					layoutMode: "masonry",
					isOriginLeft: !isRTL
				});
				setTimeout(function () {
					$container.isotope('layout');
				}, 500);
			});
			
		},
		gallerymasonryRefresh: function () {
			var $container = $('.g5plus-gallery.gallery-masonry');
			setTimeout(function () {
				$container.isotope('layout');
			}, 500);
		},
		erepropertygallery: function () {
			var $this = $('.ere-property-gallery.gallery-full-height');
			var headerheight = $('header.main-header').outerHeight();
			var headermobileheight = $('header.header-mobile').outerHeight();
			var adminBarHeight = 0;
			if ($('#wpadminbar').length && ($('#wpadminbar').css('position') == 'fixed')) {
				adminBarHeight = $('#wpadminbar').outerHeight();
			}
			if (window.innerWidth < $body.attr('data-responsive')) {
				headerheight = 0;
			}
			else {
				headermobileheight = 0;
			}
			var galleryheight = window.innerHeight - adminBarHeight - headerheight - headermobileheight;
			$('.entry-thumbnail-overlay.placeholder-image', $this).css('height', galleryheight + 'px');
		}
	};
	
	G5Plus.blog = {
		init: function () {
			this.masonryLayout();
			setTimeout(this.masonryLayout, 300);
			this.loadMore();
			this.infiniteScroll();
			this.commentReplyTitle();
			this.singleMetaTags();
			
		},
		windowResized: function () {
			G5Plus.blog.masonryLayoutRefresh();
			this.singleMetaTags();
		},
		loadMore: function () {
			$('.paging-navigation').on('click', '.blog-load-more', function (event) {
				event.preventDefault();
				var $this = $(this).button('loading'),
					link = $(this).attr('data-href'),
					contentWrapper = '.blog-wrap',
					element = '.blog-wrap article';
				
				$.get(link, function (data) {
					var next_href = $('.blog-load-more', data).attr('data-href'),
						$newElems = $(element, data).css({
							opacity: 0
						});
					$(contentWrapper).append($newElems);
					
					$newElems.imagesLoaded({background: true}, function () {
						G5Plus.common.owlCarousel();
						G5Plus.common.lightGallery();
						$newElems.animate({
							opacity: 1
						});
						
						if ($('.archive-wrap').hasClass('archive-masonry')) {
							$(contentWrapper).isotope('appended', $newElems);
							setTimeout(function () {
								$(contentWrapper).isotope('layout');
							}, 400);
						}
					});
					
					if (typeof(next_href) == 'undefined') {
						$this.parent().remove();
					} else {
						$this.button('reset');
						$this.attr('data-href', next_href);
					}
				});
			});
			
		},
		infiniteScroll: function () {
			var $container = $('.blog-wrap');
			$container.infinitescroll({
				navSelector: '#infinite_scroll_button',    // selector for the paged navigation
				nextSelector: '#infinite_scroll_button a',  // selector for the NEXT link (to page 2)
				itemSelector: '.blog-wrap article',     // selector for all items you'll retrieve
				animate: true,
				loading: {
					finishedMsg: 'No more pages to load.',
					selector: '#infinite_scroll_loading',
					img: g5plus_app_variable.theme_url + 'assets/images/ajax-loader.gif',
					msgText: 'Loading...'
				}
			}, function (newElements) {
				var $newElems = $(newElements).css({
					opacity: 0
				});
				
				$newElems.imagesLoaded({background: true}, function () {
					G5Plus.common.owlCarousel();
					G5Plus.common.lightGallery();
					$newElems.animate({
						opacity: 1
					});
					if ($('.archive-wrap').hasClass('archive-masonry')) {
						$container.isotope('appended', $newElems);
						setTimeout(function () {
							$container.isotope('layout');
						}, 400);
					}
				});
			});
			
		},
		masonryLayout: function () {
			var $container = $('.archive-masonry .blog-wrap');
			$container.imagesLoaded({background: true}, function () {
				$container.isotope({
					itemSelector: 'article',
					layoutMode: "masonry",
					isOriginLeft: !isRTL
				});
				setTimeout(function () {
					$container.isotope('layout');
				}, 500);
			});
			
		},
		commentReplyTitle: function () {
			var $replyTitle = $('h3#reply-title');
			$replyTitle.addClass('block-title');
			var $smallTag = $('small', $replyTitle);
			$smallTag.remove();
			$replyTitle.html($replyTitle.text());
			$replyTitle.append($smallTag);
		},
		masonryLayoutRefresh: function () {
			var $container = $('.archive-masonry .blog-wrap');
			setTimeout(function () {
				$container.isotope('layout');
			}, 500);
		},
		singleMetaTags: function () {
			var $container = $('.entry-meta-tag-wrap'),
				$tags = $('.entry-meta-tag', $container),
				$social = $('.social-share', $container);
			$container.removeClass('left');
			if (($tags.outerWidth() + $social.outerWidth()) > $container.outerWidth()) {
				$container.addClass('left');
			}
		}
	};
	
	G5Plus.header = {
		timeOutSearch: null,
		xhrSearchAjax: null,
		init: function () {
			this.anchoPreventDefault();
			this.topDrawerToggle();
			this.switchMenu();
			this.sticky();
			this.menuCategories();
			this.searchButton();
			this.closeButton();
			this.searchAjaxButtonClick();
			this.menuMobileToggle();
			this.advancedSearch();
			$('[data-search="ajax"]').each(function () {
				G5Plus.header.searchAjax($(this));
			});
			
			this.escKeyPress();
			this.mobileNavOverlay();
			this.menuOnePage();
		},
		windowsScroll: function () {
			this.sticky();
			this.menuDropFlyPosition();
		},
		windowResized: function () {
			this.sticky();
			this.menuDropFlyPosition();
		},
		windowLoad: function () {
		},
		topDrawerToggle: function () {
			$('.top-drawer-toggle').on('click', function () {
				$('.top-drawer-inner').slideToggle();
				$('.top-drawer-wrapper').toggleClass('in');
			});
		},
		switchMenu: function () {
			$('header .menu-switch').on('click', function () {
				$('.header-nav-inner').toggleClass('in');
			});
		},
		menuCategories: function () {
			$('.menu-categories-select > i').on('click', function () {
				$('.menu-categories').toggleClass('in');
			});
		},
		sticky: function () {
			$('.sticky-wrapper').each(function () {
				var $this = $(this);
				var stickyHeight = $('.sticky-region', $this).outerHeight();
				var stickyTop = $('.header-wrapper').outerHeight() - stickyHeight;
				
				if ($(document).outerHeight() - $this.outerHeight() - $this.offset().top <= $window.outerHeight() - stickyHeight) {
					$this.removeClass('is-sticky');
					$('.sticky-region', $this).css('top', '');
					return;
				}
				var adminBarHeight = 0;
				if ($('#wpadminbar').length && ($('#wpadminbar').css('position') == 'fixed')) {
					adminBarHeight = $('#wpadminbar').outerHeight();
				}
				if ($(window).scrollTop() - adminBarHeight > stickyTop) {
					$this.addClass('is-sticky');
					$('.sticky-region', $this).css('top', adminBarHeight + 'px');
				}
				else {
					$this.removeClass('is-sticky');
					$('.sticky-region', $this).css('top', '');
				}
			});
		},
		searchButton: function () {
			var $itemSearch = $('.header-customize-item.item-search > a, .mobile-search-button > a');
			if (!$itemSearch.length) {
				return;
			}
			var $searchPopup = $('#search_popup_wrapper');
			if (!$searchPopup.length) {
				return;
			}
			if ($itemSearch.hasClass('search-ajax')) {
				$itemSearch.on('click', function () {
					$window.scrollTop(0);
					$searchPopup.addClass('in');
					$('body').addClass('overflow-hidden');
					var $input = $('input[type="text"]', $searchPopup);
					$input.focus();
					$input.val('');
					
					var $result = $('.search-ajax-result', $searchPopup);
					$result.html('');
				});
			}
			else {
				var dlgSearch = new DialogFx($searchPopup[0]);
				$itemSearch.on('click', dlgSearch.toggle.bind(dlgSearch));
				$itemSearch.on('click', function () {
					var $input = $('input[type="text"]', $searchPopup);
					
					$input.focus();
					$input.val('');
				});
			}
		},
		searchAjax: function ($wrapper) {
			$('input[type="text"]', $wrapper).on('keyup', function (event) {
				if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					return;
				}
				var keys = ["Control", "Alt", "Shift"];
				if (keys.indexOf(event.key) != -1) return;
				switch (event.which) {
					case 27:	// ESC
						$('.search-ajax-result', $wrapper).html('');
						$wrapper.removeClass('in');
						$(this).val('');
						break;
					case 38:	// UP
						G5Plus.header.searchAjaxKeyUp($wrapper);
						event.preventDefault();
						break;
					case 40:	// DOWN
						G5Plus.header.searchAjaxKeyDown($wrapper);
						event.preventDefault();
						break;
					case 13:
						G5Plus.header.searchAjaxKeyEnter($wrapper);
						break;
					default:
						clearTimeout(G5Plus.header.timeOutSearch);
						G5Plus.header.timeOutSearch = setTimeout(G5Plus.header.searchAjaxSearchProcess, 500, $wrapper, false);
						break;
				}
			});
		},
		searchAjaxKeyUp: function ($wrapper) {
			var $item = $('.search-ajax-result li.selected', $wrapper);
			if ($('.search-ajax-result li', $wrapper).length < 2) return;
			var $prev = $item.prev();
			$item.removeClass('selected');
			if ($prev.length) {
				$prev.addClass('selected');
			}
			else {
				$('.search-ajax-result li:last', $wrapper).addClass('selected');
				$prev = $('.search-ajax-result li:last', $wrapper);
			}
			if ($prev.position().top < $('.ajax-search-result', $wrapper).scrollTop()) {
				$('.ajax-search-result', $wrapper).scrollTop($prev.position().top);
			}
			else if ($prev.position().top + $prev.outerHeight() > $('.ajax-search-result', $wrapper).scrollTop() + $('.ajax-search-result', $wrapper).height()) {
				$('.ajax-search-result', $wrapper).scrollTop($prev.position().top - $('.ajax-search-result', $wrapper).height() + $prev.outerHeight());
			}
		},
		searchAjaxKeyDown: function ($wrapper) {
			var $item = $('.search-ajax-result li.selected', $wrapper);
			if ($('.search-ajax-result li', $wrapper).length < 2) return;
			var $next = $item.next();
			$item.removeClass('selected');
			if ($next.length) {
				$next.addClass('selected');
			}
			else {
				$('.search-ajax-result li:first', $wrapper).addClass('selected');
				$next = $('.search-ajax-result li:first', $wrapper);
			}
			if ($next.position().top < $('.search-ajax-result', $wrapper).scrollTop()) {
				$('.search-ajax-result', $wrapper).scrollTop($next.position().top);
			}
			else if ($next.position().top + $next.outerHeight() > $('.search-ajax-result', $wrapper).scrollTop() + $('.search-ajax-result', $wrapper).height()) {
				$('.search-ajax-result', $wrapper).scrollTop($next.position().top - $('.search-ajax-result', $wrapper).height() + $next.outerHeight());
			}
		},
		searchAjaxKeyEnter: function ($wrapper) {
			var $item = $('.search-ajax-result li.selected a', $wrapper);
			if ($item.length > 0) {
				window.location = $item.attr('href');
			}
		},
		searchAjaxSearchProcess: function ($wrapper, isButtonClick) {
			var keyword = $('input[type="text"]', $wrapper).val();
			if (!isButtonClick && keyword.length < 3) {
				$('.search-ajax-result', $wrapper).html('');
				return;
			}
			$('.search-button i', $wrapper).addClass('fa-spinner fa-spin');
			$('.search-button i', $wrapper).removeClass('fa-search');
			if (G5Plus.header.xhrSearchAjax) {
				G5Plus.header.xhrSearchAjax.abort();
			}
			var action = $wrapper.attr('data-ajax-action');
			var data = 'action=' + action + '&keyword=' + keyword;
			if ($('.categories > span[data-id]', $wrapper)) {
				data += '&cate_id=' + $('.categories > span[data-id]', $wrapper).attr('data-id');
			}
			
			G5Plus.header.xhrSearchAjax = $.ajax({
				type: 'POST',
				data: data,
				url: g5plus_app_variable.ajax_url,
				success: function (data) {
					$('.search-button i', $wrapper).removeClass('fa-spinner fa-spin');
					$('.search-button i', $wrapper).addClass('fa-search');
					$wrapper.addClass('in');
					$('.search-ajax-result', $wrapper).html(data);
				},
				error: function (data) {
					if (data && (data.statusText == 'abort')) {
						return;
					}
					$('.search-button i', $wrapper).removeClass('fa-spinner fa-spin');
					$('.search-button i', $wrapper).addClass('fa-search');
				}
			});
		},
		searchAjaxButtonClick: function () {
			$('.search-button').on('click', function () {
				var $wrapper = $($(this).attr('data-search-wrapper'));
				G5Plus.header.searchAjaxSearchProcess($wrapper, true);
			});
		},
		menuMobileToggle: function () {
			$('.toggle-icon-wrapper > .toggle-icon').on('click', function () {
				var $this = $(this);
				var $parent = $this.parent();
				var dropType = $parent.attr('data-drop-type');
				$parent.toggleClass('in');
				if (dropType == 'menu-drop-fly') {
					$('body').toggleClass('mobile-nav-in');
				}
				else {
					$('.nav-menu-mobile').slideToggle();
				}
			});
		},
		escKeyPress: function () {
			$(document).on('keyup', function (event) {
				if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					return;
				}
				var keys = ["Control", "Alt", "Shift"];
				if (keys.indexOf(event.key) != -1) return;
				if (event.which == 27) {
					if ($('#search_popup_wrapper').hasClass('in')) {
						$('#search_popup_wrapper').removeClass('in');
						setTimeout(function () {
							$('body').removeClass('overflow-hidden');
						}, 500);
						
					}
					
				}
			});
		},
		anchoPreventDefault: function () {
			$('.prevent-default').on('click', function (event) {
				event.preventDefault();
			});
		},
		closeButton: function () {
			$('.close-button').on('click', function () {
				var $closeButton = $(this);
				var ref = $closeButton.attr('data-ref');
				if ($('#search_popup_wrapper').hasClass('in')) {
					setTimeout(function () {
						$('body').removeClass('overflow-hidden');
					}, 500);
				}
				$(ref).removeClass('in');
			});
			
		},
		mobileNavOverlay: function () {
			$('.mobile-nav-overlay').on('click', function () {
				$('body').removeClass('mobile-nav-in');
				$('.toggle-mobile-menu').removeClass('in');
			})
		},
		menuDropFlyPosition: function () {
			var adminBarHeight = 0;
			if ($('#wpadminbar').length && ($('#wpadminbar').css('position') == 'fixed')) {
				adminBarHeight = $('#wpadminbar').outerHeight();
			}
			$('.header-mobile-nav.menu-drop-fly').css('top', adminBarHeight + 'px');
		},
		menuOnePage: function () {
			$('.menu-one-page').onePageNav({
				currentClass: 'menu-current',
				changeHash: false,
				scrollSpeed: 750,
				scrollThreshold: 0,
				filter: '',
				easing: 'swing'
			});
		},
		advancedSearch: function () {
			$('.advanced-wrap .btn-other-advanced').on('click', function (event) {
				event.preventDefault();
				$('.advanced-search').slideToggle();
			});
		}
	};
	
	G5Plus.menu = {
		init: function () {
			this.processMobileMenu();
			this.mobileMenuItemClick();
		},
		processMobileMenu: function () {
			$('.nav-menu-mobile:not(.x-nav-menu) li > a').each(function () {
				var $this = $(this);
				var html = '<span>' + $this.html() + '</span>';
				if ($('> ul', $this.parent()).length) {
					html += '<b class="menu-caret"></b>';
				}
				$this.html(html);
			});
		},
		mobileMenuItemClick: function () {
			$('.nav-menu-mobile:not(.x-nav-menu) li').on('click', function () {
				if ($('> ul', this).length == 0) {
					return;
				}
				if ($(event.target).closest($('> ul', this)).length > 0) {
					return;
				}
				
				if ($(event.target).closest($('> a > span', this)).length > 0) {
					var baseUri = '';
					if ((typeof (event.target) != "undefined") && (event.target != null) && (typeof (event.target.baseURI) != "undefined") && (event.target.baseURI != null)) {
						var arrBaseUri = event.target.baseURI.split('#');
						if (arrBaseUri.length > 0) {
							baseUri = arrBaseUri[0];
						}
						
						var $aClicked = $('> a', this);
						if ($aClicked.length > 0) {
							var clickUrl = $aClicked.attr('href');
							if (clickUrl != '#') {
								if ((typeof (clickUrl) != "undefined") && (clickUrl != null)) {
									clickUrl = clickUrl.split('#')[0];
								}
								if (baseUri != clickUrl) {
									return;
								}
							}
							
						}
					}
				}
				
				event.preventDefault();
				$(this).toggleClass('menu-open');
				$('> ul', this).slideToggle();
			});
		}
	};
	
	G5Plus.widget = {
		init: function () {
			this.categoryCaret();
			
		},
		categoryCaret: function () {
			$('li', '.widget_categories, .widget_pages, .widget_nav_menu, .widget_product_categories, .product-categories').each(function () {
				if ($(' > ul', this).length > 0) {
					$(this).append('<span class="li-caret fa fa-plus"></span>');
				}
			});
			$('.li-caret').on('click', function () {
				$(this).toggleClass('in');
				$(' > ul', $(this).parent()).slideToggle();
			});
		}
	};
	
	G5Plus.onReady = {
		init: function () {
			G5Plus.common.init();
			G5Plus.menu.init();
			G5Plus.page.init();
			G5Plus.header.init();
			G5Plus.blog.init();
			G5Plus.widget.init();
			G5Plus.sticky.init();
		}
	};
	
	G5Plus.onLoad = {
		init: function () {
			G5Plus.header.windowLoad();
			G5Plus.page.windowLoad();
		}
	};
	
	G5Plus.onResize = {
		init: function () {
			G5Plus.header.windowResized();
			G5Plus.common.windowResized();
			G5Plus.page.windowResized();
			G5Plus.blog.windowResized();
		}
	};
	
	G5Plus.onScroll = {
		init: function () {
			G5Plus.header.windowsScroll();
		}
	};
	
	$(window).resize(G5Plus.onResize.init);
	$(window).scroll(G5Plus.onScroll.init);
	$(document).ready(G5Plus.onReady.init);
	$(window).load(G5Plus.onLoad.init);
	
})(jQuery);


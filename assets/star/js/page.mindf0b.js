!function (C) {
    C(window).on("load", function () {
        C(".alert-1").SlickModals({
            popup_reopenClass: "mainDemo-36",
            popup_animation: "slideBottom",
            popup_position: "bottomRight",
            popup_closeButtonPlace: "inside",
            popup_css: {
                width: "280px",
                background: "transparent",
                padding: "0",
                margin: "30px",
                "text-align": "center"
            },
            overlay_isVisible: !1,
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "100%", background: "transparent", padding: "0", margin: "auto", "text-align": "center"}
        }), C(".alert-2").SlickModals({
            popup_reopenClass: "mainDemo-37",
            popup_autoClose: !0,
            popup_autoCloseAfter: "2s",
            popup_animation: "bounceInRight",
            popup_position: "bottomRight",
            popup_closeButtonEnable: !1,
            popup_css: {
                width: "auto",
                background: "transparent",
                padding: "0",
                margin: "24px",
                "animation-duration": "1s"
            },
            overlay_isVisible: !1,
            mobile_breakpoint: "480px",
            mobile_position: "bottomCenter",
            mobile_css: {
                width: "100%",
                background: "transparent",
                padding: "0",
                margin: "auto",
                "animation-duration": "1s"
            }
        }), C(".alert-3").SlickModals({
            popup_reopenClass: "mainDemo-38",
            popup_animation: "slideTop",
            popup_position: "topCenter",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "420px", background: "#fff", padding: "0", margin: "30px"},
            overlay_closesPopup: !1,
            overlay_css: {background: "rgba(0, 0, 0, 0.1)"},
            mobile_breakpoint: "480px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", background: "#fff", padding: "0", margin: "0"}
        }), C(".audioPlayer").SlickModals({
            popup_reopenClass: "mainDemo-35",
            popup_animation: "fadeIn",
            popup_position: "bottomRight",
            popup_closeButtonEnable: !1,
            popup_css: {width: "420px", background: "transparent", padding: "40px 40px 20px 40px", margin: "0"},
            mobile_breakpoint: "480px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", background: "transparent", padding: "20px", margin: "0"},
            callback_afterClose: function () {
                C(".audioPlayer audio")[0].pause()
            }
        }), C(".bgImage").SlickModals({
            popup_reopenClass: "mainDemo-7",
            popup_animation: "slideRight",
            popup_position: "bottomRight",
            popup_css: {padding: "40px", margin: "30px"},
            overlay_css: {background: 'url("img/demos/bg.jpg") no-repeat center center / cover'}
        });
        var o = 0;
        C(".banner_readMore").SlickModals({
            popup_reopenClass: "mainDemo-23",
            overlay_isVisible: !1,
            popup_animation: "slideRight",
            popup_position: "bottomRight",
            popup_closeButtonStyle: "text label",
            popup_css: {width: "480px", background: "#fff", padding: "30px", margin: "40px"},
            mobile_breakpoint: "480px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", padding: "20px", margin: "0"},
            popup_bodyClass: "banner_readMore_visible",
            callback_afterVisible: function () {
                o || (C(".banner_readMore").children("img").attr("src", "img/demos/post.jpg"), o = 1)
            }
        });
        var e = 0;
        C(".carouselSlider").SlickModals({
            popup_reopenClass: "mainDemo-22",
            popup_animation: "zoomIn",
            popup_css: {width: "480px", height: "440px", background: "#fff", padding: "40px", margin: "0"},
            overlay_css: {background: "rgba(0,0,0,0.3)"},
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "420px", background: "#fff", padding: "30px", margin: "0"},
            callback_beforeOpen: function () {
                e || (C(".carouselSlider .carouselList li").each(function (o) {
                    C(this).find("img").attr("src", "img/demos/product-" + (o + 1) + ".jpg")
                }), e = 1)
            },
            callback_afterVisible: function () {
                sm_carouselSlider(".carouselSlider")
            }
        });
        var t = 0;
        C(".cartSlideOut").SlickModals({
            popup_reopenClass: "mainDemo-18",
            popup_position: "topRight",
            popup_animation: "slideRight",
            popup_css: {width: "400px", height: "100%", background: "#fff", padding: "40px", margin: "0"},
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "100%", background: "#fff", padding: "26px", margin: "0"},
            callback_beforeOpen: function () {
                t || (C(".cartSlideOut .cartItems .item").each(function (o) {
                    C(this).find("img").attr("src", "img/demos/product-" + (o + 1) + ".jpg")
                }), t = 1)
            },
            callback_afterVisible: function () {
                sm_cartSlideOut(".cartSlideOut")
            }
        }), C(".contactForm").SlickModals({
            popup_reopenClass: "mainDemo-1",
            popup_animation: "flipInY",
            popup_closeButtonEnable: !1,
            popup_css: {
                width: "420px",
                background: "transparent",
                padding: "0",
                margin: "auto",
                "animation-duration": "0.8s"
            },
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "auto", background: "transparent", padding: "20px", margin: "0"},
            popup_bodyClass: "sm-contactForm-active",
            callback_afterVisible: function () {
                sm_contactForm(".contactForm")
            }
        });
        var i = 0;
        C(".content_box").SlickModals({
            popup_reopenClass: "mainDemo-34",
            popup_animation: "slideRight",
            popup_position: "topRight",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "420px", height: "100%", background: "#fff", padding: "0", margin: "0"},
            overlay_css: {background: "rgba(0, 0, 0, 0.6)"},
            mobile_breakpoint: "480px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", height: "100%", padding: "0", margin: "0"},
            popup_bodyClass: "content_box_visible",
            callback_beforeOpen: function () {
                i || (C(".content_box img").attr("src", "img/demos/contentWindow.jpg"), i = 1)
            }
        }), C(".cookieNotice-1").SlickModals({
            popup_reopenClass: "mainDemo-10",
            popup_animation: "slideBottom",
            popup_position: "bottomCenter",
            popup_closeButtonEnable: !1,
            popup_css: {width: "420px", padding: "0", margin: "10px", "text-align": "center"},
            overlay_closesPopup: !1,
            page_animate: !0,
            page_animation: "scale",
            mobile_breakpoint: "480px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", padding: "0", margin: "0", "text-align": "center"}
        }), C(".cookieNotice-2").SlickModals({
            popup_reopenClass: "mainDemo-11",
            popup_animation: "slideBottom",
            popup_position: "bottomLeft",
            popup_closeButtonStyle: "text label",
            popup_closeButtonText: "Great, close this!",
            popup_css: {width: "100%", padding: "24px", margin: "0", background: "rgba(0,0,0,0.8)"},
            overlay_isVisible: !1,
            page_animate: !0,
            page_animation: "blur",
            mobile_breakpoint: "480px",
            mobile_position: "bottomLeft",
            mobile_css: {width: "100%", padding: "20px", margin: "0", background: "rgba(0,0,0,0.8)"}
        });
        var n = 0, a = 0;
        C(".countDownBanner").SlickModals({
            popup_reopenClass: "mainDemo-15",
            popup_animation: "flipInY",
            popup_position: "bottomRight",
            popup_closeButtonStyle: "text label",
            popup_css: {
                width: "400px",
                height: "400px",
                background: "transparent",
                padding: "0",
                margin: "30px",
                "animation-duration": "0.6s"
            },
            overlay_closesPopup: !1,
            mobile_breakpoint: "400px",
            mobile_position: "bottomCenter",
            mobile_css: {
                width: "100%",
                height: "400px",
                background: "transparent",
                padding: "0",
                margin: "20px",
                "animation-duration": "0.6s"
            },
            callback_beforeOpen: function () {
                n || (C(".countDownBanner").css("background", "url(img/demos/special-offer-1.jpg) 0 0 no-repeat / cover"), n = 1)
            },
            callback_afterVisible: function () {
                a || (sm_countDown(".countDownBanner"), a = 1)
            }
        });
        var p = 0;
        C(".couponCode").SlickModals({
            popup_reopenClass: "mainDemo-21",
            popup_animation: "zoomIn",
            popup_css: {width: "460px", background: "#fff", padding: "36px"},
            mobile_breakpoint: "480px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", background: "#fff", padding: "20px", margin: "0"},
            callback_afterVisible: function () {
                sm_couponCode(".couponCode"), p || (sm_countDown(".couponCode"), p = 1)
            }
        }), C(".dropdownMenu").SlickModals({
            popup_reopenClass: "mainDemo-26",
            popup_animation: "slideTop",
            popup_position: "topLeft",
            popup_closeButtonStyle: "text label",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "100%", background: "#fff", padding: "0", margin: "0"},
            overlay_css: {background: "rgba(0, 0, 0, 0.2)"},
            page_animate: !0,
            page_animation: "moveDown",
            page_moveDistance: "10%",
            mobile_breakpoint: "800px",
            mobile_position: "topLeft",
            mobile_css: {width: "100%", background: "#fff", padding: "0", margin: "0"}
        }), C(".eventsCalendar").SlickModals({
            popup_reopenClass: "mainDemo-28",
            popup_animation: "unFold",
            popup_position: "bottomRight",
            popup_closeButtonStyle: "text label",
            popup_css: {
                width: "380px",
                height: "auto !important",
                padding: "0",
                margin: "20px",
                "box-shadow": "0 0 40px rgba(0,0,0,0.3)"
            },
            callback_beforeInit: function () {
                sm_eventsCalendar(".eventsCalendar")
            }
        });
        var s = 0;
        C(".fbPage").SlickModals({
            popup_reopenClass: "mainDemo-12",
            popup_animation: "zoomIn",
            popup_position: "bottomRight",
            popup_css: {width: "420px", height: "214px", padding: "0", margin: "20px"},
            callback_beforeOpen: function () {
                s || (C(".fbPage").append('<div id="fb-root"></div> <script>(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";fjs.parentNode.insertBefore(js,fjs);}(document,"script","facebook-jssdk"));<\/script> <div class="fb-page" data-href="https://www.facebook.com/envato" data-width="420" data-height="214" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/envato"><a href="https://www.facebook.com/envato">Envato</a></blockquote></div></div>'), s = 1)
            }
        }), C(".feedbackForm").SlickModals({
            popup_reopenClass: "mainDemo-24",
            popup_animation: "slideLeft",
            popup_position: "left",
            popup_closeButtonPlace: "inside",
            popup_css: {
                width: "380px",
                padding: "40px",
                margin: "20px",
                "border-radius": "6px",
                "box-shadow": "6px 6px 0 0 rgba(0,0,0,0.15)"
            },
            overlay_animation: "zoomIn",
            overlay_css: {background: "rgba(0, 0, 0, 0.3)"},
            mobile_breakpoint: "480px",
            mobile_position: "left",
            mobile_css: {width: "100%", padding: "0", margin: "0"},
            callback_afterVisible: function () {
                sm_FeedbackForm(".feedbackForm")
            }
        }), C(".gdprSettings").SlickModals({
            popup_reopenClass: "mainDemo-43",
            popup_animation: "slideRight",
            popup_position: "topRight",
            popup_css: {width: "520px", height: "auto", background: "#fff", padding: "60px", margin: "50px 20px"},
            mobile_breakpoint: "520px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", height: "auto", background: "#fff", padding: "30px", margin: "0"}
        });
        var r = 0;
        C(".gMaps").SlickModals({
            popup_reopenClass: "mainDemo-5",
            popup_animation: "fadeIn",
            popup_position: "center",
            popup_css: {width: "80%", height: "80%", padding: "0", margin: "auto"},
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "90%", height: "90%", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                r || (C(".gMaps").append('<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d52025471.788979165!2d-27.15149075424709!3d37.262348760118975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2ssi!4v1502793884795" width="600" height="450" frameborder="0" style="width: 100%; height: 100%; border: 0" allowfullscreen></iframe>'), r = 1)
            }
        });
        var l = 0;
        C(".html5Banner").SlickModals({
            popup_reopenClass: "mainDemo-20",
            popup_animation: "zoomIn",
            popup_css: {width: "460px", height: "360px", background: "#fff", padding: "0", margin: "auto"},
            overlay_css: {background: "rgba(0, 0, 0, 0.6)"},
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "460px", height: "360px", background: "#fff", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                l || (C(".html5Banner #img1").attr("src", "img/demos/html5_banner_1.jpg"), C(".html5Banner #gwd-image_1").attr("src", "img/demos/html5_banner_2.jpg"), l = 1)
            },
            callback_afterVisible: function () {
                C("#gwd-html5Banner").addClass("gwd-play-animation")
            },
            callback_afterHidden: function () {
                C("#gwd-html5Banner").removeClass("gwd-play-animation")
            }
        }), C(".imageGallery").SlickModals({
            popup_reopenClass: "mainDemo-32",
            overlay_css: {background: "rgba(0,0,0,.3)"},
            popup_animation: "zoomIn",
            popup_css: {
                width: "90%",
                height: "80%",
                background: "transparent",
                padding: "0",
                "animation-duration": "0.6s"
            },
            mobile_breakpoint: "1024px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "80%", padding: "0"},
            callback_afterVisible: function () {
                sm_imageGallery()
            }
        });
        var c = 0;
        C(".userForm").SlickModals({
            popup_reopenClass: "mainDemo-19",
            popup_animation: "zoomIn",
            popup_css: {width: "420px", height: "490px", background: "transparent", padding: "0", margin: "auto"},
            overlay_css: {background: "rgba(0, 0, 0, 0.4)"},
            mobile_breakpoint: "420px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "100%", padding: "0", margin: "0", background: "#44b7ab"},
            callback_beforeOpen: function () {
                c || (C(".userForm .icon").each(function () {
                    var o, e = C(this);
                    e.hasClass("user") ? o = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0px' y='0px' width='512px' height='512px' viewBox='0 0 510 510' style='enable-background:new 0 0 510 510;' xml:space='preserve'><g><path d='M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M255,76.5 c43.35,0,76.5,33.15,76.5,76.5s-33.15,76.5-76.5,76.5c-43.35,0-76.5-33.15-76.5-76.5S211.65,76.4,255,76.5z M255,438.6 c-63.76,0-119.85-33.149-153-81.6c0-51,102-79.05,153-79.05S408,306,408,357C374.85,405.45,318.75,438.6,255,438.6z' fill='#FFFFFF'/></g></svg>" : e.hasClass("lock") ? o = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0px' y='0px' viewBox='0 0 299.995 299.995' style='enable-background:new 0 0 299.995 299.995;' xml:space='preserve' width='512px' height='512px'><g><path d='M149.997,161.485c-8.613,0-15.598,6.982-15.598,15.598c0,5.776,3.149,10.807,7.817,13.505v17.341h15.562v-17.341 c4.668-2.697,7.817-7.729,7.817-13.505C165.595,168.467,158.611,161.485,149.996,161.485z' fill='#FFFFFF'/><path d='M150.003,85.849c-13.111,0-23.775,10.665-23.775,23.775v25.319h47.548v-25.319 C173.775,96.516,163.111,85.849,150.003,85.849z' fill='#FFFFFF'/><path d='M149.995,0.001C67.156,0.001,0,68.159,0,149.998c0,82.837,67.156,149.997,149.995,149.997s150-67.161,150-149.997 C299.995,67.159,232.834,0.001,149.995,0.001z M196.085,227.118h-92.173c-9.734,0-17.626-7.892-17.626-17.629v-56.919 c0-8.491,6.007-15.581,14.003-17.25v-25.697c0-27.409,22.3-49.711,49.711-49.711c27.409,0,49.709,22.3,49.709,49.711v25.697 c7.993,1.673,14,8.759,14,17.25v56.919h0.002C213.711,219.225,205.819,227.118,196.085,227.118z' fill='#FFFFFF'/></g></svg>" : e.hasClass("email") && (o = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0px' y='0px' viewBox='0 0 299.997 299.997' style='enable-background:new 0 0 299.997 299.997;' xml:space='preserve' width='512px' height='512px'><g><path d='M149.996,0C67.157,0,0.001,67.158,0.001,149.997c0,82.837,67.156,150,149.994,150s150-67.163,150-150 C299.996,67.158,232.835,0,149.996,0z M149.999,52.686l88.763,55.35H61.236L149.999,52.686z M239.868,196.423h-0.009 c0,8.878-7.195,16.072-16.072,16.072H76.211c-8.878,0-16.072-7.195-16.072-16.072v-84.865c0-0.939,0.096-1.852,0.252-2.749 l84.808,52.883c0.104,0.065,0.215,0.109,0.322,0.169c0.112,0.062,0.226,0.122,0.34,0.179c0.599,0.309,1.217,0.558,1.847,0.721 c0.065,0.018,0.13,0.026,0.195,0.041c0.692,0.163,1.393,0.265,2.093,0.265h0.005c0.005,0,0.01,0,0.01,0 c0.7,0,1.401-0.099,2.093-0.265c0.065-0.016,0.13-0.023,0.195-0.041c0.63-0.163,1.245-0.412,1.847-0.721 c0.114-0.057,0.228-0.117,0.34-0.179c0.106-0.06,0.218-0.104,0.322-0.169l84.808-52.883c0.156,0.897,0.252,1.808,0.252,2.749 V196.423z' fill='#FFFFFF'/></g></svg>"), e.css("background-image", 'url("' + o + '")')
                }), c = 1)
            }
        }), C(".userForm .switch").on("click", function () {
            C(".userForm .change").toggleClass("hidden")
        });
        var d = 0, u = 0;
        C(".notificationBanner").SlickModals({
            popup_reopenClass: "mainDemo-16",
            popup_animation: "slideTop",
            popup_position: "topCenter",
            popup_css: {width: "1140px", background: "#333", padding: "0", margin: "auto"},
            overlay_css: {background: "rgba(255,255,255,0.9)"},
            mobile_breakpoint: "1140px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", background: "#333", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                d || (C(".notificationBanner .wrap").css("background-image", "url(img/demos/special-offer-2.jpg)"), d = 1)
            },
            callback_afterVisible: function () {
                u || (sm_countDown(".notificationBanner"), u = 1)
            }
        }), C(".overlayMenu").SlickModals({
            popup_reopenClass: "mainDemo-27",
            popup_position: "topLeft",
            popup_closeButtonPlace: "inside",
            popup_css: {
                width: "100%",
                background: "transparent",
                padding: "120px 20px",
                margin: "0",
                "text-align": "center",
                overflow: "auto"
            },
            overlay_closesPopup: !1,
            overlay_css: {background: "rgba(61, 177, 172, 0.8)"},
            page_animate: !0,
            page_animation: "blur",
            page_blurRadius: "2px",
            mobile_breakpoint: "800px",
            mobile_position: "topLeft",
            mobile_css: {width: "100%", background: "transparent", padding: "50px 20px", margin: "0"}
        });
        var m, _ = 0;
        C(".productQuickView").SlickModals({
            popup_reopenClass: "mainDemo-39",
            popup_animation: "flowIn",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "800px", background: "#fff", padding: "40px", margin: "auto"},
            overlay_css: {background: "rgba(0, 0, 0, 0.4)"},
            mobile_breakpoint: "800px",
            mobile_position: "center",
            mobile_css: {width: "100%", height: "auto", padding: "30px", margin: "0"},
            callback_beforeOpen: function () {
                _ || (C(".productQuickView .left img").attr("src", "img/demos/quickView.jpg"), _ = 1)
            },
            callback_afterInit: function () {
                sm_productQuickView(".productQuickView")
            }
        }), C(".pulloutFooter").SlickModals({
            popup_reopenClass: "mainDemo-41",
            popup_animation: "slideBottom",
            popup_position: "bottomLeft",
            popup_closeButtonStyle: "cancel square",
            popup_closeButtonPlace: "inside",
            popup_reopenStickyButtonEnable: !0,
            popup_reopenStickyButtonText: "Footer SlideOut",
            popup_bodyClass: "pulloutFooter-visible",
            popup_css: {width: "100%", background: "#fff", padding: "50px", margin: "0"},
            overlay_css: {background: "rgba(0, 0, 0, 0.6)"},
            content_animate: !0,
            content_animation: "slideBottom",
            content_css: {"animation-duration": "0.6s", "animation-delay": "0.4s"},
            mobile_breakpoint: "640px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", padding: "30px", margin: "0"}
        }), C(".pulloutPricelist").SlickModals({
            popup_reopenClass: "mainDemo-40",
            popup_animation: "slideInLeft",
            popup_closeButtonStyle: "text label",
            popup_position: "left",
            popup_bodyClass: "pulloutPricelist-visible",
            popup_css: {
                width: "360px",
                height: "570px",
                background: "#fff",
                padding: "0",
                margin: "0",
                "box-shadow": "0 20px 34px 0 rgba(0,0,0,.1)",
                "animation-duration": "0.6s"
            },
            overlay_isVisible: !1,
            mobile_breakpoint: "480px",
            mobile_position: "left",
            mobile_css: {width: "100%", height: "100%", padding: "0", margin: "0", "animation-duration": "0.6s"},
            callback_afterVisible: function () {
                sm_priceList(".pulloutPricelist")
            }
        }), C(".punchyBanner").SlickModals({
            popup_reopenClass: "mainDemo-30",
            popup_animation: "slideTop",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "540px", background: "#e258b0", padding: "0", margin: "auto"},
            overlay_css: {background: "rgba(255, 255, 255, 0.3)"},
            content_animate: !0,
            content_animation: "slideTop",
            mobile_breakpoint: "540px",
            mobile_position: "center",
            mobile_css: {width: "100%", background: "#e258b0", padding: "0", margin: "auto"}
        }), C(".simpleImageBanner").SlickModals({
            popup_reopenClass: "mainDemo-3",
            popup_animation: "slideLeft",
            popup_closeButtonStyle: "text label",
            popup_position: "topLeft",
            popup_css: {
                width: "300px",
                background: "transparent",
                padding: "0",
                margin: "40px",
                "box-shadow": "0 0 40px 0 rgba(0,0,0,0.4)"
            },
            mobile_breakpoint: "480px",
            mobile_position: "topLeft",
            mobile_css: {
                width: "300px",
                background: "transparent",
                padding: "0",
                margin: "0",
                "box-shadow": "0 0 40px 0 rgba(0,0,0,0.4)"
            },
            callback_afterVisible: function () {
                m || (C(".simpleImageBanner img").attr("src", "img/demos/promo-banner.jpg"), m = 1)
            }
        }), C(".simpleMsg").SlickModals({
            popup_reopenClass: "mainDemo-6",
            popup_animation: "swingTop",
            popup_closeButtonPlace: "inside",
            popup_position: "topCenter",
            popup_css: {width: "480px", background: "#fff", padding: "0", margin: "auto"},
            overlay_css: {background: "rgba(0, 0, 0, 0.4)"},
            page_animate: !0,
            mobile_breakpoint: "480px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", height: "auto", padding: "0", margin: "0"}
        }), C(".siteSearch").SlickModals({
            popup_reopenClass: "mainDemo-25",
            popup_animation: "slideTop",
            popup_position: "topCenter",
            popup_closeButtonEnable: !1,
            popup_css: {width: "50%", padding: "0", margin: "40px"},
            overlay_css: {background: "rgba(255, 255, 255, 0.5)"},
            page_animate: !0,
            page_animation: "blur",
            mobile_breakpoint: "800px",
            mobile_position: "topCenter",
            mobile_css: {width: "100%", background: "#333", padding: "0", margin: "0"}
        });
        var g = 0;
        C(".smoothBanner").SlickModals({
            popup_reopenClass: "mainDemo-31",
            popup_animation: "zoomOut",
            popup_css: {width: "540px", background: "#fff", padding: "0", margin: "auto", "animation-duration": "1s"},
            overlay_css: {background: "rgba(0, 0, 0, 0.6)"},
            mobile_breakpoint: "540px",
            mobile_position: "center",
            mobile_css: {width: "100%", background: "#fff", padding: "0", margin: "auto", "animation-duration": "1s"},
            callback_beforeOpen: function () {
                g || (C(".smoothBanner .top").css("background", "url(img/demos/promoBanner2.jpg) 0 0 no-repeat / cover"), g = 1)
            }
        });
        var b = 0;
        C(".socialShare").SlickModals({
            popup_reopenClass: "mainDemo-13",
            popup_animation: "slideBottom",
            popup_position: "bottomRight",
            popup_closeButtonEnable: !1,
            popup_css: {width: "200px", background: "transparent", padding: "0", margin: "30px"},
            overlay_isVisible: !1,
            mobile_breakpoint: "640px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "200px", background: "transparent", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                b || (C(".socialShare a").each(function () {
                    var o, e = C(this);
                    e.hasClass("fb") ? o = "data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='96.124px' height='96.123px' viewBox='0 0 96.124 96.123' style='enable-background:new 0 0 96.124 96.123;' xml:space='preserve'><g><path d='M72.089,0.02L59.624,0C45.62,0,36.57,9.285,36.57,23.656v10.907H24.037c-1.083,0-1.96,0.878-1.96,1.961v15.803 c0,1.083,0.878,1.96,1.96,1.96h12.533v39.876c0,1.083,0.877,1.96,1.96,1.96h16.352c1.083,0,1.96-0.877,1.96-1.96V54.287h14.654 c1.083,0,1.96-0.877,1.96-1.96l0.006-15.803c0-0.52-0.207-1.018-0.574-1.386c-0.367-0.368-0.867-0.575-1.386-0.575H56.842v-9.247 c0-4.444,1.059-6.7,6.848-6.7l8.397-0.003c1.082,0,1.959-0.878,1.959-1.96V1.98C74.046,0.899,73.17,0.022,72.089,0.02z' fill='#fff'/></g></svg>" : e.hasClass("tw") ? o = "data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 612 612' style='enable-background:new 0 0 612 612;' xml:space='preserve'><g><path d='M612,116.258c-22.524,9.981-46.694,16.75-72.088,19.772c25.929-15.527,45.777-40.155,55.184-69.411 c-24.322,14.379-51.169,24.82-79.775,30.48c-22.907-24.437-55.49-39.658-91.63-39.658c-69.334,0-125.551,56.217-125.551,125.513 c0,9.828,1.109,19.427,3.251,28.606C197.065,206.32,104.556,156.337,42.641,80.386c-10.823,18.51-16.98,40.078-16.98,63.102 c0,43.559,22.181,81.993,55.835,104.479c-20.575-0.688-39.926-6.348-56.867-15.756v1.568c0,60.806,43.291,111.554,100.693,123.104 c-10.517,2.83-21.607,4.398-33.08,4.398c-8.107,0-15.947-0.803-23.634-2.333c15.985,49.907,62.336,86.199,117.253,87.194 c-42.947,33.654-97.099,53.655-155.916,53.655c-10.134,0-20.116-0.612-29.944-1.721c55.567,35.681,121.536,56.485,192.438,56.485 c230.948,0,357.188-191.291,357.188-357.188l-0.421-16.253C573.872,163.526,595.211,141.422,612,116.258z' fill='#fff' /></g></svg>" : e.hasClass("in") ? o = "data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='97.395px' height='97.395px' viewBox='0 0 97.395 97.395' style='enable-background:new 0 0 97.395 97.395;' xml:space='preserve'><g><path d='M12.501,0h72.393c6.875,0,12.5,5.09,12.5,12.5v72.395c0,7.41-5.625,12.5-12.5,12.5H12.501C5.624,97.395,0,92.305,0,84.895\tV12.5C0,5.09,5.624,0,12.501,0L12.501,0z M70.948,10.821c-2.412,0-4.383,1.972-4.383,4.385v10.495c0,2.412,1.971,4.385,4.383,4.385 h11.008c2.412,0,4.385-1.973,4.385-4.385V15.206c0-2.413-1.972-4.385-4.385-4.385H70.948L70.948,10.821z M86.387,41.188h-8.572\tc0.811,2.648,1.25,5.452,1.25,8.355c0,16.2-13.556,29.332-30.275,29.332c-16.718,0-30.272-13.132-30.272-29.332 c0-2.904,0.438-5.708,1.25-8.355h-8.945v41.141c0,2.129,1.742,3.872,3.872,3.872h67.822c2.13,0,3.872-1.742,3.872-3.872V41.188 H86.387z M48.789,29.533c-10.802,0-19.56,8.485-19.56,18.953c0,10.468,8.758,18.953,19.56,18.953 c10.803,0,19.562-8.485,19.562-18.953C68.351,38.018,59.593,29.533,48.789,29.533z' fill='#fff'/></g></svg>" : e.hasClass("li") && (o = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Capa_1' x='0px' y='0px' width='512px' height='512px' viewBox='0 0 430.117 430.117' style='enable-background:new 0 0 430.117 430.117;' xml:space='preserve'><g><path id='LinkedIn' d='M430.117,261.543V420.56h-92.188V272.193c0-37.271-13.334-62.707-46.703-62.707 c-25.473,0-40.632,17.142-47.301,33.724c-2.432,5.928-3.058,14.179-3.058,22.477V420.56h-92.219c0,0,1.242-251.285,0-277.32h92.21 v39.309c-0.187,0.294-0.43,0.611-0.606,0.896h0.606v-0.896c12.251-18.869,34.13-45.824,83.102-45.824 C384.633,136.724,430.117,176.362,430.117,261.543z M52.183,9.558C20.635,9.558,0,30.251,0,57.463   c0,26.619,20.038,47.94,50.959,47.94h0.616c32.159,0,52.159-21.318,52.159-47.94C103.128,30.251,83.735,9.558,52.183,9.558z M5.477,420.56h92.184v-277.32H5.477V420.56z' fill='#fff'/></g></svg>"), e.css("background-image", 'url("' + o + '")')
                }), b = 1)
            }
        }), C(".spinWheel").SlickModals({
            popup_reopenClass: "mainDemo-42",
            popup_position: "bottomRight",
            popup_closeButtonEnable: !1,
            popup_css: {width: "400px", height: "400px", background: "transparent", padding: "0", margin: "30px"},
            page_animate: !0,
            page_animation: "blur",
            page_blurRadius: "2px",
            overlay_isVisible: !1,
            content_animate: !0,
            content_animation: "slideRight",
            mobile_breakpoint: "540px",
            mobile_css: {width: "400px", height: "400px", background: "transparent", padding: "0", margin: "20px"},
            callback_afterVisible: function () {
                sm_spinWheel(".spinWheel")
            }
        }), C(".stats").SlickModals({
            popup_reopenClass: "mainDemo-9",
            popup_animation: "slideRight",
            popup_position: "bottomLeft",
            popup_closeButtonEnable: !1,
            popup_css: {
                width: "520px",
                background: "transparent",
                padding: "0",
                margin: "50px",
                "animation-duration": "0.6s"
            },
            mobile_breakpoint: "640px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", background: "transparent", padding: "20px", margin: "0"}
        });
        var f = 0;
        C(".testimonials").SlickModals({
            popup_reopenClass: "mainDemo-29",
            overlay_isVisible: !1,
            popup_animation: "slideBottom",
            popup_position: "bottomCenter",
            popup_closeButtonPlace: "inside",
            popup_css: {width: "520px", background: "#fff", padding: "0", margin: "20px"},
            overlay_css: {background: "rgba(0, 0, 0, 0.2)", "animation-duration": "0.3s"},
            page_animate: !0,
            page_animation: "blur",
            page_animationDuration: ".3s",
            page_blurRadius: "2px",
            content_animate: !0,
            content_animation: "slideBottom",
            content_css: {
                "animation-duration": "0.4s",
                "animation-delay": "0.4s",
                "text-align": "center",
                color: "#333"
            },
            mobile_breakpoint: "520px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", height: "auto", padding: "0", margin: "0"},
            callback_beforeOpen: function () {
                f || (C(".testimonials li").each(function (o) {
                    C(this).find("img").attr("src", "img/demos/client-" + (o + 1) + ".jpg")
                }), f = 1)
            },
            callback_afterVisible: function () {
                sm_Testimonials(".testimonials", 3e3)
            }
        });
        var h = 0;
        C(".underConstruction").SlickModals({
            popup_reopenClass: "mainDemo-14",
            popup_animation: "slideLeft",
            popup_closeButtonEnable: !1,
            popup_position: "bottomLeft",
            popup_css: {width: "640px", background: "transparent", padding: "60px", margin: "0"},
            overlay_closesPopup: !1,
            overlay_css: {background: "rgba(0,154,178,0.9)"},
            mobile_breakpoint: "480px",
            mobile_position: "bottomLeft",
            mobile_css: {width: "100%", background: "transparent", padding: "30px", margin: "0"},
            callback_afterVisible: function () {
                h || (sm_countDown(".underConstruction"), h = 1)
            }
        });
        var x = 0;
        C(".userProfile").SlickModals({
            popup_reopenClass: "mainDemo-17",
            popup_animation: "slideBottom",
            popup_position: "bottomRight",
            popup_closeButtonStyle: "text label",
            popup_closeButtonText: "Close",
            popup_css: {width: "380px", background: "#fff", padding: "30px", margin: "30px"},
            overlay_css: {background: "rgba(0, 0, 0, .3)"},
            mobile_breakpoint: "480px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", background: "#fff", padding: "30px", margin: "0"},
            callback_beforeOpen: function () {
                x || (C(".userProfile .left img").attr("src", "img/demos/pic.png"), x = 1)
            }
        }), C(".welcomeMsg").SlickModals({
            popup_reopenClass: "mainDemo-33",
            popup_animation: "slideTop",
            popup_closeButtonPlace: "inside",
            popup_css: {
                width: "520px",
                background: "#f0f0f0",
                padding: "50px",
                margin: "auto",
                "border-radius": "10px"
            },
            overlay_css: {background: "rgba(0, 0, 0, 0.8)"},
            content_animate: !0,
            content_animation: "slideBottom",
            content_css: {
                "animation-duration": "0.8s",
                "animation-delay": "0.6s",
                "text-align": "center",
                color: "#555"
            },
            mobile_breakpoint: "520px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", height: "auto", padding: "50px", margin: "0"}
        });
        var v = 0;
        C("#ytVideo").SlickModals({
            popup_reopenClass: "mainDemo-4",
            popup_animation: "fadeIn",
            popup_position: "center",
            popup_closeButtonStyle: "text label",
            popup_css: {width: "80%", height: "80%", padding: "0", margin: "auto"},
            mobile_breakpoint: "640px",
            mobile_position: "center",
            mobile_css: {width: "90%", height: "90%", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                if (!v) {
                    var o = document.createElement("script");
                    o.type = "text/javascript", o.src = "https://www.youtube.com/player_api", C("head").append(o), v = 1
                }
            },
            callback_afterVisible: function () {
                ytVideo.playVideo()
            },
            callback_afterClose: function () {
                ytVideo.pauseVideo()
            }
        }), C(".newsletterForm").SlickModals({
            popup_reopenClass: "mainDemo-2",
            popup_animation: "rotateIn",
            popup_closeButtonStyle: "text label",
            popup_css: {width: "540px", background: "#489cd7", padding: "60px"},
            overlay_css: {background: "rgba(255, 255, 255, 0.4)"},
            mobile_breakpoint: "540px",
            mobile_position: "bottomCenter",
            mobile_css: {width: "100%", padding: "30px", background: "#489cd7", margin: "0"}
        });
        var w = 0;
        C(".panoramaView").SlickModals({
            popup_reopenClass: "mainDemo-8",
            popup_animation: "fadeIn",
            popup_position: "center",
            popup_css: {width: "80%", height: "80%", padding: "0", margin: "auto"},
            mobile_breakpoint: "480px",
            mobile_position: "center",
            mobile_css: {width: "90%", height: "90%", padding: "0", margin: "auto"},
            callback_beforeOpen: function () {
                w || (C(".panoramaView").append('<iframe src="https://www.google.com/maps/embed?pb=!1m0!4v1502792990771!6m8!1m7!1sCAoSLEFGMVFpcE9OdWRGNUJkbnFtejhKTGxQdVNOeWNZYUZ0clVlSWxFMmlMRjVn!2m2!1d39.16472220000001!2d-119.8977551!3f34.587043008822775!4f9.869272278921173!5f0.4000000000000002" style="height:100%; width:100%;" frameborder="0" style="border:0" allowfullscreen></iframe>'), w = 1)
            }
        }), C(".draggableDemo").SlickModals({
            popup_reopenClass: "mainDemo-44",
            popup_animation: "zoomIn",
            popup_position: "bottomRight",
            popup_draggableEnable: !0,
            popup_css: {padding: "40px", margin: "30px"}
        }), C("#transition-demo-1").SlickModals({
            popup_reopenClass: "openTransition-1",
            popup_animation: "fadeIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-2").SlickModals({
            popup_reopenClass: "openTransition-2",
            popup_animation: "zoomIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-3").SlickModals({
            popup_reopenClass: "openTransition-3",
            popup_animation: "zoomOut",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-4").SlickModals({
            popup_reopenClass: "openTransition-4",
            popup_animation: "slideTop",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-5").SlickModals({
            popup_reopenClass: "openTransition-5",
            popup_animation: "slideRight",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-6").SlickModals({
            popup_reopenClass: "openTransition-6",
            popup_animation: "slideBottom",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-7").SlickModals({
            popup_reopenClass: "openTransition-7",
            popup_animation: "slideLeft",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-8").SlickModals({
            popup_reopenClass: "openTransition-8",
            popup_animation: "rotateIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-9").SlickModals({
            popup_reopenClass: "openTransition-9",
            popup_animation: "rotateOut",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-10").SlickModals({
            popup_reopenClass: "openTransition-10",
            popup_animation: "flipInX",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-11").SlickModals({
            popup_reopenClass: "openTransition-11",
            popup_animation: "flipInY",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-12").SlickModals({
            popup_reopenClass: "openTransition-12",
            popup_animation: "swingTop",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-13").SlickModals({
            popup_reopenClass: "openTransition-13",
            popup_animation: "swingRight",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-14").SlickModals({
            popup_reopenClass: "openTransition-14",
            popup_animation: "swingBottom",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-15").SlickModals({
            popup_reopenClass: "openTransition-15",
            popup_animation: "swingLeft",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-16").SlickModals({
            popup_reopenClass: "openTransition-16",
            popup_animation: "flash",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-17").SlickModals({
            popup_reopenClass: "openTransition-17",
            popup_animation: "pulse",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-18").SlickModals({
            popup_reopenClass: "openTransition-18",
            popup_animation: "rubberBand",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-19").SlickModals({
            popup_reopenClass: "openTransition-19",
            popup_animation: "shake",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-20").SlickModals({
            popup_reopenClass: "openTransition-20",
            popup_animation: "swing",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-21").SlickModals({
            popup_reopenClass: "openTransition-21",
            popup_animation: "tada",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-22").SlickModals({
            popup_reopenClass: "openTransition-22",
            popup_animation: "wooble",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-23").SlickModals({
            popup_reopenClass: "openTransition-23",
            popup_animation: "bounce",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-24").SlickModals({
            popup_reopenClass: "openTransition-24",
            popup_animation: "bounceIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-25").SlickModals({
            popup_reopenClass: "openTransition-25",
            popup_animation: "bounceInUp",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-26").SlickModals({
            popup_reopenClass: "openTransition-26",
            popup_animation: "bounceInDown",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-27").SlickModals({
            popup_reopenClass: "openTransition-27",
            popup_animation: "bounceInRight",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-28").SlickModals({
            popup_reopenClass: "openTransition-28",
            popup_animation: "bounceInLeft",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-29").SlickModals({
            popup_reopenClass: "openTransition-29",
            popup_animation: "unFold",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-30").SlickModals({
            popup_reopenClass: "openTransition-30",
            popup_animation: "flowIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"}
        }), C("#transition-demo-31").SlickModals({
            popup_reopenClass: "openTransition-31",
            popup_animation: "slideInTop",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto", "animation-duration": "0.7s"}
        }), C("#transition-demo-32").SlickModals({
            popup_reopenClass: "openTransition-32",
            popup_animation: "slideInBottom",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto", "animation-duration": "0.7s"}
        }), C("#transition-demo-33").SlickModals({
            popup_reopenClass: "openTransition-33",
            popup_animation: "slideInRight",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto", "animation-duration": "0.7s"}
        }), C("#transition-demo-34").SlickModals({
            popup_reopenClass: "openTransition-34",
            popup_animation: "slideInLeft",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto", "animation-duration": "0.7s"}
        }), C("#page-demo-1").SlickModals({
            popup_reopenClass: "openPage-1",
            popup_animation: "zoomIn",
            popup_position: "center",
            popup_bodyClass: "noOverflow",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "scale"
        }), C("#page-demo-2").SlickModals({
            popup_reopenClass: "openPage-2",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "blur",
            page_blurRadius: "2px"
        }), C("#page-demo-3").SlickModals({
            popup_reopenClass: "openPage-3",
            popup_animation: "slideTop",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "moveUp",
            page_moveDistance: "15%"
        }), C("#page-demo-4").SlickModals({
            popup_reopenClass: "openPage-4",
            popup_animation: "slideBottom",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "moveDown",
            page_moveDistance: "15%"
        }), C("#page-demo-5").SlickModals({
            popup_reopenClass: "openPage-5",
            popup_animation: "slideLeft",
            popup_position: "center",
            popup_bodyClass: "noOverflow",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "moveRight",
            page_moveDistance: "15%"
        }), C("#page-demo-6").SlickModals({
            popup_reopenClass: "openPage-6",
            popup_animation: "slideRight",
            popup_position: "center",
            popup_bodyClass: "noOverflow",
            popup_css: {padding: "40px", margin: "auto"},
            page_animate: !0,
            page_animation: "moveLeft",
            page_moveDistance: "15%"
        }), C("#mix-demo-1").SlickModals({
            popup_reopenClass: "openMix-1",
            popup_animation: "zoomIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto", "animation-duration": "0.6s"},
            overlay_animation: "unFold",
            overlay_css: {"animation-duration": "0.6s"},
            content_animate: !0,
            content_css: {"animation-duration": "0.6s", "animation-delay": "0.6s"}
        }), C("#mix-demo-2").SlickModals({
            popup_reopenClass: "openMix-2",
            popup_animation: "slideTop",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "auto"},
            overlay_animation: "slideBottom"
        }), C("#mix-demo-3").SlickModals({
            popup_reopenClass: "openMix-3",
            popup_animation: "slideBottom",
            popup_position: "bottomCenter",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_animation: "slideBottom",
            overlay_css: {background: "rgba(0,0,0,0.2)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_animation: "blur",
            page_blurRadius: "3px"
        }), C("#mix-demo-4").SlickModals({
            popup_reopenClass: "openMix-4",
            popup_animation: "slideLeft",
            popup_position: "left",
            popup_bodyClass: "noOverflow",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_animation: "slideLeft",
            overlay_css: {background: "rgba(0,0,0,0.4)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_animation: "moveRight",
            page_moveDistance: "10%"
        }), C("#mix-demo-5").SlickModals({
            popup_reopenClass: "openMix-5",
            popup_animation: "flowIn",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_animation: "zoomIn",
            overlay_css: {background: "rgba(0,0,0,0.4)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_scaleValue: "0.95"
        }), C("#mix-demo-6").SlickModals({
            popup_reopenClass: "openMix-6",
            popup_position: "bottomRight",
            popup_animation: "slideRight",
            popup_css: {padding: "40px", margin: "30px"},
            overlay_animation: "slideRight",
            content_animate: !0,
            content_animation: "slideRight"
        }), C("#mix-demo-7").SlickModals({
            popup_reopenClass: "openMix-7",
            popup_position: "bottomCenter",
            popup_animation: "slideBottom",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_animation: "rotateIn",
            overlay_css: {background: "rgba(0,0,0,0.4)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_scaleValue: "0.95"
        }), C("#mix-demo-8").SlickModals({
            popup_reopenClass: "openMix-8",
            popup_animation: "rotateIn",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_css: {background: "rgba(0,0,0,0.2)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_animation: "blur"
        }), C("#mix-demo-9").SlickModals({
            popup_reopenClass: "openMix-9",
            popup_position: "topCenter",
            popup_animation: "slideInTop",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_css: {background: "rgba(255,255,255,0.2)", "animation-duration": "0.6s"}
        }), C("#mix-demo-10").SlickModals({
            popup_reopenClass: "openMix-10",
            popup_css: {padding: "40px", margin: "30px"},
            overlay_css: {background: "rgba(0,0,0,.4)", "animation-duration": "0.6s"}
        }), C("#mix-demo-11").SlickModals({
            popup_reopenClass: "openMix-11",
            popup_animation: "rubberBand",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.7s"},
            overlay_animation: "rubberBand",
            overlay_css: {background: "rgba(0,0,0,0.4)", "animation-duration": "0.7s"}
        }), C("#mix-demo-12").SlickModals({
            popup_reopenClass: "openMix-12",
            popup_animation: "slideBottom",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.7s"},
            overlay_animation: "slideBottom",
            overlay_css: {background: "rgba(177, 84, 84, 0.8)", "animation-duration": "0.7s"},
            content_animate: !0,
            content_animation: "slideBottom"
        }), C("#mix-demo-13").SlickModals({
            popup_reopenClass: "openMix-13",
            popup_animation: "flipInY",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.5s"},
            overlay_animation: "slideLeft",
            overlay_css: {background: "rgba(0,0,0,0.4)", "animation-duration": "0.5s"}
        }), C("#mix-demo-14").SlickModals({
            popup_reopenClass: "openMix-14",
            popup_animation: "tada",
            popup_bodyClass: "noOverflow",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.8s"},
            page_animate: !0,
            page_scaleValue: "1.05"
        }), C("#mix-demo-15").SlickModals({
            popup_reopenClass: "openMix-15",
            popup_animation: "shake",
            popup_position: "bottomRight",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.8s"},
            overlay_css: {background: "rgba(255,255,255,0.4)", "animation-duration": "0.6s"},
            page_animate: !0,
            page_animation: "blur"
        }), C("#mix-demo-16").SlickModals({
            popup_reopenClass: "openMix-16",
            popup_animation: "swingTop",
            popup_position: "topCenter",
            popup_css: {padding: "40px", margin: "40px", "animation-duration": "0.8s"},
            overlay_animation: "swingBottom",
            overlay_css: {"animation-duration": "0.6s"}
        }), C("#mix-demo-17").SlickModals({
            popup_reopenClass: "openMix-17",
            popup_animation: "swingBottom",
            popup_position: "bottomCenter",
            popup_css: {padding: "40px", margin: "30px", "animation-duration": "0.6s"},
            overlay_css: {"animation-duration": "0.6s"},
            page_animate: !0,
            page_scaleValue: "0.95",
            content_animate: !0,
            content_animation: "swingTop",
            content_css: {"animation-delay": "0.7s"}
        }), C("#mix-demo-18").SlickModals({
            popup_reopenClass: "openMix-18",
            popup_animation: "slideLeft",
            popup_position: "topLeft",
            popup_css: {padding: "40px", margin: "50px", "animation-duration": "0.5s"},
            overlay_animation: "slideLeft",
            overlay_css: {"animation-duration": "0.5s"},
            content_animate: !0,
            content_animation: "slideLeft",
            content_css: {"animation-delay": "0.5s"}
        }), C("#mix-demo-19").SlickModals({
            popup_reopenClass: "openMix-19",
            popup_animation: "zoomOut",
            popup_css: {padding: "40px", margin: "50px", "animation-duration": "0.6s"},
            overlay_css: {background: "rgba(255,255,255,0.2)"},
            page_animate: !0,
            page_animation: "blur",
            page_blurValue: "2px"
        }), C("#mix-demo-20").SlickModals({
            popup_reopenClass: "openMix-20",
            popup_animation: "unFold",
            popup_css: {padding: "40px", margin: "50px", "animation-duration": "0.6s"},
            overlay_animation: "slideTop",
            overlay_css: {background: "rgba(179, 94, 138, 0.8)"}
        }), C("#position-demo-1").SlickModals({
            popup_reopenClass: "openPosition-1",
            popup_animation: "slideLeft",
            popup_position: "topLeft",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-2").SlickModals({
            popup_reopenClass: "openPosition-2",
            popup_animation: "slideTop",
            popup_position: "topCenter",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-3").SlickModals({
            popup_reopenClass: "openPosition-3",
            popup_animation: "slideRight",
            popup_position: "topRight",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-4").SlickModals({
            popup_reopenClass: "openPosition-4",
            popup_animation: "slideLeft",
            popup_position: "left",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-5").SlickModals({
            popup_reopenClass: "openPosition-5",
            popup_animation: "zoomIn",
            popup_position: "center",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-6").SlickModals({
            popup_reopenClass: "openPosition-6",
            popup_animation: "slideRight",
            popup_position: "right",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-7").SlickModals({
            popup_reopenClass: "openPosition-7",
            popup_animation: "slideLeft",
            popup_position: "bottomLeft",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-8").SlickModals({
            popup_reopenClass: "openPosition-8",
            popup_animation: "slideBottom",
            popup_position: "bottomCenter",
            popup_css: {padding: "40px", margin: "50px"}
        }), C("#position-demo-9").SlickModals({
            popup_reopenClass: "openPosition-9",
            popup_animation: "slideRight",
            popup_position: "bottomRight",
            popup_css: {padding: "40px", margin: "50px"}
        });
        var k = 0;
        C("#exitPopup").SlickModals({
            popup_type: "exit",
            popup_animation: "slideTop",
            popup_position: "topCenter",
            popup_css: {
                width: "480px",
                height: "360px",
                background: "transparent",
                padding: "0",
                margin: "40px",
                "animation-duration": "0.3s"
            },
            overlay_css: {background: "rgba(0, 0, 0, .3)", "animation-duration": "0.2s"},
            mobile_breakpoint: "480px",
            mobile_position: "topCenter",
            mobile_css: {width: "480px", height: "360px", background: "transparent", padding: "0", margin: "40px"},
            callback_beforeOpen: function () {
                k || (C("#exitPopup img").attr("src", "img/demos/exit-modal.jpg"), k = 1)
            }
        })
    })
}(jQuery);
var sm_carouselSlider = function (o) {
    if (!(window.sm_carouselSliderExist || 0)) {
        var e = $(o), t = e.find(".nav.prev"), i = e.find(".nav.next"), n = e.find(".carouselList"),
            a = parseFloat(n.attr("data-show")), p = parseFloat(n.attr("data-padding")), s = n.children("li"),
            r = s.length;
        t.addClass("disabled"), $(o).addClass("visible"), n.width(100 * r / a + "%");
        var l = Math.round(100 * n.width()) / 100;
        s.css({
            "padding-left": p + "px",
            "padding-right": p + "px"
        }).width(Math.round(100 * (l / r - 2 * p) / 100) + "px"), n.height(s.height() + "px");
        var c = n.find("li:first").outerWidth(), d = l - c * a - p, u = Math.abs(parseFloat(n.css("left")));
        return i.on("click", function () {
            var o = $(this);
            return o.attr("disabled", !0), u < d ? (u += c, n.css("left", "-=" + c + "px")) : u = d, d <= u && o.addClass("disabled"), u <= l / r && t.removeClass("disabled"), setTimeout(function () {
                o.removeAttr("disabled")
            }, 300), u
        }), t.on("click", function () {
            var o = $(this);
            return o.attr("disabled", !0), 0 < u ? (u -= c, n.css("left", "+=" + c + "px")) : u = 0, u <= l / r - c && (o.addClass("disabled"), i.removeClass("disabled")), l / r <= u && i.removeClass("disabled"), setTimeout(function () {
                o.removeAttr("disabled")
            }, 300), u
        }), window.sm_carouselSliderExist = 1
    }
}, sm_priceList = function (o) {
    if (!(window.sm_priceListExist || 0)) {
        var e = $(o), t = e.find(".nav.prev"), i = e.find(".nav.next"), n = e.find(".carouselList"),
            a = parseFloat(n.attr("data-show")), p = parseFloat(n.attr("data-padding")), s = n.children("li"),
            r = s.length;
        t.addClass("disabled"), $(o).addClass("visible"), n.width(100 * r / a + "%");
        var l = Math.round(100 * n.width()) / 100;
        s.css({
            "padding-left": p + "px",
            "padding-right": p + "px"
        }).width(Math.round(100 * (l / r - 2 * p) / 100) + "px"), n.height(s.height() + "px");
        var c = n.find("li:first").outerWidth(), d = l - c * a - p, u = Math.abs(parseFloat(n.css("left")));
        return i.on("click", function () {
            var o = $(this);
            return o.attr("disabled", !0), u < d ? (u += c, n.css("left", "-=" + c + "px")) : u = d, d <= u && o.addClass("disabled"), u <= l / r && t.removeClass("disabled"), setTimeout(function () {
                o.removeAttr("disabled")
            }, 300), u
        }), t.on("click", function () {
            var o = $(this);
            return o.attr("disabled", !0), 0 < u ? (u -= c, n.css("left", "+=" + c + "px")) : u = 0, u <= l / r - c && (o.addClass("disabled"), i.removeClass("disabled")), l / r <= u && i.removeClass("disabled"), setTimeout(function () {
                o.removeAttr("disabled")
            }, 300), u
        }), window.sm_priceListExist = 1
    }
}, sm_cartSlideOut = function (o) {
    if (!(window.sm_cartSlideOutExist || 0)) {
        var e = $(o), t = e.find(".cartItems .item"), i = t.length, n = 0, a = 0, p = 0, s = 0;
        return t.each(function () {
            p = $(this).find(".data .price span").text().replace("$", "").replace(".", ""), a = Math.floor(p) / 100, n += a++, s = parseFloat(n).toFixed(2), $(this).find(".data .remove").on("click", function () {
                i--, p = $(this).siblings(".price").find("span").text().replace("$", "").replace(".", ""), a = Math.floor(p) / 100, s = parseFloat(s - a).toFixed(2), e.find(".total span").text("$ " + s), $(this).closest(".item").addClass("hidden").delay(300).queue(function () {
                    $(this).remove()
                }), e.find(".info span").text(i), i < 1 && (e.find(".actions, .cartItems, .total, .info").hide(), e.find(".emptyCart").fadeIn())
            })
        }), window.sm_cartSlideOutExist = 1
    }
}, sm_contactForm = function (o) {
    var e = /^[a-zA-Z\s]+$/, t = /(.+)@(.+){2,}\.(.+){2,}/, i = /^-?\d+\.?\d*$/, p = $(o), s = p.find("form"),
        n = s.find(".name"), a = s.find(".email"), r = s.find(".phone"), l = s.find(".message"),
        c = s.find(".errorMsg");
    s.on("submit", function (o) {
        o.preventDefault(), e.test(n.val()) ? t.test(a.val()) ? i.test(r.val()) ? l.val() ? $.ajax({
            type: "POST",
            url: "yourScript.php",
            data: $(this).serialize(),
            success: function () {
                var o = s.parent().find(".title"), e = s.parent().find("p"), t = s.parent().find(".close"),
                    i = o.text(), n = e.text(), a = t.text();
                c.text(""), o.text("Thank you for your submittion"), e.text("We will be with you soon."), t.text("Close the form window").css("margin-top", "20px"), s.slideUp(), setTimeout(function () {
                    p.SlickModals("closePopup"), setTimeout(function () {
                        o.text(i), e.text(n), t.text(a), s.slideDown()
                    }, 2e3)
                }, 4e3)
            },
            error: function () {
                c.text("Something went wrong. Please try again.")
            }
        }) : c.text("Message is required") : c.text("A valid phone number is required") : c.text("Please use valid email address") : c.text("Please tell us your name")
    })
}, sm_countDown = function (o) {
    var e = $(o).find(".sm-countDown"), s = e.find(".days"), r = e.find(".hours"), l = e.find(".minutes"),
        c = e.find(".seconds"), d = e.data(), u = new Date(d.smCountdownEnddate.toString()).getTime(),
        m = !0 === d.smCountdownUseservertime;

    function _(o) {
        return o < 10 ? "0" + o : o
    }

    function t(a) {
        var p = setInterval(function () {
            var o = 0;
            o = m ? u - a : u - (new Date).getTime();
            var e = Math.floor(o / 864e5), t = Math.floor(o % 864e5 / 36e5), i = Math.floor(o % 36e5 / 6e4),
                n = Math.floor(o % 6e4 / 1e3);
            if (s.text(_(e)), r.text(_(t)), l.text(_(i)), c.text(_(n)), o < 0) {
                clearInterval(p), alert(d.smCountdownEndmsg);
                return s.text("00"), r.text("00"), l.text("00"), void c.text("00")
            }
            m && (a += 1e3)
        }, 1e3)
    }

    m ? $.get(d.smCountdownServertimefile, function (o) {
        t(new Date(JSON.parse(o)).getTime())
    }) : t()
}, sm_couponCode = function (o) {
    var e = $(o), t = e.find(".sm-couponCode"), i = t.attr("data-sm-couponCode-text").toString(), n = 0, a = "",
        p = setInterval(function () {
            a += i[n], t.text(a), ++n === i.length && clearInterval(p)
        }, 40);
    e.closest(".sm-wrapper").find('[data-sm-close="true"]').one("click", function () {
        clearInterval(p), t.text("")
    })
}, sm_eventsCalendar = function (o) {
    if (!(window.sm_eventsCalendarExist || 0)) {
        var p = [{
                Date: new Date("12/28/2018"),
                Time: "11:00 AM - 13:00 PM",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("01/15/2019"),
                Time: "all day event",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("04/03/2019"),
                Time: "9:00 AM - 10:00 AM",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("08/13/2019"),
                Time: "8:00 AM - 1:00 PM",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("09/14/2019"),
                Time: "all day event",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("10/11/2019"),
                Time: "9:00 AM - 10:00 AM",
                Title: "Lorem ipsum dolor",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }, {
                Date: new Date("03/24/2020"),
                Time: "9:00 AM - 10:00 AM",
                Title: "Last event lorem ipsum",
                Summary: "Lorem ipsum dolor sit amet, nec placerat mediocrem ei. Unum illum his ex, ex vero choro."
            }], e = $(o), s = e.find(".events"), t = e.find(".calendar"), r = s.find(".date"), l = s.find(".title"),
            c = s.find(".summary"), d = s.find(".closeEvent");
        return t.datepicker({
            showOtherMonths: !0, beforeShowDay: function (e) {
                var o = [!0, "", null];
                return $.grep(p, function (o) {
                    return o.Date.valueOf() === e.valueOf()
                }).length && (o = [!0, "highlight", null]), o
            }, onSelect: function (o) {
                for (var e, t, i = new Date(o), n = 0, a = null; n < p.length && !a;) e = p[n].Date, i.valueOf() === e.valueOf() && (a = p[n]), n++;
                a && (t = a.Date, formated = t.toString().split(" ").slice(0, 4).join(" "), r.text(formated + " (" + a.Time + ")"), l.text(a.Title), c.text(a.Summary), "none" === $(s).css("display") && setTimeout(function () {
                    s.slideDown("fast")
                }, 100), d.on("click", function () {
                    s.slideUp("fast")
                }))
            }
        }), window.sm_eventsCalendarExist = 1
    }
}, sm_FeedbackForm = function (o) {
    var e = $(o), t = e.find("form"), i = t.find(".name"), n = t.find(".message"), a = t.find(".errorMsg"),
        p = /^[a-zA-Z\s]+$/;
    t.on("submit", function (o) {
        o.preventDefault(), p.test(i.val()) ? n.val() ? $.ajax({
            type: "POST",
            url: "yourScript.php",
            data: $(this).serialize(),
            success: function () {
                a.text(""), e.find(".title").text("Thank you for your submission."), e.find("p").text("The survey is anonymous."), t.slideUp(function () {
                    e.parent().css("max-height", "200px")
                }), setTimeout(function () {
                    e.SlickModals("closePopup")
                }, 4e3)
            },
            error: function () {
                a.text("Something went wrong. Please try again.")
            }
        }) : a.text("Message is required") : a.text("Please tell us your name")
    })
}, sm_imageGallery = function () {
    var o = window.sm_imageGalleryExist || 0, e = 0, t = $("#galleryWrap"), i = $("#galleryItems"), n = i.find("li"),
        a = n.length, p = t.closest(".sm-popup").width(), s = t.closest(".sm-popup").height(), r = $("#galleryDots"),
        l = $("#nextItem"), c = $("#prevItem");

    function d(o) {
        r.children("li").removeClass("active"), "reset" === o ? r.children("li").first().addClass("active") : r.children("li").eq(e).addClass("active")
    }

    if (o || (t.addClass("visible").width(Math.round(p)).height(s), i.width(p * a).height(s), n.width(p).height(s).each(function (o) {
        $(this).css("background-image", "url(" + $(this).attr("data-image-src") + ")"), r.append("<li></li>"), o + 1 === a && d("reset")
    })), l.on("click", function () {
        ++e === a && (e = 0), i.css("transform", "translateX(" + -p * e + "px)"), d()
    }), c.on("click", function () {
        -1 == --e && (e = a - 1), i.css("transform", "translateX(" + -p * e + "px)"), d()
    }), t.closest(".sm-wrapper").find('[data-sm-close="true"]').one("click", function () {
        l.off(), c.off(), setTimeout(function () {
            i.css("transform", "translateX(0px)"), d("reset")
        }, 1e3)
    }), !o) return window.sm_imageGalleryExist = 1
}, sm_productQuickView = function (o) {
    if (!(window.sm_productQuickViewExist || 0)) return $(o).find(".toCart").on("click", function () {
        var o = $(this), e = o.find("span");
        "Add to cart" === e.text() ? (o.addClass("added"), e.text("Adding ..."), setTimeout(function () {
            e.animate({opacity: 0}, 50, function () {
                e.text("Remove item").animate({opacity: 1})
            })
        }, 1e3)) : (o.removeClass("added"), e.animate({opacity: 0}, 50, function () {
            e.text("Add to cart").animate({opacity: 1})
        }))
    }), window.sm_productQuickViewExist = 1
}, sm_spinWheel = function (o) {
    var e = window.sm_spinWheelExist || 0, t = $(o), n = t.find(".wheelWrap");
    if (!e) {
        var a, p = n.find(".wheel"), s = p.children(".area"), i = n.find(".start"), r = s.length, l = 90 - 360 / r,
            c = 360 / r / 2, d = 360 * parseInt(p.attr("data-spin-circles")), u = parseFloat(p.attr("data-spin-speed")),
            m = 0;
        return t.addClass("visible"), p.css("transition-duration", u + "s"), s.each(function (o) {
            var e = $(this);
            e.css("transform", "rotate(" + 360 / r * o + "deg) skewY(-" + l + "deg)").children("span").css({
                background: e.attr("data-wheel-bg"),
                transform: "skewY(" + l + "deg) rotate(" + c + "deg)"
            })
        }), i.on("click", function () {
            m++, clearTimeout(a);
            var i = $(this), o = d * m + (Math.floor(360 * Math.random()) + 1);
            p.css("transform", "rotate(" + o + "deg)"), a = setTimeout(function () {
                var t = [];
                s.each(function () {
                    var o = $(this), e = o.offset().top.toFixed(6);
                    o.attr("data-wheel-offset", e), t.push(e)
                });
                var o = Math.min.apply(null, t), e = p.children('.area[data-wheel-offset="' + o + '"]');
                "wins" === e.attr("data-wheel-prize") ? n.find(".win").addClass("active").find(".prizeMsg").text(e.attr("data-wheel-message")) : i.text(i.attr("data-wheel-lost-text")).css("font-size", "14px")
            }, 1e3 * u + 200)
        }), window.sm_spinWheelExist = 1
    }
    n.find(".win").removeClass("active")
}, sm_Testimonials = function (o, e) {
    var t = window.sm_testimonialsExist || 0, i = 0, n = $(o), a = n.find("li"), p = a.length, s = n.find(".dot");
    if (a.first().show(), !t && !s.length) for (var r = 0; r < p; r++) n.find(".dots").append('<div id="dot-' + r + '" class="dot" style="width: ' + 100 / p + '%"></div>');
    n.find("#dot-0").addClass("active");
    var l = setInterval(function () {
        a.eq(i).fadeOut(200), $("#dot-" + i).toggleClass("active"), p - 1 < ++i && (i = 0), a.eq(i).fadeIn(200), $("#dot-" + i).toggleClass("active")
    }, e);
    if (n.closest(".sm-wrapper").find('[data-sm-close="true"]').on("click", function () {
        clearInterval(l), a.hide(), n.find(".dot.active").removeClass("active"), s.off()
    }), !t) return window.sm_testimonialsExist = 1
};
!function (h) {
    h(window).on("load", function () {
        h(".populate-animations").each(function () {
            h(this).append('<option value="fadeIn" selected>fadeIn</option>\n<option value="zoomIn">zoomIn</option>\n<option value="zoomOut">zoomOut</option>\n<option value="slideInTop">slideInTop</option>\n<option value="slideInBottom">slideInBottom</option>\n<option value="slideInRight">slideInRight</option>\n<option value="slideInLeft">slideInLeft</option>\n<option value="slideTop">slideTop</option>\n<option value="slideBottom">slideBottom</option>\n<option value="slideRight">slideRight</option>\n<option value="slideLeft">slideLeft</option>\n<option value="rotateIn">rotateIn</option>\n<option value="rotateOut">rotateOut</option>\n<option value="flipInX">flipInX</option>\n<option value="flipInY">flipInY</option>\n<option value="swingTop">swingTop</option>\n<option value="swingBottom">swingBottom</option>\n<option value="swingRight">swingRight</option>\n<option value="swingLeft">swingLeft</option>\n<option value="flash">flash</option>\n<option value="pulse">pulse</option>\n<option value="rubberBand">rubberBand</option>\n<option value="shake">shake</option>\n<option value="swing">swing</option>\n<option value="tada">tada</option>\n<option value="wobble">wobble</option>\n<option value="bounce">bounce</option>\n<option value="bounceIn">bounceIn</option>\n<option value="bounceInUp">bounceInUp</option>\n<option value="bounceInDown">bounceInDown</option>\n<option value="bounceInRight">bounceInRight</option>\n<option value="bounceInLeft">bounceInLeft</option>\n<option value="unFold">unFold</option>\n<option value="flowIn">flowIn</option>')
        }), h(".populate-positions").each(function () {
            h(this).append('<option value="center" selected>Center</option>\n<option value="left">Left</option>\n<option value="right">Right</option>\n<option value="topLeft">Top Left</option>\n<option value="topCenter">Top Center</option>\n<option value="topRight">Top Right</option>\n<option value="bottomLeft">Bottom Left</option>\n<option value="bottomCenter">Bottom Center</option>\n<option value="bottomRight">Bottom Right</option>')
        });
        var s = h("#preview"), n = h("#generator"), a = h("#results"), r = a.children(".console"),
            l = a.find(".hasSettings"), c = a.find(".noSettings"), d = {
                restrict_hideOnUrls: "",
                restrict_cookieSet: "false",
                restrict_cookieName: "",
                restrict_cookieScope: "domain",
                restrict_cookieDays: "30",
                restrict_cookieSetClass: "",
                restrict_dateRange: "false",
                restrict_dateRangeStart: "",
                restrict_dateRangeEnd: "",
                restrict_dateRangeServerTime: "true",
                restrict_dateRangeServerTimeFile: "",
                restrict_dateRangeServerTimeZone: "",
                restrict_showAfterVisits: "1",
                restrict_showAfterVisitsResetWhenShown: "false",
                popup_scriptPath: "path",
                popup_selector: "myPopup",
                popup_type: "none",
                popup_delayedTime: "1s",
                popup_scrollDistance: "400px",
                popup_scrollHideOnUp: "false",
                popup_exitShowAlways: "false",
                popup_autoClose: "false",
                popup_autoCloseAfter: "5s",
                popup_openWithHash: "",
                popup_redirectOnClose: "false",
                popup_redirectOnCloseUrl: "",
                popup_redirectOnCloseTarget: "_blank",
                popup_redirectOnCloseTriggers: "overlay button",
                popup_position: "center",
                popup_animation: "fadeIn",
                popup_closeButtonEnable: "true",
                popup_closeButtonStyle: "cancel simple",
                popup_closeButtonAlign: "right",
                popup_closeButtonPlace: "outside",
                popup_closeButtonText: "",
                popup_reopenClass: "",
                popup_reopenClassTrigger: "click",
                popup_reopenStickyButtonEnable: "false",
                popup_reopenStickyButtonText: "",
                popup_enableESC: "true",
                popup_bodyClass: "",
                popup_wrapperClass: "",
                popup_draggableEnable: "false",
                popup_allowMultipleInstances: "false",
                popup_css: {},
                overlay_isVisible: "true",
                overlay_closesPopup: "true",
                overlay_animation: "fadeIn",
                overlay_css: {},
                content_loadViaAjax: "false",
                content_animate: "false",
                content_animation: "zoomIn",
                content_css: {},
                page_animate: "false",
                page_animation: "scale",
                page_animationDuration: ".4s",
                page_blurRadius: "1px",
                page_scaleValue: ".9",
                page_moveDistance: "30%",
                mobile_show: "true",
                mobile_breakpoint: "480px",
                mobile_position: "bottomCenter",
                mobile_css: {}
            };

        function u(o, e, t) {
            var i = n.find('[data-depends="' + e + '"]');
            "enable" === o ? i.show() : (i.hide(), a.find('[data-depends="' + e + '"]').removeClass("visible"), t && a.find("." + e).addClass("visible"))
        }

        function m(o, e, t) {
            r.find("span.attr-html").text(o), r.find("span.attr-js").text(e)
        }

        function _(o) {
            for (var e = o.split(","), t = 0; t < e.length; t++) e[t] = "'" + e[t].trim() + "'";
            return e
        }

        function g(o) {
            try {
                return new Date(o.split(",")[0] + "T" + o.split(",")[1].replace(" ", "")).getTime(), o
            } catch (o) {
                return alert("Date must be formatted as Y-M-D, H:M:S."), ""
            }
        }

        function b(o) {
            return -1 < o.indexOf("http://") || -1 < o.indexOf("https://") ? o : (alert("URL is missing http(s) protocol."), "")
        }

        function f(o, e, t) {
            return "" === o ? null : 1 < o.split(":").length && "" !== o.split(":")[0] && "" !== o.split(":")[1] && ":" !== o ? function (o, e) {
                var t = o.replace(/'/g, "").split(","), i = {};
                {
                    if (t.forEach(function (o) {
                        var e = o.split(":");
                        i[e[0].trim()] = e[1].trim()
                    }), e) {
                        var n = JSON.stringify(i);
                        return n.replace(/"/g, " '").replace(/ /g, "")
                    }
                    return i
                }
            }(o, e) : (t && alert("CSS properties are not formatted properly."), null)
        }

        if (r.find(".setting").each(function () {
            h(this).prepend("&nbsp;".repeat(8)).append("<br />")
        }), r.find(".lvl1").prepend("&nbsp;".repeat(4)), r.find(".html .row").each(function () {
            h(this).append("<br />")
        }), h("#generator input, #generator select, #generator textarea").on("change", function () {
            var o = h(this), e = o.attr("id").replace("field-", ""), t = o.val();
            for (var i in d) if (i === e) {
                var n = r.find("span." + e);
                if (("popup_scriptPath" === e || "popup_selector" === e) && (t = t.replace(/\s/g, ""), o.val(t), "popup_selector" === e)) if ("#" === t.charAt(0)) m("id", "#"), t = t.replace("#", ""); else {
                    if ("." !== t.charAt(0)) return alert("Selector needs an ID or CLASS prefix (hash or dot)."), void o.val("").focus();
                    m("class", "."), t = t.replace(".", "")
                }
                if ("" !== t ? ("popup_openWithHash" === e && "#" !== t.charAt(0) && (t = "#" + t, o.val(t)), "restrict_hideOnUrls" === e && (t = _(t)), "restrict_dateRangeStart" !== e && "restrict_dateRangeEnd" !== e || (t = g(t)), "popup_redirectOnCloseUrl" === e && (t = b(t)), -1 < e.indexOf("_css") && (s.SlickModals("styleElement", e.replace("_css", ""), f(t, !1, !1)), t = f(t, !0, !0))) : -1 < e.indexOf("_css") && (t = null), "popup_type" === e) {
                    var a = "";
                    "delayed" === t && (a = h("#field-popup_delayedTime").val() + "s"), "scrolled" === t && (a = h("#field-popup_scrollDistance").val() + "px"), s.SlickModals("setType", "none" !== t ? t : "instant", a)
                }
                "popup_delayedTime" === e && s.SlickModals("setType", h("#field-popup_type").val(), t + "s"), "popup_scrollDistance" === e && s.SlickModals("setType", h("#field-popup_type").val(), t + "px"), "popup_position" === e && s.SlickModals("popupPosition", t), -1 < e.indexOf("_animation") && s.SlickModals("setEffect", e.replace("_animation", ""), t), "popup_autoClose" === e && s.SlickModals("autoClose", "true" === t ? "enable" : "disable", h("#field-popup_autoCloseAfter").val() + "s"), "popup_autoCloseAfter" === e && s.SlickModals("autoClose", "enable", t + "s"), "popup_closeButtonEnable" === e && ("true" === t ? s.prev().show() : s.prev().hide()), "popup_closeButtonStyle" === e && s.prev().attr("data-sm-button-style", t), "popup_closeButtonAlign" === e && s.prev().attr("data-sm-button-align", t), "popup_closeButtonPlace" === e && s.prev().attr("data-sm-button-place", t), "popup_closeButtonText" === e && s.prev().attr("data-sm-button-text", t), "overlay_isVisible" === e && ("true" === t ? s.parent().prev().show() : s.parent().prev().hide()), "overlay_closesPopup" === e && ("true" === t ? s.parent().prev().css("pointer-events", "auto") : s.parent().prev().css("pointer-events", "none")), "content_animate" === e && ("true" === t ? s.attr("data-sm-animated", "true").attr("data-sm-effect", h("#field-content_animation").val()).css({
                    "animation-duration": "0.4s",
                    "animation-delay": "0.4s"
                }) : s.attr("data-sm-animated", "false").attr("data-sm-effect", "")), "content_animation" === e && s.attr("data-sm-effect", t);
                var p = d[i] !== t;
                p ? n.addClass("visible") : n.removeClass("visible"), null === t && n.removeClass("visible"), "true" === t ? u("enable", e, p) : "false" === t ? u("disable", e, p) : "popup_type" === e && u("none" !== t ? "enable" : "disable", e, p), n.children("span").text(t);
                break
            }
            0 === r.children(".setting:visible").length ? (c.show(), l.hide()) : (c.hide(), l.show()), r.children(".setting").removeClass("hideComma"), r.children(".setting:visible:last").addClass("hideComma")
        }), n.find(".moreInfo_cta").on("click", function () {
            n.find(".moreInfo_content").toggle()
        }), a.find(".copyCode").on("click", function () {
            var o = window.getSelection(), e = document.createRange();
            e.selectNodeContents(r[0]), o.removeAllRanges(), o.addRange(e), document.execCommand("copy");
            var t = h(this), i = t.text();
            t.text("Code copied!").addClass("active"), setTimeout(function () {
                t.text(i).removeClass("active"), o.removeAllRanges()
            }, 2e3)
        }), s.SlickModals({
            popup_animation: "slideRight",
            popup_position: "bottomRight",
            popup_css: {padding: "40px", margin: "30px"}
        }), s.SlickModals("setType", "instant"), h(".openPreview").on("click", function () {
            s.SlickModals("openPopup")
        }), 1024 < h(window).width()) {
            /*var o = h(document), e = n.offset().top, t = n.height(), i = o.height();
            o.scroll(function () {
                var o = h(window).scrollTop();
                e <= o && o <= i - t && a.css("top", o - e + 40 + "px")
            })*/
        }
        h(".showMoreSettings").on("click", function () {
            h(this).next().slideToggle()
        })
    })
}(jQuery), $("a.next").bind("click", function (o) {
    o.preventDefault();
    var e = $(this);
    $("html, body").stop().animate({scrollTop: parseInt($(e.attr("href")).offset().top, 0)}, 1e3, "swing")
});
var lastScrollTop = 0, $firstSectionContent = $("#section-1").find(".content"), scrollStep = .03;
$(window).scroll(function () {
    var o = $(this).scrollTop(), e = parseFloat($firstSectionContent.css("opacity"));
    o < lastScrollTop && e < 1 && ($firstSectionContent.css("opacity", e + scrollStep), o < 200 && e < .8 && $firstSectionContent.css("opacity", "1")), lastScrollTop < o && 0 < e && $firstSectionContent.css("opacity", e - scrollStep), lastScrollTop = o
}), function (d) {
    "use strict";
    if (!d || void 0 === d) return u("[Slick Modals] No jQuery library detected. Load SlickModals after jQuery has been loaded on the page.");
    var t = {
        restrict_hideOnUrls: [],
        restrict_cookieSet: !1,
        restrict_cookieName: "slickModal-1",
        restrict_cookieScope: "domain",
        restrict_cookieDays: "30",
        restrict_cookieSetClass: "setSmCookie-1",
        restrict_dateRange: !1,
        restrict_dateRangeStart: "",
        restrict_dateRangeEnd: "",
        restrict_dateRangeServerTime: !0,
        restrict_dateRangeServerTimeFile: "",
        restrict_dateRangeServerTimeZone: "Europe/London",
        restrict_showAfterVisits: 1,
        restrict_showAfterVisitsResetWhenShown: !1,
        popup_type: "none",
        popup_delayedTime: "1s",
        popup_scrollDistance: "400px",
        popup_scrollHideOnUp: !1,
        popup_exitShowAlways: !1,
        popup_autoClose: !1,
        popup_autoCloseAfter: "5s",
        popup_openWithHash: !1,
        popup_redirectOnClose: !1,
        popup_redirectOnCloseUrl: "",
        popup_redirectOnCloseTarget: "_blank",
        popup_redirectOnCloseTriggers: "overlay button",
        popup_position: "center",
        popup_animation: "fadeIn",
        popup_closeButtonEnable: !0,
        popup_closeButtonStyle: "cancel simple",
        popup_closeButtonAlign: "right",
        popup_closeButtonPlace: "outside",
        popup_closeButtonText: "Close",
        popup_reopenClass: "open-sm",
        popup_reopenClassTrigger: "click",
        popup_reopenStickyButtonEnable: !1,
        popup_reopenStickyButtonText: "Open popup",
        popup_enableESC: !0,
        popup_bodyClass: "",
        popup_wrapperClass: "",
        popup_draggableEnable: !1,
        popup_allowMultipleInstances: !1,
        popup_css: {
            width: "480px",
            height: "auto",
            background: "#fff",
            margin: "24px",
            padding: "24px",
            "animation-duration": "0.4s"
        },
        overlay_isVisible: !0,
        overlay_closesPopup: !0,
        overlay_animation: "fadeIn",
        overlay_css: {background: "rgba(0, 0, 0, .8)", "animation-duration": "0.4s", "animation-delay": "0s"},
        content_loadViaAjax: !1,
        content_animate: !1,
        content_animation: "zoomIn",
        content_css: {"animation-duration": "0.4s", "animation-delay": "0.4s"},
        page_animate: !1,
        page_animation: "scale",
        page_animationDuration: ".4s",
        page_blurRadius: "1px",
        page_scaleValue: ".9",
        page_moveDistance: "30%",
        mobile_show: !0,
        mobile_breakpoint: "480px",
        mobile_position: "bottomCenter",
        mobile_css: {
            width: "100%",
            height: "auto",
            background: "#fff",
            margin: "0",
            padding: "18px",
            "animation-duration": "0.4s"
        },
        callback_beforeInit: d.noop,
        callback_afterInit: d.noop,
        callback_beforeOpen: d.noop,
        callback_afterOpen: d.noop,
        callback_afterVisible: d.noop,
        callback_beforeClose: d.noop,
        callback_afterClose: d.noop,
        callback_afterHidden: d.noop
    }, n = "SlickModals", l = "sm-", c = "[Slick Modals] ", i = " can be passed into this method.";

    function u(o) {
        console.log(o)
    }

    function a(o, e) {
        this.$el = d(o), this.$wrapper = "", this.$overlay = "", this.$popup = "", this.settings = d.extend(!0, {}, t, e), this.autoCloseTimer = null, this.ajaxContentLoaded = 0, this._build()
    }

    a.prototype = {
        constructor: a, _build: function () {
            if ("true" !== this.$el.attr("data-sm-init")) return this.$el.hide(), u(c + 'Element is missing data-sm-init="true" attribute.');
            this.settings.callback_beforeInit(), this._createParent(), this.settings.overlay_isVisible && this._createOverlay(), this.settings.popup_reopenStickyButtonEnable && this._createStickyButton(), this._createPopup(), this.settings.content_animate && this._contentAnimate(), this._createEvents(), this._checkInitRestrictions()
        }, _createParent: function () {
            this.$el.wrapAll('<div class="sm-wrapper"></div>'), this.$wrapper = this.$el.parent();
            var o = this.settings.popup_type, e = 0;
            switch (!0) {
                case"delayed" === o:
                    e = this.settings.popup_delayedTime;
                    break;
                case"scrolled" === o:
                    e = this.settings.popup_scrollDistance
            }
            this.$wrapper.attr({
                "data-sm-type": o,
                "data-sm-type-val": e
            }), this.settings.popup_autoClose && this.$wrapper.attr({
                "data-sm-autoClose": "enable",
                "data-sm-autoClose-after": this.settings.popup_autoCloseAfter
            })
        }, _createOverlay: function () {
            this.$wrapper.prepend('<div class="sm-overlay"></div>'), this.$overlay = this.$wrapper.children(".sm-overlay"), this.$overlay.attr({
                "data-sm-animated": !0,
                "data-sm-close": this.settings.overlay_closesPopup,
                "data-sm-effect": this.settings.overlay_animation
            }).css(this.settings.overlay_css)
        }, _createStickyButton: function () {
            if ("" === this.settings.popup_reopenClass) return u(c + 'Sticky button must have defined "popup_reopenClass" within the plugin settings.');
            d("body").append('<div class="sm-sticky-button ' + this.settings.popup_reopenClass + '">' + this.settings.popup_reopenStickyButtonText + "</div>")
        }, _createPopup: function () {
            this.$el.attr("data-sm-init", "false").wrapAll('<div class="sm-popup"></div>'), this.$popup = this.$wrapper.children(".sm-popup");
            var o, e = d(window).width() <= parseInt(this.settings.mobile_breakpoint);
            (o = e ? this.settings.mobile_css : this.settings.popup_css)["animation-delay"] = (this.settings.overlay_isVisible ? parseFloat(this.settings.overlay_css["animation-duration"]) / 2 : 0) + "s", this.$popup.attr({
                "data-sm-animated": !0,
                "data-sm-position": e ? this.settings.mobile_position : this.settings.popup_position,
                "data-sm-effect": this.settings.popup_animation
            }).css(o).prepend(this.settings.popup_closeButtonEnable ? '<div class="sm-button" data-sm-button-style="' + this.settings.popup_closeButtonStyle + '" data-sm-button-align="' + this.settings.popup_closeButtonAlign + '" data-sm-button-place="' + this.settings.popup_closeButtonPlace + '" data-sm-button-text="' + this.settings.popup_closeButtonText + '" data-sm-close="true"></div>' : "", this.settings.popup_draggableEnable ? '<div class="sm-draggable"></div>' : ""), this._popupPositionCorrect()
        }, _contentAnimate: function () {
            this.$el.attr({
                "data-sm-animated": !0,
                "data-sm-effect": this.settings.content_animation
            }).css(this.settings.content_css)
        }, _checkInitRestrictions: function () {
            var n, e, a = this;

            function t() {
                return !!a.settings.restrict_cookieSet && -1 < document.cookie.indexOf(a.settings.restrict_cookieName)
            }

            function i() {
                if (!a.settings.restrict_hideOnUrls.length) return !1;
                for (var o = a.settings.restrict_hideOnUrls, e = 0; e < o.length; e++) {
                    var t = o[e], i = window.location.pathname;
                    if (t instanceof RegExp && t.test(i) || "string" == typeof t && -1 < i.indexOf(t)) return !0
                }
                return !1
            }

            function p() {
                return !a.settings.mobile_show && !a.settings.mobile_show && d(window).width() <= parseInt(a.settings.mobile_breakpoint)
            }

            function s() {
                var o = parseInt(a.settings.restrict_showAfterVisits);
                if (o <= 1) return !1;
                var e = l + "visits-" + a.$el.attr("class");
                if (1 < o) {
                    var t = localStorage.getItem(e);
                    return null !== t ? parseInt(t) === o - 1 ? (a.settings.restrict_showAfterVisitsResetWhenShown && localStorage.removeItem(e), !1) : (localStorage.setItem(e, parseInt(t) + 1), !0) : (localStorage.setItem(e, "1"), !0)
                }
                localStorage.removeItem(e)
            }

            function r(o) {
                a.settings.callback_afterInit(), o || a.openPopup()
            }

            a.settings.restrict_dateRange ? (n = function (o) {
                r(!!(t() || i() || p() || a._activeInstanceExist() || s() || o))
            }, e = function (o) {
                function e(o) {
                    var e = new Date(o.split(",")[0] + "T" + o.split(",")[1].replace(" ", "")).getTime();
                    return isNaN(e) ? u(c + "Invalid date format.") : e
                }

                var t = e(a.settings.restrict_dateRangeStart), i = e(a.settings.restrict_dateRangeEnd);
                n(!(t < o && o < i && t < i))
            }, a.settings.restrict_dateRangeServerTime && "" !== a.settings.restrict_dateRangeServerTimeFile ? d.ajax({
                url: a.settings.restrict_dateRangeServerTimeFile,
                type: "POST",
                data: {timezone: a.settings.restrict_dateRangeServerTimeZone},
                dataType: "json",
                success: function (o) {
                    e(new Date(o).getTime())
                },
                error: function () {
                    u(c + "Ajax request error upon retrieving server time.")
                }
            }) : e((new Date).getTime())) : r(!!(t() || i() || p() || a._activeInstanceExist() || s()))
        }, _activeInstanceExist: function () {
            return !this.settings.popup_allowMultipleInstances && 0 < d(".sm-wrapper.sm-active").length && (u(c + "Another Slick Modal instance is already active."), !0)
        }, _popupPositionCorrect: function () {
            var o = this.$popup.attr("data-sm-position");
            switch (!0) {
                case"center" === o:
                    this.$popup.css("margin", "auto");
                    break;
                case"bottomCenter" === o || "topCenter" === o:
                    this.$popup.css({"margin-left": "auto", "margin-right": "auto"});
                    break;
                case"right" === o || "left" === o:
                    this.$popup.css({"margin-top": "auto", "margin-bottom": "auto"})
            }
        }, _popupCalculateHeight: function () {
            var o = 0;
            this.$popup.children().not(".sm-button").each(function () {
                o += d(this).outerHeight(!0)
            })
        }, _createEvents: function () {
            var e = this;
            if (0 < e.$wrapper.find('[data-sm-close="true"]').length && e.$wrapper.find('[data-sm-close="true"]').each(function () {
                var o = d(this);
                o.on("click", function () {
                    e.closePopup(), e.settings.popup_redirectOnClose && -1 < e.settings.popup_redirectOnCloseTriggers.indexOf(o.attr("class").replace("sm-", "")) && -1 === e.settings.popup_redirectOnCloseTriggers.indexOf("close") && e._redirectOnClose()
                })
            }), "" !== e.settings.popup_reopenClass && d("body").on("click" === e.settings.popup_reopenClassTrigger ? "click" : "mouseover", "." + e.settings.popup_reopenClass, function (o) {
                d(o.target).is("a") && o.preventDefault(), e.openPopup("instant")
            }), e.settings.popup_enableESC && d(window).on("keydown", function (o) {
                27 === o.keyCode && e._wrapperActive() && e.closePopup()
            }), e.settings.popup_openWithHash) {
                var o = e.settings.popup_openWithHash, t = !1 !== o && "" !== o && "#" === o.charAt(0);
                t && d(window).on("load hashchange", function () {
                    t && o === window.location.hash && e.openPopup("instant")
                })
            }
            if (this.settings.popup_draggableEnable) {
                var i, n, a, p, s = s || !1, r = parseInt(e.$popup.css("margin-left")),
                    l = parseInt(e.$popup.css("margin-top")), c = e.$popup[0];
                e.$popup.children(".sm-draggable").on("mousedown", function (o) {
                    s = !0, i = o.clientX + r, n = o.clientY + l, a = c.offsetLeft, p = c.offsetTop, d(window).on("mousemove", function (o) {
                        if (s) return c.style.left = o.clientX - i + a + "px", c.style.top = o.clientY - n + p + "px", !1
                    }), d(window).on("mouseup", function () {
                        s = !1
                    })
                })
            }
        }, _setCookie: function () {
            var o = parseInt(this.settings.restrict_cookieDays), e = new Date, t = "/";
            "page" === this.settings.restrict_cookieScope && (t = window.location.href), e.setTime(e.getTime() + 24 * o * 60 * 60 * 1e3), document.cookie = this.settings.restrict_cookieName + "=1; path=" + t + "; expires=" + (0 < o ? e.toGMTString() : 0)
        }, _redirectOnClose: function () {
            var o = this.settings.popup_redirectOnCloseUrl;
            "" !== o && -1 < o.indexOf("http") ? window.open(o, this.settings.popup_redirectOnCloseTarget) : u(c + "Redirect URL is empty or not valid.")
        }, _loadContentViaAjax: function () {
            if (!this.ajaxContentLoaded && "" !== this.settings.content_loadViaAjax) {
                var e = this;
                d.ajax({
                    url: e.settings.content_loadViaAjax, type: "GET", dataType: "html", success: function (o) {
                        e.$el.html(o), e._popupCalculateHeight(), e.ajaxContentLoaded = 1
                    }, error: function () {
                        u(c + "Ajax request error upon retrieving the content.")
                    }
                })
            }
        }, _pageAnimation: function (o) {
            var e = this.settings.page_animation,
                t = d("body").children().not(".sm-wrapper, .sm-sticky-button, script, style");
            if ("enable" === o) {
                switch (!0) {
                    case"blur" === e:
                        t.css({
                            filter: "blur(" + this.settings.page_blurRadius + ")",
                            "transition-duration": this.settings.page_animationDuration
                        });
                        break;
                    case"scale" === e:
                        t.css({
                            transform: "scale(" + this.settings.page_scaleValue + ")",
                            "transition-duration": this.settings.page_animationDuration
                        });
                        break;
                    case-1 < e.indexOf("move"):
                        var i = "", n = "";
                        switch (!0) {
                            case"moveUp" === e:
                                i = "Y", n = "-";
                                break;
                            case"moveDown" === e:
                                i = "Y", n = "";
                                break;
                            case"moveLeft" === e:
                                i = "X", n = "-";
                                break;
                            case"moveRight" === e:
                                i = "X", n = ""
                        }
                        t.css({
                            transform: "translate" + i + "(" + n + this.settings.page_moveDistance + ")",
                            "transition-duration": this.settings.page_animationDuration
                        })
                }
                d("body").addClass(l + "pageAnimated")
            } else t.css({transform: "", filter: ""}), d("body").removeClass(l + "pageAnimated")
        }, _wrapperActive: function () {
            return this.$wrapper.hasClass(l + "active")
        }, _prepareClose: function () {
            var o = this, e = o.$popup.css("animation-duration"),
                t = o.settings.overlay_isVisible ? o.$overlay.css("animation-delay") : 0,
                i = o.$el.css("animation-delay") || 0, n = o.$popup.css("animation-delay") || 0;
            o.settings.overlay_isVisible && o.$overlay.css("animation-delay", e), o.settings.content_animate && o.$el.css("animation-delay", "0s"), o.$popup.css("animation-delay", "0s");
            var a = 1e3 * ((o.settings.overlay_isVisible ? parseFloat(o.$overlay.css("animation-duration")) : 0) + parseFloat(e));
            o._togglePopup("disable", a, n, t, i)
        }, _togglePopup: function (o, e, t, i, n) {
            var a = this, p = "enable" === o;
            p ? (a.settings.callback_beforeOpen(), a.$wrapper.addClass(l + "active"), "" !== a.settings.popup_bodyClass && d("body").addClass(a.settings.popup_bodyClass), "" !== a.settings.popup_wrapperClass && a.$wrapper.addClass(a.settings.popup_wrapperClass), a.settings.content_loadViaAjax && a._loadContentViaAjax(), setTimeout(function () {
                a.settings.callback_afterVisible(), "enable" === a.$wrapper.attr("data-sm-autoClose") && a.autoClose()
            }, 1e3 * (parseFloat(a.$popup.css("animation-delay")) + parseFloat(a.$popup.css("animation-duration"))) + e)) : (a.settings.callback_afterClose(), a.$wrapper.removeClass(l + "active"), a.settings.page_animate && a._pageAnimation("disable")), setTimeout(function () {
                p ? (a.settings.callback_afterOpen(), a.$wrapper.show(), "auto" === a.$popup[0].style.height && a._popupCalculateHeight(), a.settings.page_animate && a._pageAnimation("enable")) : (a.settings.overlay_isVisible && a.$overlay.css("animation-delay", i), a.settings.content_animate && a.$el.css("animation-delay", n), a.$popup.css("animation-delay", t), a.$wrapper.hide(), a.settings.callback_afterHidden(), "" !== a.settings.popup_bodyClass && d("body").removeClass(a.settings.popup_bodyClass), "" !== a.settings.popup_wrapperClass && a.$wrapper.removeClass(a.settings.popup_wrapperClass), "enable" === a.$wrapper.attr("data-sm-autoClose") && clearTimeout(a.autoCloseTimer))
            }, e)
        }, _typeController: function (o, e) {
            var t = this, i = o || t.$wrapper.attr("data-sm-type"),
                n = e || parseFloat(t.$wrapper.attr("data-sm-type-val"));
            switch (!0) {
                case"delayed" === i:
                    t._togglePopup("enable", 1e3 * n);
                    break;
                case"scrolled" === i:
                    var a = 0, p = 0;
                    d(document).on("scroll", function () {
                        var o = d(this).scrollTop();
                        n < o && !a && (t._togglePopup("enable", 0), a = 1), t.settings.popup_scrollHideOnUp && o < n && a && !p && (t.closePopup(), p = 1, d(document).unbind("scroll"))
                    });
                    break;
                case"exit" === i:
                    var s = 0;
                    d(document).on("mouseleave", function () {
                        s || (t.settings.popup_exitShowAlways || (s = 1, d(document).unbind("mouseleave")), t._togglePopup("enable", 0))
                    });
                    break;
                case"instant" === i:
                    t._togglePopup("enable", 0)
            }
        }, openPopup: function (o, e) {
            if (this._wrapperActive()) return u(c + "This popup instance is already active.");
            this._activeInstanceExist() || this._typeController(o, e)
        }, closePopup: function () {
            if (!this._wrapperActive()) return u(c + "Popup is already closed.");
            this.settings.callback_beforeClose(), this._prepareClose(), this.settings.restrict_cookieSet && this._setCookie(), this.settings.popup_redirectOnClose && -1 < this.settings.popup_redirectOnCloseTriggers.indexOf("close") && this._redirectOnClose()
        }, styleElement: function (o, e) {
            if ("object" != typeof e) return u(c + "Only object with CSS properties" + i);
            switch (!0) {
                case"overlay" === o && this.settings.overlay_isVisible:
                    this.$overlay.css(e), 0 < this.$popup.length && e["animation-duration"] && this.$popup.css("animation-delay", parseFloat(e["animation-duration"]) / 2 + "s");
                    break;
                case"popup" === o:
                    this.$popup.css(e), this._popupPositionCorrect();
                    break;
                case"content" === o:
                    this.$el.css(e)
            }
        }, popupPosition: function (o) {
            if ("string" != typeof o) return u(c + "Only string" + i);
            this.$popup.attr("data-sm-position", o), this._popupPositionCorrect()
        }, setEffect: function (o, e) {
            if ("string" != typeof o || "string" != typeof e) return u(c + "Only strings" + i);
            switch (!0) {
                case"overlay" === o && this.settings.overlay_isVisible:
                    this.$overlay.attr("data-sm-effect", e);
                    break;
                case"popup" === o:
                    this.$popup.attr("data-sm-effect", e);
                    break;
                case"content" === o:
                    this.$el.attr("data-sm-effect", e)
            }
        }, setType: function (o, e) {
            this.$wrapper.attr({"data-sm-type": o, "data-sm-type-val": e})
        }, autoClose: function (o, e) {
            var t = this;
            t.$wrapper.attr({
                "data-sm-autoClose": o,
                "data-sm-autoClose-after": e
            }), o = o || t.$wrapper.attr("data-sm-autoClose"), e = e || t.$wrapper.attr("data-sm-autoClose-after"), "enable" === o && (t.autoCloseTimer = setTimeout(function () {
                t.closePopup()
            }, 1e3 * parseFloat(e)))
        }, destroy: function () {
            d("." + this.settings.popup_reopenClass).on("click" === this.settings.popup_reopenClassTrigger ? "click" : "mouseover", function () {
                return !1
            }), this.$el.remove(), this.$wrapper.remove(), this.$overlay.remove(), this.$popup.remove(), delete this.$el, delete this.$wrapper, delete this.$overlay, delete this.$popup
        }
    }, d.fn[n] = function (t) {
        var i = Array.prototype.slice.call(arguments, 1);
        return this.each(function () {
            var o = d(this), e = o.data(n);
            if (e) {
                if ("string" == typeof t) try {
                    e[t].apply(e, i)
                } catch (o) {
                    u(c + "Method does not exist in Slick Modals.")
                }
            } else o.data(n, new a(this, t))
        })
    }
}(jQuery);
//# sourceMappingURL=page.min.js.map

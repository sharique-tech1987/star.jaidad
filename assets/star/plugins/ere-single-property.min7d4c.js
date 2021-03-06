!function (e) {
    "use strict";
    e(document).ready(function () {
        function t(t) {
            function a(e) {
                var t = e.item.index;
                r.find(".owl-item").removeClass("current").eq(t).addClass("current");
                var a = r.find(".owl-item.active").length - 1, i = r.find(".owl-item.active").first().index(),
                    n = r.find(".owl-item.active").last().index();
                t > n && r.data("owl.carousel").to(t, 500, !0), i > t && r.data("owl.carousel").to(t - a, 500, !0)
            }

            function n(e) {
                var t = e.item.index;
                o.data("owl.carousel").to(t, 500, !0)
            }

            var o = t.find(".single-property-image-main"), r = t.find(".single-property-image-thumb");
            o.owlCarousel({
                items: 1,
                nav: !0,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                dots: !1,
                loop: !1,
                smartSpeed: 500,
                rtl: i
            }).on("changed.owl.carousel", a), r.on("initialized.owl.carousel", function () {
                r.find(".owl-item").eq(0).addClass("current")
            }).owlCarousel({
                loop: !1,
                items: 5,
                nav: !1,
                dots: !1,
                rtl: i,
                margin: 9,
                responsive: {1200: {items: 5}, 992: {items: 4}, 768: {items: 3}, 0: {items: 2}}
            }).on("changed.owl.carousel", n), r.on("click", ".owl-item", function (t) {
                if (t.preventDefault(), !e(this).hasClass("current")) {
                    var a = e(this).index();
                    o.data("owl.carousel").to(a, 500, !0)
                }
            })
        }

        function a() {
            /*e("#property-print").on("click", function (t) {
                t.preventDefault();
                var a = e(this), i = a.data("property-id"), n = a.data("ajax-url"),
                    o = window.open("", "Property Print Window", "scrollbars=0,menubar=0,resizable=1,width=991 ,height=800");
                e.ajax({
                    type: "POST",
                    url: n,
                    data: {
                        action: "property_print_ajax",
                        property_id: i,
                        isRTL: e("body").hasClass("rtl") ? "true" : "false"
                    },
                    success: function (e) {
                        o.document.write(e), o.document.close(), o.focus()
                    }
                })
            })*/
        }

        var i = e("body").hasClass("rtl");
        ERE.contact_agent_by_email();
        var n = e(".property-gallery-wrap");
        t(n), a()
    })
}(jQuery);
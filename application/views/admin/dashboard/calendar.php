<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head">
        <div class="m-portlet__head-progress"><!-- here can place a progress bar--></div>
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-calendar-3"></i>
                    </span>
                    <h3 class="m-portlet__head-text">Calendar</h3>
                </div>
            </div>
            <?php echo portlet_actions(); ?>
        </div>
    </div>

    <div class="m-portlet__body p-1">
        <div id="m_calendar"></div>
    </div>
</div>

<script>

    var CalendarBasic = {
        init: function () {
            $("#m_calendar").fullCalendar({
                    events: function (start, end, timezone, callback) {
                        $.ajax({
                            url: '<?php echo admin_url('profile/AJAX/holidays/?campus_id=' . $campus_id);?>',
                            dataType: 'json',
                            data: {
                                // our hypothetical feed requires UNIX timestamps
                                start: start.unix(),
                                end: end.unix()
                            },
                            success: function (doc) {
                                var events = doc;
                                callback(events);
                            },
                            error: function () {
                                toastr.warning("Record not found!");
                            }
                        });
                    },
                    loading: function (bool) {
                        var portlet = $(this).closest('.m-portlet')
                        if (bool) {
                            mApp.block(portlet, {
                                type: "loader",
                                state: "success",
                                message: "Please wait..."
                            });
                        } else {
                            mApp.unblock(portlet)
                        }
                    },
                    isRTL: mUtil.isRTL(),
                    header: {
                        left: "prev,next today", center: "title",
                        //right: "month,agendaWeek,agendaDay,listWeek"
                        //right: "month,listWeek"
                    },
                    editable: false,
                    timezone: '<?php echo APP_TIME_ZONE;?>',
                    eventLimit: !0,
                    //navLinks: !0,
                    firstDay: 1,
                    //weekends: false,
                    eventRender: function (e, t) {
                        t.hasClass("fc-day-grid-event")
                            ? (t.data("html", true), t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t))
                            : t.hasClass("fc-time-grid-event")
                            ? t.find(".fc-title").append('<div class="fc-description">' + e.description + "</div>")
                            : 0 !== t.find(".fc-list-item-title").lenght && t.find(".fc-list-item-title").append('<div class="fc-description">' + e.description + "</div>")
                    }
                }
            )
        }
    };
    jQuery(document).ready(function () {
            CalendarBasic.init()
        }
    );
</script>
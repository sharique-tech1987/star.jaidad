<?php
$user_id = _session(FRONT_SESSION_ID);
$_labels = $this->db->get_where('inbox_labels', ['user_id' => $user_id])->result();

?>
<link href="<?php echo asset_url("inbox/css/inbox.css ");?>" rel="stylesheet">
<!-- Modal -->
<div class="inbox-container">

    <div class="modal fade" id="composeModal" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="<?php echo site_url('inbox/ajax/reply');?>" method="post" id='reply_form' enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Compose</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                                <input type="hidden" name="msg_id" value="">
                                <input type="hidden" name="to_id" value="">
                                <input type="hidden" name="sender_type" value="Guest">

                                <div class="form-group">
                                    <label>Subject: </label>
                                    <input type='text' name='subject' placeholder='Subject' class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Message: </label>
                                    <textarea name='message' rows="7" class="form-control" placeholder='Write your message here...'></textarea>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <input type='submit' name='submit' value='send'  class="btn btn-primary"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="reset" class="reset" style="display: none;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--
    End Compose
    -->

    <nav class="secondary-sidebar">
        <!--<div class=" m-b-30 m-l-30 m-r-30 d-sm-none d-md-block d-lg-block d-xl-block">
            <a href="#myModal" class="btn btn-complete btn-block btn-compose" data-toggle="modal" data-target="#composeModal">Compose</a>
        </div>-->

        <p class="menu-title">BROWSE</p>
        <ul class="main-menu">
            <li class="active">
                <a href="#" data-box="inbox" data-start="0">
                    <span class="title"><i class="pg-inbox"></i> Inbox</span>
                    <span class="badge pull-right counter">5</span>
                </a>
            </li>
            <!--<li class="">
                <a href="#" data-box="all">
                    <span class="title"><i class="pg-folder"></i> All mail</span>
                </a>
            </li>-->
            <li>
                <a href="#" data-box="sent">
                    <span class="title"><i class="pg-sent"></i> Sent</span>
                </a>
            </li>
        </ul>
        <!--
        <p class="menu-title m-t-20 all-caps">Labels</p>
        <ul class="sub-menu no-padding">
        <?php
        if (count($_labels) > 0){
            foreach ($_labels as $label) {
                ?>
                <li>
                    <a href="javascript: void(0);" data-label-id="<?php echo $label->id;?>">
                        <i class="la la-tag" style="color: <?php echo $label->color;?>;"></i>
                        <span class="title"><?php echo $label->label;?></span>
                    </a>
                </li>
                <?php
            }
        }
        ?>
        </ul>
        -->
    </nav>


    <div class="inner-content full-height">
        <div class="split-view">

            <div class="split-list">
                <a class="list-refresh" href="#"><i class="fa fa-refresh"></i></a>
                <div class="list-box">

                </div>

                <div class="padding-15">
                    <a href="javascript: void(0);" class="load-more btn btn-success btn-block">Load more.</a>
                </div>
            </div>
            <div  class="split-details">

                <div class="no-result" style="display: block;">
                    <h1>No email has been selected</h1>
                </div>

                <div class="email-content-wrapper" style="display: none;">
                    <div class="actions-wrapper menuclipper bg-master-lightest">
                        <ul class="actions menuclipper-menu no-margin p-l-20 ">
                            <li class="d-lg-none d-xl-none sm-no-padding">
                                <a href="#" class="split-list-toggle"><i class="fa fa-angle-left"></i> All Inboxes</a>
                            </li>
                            <li class="no-padding"><a href="#" data-toggle="modal" data-target="#composeModal" class="text-info">Reply</a></li>
                            <!--<li class="no-padding"><a href="#">Reply all</a></li>
                            <li class="no-padding"><a href="#">Forward</a></li>
                            <li class="no-padding"><a href="#">Mark as read</a></li>-->
                            <!--<li class="no-padding"><a href="#" class="text-danger">Delete</a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="email-content">
                        <div class="email-content-header">
                            <div class="thumbnail-wrapper d48 circular">
                                <img width="40" height="40" alt=""
                                     data-src-retina="<?php echo asset_url("inbox/img/profiles/a2x.jpg ");?>"
                                     data-src="<?php echo asset_url("inbox/img/profiles/a.jpg ");?>"
                                     src="<?php echo asset_url("inbox/img/profiles/a2x.jpg ");?>">
                            </div>
                            <div class="sender inline m-l-10">
                                <p class="name no-margin bold"></p>
                                <p class="datetime no-margin"></p>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="email-content-body m-t-20">

                        </div>
                    </div>
                </div>
            </div>

            <div class="compose-wrapper d-md-none">
                <a class="compose-email text-info pull-right m-r-10 m-t-10" href=""><i class="fa fa-pencil-square-o"></i></a>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            let MSGs = [];
            function get_msg(dir, start = 0){
                console.log(dir);
                let last_msg_id = $('[data-email="'+dir+'"] .email-list li:first').data('email-id');

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('inbox/ajax/message_list/');?>',
                    data: {dir: dir, last_msg_id : last_msg_id, start: start},
                }).done(function(json) {
                    let emails = json[dir];
                    console.log(emails.start);
                    $('.main-menu li.active a[data-box]').data({start: emails.start});
                    if(emails.start == emails.total_rows){
                        $('.load-more').hide(0);
                    }

                    $('[data-box="' + dir + '"] .counter').html('<span class="unread">'+emails.total_unread+'</span>/<span class="total">'+emails.total_rows+'</span>');

                    $('[data-email]').hide(0);
                    $('[data-email="' + dir + '"]').show(0);

                    if(emails.total_rows > 0){
                        if($('[data-email="' + dir + '"]').length == 0){
                        let HTML = '<div data-email="' + dir + '" class="boreded no-top-border list-view"><div class="list-view-wrapper" data-ios="false"></div></div>';
                            $('.list-box').append(HTML);
                        }

                        $.each(emails.rows, function (date, msg) {

                            let HTML = '<div class="list-view-group-container">\n' +
                                '           <div data-date='+ date +' class="list-view-group-header"><span>'+msg[0].date+'</span></div>\n' +
                                '               <ul class="no-padding email-list"></ul>\n' +
                                '           </div>\n' +
                                '       </div>';

                            if($('[data-email="' + dir + '"] [data-date="'+ date +'"]').length == 0){
                                $('[data-email="'+dir+'"]').append(HTML);
                            }

                            $.each(msg, function (i, v) {

                                //MSGs[v.id] = v;
                                let _cls = (v.status == 'Unread' && dir == 'inbox' ? 'text-bold' : '');
                                let HTML = ' <li class="item padding-15" data-email-id="' + v.id + '">\n' +
                                    '<div class="thumbnail-wrapper d32 circular">\n' +
                                    '    <img width="40" height="40" alt="" data-src-retina="' + v.photo + '" data-src="' + v.photo + '" src="' + v.photo + '">\n' +
                                    '</div>\n' +
                                    '<div class="checkbox  no-margin p-l-10">\n' +
                                    '    <input type="checkbox" value="' + v.id + '" id="emailcheckbox-0-' + v.id + '">\n' +
                                    '    <label for="emailcheckbox-0-' + v.id + '"></label>\n' +
                                    '</div>\n' +
                                    '<div class="inline m-l-15">\n' +
                                    '    <p class="recipients no-margin hint-text small">' + v.full_name + '</p>\n' +
                                    '    <p class="subject no-margin ' + _cls + '">' + v.subject + '</p>\n' +
                                    '    <p class="body no-margin">' + (v.short_message) + '</p>\n' +
                                    '</div>\n' +
                                    '<div class="datetime">' + v.time_ago + '</div>\n' +
                                    '<div class="clearfix"></div>\n' +
                                    '</li>';

                                $('[data-email="' + dir + '"] [data-date="'+ date +'"]').next('.email-list').append(HTML);
                            });
                        });
                    }

                });
            }

            let box = $('.main-menu li.active a[data-box]').data('box');
            get_msg(box);
            $(document).on('click', '[data-box]', function (e) {
                e.preventDefault();
                let msg_box = $(this).data('box');
                $(this).closest('ul').find('li').removeClass('active');
                $(this).parent('li').addClass('active');
                get_msg(msg_box);
            });

            $(document).on('click', '.load-more', function (e) {
                e.preventDefault();
                let box = $('.main-menu li.active a[data-box]').data();
                get_msg(box.box, box.start);
            });

            $(document).on('click', '[data-email-id]', function(e) {
                e.preventDefault();
                let _this = $(this);
                let email_id = _this.data('email-id');
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url("inbox/ajax/msg/")?>' + email_id,
                    data: {},
                    complete: function (data) {
                        let msg = data.responseJSON.row;
                        let total_unread = data.responseJSON.total_unread;

                        _this.find('.subject').removeClass('text-bold');
                        $('.main-menu li.active a[data-box] .counter .unread').html(total_unread);

                        $('.no-result').css({display: 'none'});
                        $('.email-content-wrapper').css({display: 'block'});
                        $('.email-content-wrapper .email-content-body').html(msg.message);

                        $('.email-content .thumbnail-wrapper img').attr('src', msg.photo).data({'src-retina': msg.photo, 'src-retina': msg.photo});
                        $('.email-content .sender .name').html(msg.full_name);
                        $('.email-content .sender .datetime').html(msg.time_ago);

                        $('#reply_form [name=msg_id]').val(msg.id);
                        $('#reply_form [name=to_id]').val(msg.from_id);
                        $('#reply_form [name=sender_type]').val(msg.sender_type);
                        $('#reply_form [name=subject]').val('RE: ' + msg.subject);
                    }
                }).fail(function() {
                    alert('Try again!');
                });
            });


            $(document).on('submit', '#reply_form', function (e) {
                e.preventDefault();
                let _form = $(this);
                console.log(_form);
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: _form.attr('action'),
                    data: _form.serialize(),
                }).done(function(json) {
                    console.log(json);
                    //get_msg(box);
                    $('#composeModal').modal('hide');
                    _form.find('.reset').trigger('click');
                })
                .fail(function() {

                });
            });

        });

    </script>
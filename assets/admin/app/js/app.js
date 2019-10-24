//== Class definition
var _APP = function() {
    //== Private functions
    var onPage = function() {

        $('.dropify').dropify({
            tpl: {
                clearButton:     '<a class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air dropify-clear"><i class="la la-trash"></i></a>',
                /*clearButton:     '<a href="#" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air dropify-view lightbox"><i class="flaticon-visible"></i></a>' +
                    '<a class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air dropify-clear"><i class="la la-trash"></i></a>',*/
            }
        }).on('dropify.beforeClear', function(event, element){
            event.preventDefault();
            var url = element.settings.delete_url;
            console.log(url);
            if(url === null) return true;
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Confirm!",
                cancelButtonText: "Cancel!",
                reverseButtons: !0
            }).then(function(e) {
                console.log(e.value);
                if(e.value){
                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        url: url,
                        data: {},
                        complete: function (data) {
                            var json = $.parseJSON(data.responseText);
                            console.log(json);
                            _this.closest('.thumbnail').remove();
                            return true;
                        }
                    });
                }
                return false;
            });
                //return confirm("Do you really want to delete \"" + element.filename + "\" ?");
        });

        $(".sortable-ordering").sortable({
            //group: 'sortable-row',
            containerSelector: '.sortable-ordering',
            itemSelector: '.sortable-row',
            handle: '.sortable-move',
            //group: 'sortable-ordering',
            nested: false,
            //placeholder: '<div class="col-lg-2 img-row"><div class="block"><div class="thumbnail thumbnail-boxed"><div class="thumb"><img src="https://via.placeholder.com/200x200.png?text=Sorting..." alt="" class="img-responsive"></div></div></div></div>',
            onDragStart: function ($item, container, _super) {
                // Duplicate items of the no drop area
                if(!container.options.drop){
                    $item.clone().insertAfter($item);
                }
                _super($item, container);
            },
            onDrop: function ($item, container, _super) {
                oldIndex = $item.index();
                newIndex = $item.index();
                //console.log(oldIndex + ' - ' + newIndex);
                //console.log($item);
                console.log(container);
                //$('#serialize_output').text(group.sortable("serialize").get().join("\n"));
                _super($item, container);
            }
        });

        // basic
        $(document).on('click', '.form-btns [action], .grid-bluk-action [action]', function (e) {
            e.preventDefault();

            var _this = $(this);
            var action = $(this).attr('action');
            console.log(action);
            var url = $(this).attr('href');
            switch (action){
                case 'edit':
                case 'update':
                case 'save':
                case 'update_profile':
                    //console.log(_this.closest('form'));
                    _this.closest('form').submit();
                    break;
                case 'save_new':
                case 'save_close':
                    var form = _this.closest('form');
                    form.find('.__redirect').remove();
                    form.prepend('<input type="hidden" class="__redirect" name="__redirect" value="' + url + '">');
                    form.submit();
                    break;
                case 'update_grid':
                    var form = _this.closest('.m-portlet');
                    if(url.indexOf('?') != -1){
                        url += '&' + $('input[name*=ids][type=checkbox]', form).serialize();
                    }else{
                        url += '/?' + $('input[name*=ids][type=checkbox]', form).serialize();
                    }
                    var grid_bluk = $('.grid-bluk-action', form);
                    if($('select[name=status]', grid_bluk).val() == ''){
                        swal('Select a status!');
                        return false;
                    }
                    url += '&' + $('input,select,textarea', grid_bluk).serialize();
                    window.location = url;
                    break;
                case 'delete':
                    var form = _this.closest('.m-portlet').find('.m-portlet__body > form');
                    console.log(form);
                    if($('.grid-table tbody input[name*=ids][type=checkbox]:checked', form).length == 0){
                        swal("Select one or more checkbox!");
                        return false
                    }
                    swal({
                        title: "Are you sure?",
                        text: "You won't be able to delete these!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function (e) {
                        if(e.value){
                            if(url.indexOf('?') != -1){
                                url += '&' + $('input[name*=ids][type=checkbox]', form).serialize();
                            }else{
                                url += '/?' + $('input[name*=ids][type=checkbox]', form).serialize();
                            }
                            console.log(url);
                            window.location = url;
                        }
                    });
                    break;

                case 'print':
                    //var form = _this.closest('.m-portlet');
                    $(".print-me").print({
                        globalStyles: true,
                        mediaPrint: false,
                        iframe: false,
                        noPrintSelector: $(".print-me").data('print-hide'),
                        prepend: '',
                        append: '',
                        deferred: $.Deferred().done(function () {
                            //console.log('Printing done', arguments);
                        })
                    });
                    break;
                default:
                    window.location = url;
                    break;
            }
        });

        $(document).on('blur', '.gtd-ordering input.ordering', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            if(url.indexOf('?') != -1){url += '&' + $(this).serialize()}
            else {url += '?' + $(this).serialize()}
            //console.log(url);
            $.get(url)
            .done(function () {
                var notify = $.notify('Record has been updated!', {
                    type: 'success',
                    newest_on_top: true,
                    allow_dismiss: true,
                });
            })
            .fail(function () {
                var notify = $.notify('Some error occurred!', {
                    type: 'error',
                    newest_on_top: true,
                    allow_dismiss: true,
                });
            });
        });

        $(document).on('click', '.gtd-grid_actions a[action]', function (e) {
            e.preventDefault();

            var _this = $(this);
            var action = $(this).attr('action');
            var url = $(this).attr('href');
            switch (action){
                case 'delete':
                    swal({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function(e) {
                        console.log(e);
                        if(e.value){
                            window.location = url;
                        }
                    });
                    break;
                default:
                    window.location = url;
                    break;
            }
        });

        $(document).on('click', '[ajax-call]', function (e) {
            e.preventDefault();

            var _this = $(this);
            var action = $(this).attr('ajax-call');
            var url = $(this).attr('href');
            switch (action){
                case 'delete':
                case 'delete_img':
                    swal({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function(e) {
                        if(e.value){
                            var notify = $.notify('<strong>Saving</strong> Do not close this page...', {
                                type: 'info',
                                newest_on_top: true,
                                allow_dismiss: false,
                                showProgressbar: true
                            });

                            $.ajax({
                                type: "GET",
                                dataType: "JSON",
                                url: url,
                                data: {},
                                complete: function (data) {
                                    var json = $.parseJSON(data.responseText);
                                    console.log(json);
                                    _this.closest('.thumbnail').remove();
                                    notify.update({'type': 'success', 'message': '<strong>Saving</strong> Page Data.'});
                                    notify.close();
                                }
                            });
                        }
                    });
                    break;
                default:

                    var notify = $.notify('<strong>Saving</strong> Do not close this page...', {
                        type: 'info',
                        newest_on_top: true,
                        allow_dismiss: false,
                        showProgressbar: true
                    });

                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        url: url,
                        data: {},
                        complete: function (data) {
                            var json = $.parseJSON(data.responseText);
                            console.log(json);
                            notify.update('message', '<strong>Saving</strong> Page Data.');
                        }
                    });

                    break;
            }
        });

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

        $(document).on('change', '.grid-table tbody input[name*=ids][type=checkbox]', function (e) {
            e.preventDefault();
            var p = $(this).closest('.m-portlet');

            var chk_lenght = $('tbody input[name*=ids][type=checkbox]:checked', p).length;
            if(chk_lenght > 0){
                $('.grid-bluk-action', p).show();
            }else{
                $('.grid-bluk-action', p).hide();
                $('.check-all', p).attr('checked', false).next('span').find(':after').remove();
            }
        });


        $(document).on("keyup", ".search-input", function() {
            var value = $(this).val().toLowerCase();
            var find_attr = $(this).attr('find-in');
            var find_container = $(this).attr('find-block');

            $(find_attr, find_container).filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        $("[data-mask]").inputmask();

        $(".m_maxlength").maxlength({
            alwaysShow: !0,
            warningClass: "m-badge m-badge--primary m-badge--rounded m-badge--wide",
            limitReachedClass: "m-badge m-badge--danger m-badge--rounded m-badge--wide"
        });

        $('.m_touchspin').each(function (i, v) {

            var options = {
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                verticalbuttons: true,
                min: -1000000000,
                max: 1000000000,
                verticalupclass: 'la la-plus',
                verticaldownclass: 'la la-minus'
            };

            options = get_options($(this).data(), options);
            $(this).TouchSpin(options);
        });



        $('.m_selectpicker,.selectpicker').selectpicker();


        $('.datetimepicker').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            showMeridian: !0,
            todayHighlight: !0,
            autoclose: !0,
            pickerPosition: "bottom-left"
        });

        $('.datepicker').each(function (i, v) {

            var options = {
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            };

            options = get_options($(this).data(), options);

            $(this).datepicker(options);
        });

        $('.m_datepicker').each(function (i, v) {
            var options = {
                format: "yyyy-mm-dd",
                //todayBtn: "linked",
                autoclose: true,
                clearBtn: true,
                todayHighlight: true,
                rtl: mUtil.isRTL(),
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            };

            options = get_options($(this).data(), options);
            $(this).datepicker(options);
        });

        $('.timepicker').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            snapToStep: true
        });


        function resize_table() {
            $('.table-responsive').each(function () {
                var t_res_w = $('thead', this).width();
                var t_res_body_w = $(this).closest('.grid_form').width();
                console.log(t_res_w + ' - ' + t_res_body_w);
                if (t_res_body_w > t_res_w) {
                    $(this).css('display', 'table');
                }else{
                    $(this).css('display', 'inherit');
                }
            })
        }
        resize_table();
        $(window).resize(function (e) {
            resize_table();
        });


        $(document).on('change', '.check-all', function (e) {
            var _check = $(this).is(':checked');
            var _table = $(this).closest('table').find('tbody');
            if(!_check){
                _table.checkboxes('uncheck');
            }else {
                _table.checkboxes('check');
            }
            e.preventDefault();
        });
        $('.grid-table tbody').checkboxes('range', true);

        $(document).on('change', '.chk-id', function (e) {
            if($(':checked', '.chk-id').length > 0){
                $(this).closest('form').find('.selection-box').show();
            }else {
                $(this).closest('form').find('.selection-box').hide();
            }
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

        $('.m-select2').select2({
            //placeholder: "Select a state"
            templateResult: format,
            templateSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


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

        // tagging support
        $('.m_select2-tags').select2({
            placeholder: "Add a tag",
            tags: true
        });

        // loading remote data

        function formatRepo(repo) {
            if (repo.loading) return repo.text;
            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
            if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }
            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
            return markup;
        }

        function formatRepoSelection(repo) {
            return repo.full_name || repo.text;
        }




        var portlet = new mPortlet('m_portlet_tools');


        $("[data-fancybox],.lightbox").fancybox({
            buttons : [
                'slideShow',
                'fullScreen',
                'thumbs',
                //'share',
                'download',
                'zoom',
                'close'
            ],
        });


        new Clipboard("[data-clipboard=true]").on("success", function (e) {
            e.clearSelection();
        });

        $(document).on('change', 'select.other-option', function (e) {
            var _this = $(this);
            var other_text = (_this.data('other-text'));

            if(_this.find('option:selected').text() == other_text){
                var HTML = '<div class="input-group other-option-input mb-3">\n' +
                    '<input type="text" value="" placeholder="'+_this.find('option:selected').text()+'" class="form-control" name="'+_this.attr('name')+'">\n' +
                    '<div class="input-group-append"><span class="input-group-text remove-other-opt"> <i class="la la-close"></i> </span></div>\n' +
                    '</div>';

                _this.closest('.other-body').find('.bootstrap-select,.select2-container').hide();
                _this.closest('.other-body').find('select').hide().attr('disabled', true);
                _this.closest('.other-body').append(HTML);
                _this.closest('.other-body').find('input.form-control').focus();
            }
        });

        $(document).on('click', '.remove-other-opt', function (e) {
            e.preventDefault();
            var _this = $(this);
            var _parent = _this.closest('.other-body');
            _parent.find('.other-option-input').remove();
            _parent.find('.bootstrap-select,.select2-container').show();
            _parent.find('select').show().attr('disabled', false);
        });


    }




    /*********************************************************************************************
     *
     * Modal
     *
     */
    var onModal = function() {
        $('.modal').on('shown.bs.modal', function () {
            // basic
            var _modal = $(this);

            $("[data-mask]").inputmask();

            $('.m-select2').select2({
                //placeholder: "Select a state"
            });

            $('.m_touchspin').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                verticalbuttons: true,
                verticalupclass: 'la la-plus',
                verticaldownclass: 'la la-minus'
            });


            $('.m_selectpicker,.select').selectpicker();


            //var portlet = $('.m_portlet').mPortlet();

            /*$(this).find('select.ajax').addClass('m-select2-ajax-modal');
            $(".m-select2-ajax-modal").select2({
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
                dropdownParent: _modal,
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
            });*/


        });
    }

    //== Public functions
    return {
        init: function() {
            onPage();
            onModal();
        }
    };
}();

//== Initialization
jQuery(document).ready(function() {
    _APP.init();
});

function  get_options(data, options) {
    if(Object.keys(data).length > 0) {
        $.each(data, function (k, v) {
            options[k.substring(2)] = v;
        });
    }
    return options;
}
function friendly_URL(url) {
    url.trim();
    var URL = url.replace(/\-+/g, '-').replace(/\W+/g, '-');// Replace Non-word characters
    if (URL.substr((URL.length - 1), URL.length) == '-') {
        URL = URL.substr(0, (URL.length - 1));
    }

    return URL.toLowerCase();
}
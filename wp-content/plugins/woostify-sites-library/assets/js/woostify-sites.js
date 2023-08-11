
var Woostify_Sites = (function($){

    var t;
    var current_index;

    // callbacks from form button clicks.
    var callbacks = {
        install_child: function(btn) {
            var installer = new ChildTheme();
            installer.init(btn);
        },
        activate_license: function(btn) {
            var license = new ActivateLicense();
            license.init(btn);
        },
        install_plugins: function(btn){
            var plugins = new PluginManager();
            plugins.init(btn);
        },
        install_content: function(btn){
            var content = new ContentManager();
            content.init(btn);
        },
        active_modules: function(btn) {
            var modules = new ModuleManager();
            modules.init(btn);
        }
    };


    function window_loaded(){

        var
        body            = $('.merlin__body'),
        body_loading    = $('.merlin__body--loading'),
        body_exiting    = $('.merlin__body--exiting'),
        drawer_trigger  = $('#merlin__drawer-trigger'),
        drawer_opening  = 'merlin__drawer--opening',
        drawer_opened   = 'merlin__drawer--open',
        btn_filter_link = $( '.js-select-filter' ),
        select_demo_btn = $( '.js-select-demo' );

        setTimeout(function(){
            body.addClass('loaded');
        },100);

        drawer_trigger.on('click', function(){
            body.toggleClass( drawer_opened );
        });

        $('.merlin__button--proceed:not(.merlin__button--closer)').click(function (e) {
            e.preventDefault();
            var goTo = this.getAttribute("href");

            body.addClass('exiting');

            setTimeout(function(){
                window.location = goTo;
            },400);
        });

        $(".merlin__button--closer").on('click', function(e){

            body.removeClass( drawer_opened );

            e.preventDefault();
            var goTo = this.getAttribute("href");

            setTimeout(function(){
                body.addClass('exiting');
            },600);

            setTimeout(function(){
                window.location = goTo;
            },1100);
        });


        $( window ).scroll(function() {
            var demoElement = $('.merlin__demos');
            if ( demoElement.length > 0 ) {
                var height =  demoElement.offset().top;
                console.log( height );
                if ( $( window ).scrollTop() > height ) {
                    $('.merlin__footer-sticky').addClass('show');
                } else {
                    $('.merlin__footer-sticky').removeClass('show');
                }
            }
        });

        $(".button-next").on( "click", function(e) {
            e.preventDefault();
            if ( ! getCookie('demo') || getCookie('demo') == 'undefined' ) {
                alert('You have to select a demo before start importing.');
                return;
            }
            var loading_button = merlin_loading_button(this);
            if ( ! loading_button ) {
                return false;
            }
            var data_callback = $(this).data("callback");
            if( data_callback && typeof callbacks[data_callback] !== "undefined"){
                // We have to process a callback before continue with form submission.
                callbacks[data_callback](this);
                return false;
            } else {
                return true;
            }
        });
        var page = 1;
        var btnLoadMore = $( '.btn-merlin--loadmore' );
        btnLoadMore.on('click', function(e) {
            var pageBuilder = $('.merlin__other-page-builder').find('.active').attr('data-group'),
                cat = $('.merlin__categories').find('.active').attr('data-group'),
                data = {
                    action: 'woostify_sites_load_more_demo',
                    _ajax_nonce: woostify_sites_params.wpnonce,
                    page: page,
                    category: cat,
                    page_builder: pageBuilder,
                };

            $.ajax({ // you can also use $.post here
                url : woostify_sites_params.ajaxurl, // AJAX handler
                data : data,
                type : 'POST',
                beforeSend : function ( xhr ) {
                    btnLoadMore.addClass('loading')

                },
                success : function( response ){
                    btnLoadMore.removeClass('loading');
                    console.log( response );
                    if( response ) {
                        page++;
                        
                        $( '.merlin__demos' ).append(response.data);
                        if ( page >= woostify_sites_params.total_page ) {
                            btnLoadMore.css( { 'display' : 'none' } );
                            btnLoadMore.attr( 'disabled', 'disabled' );
                            page = 1;
                        }
                    } else {
                        btnLoadMore.css( { 'display' : 'none' } );
                        btnLoadMore.attr( 'disabled', 'disabled' );
                        page = 1;
                    }
                },
                error: function (e){
                    alert( 'Opps!, Something went wrong, please try again later.' );
                }
            });
        });


        btn_filter_link.on( 'click', function (e) {
            e.preventDefault();
            document.cookie = "demo=undefined";
            console.log( getCookie('demo') );
            page = 1;
            $(this).parents( '.filter-links' ).find( '.active' ).removeClass( 'active' );
            $(this).addClass('active');
            var pageBuilder = $('.merlin__other-page-builder').find('.active').attr('data-group'),
                cat = $('.merlin__categories').find('.active').attr('data-group');
            var data = {
                    action: 'woostify_site_filter_demo',
                    _ajax_nonce: woostify_sites_params.wpnonce,
                    page_builder: pageBuilder,
                    category: cat,
                };

            $.ajax({ // you can also use $.post here
                url : woostify_sites_params.ajaxurl, // AJAX handler
                data : data,
                type : 'POST',
                beforeSend : function ( xhr ) {
                    $( '.merlin__demos' ).html('');
                    $( '.merlin__demos' ).addClass('loading');
                },
                success : function( response ){
                    $('.merlin__button--next').css({'display': 'none'});
                    var totalPage = parseInt( getCookie( 'total_page' ) );
                    $( '.merlin__demos' ).removeClass('loading');
                    if( response ) {
                        $( '.merlin__demos' ).html(response.data);
                        if ( totalPage > page ) {
                            btnLoadMore.css( { 'display' : 'flex' } );
                            btnLoadMore.removeAttr( 'disabled' );
                        } else {
                            btnLoadMore.css( { 'display' : 'none' } );
                            btnLoadMore.attr( 'disabled', 'disabled' );
                        }
                    } else {
                        btnLoadMore.css( { 'display' : 'none' } );
                        btnLoadMore.attr( 'disabled', 'disabled' );
                    }
                },
                error: function (e){
                    alert( 'Opps!, Something went wrong, please try again later.' );
                }
            });

        } );


        $('.merlin__demos ').on( 'click', '.js-select-demo', function() {
            current_index = $( this ).data('content');
            $(document).find('.js-select-demo').removeClass('merlin__demo-button--primary');
            console.log(current_index);
            document.cookie = "demo=" + current_index;
            var $this = $(this);
            var $selectedOption  = $( this ).children( ':selected' ),
                optionImgSrc     = $selectedOption.data( 'img-src' ),
                optionNotice     = $selectedOption.data( 'notice' ),
                optionPreviewUrl = $selectedOption.data( 'preview-url' );

            $.post( woostify_sites_params.ajaxurl, {
                action: 'woostify_sites_update_selected_import_data_info',
                _ajax_nonce: woostify_sites_params.wpnonce,
                selected_index: current_index,
            }, function( response ) {
                if ( response.data != 'success' ) {
                    alert(response.data);
                } else {
                    $( '.js-merlin-drawer-import-content' ).html( response.data );
                    $this.addClass('merlin__demo-button--primary');
                    $('[data-callback="install_content"]').css({'display': 'block'});
                    $('.js-select').css({'display': 'block'});
                    $('.js-select').css({'display': 'block'});
                }
            } )
                .fail( function() { alert( woostify_sites_params.texts.something_went_wrong ); } );
        } );

    }

    function ChildTheme() {
        var body                = $('.merlin__body');
        var complete, notice    = $("#child-theme-text");

        function ajax_callback(r) {

            if (typeof r.done !== "undefined") {
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);


                complete();
            } else {
                notice.addClass("lead error");
                notice.html(r.error);
            }
        }

        function do_ajax() {
            jQuery.post(woostify_sites_params.ajaxurl, {
                action: "woostify_sites_child_theme",
                wpnonce: woostify_sites_params.wpnonce,
            }, ajax_callback).fail(ajax_callback);
        }

        return {
            init: function(btn) {
                complete = function() {

                    setTimeout(function(){
                $(".merlin__body").addClass('js--finished');
            },1500);

                    body.removeClass( drawer_opened );

                    setTimeout(function(){
                $('.merlin__body').addClass('exiting');
            },3500);

                        setTimeout(function(){
                window.location.href=btn.href;
            },4000);

                };
                do_ajax();
            }
        }
    }

    function ActivateLicense() {
        var body        = $( '.merlin__body' );
        var wrapper         = $( '.merlin__content--license-key' );
        var complete, notice    = $( '#license-text' );

        function ajax_callback(r) {

            if (typeof r.success !== "undefined" && r.success) {
              notice.siblings( '.error-message' ).remove();
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);
                complete();
            } else {
                $( '.js-merlin-license-activate-button' ).removeClass( 'merlin__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax() {

            wrapper.removeClass('has-error');

            jQuery.post(woostify_sites_params.ajaxurl, {
              action: "woostify_sites_activate_license",
              wpnonce: woostify_sites_params.wpnonce,
              license_key: $( '.js-license-key' ).val()
            }, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                $(".merlin__body").addClass('js--finished');
            },1500);

                    body.removeClass( drawer_opened );

                    setTimeout(function(){
                $('.merlin__body').addClass('exiting');
            },3500);

                        setTimeout(function(){
                window.location.href=btn.href;
            },4000);

                };
                do_ajax();
            }
        }
    }

    function PluginManager(){

        var body = $('.merlin__body');
        var complete;
        var items_completed     = 0;
        var current_item        = "";
        var $current_node;
        var current_item_hash   = "";

        function ajax_callback(response){

            var currentSpan = $current_node.find("label");
            if(typeof response === "object" && typeof response.message !== "undefined"){
                currentSpan.removeClass( 'installing success error' ).addClass(response.message.toLowerCase());

                // The plugin is done (installed, updated and activated).
                if(typeof response.done != "undefined" && response.done){
                    find_next();
                }else if(typeof response.url != "undefined"){
                    // we have an ajax url action to perform.
                    if(response.hash == current_item_hash){
                        currentSpan.removeClass( 'installing success' ).addClass("error");
                        find_next();
                    }else {
                        current_item_hash = response.hash;
                        jQuery.post(response.url, response, ajax_callback).fail(ajax_callback);
                    }
                }else{
                    // error processing this plugin
                    find_next();
                }
            }else{
                // The TGMPA returns a whole page as response, so check, if this plugin is done.
                process_current();
            }
        }

        function process_current(){
            if(current_item){
                var $check = $current_node.find("input:checkbox");
                if($check.is(":checked")) {
                    jQuery.post(woostify_sites_params.ajaxurl, {
                        action: "woostify_sites_plugins",
                        wpnonce: woostify_sites_params.wpnonce,
                        slug: current_item,
                    }, ajax_callback).fail(ajax_callback);
                }else{
                    $current_node.addClass("skipping");
                    setTimeout(find_next,300);
                }
            }
        }

        function find_next(){
            if($current_node){
                if(!$current_node.data("done_item")){
                    items_completed++;
                    $current_node.data("done_item",1);
                }
                $current_node.find(".spinner").css("visibility","hidden");
            }
            var $li = $(".merlin__drawer--install-plugins li");
            $li.each(function(){
                var $item = $(this);

                if ( $item.data("done_item") ) {
                    return true;
                }

                current_item = $item.data("slug");
                $current_node = $item;
                process_current();
                return false;
            });
            if(items_completed >= $li.length){
                // finished all plugins!
                complete();
            }
        }

        return {
            init: function(btn){
                $(".merlin__drawer--install-plugins").addClass("installing");
                $(".merlin__drawer--install-plugins").find("input").prop("disabled", true);
                complete = function(){

                    setTimeout(function(){
                        $(".merlin__body").addClass('js--finished');
                    },1000);

                    body.removeClass( 'merlin__drawer--open' );

                    setTimeout(function(){
                        $('.merlin__body').addClass('exiting');
                    },3000);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },3500);

                };
                find_next();
            }
        }
    }

    function ContentManager(){

        var body                = $('.merlin__body');
        var complete;
        var items_completed     = 0;
        var current_item        = "";
        var $current_node;
        var current_item_hash   = "";
        var current_content_import_items = 1;
        var total_content_import_items = 0;
        var progress_bar_interval;

        function ajax_callback(response) {

            var currentSpan = $current_node.find("label");
            console.log(currentSpan);
            if(typeof response == "object" && typeof response.message !== "undefined"){
                console.log(response);
                currentSpan.addClass(response.message.toLowerCase());

                if( typeof response.num_of_imported_posts !== "undefined" && 0 < total_content_import_items ) {
                    current_content_import_items = 'all' === response.num_of_imported_posts ? total_content_import_items : response.num_of_imported_posts;
                    update_progress_bar();
                }

                if(typeof response.url !== "undefined"){
                    // we have an ajax url action to perform.
                    if(response.hash === current_item_hash){
                        currentSpan.addClass("status--failed");
                        find_next();
                    } else {
                        current_item_hash = response.hash;

                        // Fix the undefined selected_index issue on new AJAX calls.
                        if ( typeof response.selected_index === "undefined" ) {
                            response.selected_index = getCookie('demo');
                        }

                        jQuery.post(response.url, response, ajax_callback).fail(ajax_callback); // recuurrssionnnnn
                    }
                }else if(typeof response.done !== "undefined"){
                    // finished processing this plugin, move onto next
                    find_next();
                }else{
                    // error processing this plugin
                    find_next();
                }
            }else{
                console.log(response);
                // error - try again with next plugin
                currentSpan.addClass("status--error");
                find_next();
            }
        }

        function process_current(){
            if(current_item){
                var $check = $current_node.find("input:checkbox");
                if($check.is(":checked")) {
                    jQuery.post(woostify_sites_params.ajaxurl, {
                        action: "woostify_sites_content",
                        wpnonce: woostify_sites_params.wpnonce,
                        content: current_item,
                        selected_index: getCookie('demo'),
                    }, ajax_callback).fail(ajax_callback);
                }else{
                    $current_node.addClass("skipping");
                    setTimeout(find_next,300);
                }
            }

        }

        function find_next(){
            var do_next = false;
            if($current_node){
                console.log(222);
                if(!$current_node.data("done_item")){
                    items_completed++;
                    $current_node.data("done_item",1);
                }
                $current_node.find(".spinner").css("visibility","hidden");
            }
            var $items = $(".merlin__drawer--import-content__list-item");
            var $enabled_items = $(".merlin__drawer--import-content__list-item input:checked");
            console.log( current_item );
            $items.each(function(){
                if (current_item == "" || do_next) {
                    current_item = $(this).data("content");
                    $current_node = $(this);
                    process_current();
                    do_next = false;
                } else if ($(this).data("content") == current_item) {
                    do_next = true;
                }
            });
            if(items_completed >= $items.length){
                complete();
            }
        }

        function init_content_import_progress_bar() {
            if( ! $(".merlin__drawer--import-content__list-item .checkbox-content").is( ':checked' ) ) {
                return false;
            }

            jQuery.post(woostify_sites_params.ajaxurl, {
                action: "woostify_sites_get_total_content_import_items",
                wpnonce: woostify_sites_params.wpnonce,
                selected_index: getCookie('demo'),
            }, function( response ) {
                total_content_import_items = response.data;
                console.log(response);

                if ( 0 < total_content_import_items ) {
                    update_progress_bar();

                    // Change the value of the progress bar constantly for a small amount (0,2% per sec), to improve UX.
                    progress_bar_interval = setInterval( function() {
                        current_content_import_items = current_content_import_items + total_content_import_items/500;
                        update_progress_bar();
                    }, 1000 );
                }
            } );
        }

        function valBetween(v, min, max) {
            return (Math.min(max, Math.max(min, v)));
        }

        function update_progress_bar() {
            $('.js-merlin-progress-bar').css( 'width', (current_content_import_items/total_content_import_items) * 100 + '%' );

            var $percentage = valBetween( ((current_content_import_items/total_content_import_items) * 100) , 0, 99);

            $('.js-merlin-progress-bar-percentage').html( Math.round( $percentage ) + '%' );

            if ( 1 === current_content_import_items/total_content_import_items ) {
                clearInterval( progress_bar_interval );
            }
        }

        return {
            init: function(btn){
                if ( ! getCookie('demo') || getCookie('demo') == 'undefined' ) {
                    alert('You have to select a demo before start importing.');
                    console.log(getCookie('demo'));
                    return;
                }

                $(".merlin__drawer--import-content").addClass("installing");
                $(".merlin__drawer--import-content").find("input").prop("disabled", true);
                $( btn ).find( '.merlin__button--loading__text' ).css( 'color', 'transparent' );
                $( btn ).find('.js-merlin-progress-bar-percentage' ).css({ 'display':'inline-block', 'color':'#46b450'});
                complete = function(){

            $.post(woostify_sites_params.ajaxurl, {
                action: "woostify_sites_import_finished",
                wpnonce: woostify_sites_params.wpnonce,
                selected_index: getCookie('demo'),
            });

            setTimeout(function(){
                $('.js-merlin-progress-bar-percentage').html( '100%' );
            },100);

                    setTimeout(function(){
                       body.removeClass( 'merlin__drawer--open' );
                    },500);

                    setTimeout(function(){
                        $(".merlin__body").addClass('js--finished');
                    },1500);

                    setTimeout(function(){
                        $('.merlin__body').addClass('exiting');
                    },3400);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);
                };
                init_content_import_progress_bar();
                find_next();
            }
        }
    }

    function ModuleManager(){

        var body                = $('.merlin__body');
        var complete;
        var items_completed     = 0;
        var current_item        = "";
        var $current_node;
        var current_item_hash   = "";
        var current_content_import_items = 1;
        var total_content_import_items = 0;
        var progress_bar_interval;
        var counter = 1;

        function ajax_active( module_id, item ) {
            var data     = {
                action: 'woostify_sites_module_action',
                ajax_nonce: woostify_sites_params.wpnonce,
                name: module_id,
                counter: counter
            };
            item.next().addClass( 'installing' );
            item.parent().addClass('installing');
            $.ajax(
                {
                    type: 'POST',
                    url: woostify_sites_params.ajaxurl,
                    data: data,
                    

                    success: function (response) {
                        console.log( response );
                        item.next().addClass( 'success' );
                        current_content_import_items++;
                        counter++;
                    },
                    error: function () {
                        item.next().addClass( 'error' );
                    }
                }
            );

            update_progress_bar();
            progress_bar_interval = setInterval( function() {
                current_content_import_items = current_content_import_items + total_content_import_items/500;
                update_progress_bar();
            }, 1000 );
        };

        function multiModuleAction( btn ) {
            var listMolude = $('.module-checkbox:checked'),
                time;
            total_content_import_items = listMolude.length;

            if ( listMolude.length > 0 ) {
                listMolude.each( function( index ) {
                    var item = $(this),
                        moduleId = item.attr( 'value' );
                    time = 1000 * index;
                    setTimeout(
                        function() {
                            ajax_active( moduleId, item );
                        },
                        time
                    );
                });
            }

            setTimeout(
                function() {
                    $(".merlin__body").addClass('js--finished');
                },
                time + 1500
            );

            setTimeout(
                function() {
                    window.location.href = btn.href;
                },
                time + 3000
            );

        };

        function update_progress_bar() {
            $('.js-merlin-progress-bar').css( 'width', (current_content_import_items/total_content_import_items) * 100 + '%' );

            var $percentage = valBetween( ((current_content_import_items/total_content_import_items) * 100) , 0, 99);

            $('.js-merlin-progress-bar-percentage').html( Math.round( $percentage ) + '%' );

            if ( 1 < current_content_import_items/total_content_import_items ) {
                clearInterval( progress_bar_interval );
                $('.js-merlin-progress-bar-percentage').html( '100%' );
            }
        };

        function valBetween(v, min, max) {
            return (Math.min(max, Math.max(min, v)));
        }

        return {
            init: function(btn){
                $( btn ).find( '.merlin__button--loading__text' ).css( 'color', 'transparent' );
                $( btn ).find('.js-merlin-progress-bar-percentage' ).css({ 'display':'inline-block', 'color':'#46b450'});
                setTimeout(function(){
                    multiModuleAction( btn );
                },500);
            }
        }
    }

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function merlin_loading_button( btn ){

        var $button = jQuery(btn);

        if ( $button.data( "done-loading" ) == "yes" ) {
            return false;
        }

        var completed = false;

        var _modifier = $button.is("input") || $button.is("button") ? "val" : "text";

        // $button.data("done-loading","yes");

        if (current_index > -1) {
            $button.addClass("merlin__button--loading");
        }

        return {
            done: function(){
                completed = true;
                $button.attr("disabled",false);
            }
        }

    }


    return {
        init: function(){
            t = this;
            $(window_loaded);
        },
        callback: function(func){
            console.log(func);
            console.log(this);
        }

    }

})(jQuery);

Woostify_Sites.init();

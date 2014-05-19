require.config({
    baseUrl: '/default/js',
    paths: {
        jquery: 'lib/jquery',
        knockout: 'lib/knockout',
        bootstrap: '/mac/js/bootstrap',
        custom: '/mac/js/custom',
        switch:'/mac/js/bootstrap-switch.min',
        validation:'lib/knockout.validation',
        validationConfig:'module/knockout.validation.config',
        typeahead:'lib/typeahead.min',
        underscore:'lib/underscore.min',
        loadBar:'lib/jquery.loadingbar.min',
        knockoutMapping:'lib/knockout.mapping',
        checkedAll:'module/checked.all.handle',
        pace:'lib/pace.min',
        formPost:'module/formPost',
        imageUploader:'module/image.uploader'
    },
    shim:{
        'bootstrap':{
            deps:['jquery'],
            exports:"$.fn.popover"
        },
        'typeahead':{
            deps:['bootstrap'],
            exports:"$.fn.typeahead"
        },
        'json2':{
            deps:[],
            exports:"JSON"
        },
        'switch':{
            deps:['jquery'],
            exports:"$.fn.bootstrapSwitch"
        }
    }
});
require(["jquery",'pace','bootstrap'], function($,pace) {

        pace.start();
        var $submitBtn = $('button[type="submit"]');
        isAjaxRunning = false;
        if($submitBtn.length>0){
            $(document).ajaxStart(function(){
                isAjaxRunning = true;
                $submitBtn.button('loading');
            });
            $(document).ajaxStop(function(){
                isAjaxRunning = false;
                $submitBtn.button('reset');
            });
        }
        message = {
            show:function(message,type){
                $('<div class="alert alert-'+type+'" style="position:fixed;bottom:-54px;left:0px;width:100%;z-index:100;margin:0px;">'+message+'</div>')
                    .appendTo('body')
                    .animate({'bottom':0},500);
            },
            close:function(){

            },
            error:function(message){
                this.show(message,'danger');
            },
            success:function(){

            },
            info:function(){

            }
        }
        message.error('test asdasdasdasdasd');
        $('.spinner .btn:first-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
            return false;
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
            return false;
        });
        /* Navigation */

        $(window).scroll( function() {
              if($(window).scrollTop()>$('header').outerHeight()-5){
                  if(!$("#sidebarContent").hasClass('nav-fix')){
                      $("#sidebarContent").addClass('nav-fix');
                  }
              }else{
                  if($("#sidebarContent").hasClass('nav-fix')){
                      $("#sidebarContent").removeClass('nav-fix');
                  }
              }
        });
        $(window).resize(function()
        {
            if ($(window).width() >= 765) {
                $(".sidebar #nav").slideDown(350);
            }
            else {
                $(".sidebar #nav").slideUp(350);
            }
        });


        $("#nav > li > a").on('click', function(e) {
            if ($(this).parent().hasClass("has_sub")) {
                e.preventDefault();
            }
            var $ul = $(this).next('ul');
            if ($ul.css('display')=='none') {

                // open our new menu and add the open class
                $(this).next("ul").slideDown(350);
                $(this).addClass("subdrop");
            }

            else {
                $(this).removeClass("subdrop");
                $(this).next("ul").slideUp(350);
            }

        });
//        $(".sidebar-dropdown a").on('click', function(e) {
//            e.preventDefault();
//
//            if (!$(this).hasClass("open")) {
//                // hide any open menus and remove all other classes
//                $(".sidebar #nav").slideUp(350);
//                $(".sidebar-dropdown a").removeClass("open");
//
//                // open our new menu and add the open class
//                $(".sidebar #nav").slideDown(350);
//                $(this).addClass("open");
//            }
//
//            else if ($(this).hasClass("open")) {
//                $(this).removeClass("open");
//                $(".sidebar #nav").slideUp(350);
//            }
//        });
        
        /* Widget close */

        $('.wclose').click(function(e) {
            e.preventDefault();
            var $wbox = $(this).parent().parent().parent();
            $wbox.hide(100);
        });

        /* Widget minimize */

        $('.wminimize').click(function(e) {
            e.preventDefault();
            var $wcontent = $(this).parent().parent().next('.widget-content');
            if ($wcontent.is(':visible'))
            {
                $(this).children('i').removeClass('icon-chevron-up');
                $(this).children('i').addClass('icon-chevron-down');
            }
            else
            {
                $(this).children('i').removeClass('icon-chevron-down');
                $(this).children('i').addClass('icon-chevron-up');
            }
            $wcontent.toggle(500);
        });
        /* Scroll to Top */


        $(".totop").hide();

        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300)
                {
                    $('.totop').slideDown();
                }
                else
                {
                    $('.totop').slideUp();
                }
            });

            $('.totop a').click(function(e) {
                e.preventDefault();
                $('body,html').animate({scrollTop: 0}, 500);
            });

        });
        /* Support */
        $("#slist a").click(function(e) {
            e.preventDefault();
            $(this).next('p').toggle(200);
        });
        
        /* Modal fix */

        $('.modal').appendTo($('body'));
});



require.config({
    baseUrl: '/default/js',
    paths: {
        jquery: 'lib/jquery',
        knockout: 'lib/knockout',
        bootstrap: 'lib/bootstrap',
        custom: 'lib/custom',
        switch:'lib/bootstrap-switch.min',
        validation:'lib/knockout.validation',
        validationConfig:'module/knockout.validation.config',
        typeahead:'lib/typeahead.min',
        underscore:'lib/underscore.min',
        loadBar:'lib/jquery.loadingbar.min',
        knockoutMapping:'lib/knockout.mapping',
        checkedAll:'module/checked.all.handle',
        pace:'lib/pace.min',
        formPost:'module/formPost',
        imageUploader:'module/image.uploader',
        message:'module/message',
        datetimepicker:'lib/bootstrap-datetimepicker',
        moment:'lib/moment',
        'moment.zh-CN':'lib/moment.zh-CN',
        flot:'lib/jquery.flot',
        flotResize:'lib/jquery.flot.resize',
        date:'lib/date-utils',
        chart:'module/chart.helper',
        cookie:'lib/jquery.cookie',
        search:'module/search'
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
        },
        'flot':{
            deps:['jquery'],
            exports:"$.fn.plot"
        },
        'flotResize':{
            deps:['flot'],
            exports:"$.fn.plot"
        }
    }
});
require(["jquery",'pace','bootstrap','moment','moment.zh-CN'], function($,pace) {

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
        $(".sidebar-dropdown a").on('click', function(e) {
            e.preventDefault();

            if (!$(this).hasClass("open")) {
                // hide any open menus and remove all other classes
                $(".sidebar #nav").slideUp(350);
                $(".sidebar-dropdown a").removeClass("open");

                // open our new menu and add the open class
                $(".sidebar #nav").slideDown(350);
                $(this).addClass("open");
            }

            else if ($(this).hasClass("open")) {
                $(this).removeClass("open");
                $(".sidebar #nav").slideUp(350);
            }
        });
        
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



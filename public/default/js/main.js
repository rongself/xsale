require.config({
    baseUrl: '/default/js',
    paths: {
        jquery: 'lib/jquery',
        knockout: 'lib/knockout',
        bootstrap: '/mac/js/bootstrap',
        custom: '/mac/js/custom',
        validation:'lib/knockout.validation',
        validationConfig:'module/knockout.validation.config',
        typeahead:'lib/typeahead.min',
        underscore:'lib/underscore.min',
        loadBar:'lib/jquery.loadingbar.min'
    }
});
require(["jquery"], function($) {
    require(['bootstrap'], function() {
        PRODUCT_IMAGE_PATH = '/uploads/img/';
        /* Navigation */

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

            if (!$(this).hasClass("subdrop")) {
                // hide any open menus and remove all other classes
                $("#nav li ul").slideUp(350);
                $("#nav li a").removeClass("subdrop");

                // open our new menu and add the open class
                $(this).next("ul").slideDown(350);
                $(this).addClass("subdrop");
            }

            else if ($(this).hasClass("subdrop")) {
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
});



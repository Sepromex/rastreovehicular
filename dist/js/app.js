(function ($) {
    "use strict";
    var primarycolor = getComputedStyle(document.body).getPropertyValue('--primarycolor');

//////////////////////// Window On Load //////////////////
    $(window).on("load", function () {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
        ;
    });
 
///////////////// Flip Menu ///////////

    $(".flip-menu-toggle").on("click", function () {
        $('.flip-menu').toggleClass('active');
    });
    $(".flip-menu-close").on("click", function () {
        $('.flip-menu').toggleClass('active');
    });
//////////////////////// Chat ////////////////////
    $('.chat-contact').on('click', function () {
        $('.chat-contact-list').toggleClass('active');
    });
    $('.chat-profile').on('click', function () {
        $('.chat-user-profile').toggleClass('active');
    });
    $('.scrollerchat').slimScroll({
        height: '460px',
        color: '#fff'
    });

/////////////////////// Loader /////////////////////
    var angle = 0;
    setInterval(function () {

        $(".se-pre-con img")
                .css('-webkit-transform', 'rotate(' + angle + 'deg)')
                .css('-moz-transform', 'rotate(' + angle + 'deg)')
                .css('-ms-transform', 'rotate(' + angle + 'deg)');
        angle++;
        angle++;
        angle++;
    }, 10);



    $('.popupchat').slimScroll({
        height: '220px',
        color: '#fff'
    });


    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    $('.checkall').on('click', function () {
        $('.mail-app input:checkbox').not(this).prop('checked', this.checked);
    });
    /**************** Menu **********************/
    $('.sidebar-menu .dropdown>a').on('click', function () {
        if ($(this).parent().hasClass('active'))
        {
            $(this).parent().find('>.sub-menu').slideUp('slow');
            $(this).parent().removeClass('active');
        } else
        {

            $(this).parent().find('>.sub-menu').slideDown('slow');
            $(this).parent().addClass('active');
        }

        return false;
    });


    /**************** Chat Pop Up **********************/
    $('.chatbutton').on('click', function () {
        $('.chatwindow').toggle();
        return false;

    });
    /*==============================================================
     Sidebar 
     ============================================================= */

    $('.sidebarCollapse').on('click', function () {
        $('body').toggleClass('compact-menu');
        $('.sidebar').toggleClass('active');
    });

    $('.mobilesearch').on('click', function () {
        $('.search-form').toggleClass('d-none');

    });

    /////////////////////////// Datepicker ////////////////////////
    if (typeof $.fn.datepicker !== "undefined") {
        $('.datepicker').datepicker();
    }

/////////////////////////// Wizard Form ////////////////////////

    $('.nexttab').click(function () {
        var nextId = $(this).parents('.tab-pane').next().attr("id");
        $('[href="#' + nextId + '"]').tab('show');
    });

    $('.prevtab').click(function () {
        var nextId = $(this).parents('.tab-pane').prev().attr("id");
        $('[href="#' + nextId + '"]').tab('show');
    });
    /********************************** Image Background *************************/
    $('.background-image-maker').each(function () {
        var imgURL = $(this).next('.holder-image').find('img').attr('src');
        $(this).css('background-image', 'url(' + imgURL + ')');
    });

    /********************************** Top Scroll *************************/
    $('.scrollup').on('click', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    /****************************** Window Scroll ****************************/
    $(window).on("scroll", function () {
        /*==============================================================
         Back To Top
         =============================================================*/
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    /*==============================================================
     Form Validation 
     ============================================================= */
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();            
            }else{                
                event.preventDefault();
                event.stopPropagation(); 
            } 
            form.classList.add('was-validated');
        }, false);                
    }); 

    /*==============================================================
     Sidebar Settings 
     ============================================================= */ 
    
    $('.openside').on('click', function () {
        $('#settings').toggleClass('active');
        return false;
    });


    var uri = window.location.href.toString();
    if (uri.indexOf("?") > 0) {
        delete_cookie('menulayout');
        delete_cookie('themecolor');
        delete_cookie('sidebarstyle');
        delete_cookie('horizontal');
        delete_cookie('menuicon');
    }


////////////////////////////// TEMPLATE Color /////////////////////////
      
    $('input.sidebar').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('compact-menu');
            $('.smail-icon').hide();

            createCookie('sidebarstyle', 'compact-menu');
        } else
        {
            $('body').removeClass('compact-menu');
            delete_cookie('sidebarstyle');
        }
    });

    var sidebarstyle = getUrlParameter('sidebarstyle');
    if (sidebarstyle != null && sidebarstyle != '')
    {
        createCookie('sidebarstyle', sidebarstyle);
    }

    var sidebarstyle = getCookie("sidebarstyle");
    if (sidebarstyle != null && sidebarstyle != '') {
        $('body').addClass(sidebarstyle);
        $('.smail-icon').hide();
        $(".sidebar").prop('checked', true);
    }

///////////////////////////// horizontal Layout /////////////////////////////

    $('.horizontallayout').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('horizontal-menu');
            createCookie('horizontal', 'horizontal-menu');
            $('.compact').hide();
        } else
        {
            $('body').removeClass('horizontal-menu');
            delete_cookie('horizontal');
            $('.compact').show();
        }
    });

    var horizontalstyle = getUrlParameter('horizontal');
    if (horizontalstyle != null && horizontalstyle != '')
    {
        createCookie('horizontal', horizontalstyle);
    }

    var horizontalstyle = getCookie("horizontal");
    if (horizontalstyle != null && horizontalstyle != '') {
        $('body').addClass(horizontalstyle);
        $(".horizontallayout").prop('checked', true);
        $('.compact').hide();
    }


})(jQuery);

function createCookie(name, value) {
    var now = new Date();
    now.setTime(now.getTime() + 1 * 3600 * 1000);
    document.cookie = name + "=" + value + ";expires=" + now.toUTCString() + "; path=/pick";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
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
function delete_cookie(name) {
    document.cookie = name + '=; Path=/pick; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}
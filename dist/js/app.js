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

    /*$('.checkall').on('click', function () {
        
    });*/
    
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

 
    /*==============================================================
     Sidebar 
     ============================================================= */

   

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
    /*var forms = document.getElementsByClassName('needs-validation');
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
    }); */

    /*==============================================================
     Sidebar Settings 
     ============================================================= */ 
    
    $('.openside').on('click', function () {
        $('#settings').toggleClass('active');
        return false;
    });


   
    
    
    
    

////////////////////////////// TEMPLATE Color /////////////////////////
      
   
///////////////////////////// horizontal Layout /////////////////////////////

   

    

})(jQuery);
 
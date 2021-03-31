(function ($) {
    "use strict";

    var primarycolor = getComputedStyle(document.body).getPropertyValue('--primarycolor');

    $('.scrollertodo').slimScroll({
        height: '475px', 
        color: '#8f8f8f' 
    });

////////////////////////////// Main Controls  ////////////////////////
// Map control - menu tabs 
$('.mail-menu li a').on('click', function () {
    $('.mail-menu li a').removeClass('active');
    $(this).addClass('active');
    $('.mainmap_list').css("display","none");
    $('#' + $(this).data("list")).css("display","block");
    
        
    //$('#form_sitelist input:checkbox').prop('checked', false);
    //$('#form_geolist input:checkbox').prop('checked', false);
    
    if($("#mostrar_veh")){
        $("#mostrar_veh").html("");
    } 

    $('#settings').removeClass('active');
   // reset();
    return false; 
});

// Filter Speed  
$(".back-to-vlist").on("click", function () {
    $('.view-vehicle').fadeOut();
});

// Filter Motor
$('.bulk-mail-type a').on('click', function () {
    var speedclass = $(this).data("speed");    
    $('#vehicles_list .mail-item').hide();    
    $('#vehicles_list .'+speedclass).show(500); 
});


// Filter site
$("#site_tipe").on("change", function () {
    console.log($(this).val());  
    if($(this).val() != 0){
        $('#sites_list .mail-item').hide();    
        $('#sites_list .sitetype-'+$(this).val()).show(500);
    } else{        
        $('#sites_list .mail-item').show(500);
    }    
});


// Filter geo-type
$('.fgeo-type a').on('click', function () {
    var geoclass = $(this).data("type");     
    $('#geo_list .mail-item').hide();    
    $('#geo_list .'+geoclass).show(500); 
});

// Filter geo-user
$('.fcompany_type a').on('click', function () {
    var geoclass = $(this).data("filter");     
    $('#geo_list .mail-item').hide();    
    $('#geo_list .'+geoclass).show(500); 
});

/*$('#vehicles_list mail-content a .mark-list').on('click', function () {
    console.log( "checo" );   
    //.mail-app li 
    
    
});*/

// Filter engine
$('.status-engine a').on('click', function () {
    var engineclass = $(this).data("engine");     

    $('#vehicles_list .mail-item').hide();    
    $('#vehicles_list .'+engineclass).show(500);

});

$(".vehicle-search").on("keyup", function () {
    var v = $(".vehicle-search").val().toLowerCase();
    var rows = $('#vehicles_list li');
    for (var i = 0; i < rows.length; i++) {
        var fullname = rows[i].getElementsByClassName("mail-content");
        fullname = fullname[0].innerHTML.toLowerCase();
        if (fullname) {
            if (v.length == 0 || (v.length < 1 && fullname.indexOf(v) == 0) || (v.length >= 1 && fullname.indexOf(v) > -1)) {
                rows[i].style.animation = 'fadein 7s';
                rows[i].style.display = "block";
            } else {
                rows[i].style.display = "none";
                rows[i].style.animation = 'fadeout 7s';
            }
        }
    }
});

$(".site-search").on("keyup", function () {
    var v = $(".site-search").val().toLowerCase();
    var rows = $('#sites_list li');
    for (var i = 0; i < rows.length; i++) { 
        var fullname = rows[i].getElementsByClassName("mail-content");
        fullname = fullname[0].innerHTML.toLowerCase();
        if (fullname) {
            if (v.length == 0 || (v.length < 1 && fullname.indexOf(v) == 0) || (v.length >= 1 && fullname.indexOf(v) > -1)) {
                rows[i].style.animation = 'fadein 7s';
                rows[i].style.display = "block";
            } else {
                rows[i].style.display = "none";
                rows[i].style.animation = 'fadeout 7s';
            }
        }
    }
});

$(".geo-search").on("keyup", function () {
    var v = $(".geo-search").val().toLowerCase();
    var rows = $('#geoc_list li');
    for (var i = 0; i < rows.length; i++) { 
        var fullname = rows[i].getElementsByClassName("mail-content");
        fullname = fullname[0].innerHTML.toLowerCase();
        if (fullname) {
            if (v.length == 0 || (v.length < 1 && fullname.indexOf(v) == 0) || (v.length >= 1 && fullname.indexOf(v) > -1)) {
                rows[i].style.animation = 'fadein 7s';
                rows[i].style.display = "block";
            } else {
                rows[i].style.display = "none";
                rows[i].style.animation = 'fadeout 7s';
            }
        }
    }
});

/*
$('.bulk-mail-type a').on('click', function () {
    var speedclass = $(this).data("speed");

    $('.' + $('.mail-menu li a.active').data("mailtype")).each(function () {
        if ($(this).find('input').is(':checked')) {
            $(this).removeClass('business-mail');
            $(this).removeClass('private-mail');
            $(this).removeClass('social-mail');
            $(this).removeClass('personal-mail');
            $(this).removeClass('work-mail');
            $(this).addClass(mailclass);
            $(".dropdown.show").toggle();
            $(this).find('input').prop('checked', false);
        }
    });
});
*/

    if ($("#snow-container").length > 0)
    {
        var quill = new Quill('#snow-container', {
            placeholder: 'Compose an epic...',
            theme: 'snow'
        });
    }

    $('.mail-label li a').on('click', function () {
        $('.mail-app .mail-item').hide();
        $('.' + $('.mail-menu li a.active').data("mailtype") + '.' + $(this).data("label")).show(500);
        return false;
    }); 
 


    $('.bulk-star').on('click', function () {
        $('.' + $('.mail-menu li a.active').data("mailtype")).each(function () {
            if ($(this).find('input').is(':checked')) {
                $(this).addClass('starred');
                $(this).find('input').prop('checked', false);
            }
        });
    });

 



    $('.mail-bulk-action .mailread').on('click', function () {
        $('.' + $('.mail-menu li a.active').data("mailtype")).each(function () {
            if ($(this).find('input').is(':checked')) {
                $(this).removeClass('unread');
                $(this).find('input').prop('checked', false);
            }
        });
    });



    $('.mail-bulk-action .mailunread').on('click', function () {
        $('.' + $('.mail-menu li a.active').data("mailtype")).each(function () {
            if ($(this).find('input').is(':checked')) {
                $(this).addClass('unread');
                $(this).find('input').prop('checked', false);
            }
        });
    });




    $('.mail-bulk-action .delete').on('click', function () {
        $('.' + $('.mail-menu li a.active').data("mailtype")).each(function () {
            if ($(this).find('input').is(':checked')) {
                $(this).addClass('bg-danger');
                $(this).slideUp(550, function () {
                    $(this).remove();
                });
            }
        });
    });



    $(".single-read").on("click", function () {
        $(this).closest('.mail-item').removeClass('unread');
    });
    $(".single-unread").on("click", function () {
        $(this).closest('.mail-item').addClass('unread');
    });
    $(".single-delete").on("click", function () {
        $(this).closest('.mail-item').addClass('bg-danger');
        $(this).closest('.mail-item').slideUp(550, function () {
            $(this).closest('.mail-item').remove();
        });
    });




})(jQuery);

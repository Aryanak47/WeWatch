
function volumeToggle(button) {
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fa-volume-mute");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded() {
    console.log("Preview ended")
    $(".previewVideo").toggle();
    $(".previewImage").prop("hidden",false);
}

$(document).ready(function(){
   
    // sticky header anmation and height 
    // function headerHeight(){
    //     var height = $("#main-header").height();
    //     $('.iq-height').css('height',height + 'px');
    // }

    // $(function(){
    //     var header = $("#main-header"),
    //     yOffset = 0,
    //     triggerPoint = 80;
    //     headerHeight();
    //     $(window).resize(headerHeight);
    //     $(window).in('scroll', function() {
    //         yOffset = $(window).scrollTop();

    //         if(yOffset >= triggerPoint){
    //             header.addClass("menu-sticky animated slideDown");
    //         } else {
    //             header.removeClass("menu-sticky animated slideDown");
    //         }
    //     });
    // });

    // header menu dropdown 
    // $('[data-toggle=more-toggle]').on('click', function () {
    //     $(this).next().toggleClass('show');
    // });

    // $(document).on('click', function(e){
    //     let myTargetElement = e.target;
    //     let selector, mainElement;
    //     if($(myTargetElement).hasClass('search-toggle') || $(myTargetElement).parent().hasClass('search-toggle') || $(myTargetElement).parent().parent().hasClass('search-toggle') ){
    //         if($(myTargetElement).hasClass('search-toggle')) {
    //             selector = $(myTargetElement).parent();
    //             mainElement = $(myTargetElement);
    //         } else if ($(myTargetElement).parent().hasClass('search-toggle')){
    //             selector = $(myTargetElement).parent().parent();
    //             mainElement = $(myTargetElement).parent();
    //         }else if ($(myTargetElement).parent().parent().hasClass('search-toggle')){
    //             selector = $(myTargetElement).parent().parent().parent();
    //             mainElement = $(myTargetElement).parent().parent();
    //         }
    //         if(!mainElement.hasClass('active') && $('.navbar-list li').find('.active')){
    //             $('.navbar-right li').removeClass('.iq-show');
    //             $('.navbar-right li .search-toggle').removeClass('active');
    //         }

    //         selector.toggleClass('iq-show');
    //         mainElement.toggleClass('active');
    //         e.preventDefault();
    //     } else if ($(myTargetElement).is('search-input')){} else {
    //         $('.navbar-right li').removeClass('.iq-show');
    //         $('.navbar-right li .search-toggle').removeClass('active');
    //     }
    // });
    // $(document).on('click', function(event){
    //     var $trigger = $(".main-header .navbar");
    //     if($trigger !== event.target && !$trigger.has(event.target).length){
    //         $(".main-header .navbar-collapse").collapse('hide');
    //         $('body').removeClass('nav-open');
    //     }
    // });
    // $('.c-toggler').on("click", function(){
    //     $('body').addClass('nav-open');
    // });


    $('#home-slider').slick({
        autoplay : false,
        speed : 800,
        lazyload : 'progressive',
        arrows : true,
        dots : false,
        prevArrow : '<div class="slick-nav prev-arrow"><i class="fa fa-chevron-right"></i></div>',
        nextArrow : '<div class="slick-nav next-arrow"><i class="fa fa-chevron-left"></i></div>',
        responsive : [
            {
                breakpoint : 992,
                settings : {
                    dots : true,
                    arrows : false,
                }
            }
        ]
    }).slickAnimation();
    $(".slick-nav").on("click touch", function (e){
        e.preventDefault();

        var arrow = $(this);

        if(!arrow.hasClass('animate')){
            arrow.addClass('animate');
            setTimeout(() => {
                arrow.removeClass('animate');
            }, 1600);
        }
    });

    $('.favorites-slider').slick({
        dots:false,
        arrow : true,
        infinite : true,
        speed : 300,
        autoplay : false,
        slidesToShow : 4,
        slidesToScroll :1,
        nextArrow: '<a href="#" class="slick-arrow slick-next"><i class="fa fa-chevron-right"></i></a>',
        prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class="fa fa-chevron-left"></i></a>',
        responsive : [
            {
                breakpoint:1200,
                settings : {
                    slidesToShow : 3,
                    slidesToScroll : 1,
                    infinite : true,
                    dots : true
                }
            },
            {
                breakpoint:768,
                settings : {
                    slidesToShow : 2,
                    slidesToScroll : 1
                }
            },
            {
                breakpoint:480,
                settings : {
                    slidesToShow : 1,
                    slidesToScroll : 1
                }
            },
        ]
    });

    $('#top-ten-slider').slick({
        slidesToScroll : 1,
        slidesToShow : 1,
        arrows : false,
        fade : true,
        asNavFor : '#top-ten-slider-nav',
        responsive : [
            {
                breakpoint : 992,
                settings : {
                    asNavFor : false,
                    arrows : true ,
                    nextArrow : '<button class="NextArrow"><i class="fa fa-angle-right"></i></button>',
                    prevArrow : '<button class="PrevArrow"><i class="fa fa-angle-left"></i></button>',
                }
            }
        ]
    });
    $('#top-ten-slider-nav').slick({
        slidesToShow : 3,
        slidesToScroll : 1,
        asNavFor : '#top-ten-slider',
        dots: false,
        arrows : true,
        infinite : true,
        vertical : true,
        verticalSwiping : true,
        centerMode :false,
        nextArrow : '<button class="NextArrow"><i class="fa fa-angle-down"></i></button>',
        prevArrow : '<button class="PrevArrow"><i class="fa fa-angle-up"></i></button>',
        focusOnSelect : true,
        responsive : [
            {
                breakpoint : 1200,
                settings : {
                    slidesToShow : 2,
                }
            },
            {
                breakpoint : 600,
                settings : {
                    asNavFor : false,
                }
            },
        ]
    });
    

    $("#trending-slider").slick({
        slidesToShow : 1,
        slidesToScroll : 1,
        arrows : false,
        fade : true,
        draggable : false,
        asNavFor : "#trending-slider-nav",
    });

    $("#trending-slider-nav").slick({
        slidesToShow : 5,
        slidesToScroll : 1,
        asNavFor : "#trending-slider",
        dots : false ,
        arrows : true ,
        nextArrow: '<a href="#" class="slick-arrow slick-next"><i class="fa fa-chevron-right"></i></a>',
        prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class="fa fa-chevron-left"></i></a>',
        infinite : true,
        centerMode : true,
        centerPadding : 0,
        focusOnSelect : true,
        responsive : [
            {
                breakpoint : 1024,
                settings : {
                    slidesToShow : 2,
                    slidesToScroll : 1,
                }
            },
            {
                breakpoint : 600,
                settings : {
                    slidesToShow : 1,
                    slidesToScroll : 1,
                }
            }
        ]
    });

    $('.episodes-slider1').owlCarousel({
        loop : true,
        margin : 20,
        nav: true,
        navText : ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i> "],
        dots : false,
        responsive : {
            0:{
                items : 1
            },
            600: {
                items : 1
            },
            1000 : {
                items : 4
            }
        }
    });


    $('.trending-content').each(function(){
        var highestBox = 0;
        $('.tab-pane', this).each(function(){
            if($(this).height() > highestBox){
                highestBox = $(this).height();
            }
        });
        $('.tab-pane', this).height(highestBox);
    });

    if($('select').hasClass('season-select')){
        $('select').select2({
            theme : 'bootstrap4',
            allowClear : false,
            width : 'resolve'
        });
    }
});



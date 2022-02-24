
$(document).scroll(function() {
    var isScrolled = $(this).scrollTop() > $(".topBar").height();
    $(".topBar").toggleClass("scrolled", isScrolled);
})

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


function goBack() {
    window.history.back();
}

function startHideTimer() {
    var timeout = null;
    
    $(document).on("mousemove", function() {
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(function() {
            $(".watchNav").fadeOut();
        }, 2000);
    })
}

function initVideo(videoId, username) {
    startHideTimer();
    setStartTime(videoId, username);
    updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId, username) {
    addDuration(videoId, username);

    var timer;

    $("video").on("playing", function(event) {
        window.clearInterval(timer);
        timer = window.setInterval(function() {
            updateProgress(videoId, username, event.target.currentTime);
        }, 3000);
    })
    .on("ended", function() {
        setFinished(videoId, username);
        window.clearInterval(timer);
    })
}

function addDuration(videoId, username) {
    $.post("ajax/addDuration.php", { videoId: videoId, username: username }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

function updateProgress(videoId, username, progress) {
    $.post("ajax/updateDuration.php", { videoId: videoId, username: username, progress: progress }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

function setFinished(videoId, username) {
    $.post("ajax/setFinished.php", { videoId: videoId, username: username }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

function setStartTime(videoId, username) {
    $.post("ajax/getProgress.php", { videoId: videoId, username: username }, function(data) {
        if(isNaN(data)) {
            alert(data);
            return;
        }

        $("video").on("canplay", function() {
            this.currentTime = data;
            $("video").off("canplay");
        })
    })
}
console.log("working")
function restartVideo() {
    $("video")[0].currentTime = 0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}
function watchVideo(videoID) {
    window.location.href = `watch.php?id=${videoID}`;
}

function showUpNext() {
    $(".upNext").fadeIn();
}


$(document).ready(function(){

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

});



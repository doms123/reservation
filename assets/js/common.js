$(document).ready(function () {

    if ($('.sticky-header').length >= 1) {
        $(window).scroll(function () {
            var header = $(document).scrollTop();
            var headerHeight = $('header').height();
            if (header > headerHeight) {
                $('.sticky-header').addClass('sticky');
            } else {
                $('.sticky-header').removeClass('sticky');
            }
        });
    }

    // $('.slider').slick({
    //     dots: false,
    //     infinite: true,
    //     speed: 300,
    //     slidesToShow: 1,
    //     adaptiveHeight: true
    // });

    $('.services-tabs li a').click(function (e) {
        e.preventDefault();
        var target_tab = $(this).attr('href');
        $('.services-tabs li a').removeClass('active');
        $(this).addClass('active');
        $('.tabs-content').hide();
        $(target_tab).fadeIn();
    });
    // $('.slider').slick({
    //     dots: false,
    //     infinite: true,
    //     speed: 300,
    //     slidesToShow: 1,
    //     adaptiveHeight: true
    // });
    // $('.home-slider').slick({
    //     dots: false,
    //     autoplay: true,
    //     infinite: true,
    //     speed: 500,
    //     slidesToShow: 1,
    //     adaptiveHeight: true
    // });
    
    //light gallery
     // Animated thumbnails
    var $animThumb01 = $('.aniimated-thumbnials01');
    if ($animThumb01.length) {
        $animThumb01.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb01.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb02 = $('.aniimated-thumbnials02');
    if ($animThumb02.length) {
        $animThumb02.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb02.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb03 = $('.aniimated-thumbnials03');
    if ($animThumb03.length) {
        $animThumb03.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb03.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb04 = $('.aniimated-thumbnials04');
    if ($animThumb04.length) {
        $animThumb04.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb04.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb05 = $('.aniimated-thumbnials05');
    if ($animThumb05.length) {
        $animThumb05.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb05.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb06 = $('.aniimated-thumbnials06');
    if ($animThumb06.length) {
        $animThumb06.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb06.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb07 = $('.aniimated-thumbnials07');
    if ($animThumb07.length) {
        $animThumb07.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb07.lightGallery({
                thumbnail: true
            });
        });
    };
    var $animThumb08 = $('.aniimated-thumbnials08');
    if ($animThumb08.length) {
        $animThumb08.justifiedGallery({
            border: 7
        }).on('jg.complete', function() {
            $animThumb08.lightGallery({
                thumbnail: true
            });
        });
    };
});
(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('bg-global-second shadow-sm').css('top', '0px');
            $('.logoText').css('color', '#19E6D4');
            
        } else {
            $('.sticky-top').removeClass('bg-global-second shadow-sm').css('top', '-150px');
            $('.logoText').css('color', '#14183E');
        }
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        smartSpeed: 1000,
        dots: true,
        loop: true,
        nav: true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });

    var owl = $('.my-slider');
    owl.owlCarousel({
        center:true,
        items:3,
        loop:true,
        margin:15,
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        dots:false,
        nav:false,
        responsive:{
            0:{ items:1 },
            1000:{ items:3 }
        }
    });

    $('.nav-next').click(function(){
        owl.trigger('next.owl.carousel');
    });

    $('.nav-prev').click(function(){
        owl.trigger('prev.owl.carousel');
    });

    
})(jQuery);


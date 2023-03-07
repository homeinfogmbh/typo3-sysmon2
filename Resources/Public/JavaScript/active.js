$(document).ready(function(){

    $('.realestate_slider').owlCarousel({
        loop:true,
        margin:10,
        dots:false,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1200:{
                items:3
            }
        }
    });

    $(".parent_menu").click(function(){
        $(this).siblings(".inner_menu").slideToggle();
        $(this).toggleClass("active");
      });

    var owl = $('.owl-carousel');
    owl.owlCarousel();
    $('button.next-button').click(function() {
        owl.trigger('next.owl.carousel');
    })
    $('button.prev-button').click(function() {
        owl.trigger('prev.owl.carousel', [300]);
    })

    $(".nav_triger, .menu_overlay").click(function(){
        $("body").toggleClass("menu_active");
    });

});
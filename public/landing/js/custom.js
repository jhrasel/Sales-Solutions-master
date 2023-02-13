$(function() {

  // Preloader
  
  $(window).on('load',function(){
    $('.preloader').delay(300).fadeOut(300);
  }); 
  
    
  // backToTop
  var btn = $('#backToTop');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });

  // OurServiceSlider
  var swiper = new Swiper(".OurServiceSlider", {
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 30,
      },
      1200:{
        slidesPerView: 8,
        spaceBetween: 30,
      }
    },
  });
    

  // CustomerReviewSlider
  var swiper = new Swiper(".CustomerReviewSlider", {
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      1200:{
        slidesPerView: 3,
        spaceBetween: 30,
      }
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });






});

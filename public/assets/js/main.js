;(function($){

$(document).ready(function(){

//========== HEADER ACTIVE STRATS ============= //
if ($("#header").length > 0) {
$(window).on("scroll", function (event) {
  var scroll = $(window).scrollTop();
  if (scroll < 1) {
  $(".header-area").removeClass("sticky");
  } else {
  $(".header-area").addClass("sticky");
  }
  });
}
//========== HEADER ACTIVE ENDS ============= //

//========== SIDEBAR/SEARCH AREA ============= //
$(".header-search-btn").on("click", function (e) {
  e.preventDefault();
  $(".header-search-form-wrapper").addClass("open");
  $('.header-search-form-wrapper input[type="search"]').focus();
  $('.body-overlay').addClass('active');
});
$(".tx-search-close").on("click", function (e) {
  e.preventDefault();
  $(".header-search-form-wrapper").removeClass("open");
  $("body").removeClass("active");
  $('.body-overlay').removeClass('active');
});
//========== SIDEBAR/SEARCH AREA ============= //

//========== PAGE PROGRESS STARTS ============= // 
  var progressPath = document.querySelector(".progress-wrap path");
  var pathLength = progressPath.getTotalLength();
  progressPath.style.transition = progressPath.style.WebkitTransition =
  "none";
  progressPath.style.strokeDasharray = pathLength + " " + pathLength;
  progressPath.style.strokeDashoffset = pathLength;
  progressPath.getBoundingClientRect();
  progressPath.style.transition = progressPath.style.WebkitTransition =
    "stroke-dashoffset 10ms linear";
  var updateProgress = function () {
    var scroll = $(window).scrollTop();
    var height = $(document).height() - $(window).height();
    var progress = pathLength - (scroll * pathLength) / height;
    progressPath.style.strokeDashoffset = progress;
  };
  updateProgress();
  $(window).scroll(updateProgress);
  var offset = 50;
  var duration = 550;
  jQuery(window).on("scroll", function () {
    if (jQuery(this).scrollTop() > offset) {
      jQuery(".progress-wrap").addClass("active-progress");
    } else {
      jQuery(".progress-wrap").removeClass("active-progress");
    }
  });
  jQuery(".progress-wrap").on("click", function (event) {
    event.preventDefault();
    jQuery("html, body").animate({ scrollTop: 0 }, duration);
    return false;
  });
//========== PAGE PROGRESS STARTS ============= // 

//========== VIDEO POPUP STARTS ============= //
   if ($(".popup-youtube").length > 0) {
    $(".popup-youtube").magnificPopup({
    type: "iframe",
    });
    }
//========== VIDEO POPUP ENDS ============= //
AOS.init;
AOS.init({disable: 'mobile'});

//========== NICE SELECT ============= //
$('select').niceSelect();

});
//========== COUNTER UP============= //
// const ucounter = $('.counter');
// if (ucounter.length > 0) {
//  ucounter.countUp();  
// };

if ($('.odometer').length > 0) {
  $('.odometer').appear(function (e) {
      var odo = $('.odometer');
      odo.each(function () {
          var countNumber = $(this).attr('data-count');
          $(this).html(countNumber);
      });
  });
}
//========== TESTIMONIAL AREA ============= //

// testimonial //
$('.team-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:3,
      }
  }
});

// testimonial //
$('.team-slider-area7').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:4,
      }
  }
});

// testimonial //
$('.team-slider-area8').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:4,
      }
  }
});

$('.team-slider-area4').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:3,
      }
  }
});

// testimonial //
$('.testimonial-content-slider').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:1,
      },
      1000:{
          items:1,
      }
  }
});

// testimonial //
$('.testimonial-content-slider7').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:3,
      }
  }
});

// testimonial //
$('.memory-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  center:true,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:3,
      }
  }
});

// testimonial //
$('.brand-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:false,
  dots:false,
  items:10,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:4,
      }
  }
});

// testimonial //
$('.brand-slider-area9').owlCarousel({
  loop:true,
  margin:30,
  nav:false,
  dots:false,
  items:10,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:4,
      }
  }
});


$('.memory-widget-slider').owlCarousel({
  loop:true,
  margin:30,
  nav:false,
  dots:false,
  items:10,
  center:true,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:2,
      }
  }
});

$('.memory-widget-slider5').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  center:true,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:2,
      }
  }
});

$('.team-slider-area2').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  items:10,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:4,
      }
  }
});

$('.testimonial-review-slider').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  items:10,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:1,
      },
      1000:{
          items:1,
      }
  }
});

$('.memory-team-slider').owlCarousel({
  loop:true,
  margin:30,
  nav:false,
  dots:false,
  items:10,
  center:true,
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:3,
      }
  }
});

$('.memory-team-slider2').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  center:true,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:2000,
  autoplayTimeout:3000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
          center:false,
      },
      600:{
          items:2,
          center:false,
      },
      1000:{
          items:3,
      }
  }
});

// testimonial //
$(".hero2-slider-area").slick({
  autoplay:true,
  autoplaySpeed:2500,
  speed:1500,
  slidesToShow:1,
  slidesToScroll:1,
  pauseOnHover:false,
  dots:false,
  arrows:true,
  pauseOnDotsHover:true,
  cssEase:'linear',
  fade:true,
  draggable:true,
  prevArrow: $(".testimonial-prev-arrow"),
  nextArrow: $(".testimonial-next-arrow"), 
});  

$('.testimonial-reviews-area').slick({
  loop:true,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 0,
  speed:5000,
  cssEase: 'linear',
  infinite: true,
  arrows:false,
  touchMove:true,
  swipeToSlide:true,
  swipe:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
      slidesToShow: 2,
      slidesToScroll: 1,
       infinite: true,
    }
    },

    {
      breakpoint: 600,
      ettings: {
      slidesToShow: 2,
      slidesToScroll: 1,
      }
    },

    {
      breakpoint: 480,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },

    {
      breakpoint: 375,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },

    {
      breakpoint: 320,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },
    ]
});

$('.testimonial-reviews-area2').slick({
  loop:true,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 0,
  speed:7000,
  cssEase: 'linear',
  infinite: true,
  arrows:false,
  touchMove:true,
  swipeToSlide:true,
  swipe:true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
      slidesToShow: 2,
      slidesToScroll: 1,
       infinite: true,
    }
    },

    {
      breakpoint: 600,
      ettings: {
      slidesToShow: 2,
      slidesToScroll: 1,
      }
    },

    {
      breakpoint: 480,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },

    {
      breakpoint: 375,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },

    {
      breakpoint: 320,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
    },
    ]
});

//========== PRELOADER ============= //
$(window).on("load", function (event) {
  setTimeout(function () {
    $(".preloader").fadeToggle();
  }, 200);

});


})(jQuery);

//========== TIMER ============= //
 // TIMER //
 
function startCountdown(targetDate, daysId, hoursId, minutesId, secondsId) {
  var countdownFunction = setInterval(function () {
      var now = new Date().getTime();
      var distance = targetDate - now;

      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById(daysId).innerHTML = days + " <span>DAYS</span>";
      document.getElementById(hoursId).innerHTML = hours + " <span>Hours</span>";
      document.getElementById(minutesId).innerHTML = minutes + " <span>Minutes</span>";
      document.getElementById(secondsId).innerHTML = seconds + " <span>Seconds</span>";

      if (distance < 0) {
          clearInterval(countdownFunction);
          document.getElementById(daysId).innerHTML = "00";
          document.getElementById(hoursId).innerHTML = "00";
          document.getElementById(minutesId).innerHTML = "00";
          document.getElementById(secondsId).innerHTML = "00";
          alert("Countdown Ended");
      }
  }, 1000);
}

var targetDate = new Date();
targetDate.setDate(targetDate.getDate() + 119);
targetDate.setHours(targetDate.getHours() + 22);
targetDate.setMinutes(targetDate.getMinutes() + 18);
targetDate.setSeconds(targetDate.getSeconds() + 44);

startCountdown(targetDate, "days", "hours", "minutes", "seconds");
startCountdown(targetDate, "days1", "hours1", "minutes1", "seconds1");


//========== GSAP AREA ============= //

if ($('.text-anime-style-1').length) {
  let staggerAmount 	= 0.05,
  translateXValue = 0,
  delayValue 		= 0.5,
   animatedTextElements = document.querySelectorAll('.text-anime-style-1');

  animatedTextElements.forEach((element) => {
  let animationSplitText = new SplitText(element, { type: "chars, words" });
    gsap.from(animationSplitText.words, {
    duration: 1,
    delay: delayValue,
    x: 20,
    autoAlpha: 0,
    stagger: staggerAmount,
    scrollTrigger: { trigger: element, start: "top 85%" },
    });
  });
  }

  if ($('.text-anime-style-2').length) {
  let	 staggerAmount 		= 0.05,
   translateXValue	= 20,
   delayValue 		= 0.5,
   easeType 			= "power2.out",
   animatedTextElements = document.querySelectorAll('.text-anime-style-2');

  animatedTextElements.forEach((element) => {
  let animationSplitText = new SplitText(element, { type: "chars, words" });
    gsap.from(animationSplitText.chars, {
      duration: 1,
      delay: delayValue,
      x: translateXValue,
      autoAlpha: 0,
      stagger: staggerAmount,
      ease: easeType,
      scrollTrigger: { trigger: element, start: "top 85%"},
    });
  });
  }

  if ($('.text-anime-style-3').length) {
  let	animatedTextElements = document.querySelectorAll('.text-anime-style-3');

  animatedTextElements.forEach((element) => {
  //Reset if needed
  if (element.animation) {
    element.animation.progress(1).kill();
    element.split.revert();
  }

  element.split = new SplitText(element, {
    type: "lines,words,chars",
    linesClass: "split-line",
  });
  gsap.set(element, { perspective: 400 });

  gsap.set(element.split.chars, {
    opacity: 0,
    x: "50",
  });

  element.animation = gsap.to(element.split.chars, {
    scrollTrigger: { trigger: element,	start: "top 90%" },
    x: "0",
    y: "0",
    rotateX: "0",
    opacity: 1,
    duration: 1,
    ease: Back.easeOut,
    stagger: 0.02,
  });
  });
  }
//========== Images AREA ============= //
if($('.reveal').length)
{gsap.registerPlugin(ScrollTrigger);
let revealContainers=document.querySelectorAll(".reveal");
revealContainers.forEach((container)=>{let image=container.querySelector("img");
let tl=gsap.timeline({scrollTrigger:{trigger:container,toggleActions:"play none none none"}});
tl.set(container,{autoAlpha:1});tl.from(container,1.5,{xPercent:-100,ease:Power2.out});
tl.from(image,1.5,{xPercent:100,scale:1.3,delay:-1.5,ease:Power2.out});})
;}
    

//========== PRELOADER BAR AREA ============= //
document.addEventListener("DOMContentLoaded", function() {
  setTimeout(function() {
      const popup = document.getElementById('popup');
      popup.style.display = 'flex'; 
  }, 100); 
  const closeBtn = document.getElementById('close-popup');
  closeBtn.addEventListener('click', function() {
      const popup = document.getElementById('popup');
      popup.style.display = 'none'; 
  });

  document.querySelector('.no-thanks').addEventListener('click', function() {
      const popup = document.getElementById('popup');
      popup.style.display = 'none';
  });
});


// Tabs //
  const tabNavigation = document.getElementById('tab-navigation');
  if (tabNavigation) {
    const tabLinks = tabNavigation.querySelectorAll('.nav-link');

    tabLinks.forEach(tabLink => {
      tabLink.addEventListener('click', () => {
        tabLinks.forEach(link => link.classList.remove('active'));
        tabLink.classList.add('active');
      });
    });
  }

  function removeSection() {
    const countdownSection = document.getElementById("timer-btn-area");
    countdownSection.style.display = "none";
  }

  const marqueeContent = document.getElementById('marquee-content');
  if (marqueeContent) {
    marqueeContent.innerHTML += marqueeContent.innerHTML;
  }
  //Circle text 
  const circles = document.querySelectorAll(".circle");
  circles.forEach((circle) => {
    circle.innerHTML = circle.textContent.replace(/\S/g, "<span>$&</span>").replace(/ /g, "<span> </span>");
    const elements = circle.querySelectorAll("span");
    for (let i = 0; i < elements.length; i++) {
      elements[i].style.transform = "rotate(" + i * 17 + "deg)";
    }
  });


  

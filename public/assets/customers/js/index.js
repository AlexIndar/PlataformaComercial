
$('document').ready(function(){

    AOS.init();
    ScrollReveal().reveal('.appear-500', {delay:500});
    ScrollReveal().reveal('.appear-1000', {delay:1000});
    ScrollReveal().reveal('.appear-1500', {delay:1500});
    ScrollReveal().reveal('.appear-2000', {delay:2000});
    
    

      const swiper = new Swiper(".swiper-1", {
        slidesPerView: 5,
        spaceBetween: 15,
        slidesPerGroup: 5,
        loop: true,
        pagination: {
          el: ".swiper-pagination-1",
          clickable: true,
        },
        autoplay: false,
        navigation: {
          nextEl: ".swiper-button-next-1",
          prevEl: ".swiper-button-prev-1",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                slidesPerGroup: 1,
            },
            400: {
                slidesPerView: 1,
                slidesPerGroup: 1,
            },
            600: {
                slidesPerView: 2,
                slidesPerGroup: 2,
            },
            850: {
                slidesPerView: 3,
                slidesPerGroup: 3,
            },
            1350: {
                slidesPerView: 4,
                slidesPerGroup: 4,
            },
            1400:{
                slidesPerView: 5,
                slidesPerGroup: 5,
            }
        }
      });

      const swiper2 = new Swiper(".swiper-2", {
        slidesPerView: 5,
        spaceBetween: 15,
        slidesPerGroup: 5,
        loop: true,
        pagination: {
          el: ".swiper-pagination-2",
          clickable: true,
        },
        autoplay: false,
        navigation: {
          nextEl: ".swiper-button-next-2",
          prevEl: ".swiper-button-prev-2",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                slidesPerGroup: 1,
            },
            400: {
                slidesPerView: 1,
                slidesPerGroup: 1,
            },
            600: {
                slidesPerView: 2,
                slidesPerGroup: 2,
            },
            850: {
                slidesPerView: 3,
                slidesPerGroup: 3,
            },
            1350: {
                slidesPerView: 4,
                slidesPerGroup: 4,
            },
            1400:{
                slidesPerView: 5,
                slidesPerGroup: 5,
            }
        }
      });

      const swiper3 = new Swiper(".swiper-suppliers", {
        slidesPerView: 10,
        spaceBetween: 0,
        slidesPerGroup: 1,
        loop: true,
        autoplay: true,
        breakpoints: {
            0: {
                slidesPerView: 3,
                slidesPerGroup: 1,
            },
            400: {
                slidesPerView: 4,
                slidesPerGroup: 1,

            },
            600: {
                slidesPerView: 5,
                slidesPerGroup: 1,

            },
            850: {
                slidesPerView: 6,
                slidesPerGroup: 1,

            },
            1350: {
                slidesPerView: 8,
                slidesPerGroup: 1,

            },
            1400:{
                slidesPerView: 10,
                slidesPerGroup: 1,

            }
        }
      });

});

function conocerMas(){
 console.log("Conocer mas");
}



document.addEventListener("DOMContentLoaded", function(){
    // make it as accordion for smaller screens
    if (window.innerWidth < 992) {
    
      // close all inner dropdowns when parent is closed
      document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
        everydropdown.addEventListener('hidden.bs.dropdown', function () {
          // after dropdown is hidden, then find all submenus
            this.querySelectorAll('.submenu').forEach(function(everysubmenu){
              // hide every submenu as well
              everysubmenu.style.display = 'none';
            });
        })
      });
    
      document.querySelectorAll('.dropdown-menu a').forEach(function(element){
        element.addEventListener('click', function (e) {
            let nextEl = this.nextElementSibling;
            if(nextEl && nextEl.classList.contains('submenu')) {	
              // prevent opening link if link needs to open dropdown
              e.preventDefault();
              if(nextEl.style.display == 'block'){
                nextEl.style.display = 'none';
              } else {
                nextEl.style.display = 'block';
              }
    
            }
        });
      })
    }
    // end if innerWidth
    }); 
    // DOMContentLoaded  end


    function activeModal(modal){ //if modal = 1 active login / if modal = 2 active register
        if(modal == 1){
            var login = document.getElementById('loginModal');
            login.style.opacity = 1;
            login.style.zIndex = 1000;
            login.classList.add("active-modal");
        }
        if(modal == 2){
            var login = document.getElementById('registerModal');
            login.style.opacity = 1;
            login.style.zIndex = 1000;
            login.classList.add("active-modal");
        }

    }

    function allowMiddleware(){
        //ver qué se puede hacer para que funcione el middleware
    }

    function closeModal(){
        var activeModal = document.getElementsByClassName("active-modal")[0];
        activeModal.style.opacity = 0;
        activeModal.style.zIndex = -1000;
        activeModal.classList.remove("active-modal");
    }

    function navigate(blade){
        window.location.href = blade;
    }


    function changeEstadoPostventa(estado, src){
      document.getElementById('estado').innerHTML = estado;
      document.getElementById('estadoPostventa').src = "/assets/customers/img/jpg/postventa/CSA"+src+".jpg";
    }

    function changePagination(page){
      $('.active-page').delay(500).fadeToggle().css('display','flex');
      $('.page-'+page).delay(500).fadeToggle().css('display','flex');
      $('.active-page').toggleClass('active-page');
      $('.page-'+page).toggleClass('active-page');    
      console.log('change to page '+page);
    }

    function showPdf(proveedor){
      
    }
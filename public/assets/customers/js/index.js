/* --------------------------
 * GLOBAL VARS
 * -------------------------- */
// The date you want to count down to
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '/' + mm + '/' + dd;
let targetDate;

const getOfertasRelampago = () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: "GET",
      enctype: 'multipart/form-data',
      url: "/getOfertasRelampago",
      headers: {
          'X-CSRF-Token': '{{ csrf_token() }}',
      },
      success: function (resp) {
          resolve(resp);
      },
      error: function (error) {
          reject(error);
      }
  });
  })
}

getOfertasRelampago().then(resp => changeDateOferta(resp)).catch(console.warn);

function changeDateOferta(oferta){
  console.log(oferta);
  targetDate = new Date(oferta.ofertaRelampago.fechaFin.replaceAll('-', '/').replaceAll('T', ' '));
}

// Other date related variables
// var days;
var hrs;
var min;
var sec;

/* --------------------------
 * ON DOCUMENT LOAD
 * -------------------------- */
$(function () {
  // Calculate time until launch date
  timeToLaunch();
  // Transition the current countdown from 0 
  // numberTransition('#days .number', days, 1000, 'easeOutQuad');
  numberTransition('#hours .number', hrs, 1000, 'easeOutQuad');
  numberTransition('#minutes .number', min, 1000, 'easeOutQuad');
  numberTransition('#seconds .number', sec, 1000, 'easeOutQuad');
  // Begin Countdown
  setTimeout(countDownTimer, 1001);
});

/* --------------------------
 * FIGURE OUT THE AMOUNT OF 
   TIME LEFT BEFORE LAUNCH
 * -------------------------- */
function timeToLaunch() {
  // Get the current date
  var currentDate = new Date();
  // Find the difference between dates
  var diff = (currentDate - targetDate) / 1000;
  var diff = Math.abs(Math.floor(diff));
  // Check number of days until target
  days = Math.floor(diff / (24 * 60 * 60));
  sec = diff - days * 24 * 60 * 60;
  // Check number of hours until target
  hrs = Math.floor(sec / (60 * 60));
  sec = sec - hrs * 60 * 60;
  // Check number of minutes until target
  min = Math.floor(sec / (60));
  sec = sec - min * 60;
}

/* --------------------------
 * DISPLAY THE CURRENT 
   COUNT TO LAUNCH
 * -------------------------- */
function countDownTimer() {
  // Figure out the time to launch
  timeToLaunch();
  // Write to countdown component
  $("#days .number").text(days);
  $("#hours .number").text(hrs);
  $("#minutes .number").text(min);
  $("#seconds .number").text(sec);
  // Repeat the check every second
  setTimeout(countDownTimer, 1000);
}

/* --------------------------
 * TRANSITION NUMBERS FROM 0
   TO CURRENT TIME UNTIL LAUNCH
 * -------------------------- */
function numberTransition(id, endPoint, transitionDuration, transitionEase) {
  // Transition numbers from 0 to the final number
  $({ numberCount: $(id).text() }).animate({ numberCount: endPoint }, {
    duration: transitionDuration,
    easing: transitionEase,
    step: function () {
      $(id).text(Math.floor(this.numberCount));
    },
    complete: function () {
      $(id).text(this.numberCount);
    }
  });
};

$('document').ready(function () {

  AOS.init();
  ScrollReveal().reveal('.appear-500', { delay: 500 });
  ScrollReveal().reveal('.appear-1000', { delay: 1000 });
  ScrollReveal().reveal('.appear-1500', { delay: 1500 });
  ScrollReveal().reveal('.appear-2000', { delay: 2000 });

  if (document.getElementById('first-carousel-item')) {
    var timer = setInterval(function () {

      document.getElementById('first-carousel-item').classList.add('active');
      if (getCookie("_lt")) {
        if (getCookie("_lt").includes('error')) {
          document.cookie = '_lt =; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
          var toast = Swal.mixin({
            toast: true,
            icon: 'error',
            title: 'General Title',
            animation: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toast.fire({
            animation: true,
            title: 'Nombre de usuario inválido o contraseña incorrecta',
            icon: 'error'
          });
        }
        else {
          var toast = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toast.fire({
            animation: true,
            title: '¡Bienvenido de nuevo!',
            icon: 'success'
          });
        }
      }
      if (getCookie("_ep") && getCookie("_lte")) {
        var toast = Swal.mixin({
          toast: true,
          icon: 'warning',
          title: 'General Title',
          animation: true,
          position: 'top-start',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: false,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });
        toast.fire({
          animation: true,
          title: 'Tu sesión ha caducado. Vuelve a iniciar sesión.',
          icon: 'warning'
        });
      }
      clearInterval(timer);
    }, 300);
  }


  $('#check').on('click', function (event) {
    var icon = document.getElementsByClassName('navbar-mobile')[0];
    if (icon.classList.contains('active')) {
      icon.classList.remove('active');
    }
    else {
      icon.classList.add('active');
    }
  });

  $('a.dropdown-item-main').hover(
    function () {
      var active = document.querySelectorAll('.active-item-main');
      [].forEach.call(active, function (el) {
        el.classList.remove("active-item-main");
      })
      $(this).addClass('active-item-main');
    }
  );

  $('a.dropdown-item-2').hover(
    function () {
      var active = document.querySelectorAll('.active-item-2');
      [].forEach.call(active, function (el) {
        el.classList.remove("active-item-2");
      })
      $(this).addClass('active-item-2')
    }
  );

  $('li.dropdown').hover(
    function () {
      $(".overlayDropdown").fadeIn();
    }
  );

  $('a.dropdown-item').hover(
    function () {
      $(".overlayDropdown").fadeIn();
    }
  );

  $('.overlayDropdown').hover(
    function () {
      $(".overlayDropdown").fadeOut();
    }
  );

  $('li.notDropdown').hover(
    function () {
      $(".overlayDropdown").fadeOut();
    }
  );

  $('.brand-logo').hover(
    function () {
      $(".overlayDropdown").fadeOut();
    }
  );

  $(window).resize(function () {
    var navmobile = document.getElementById('navmobile');
    if ($(window).width() > 991 && navmobile.classList.contains('active')) {
      document.getElementById('check').click();
    }
  });


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
      1400: {
        slidesPerView: 5,
        slidesPerGroup: 5,
      }
    }
  });

  const suppliers = new Swiper(".swiper-suppliers", {
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
      1400: {
        slidesPerView: 10,
        slidesPerGroup: 1,

      }
    }
  });

});

function conocerMas() {
  console.log("Conocer mas");
}

document.addEventListener("DOMContentLoaded", function () {
  // make it as accordion for smaller screens
  if (window.innerWidth < 992) {
    // close all inner dropdowns when parent is closed
    document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
      everydropdown.addEventListener('hidden.bs.dropdown', function () {
        // after dropdown is hidden, then find all submenus
        this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
          // hide every submenu as well
          everysubmenu.style.display = 'none';
        });
      })
    });

    document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
      element.addEventListener('click', function (e) {
        let nextEl = this.nextElementSibling;
        if (nextEl && nextEl.classList.contains('submenu')) {
          // prevent opening link if link needs to open dropdown
          e.preventDefault();
          if (nextEl.style.display == 'block') {
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


function activeModal(modal) { //if modal = 1 active login / if modal = 2 active register
  var navmobile = document.getElementById('navmobile');
  if ($(window).width() <= 991 && navmobile.classList.contains('active')) {
    document.getElementById('check').click();
  }
  if (modal == 1) {
    var login = document.getElementById('loginModal');
    login.style.opacity = 1;
    login.style.zIndex = 1000;
    login.classList.add("active-modal");
  }
  if (modal == 2) {
    var login = document.getElementById('registerModal');
    login.style.opacity = 1;
    login.style.zIndex = 1000;
    login.classList.add("active-modal");
  }

}


function closeModal() {
  var activeModal = document.getElementsByClassName("active-modal")[0];
  activeModal.style.opacity = 0;
  activeModal.style.zIndex = -1000;
  activeModal.classList.remove("active-modal");
}

function navigate(blade, validateToken) { //validateToken => Boolean   true: vista protegida, únicamente usuarios logueados      false: vista pública
  if (validateToken) {
    if (getCookie("_lt")) {
      window.location.href = blade;
    }
    else {
      activeModal(1);
    }
  }
  else {
    window.location.href = blade;
  }
}

function getCookie(name) { //saber si una cookie existe 
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
    begin = dc.indexOf(prefix);
    if (begin != 0) return null;
  }
  else {
    begin += 2;
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
      end = dc.length;
    }
  }
  return decodeURI(dc.substring(begin + prefix.length, end));
}

function changeEstadoPostventa(estado, src) {
  document.getElementById('estado').innerHTML = estado;
  document.getElementById('estadoPostventa').src = "/assets/customers/img/jpg/postventa/CSA" + src + ".jpg";
}


function deleteTokenCookie() {
  document.cookie = "_lt= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
}

function showLoadImg(element) {
  element.src = "/assets/customers/img/jpg/imagen_no_disponible.jpg";
}

// FUNCIONES PARA ACTIVAR RAMAS EN VERSIÓN MÓVIL

function activeRama1(categoria, ele) {
  if (ele.childNodes[3].classList.contains('fa-angle-down')) {
    ele.childNodes[3].classList.remove('fa-angle-down');
    ele.childNodes[3].classList.add('fa-chevron-up');
    var ramas = document.getElementsByClassName('rama-1 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.add('active');
    });
  }
  else {
    ele.childNodes[3].classList.add('fa-angle-down');
    ele.childNodes[3].classList.remove('fa-chevron-up');
    var ramas = document.getElementsByClassName('rama-1 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.remove('active');
    });
  }
}

function activeRama2(categoria, ele) {
  if (ele.childNodes[3].classList.contains('fa-caret-down')) {
    ele.childNodes[3].classList.remove('fa-caret-down');
    ele.childNodes[3].classList.add('fa-caret-up');
    var ramas = document.getElementsByClassName('rama-2 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.add('active');
    });
  }
  else {
    ele.childNodes[3].classList.add('fa-caret-down');
    ele.childNodes[3].classList.remove('fa-caret-up');
    var ramas = document.getElementsByClassName('rama-2 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.remove('active');
    });
  }
}

function activeRama3(categoria, ele) {
  if (ele.childNodes[3].classList.contains('fa-plus')) {
    ele.childNodes[3].classList.remove('fa-plus');
    ele.childNodes[3].classList.add('fa-minus');
    var ramas = document.getElementsByClassName('rama-3 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.add('active');
    });
  }
  else {
    ele.childNodes[3].classList.add('fa-plus');
    ele.childNodes[3].classList.remove('fa-minus');
    var ramas = document.getElementsByClassName('rama-3 rama-' + categoria);
    Array.prototype.forEach.call(ramas, function (rama) {
      rama.classList.remove('active');
    });
  }
}

function addPedidoRelampago(){
  $("#formRelampago").submit();
}
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import 'bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');
require('bootstrap-select/dist/js/bootstrap-select');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// -
function expand() {
    $(".search").toggleClass("close");
    $(".input").toggleClass("square");
    if ($('.search').hasClass('close')) {
      $('input').focus();
    } else {
      $('input').blur();
    }
  }
  $('button').on('click', expand);

    // filter : custom selectAll and unSelectAll
$ ( '.selectpicker' ) .selectpicker ( { 
  selectAllText : 'Tous' , 
  deselectAllText : '<i class="fas fa-times"></i>' 
} ) ;

$(document).on("scroll", function(){
  if
    ($(document).scrollTop() > 86){
    $("#banner").addClass("shrink");
  }
  else
  {
    $("#banner").removeClass("shrink");
  }
});


// Btn return to the top
  mybutton = document.getElementById("myBtn");

  window.onscroll = function () { scrollFunction() };
  
  function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          mybutton.style.display = "block";
      } else {
          mybutton.style.display = "none";
      }
  }
  
  function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
  }
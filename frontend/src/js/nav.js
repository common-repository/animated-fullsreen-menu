/*!
  * Scripts for navigation Table and related
  * Copyright 2017 by Samuel Silva
  *
  *
  */

var transition = false; /*flag to check if the transition is happening*/
var $ = jQuery;


(function(){

  $("nav").not(".navbar").hide();
  var button = $('button.navbar-toggler');


  button.on("click", function(){
  
    
    //navItens();
    if ( transition ){
      return false;
    }

    transition = true;


    var navbar = $(".animatedfsmenu");


      navbar.toggleClass("navbar-expand-md");

      navbar.toggleClass('d-flex');
    if ( $(".navbar-collapse").hasClass('opacity-1-trans') ){
      $(".navbar-collapse").removeClass('opacity-1-trans'); /* remove opacity on links menu */
      transition = false;
      if( $.fn.fullpage ){
        $.fn.fullpage.setMouseWheelScrolling(true);
      }
    } else {
      setTimeout(function (){
        $(".navbar-collapse").addClass('opacity-1-trans'); /* add opacity on links menu */
        transition = false;
      },800);
    }

    $('.top').toggleClass('top-animate');
    $('.bot').toggleClass('bottom-animate');
    $('.mid').toggleClass('mid-animate');

  });

    function navItens(){
      var li = $('.menu-item');
      // [].forEach.call(document.querySelectorAll('.menu-item'), function(item) {
      //   item.classList.add('opacity-1-trans');
      // });

      Object.keys(li).map(function(key, index){
        window.setTimeout(function(){
            li[index].addClass('opacity-1-trans');
        }, 400);
      });

    }

    $('.animatedfsmenu .menu-item-has-children').click(function(e){
      e.preventDefault();
      var $submenu = $(this).find('.sub-menu'),
      submenu_height = $submenu.height();

      if( $(this).hasClass('has-children__on') ){
          $(this).removeClass('has-children__on');
          $submenu.css('height',0);
          $submenu.css('opacity','0');
          setTimeout(function(){

            $submenu.css('display','none');
            $submenu.removeAttr("style");

          },300);
          return;
      }

    
    
      $('.menu-item-has-children').removeClass('has-children__on');
      $(this).addClass('has-children__on');


      
      $submenu.height(0);
      $submenu.css('display','block');

      $submenu.height(submenu_height);
      setTimeout(function(){
          $submenu.css('opacity','1');
       }, 100);

      });

    
  
})();

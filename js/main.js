jQuery(document).ready(function ($) {

  //////////////////////////////////////////// bouton close messages d'erreur //
  //////////////////////////////////////////////////////////////////////////////

  $(document).on('click', '.closeButton', function() {
    $('.closeButton').parent().fadeOut();
    $('.box_info').fadeOut();
    $('.box_warning').fadeOut();
  });

  // bouton close tooltips
  $('.helpText').append('<button class="closeB"><i class="ion-ios-close-empty" aria-hidden="true"></i></button>');
  $(document).on('click', '.closeB', function() {
    $('.closeB').parent().fadeOut();
  });

  ///////////////////////////////////////// ajout icone info dans pages devis //
  //////////////////////////////////////////////////////////////////////////////

  $('#buying h3').append('<a class="aideDevis modal-link" href="//www.france-banderole.com/un-devis/" title="Aide pour le devis en ligne" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>');

  //////////////////////////////// SlidesJS (slider carré des pages produits) //
  //////////////////////////////////////////////////////////////////////////////

  $('#slides').slidesjs({
    width: 400,
    height: 400,
    navigation: false, // [boolean] Generates next and previous buttons.
    pagination: false, // [boolean] Create pagination items.
    play: {
      active: false, // [boolean] Generate the play and stop buttons.
      effect: "slide", // [string] Can be either "slide" or "fade".
      interval: 5000, // [number] Time spent on each slide in milliseconds.
      auto: true, // [boolean] Start playing the slideshow on load.
      swap: false, // [boolean] show/hide stop and play buttons
      pauseOnHover: true, // [boolean] pause a playing slideshow on hover
      restartDelay: 2500 // [number] restart delay on inactive slideshow
    }
  });

  ////////////////////////////////////////////////// toggle (texte déroulant) //
  //////////////////////////////////////////////////////////////////////////////

  $('.toggle-button').click(function() {
    $('.toggle-block').slideToggle('slow');
  });

  // home buttons hover
  $('#tarifs li').mouseover(function() {
    $(this).find('.micro a').css({
      background: '#EA2A6A',
      color: '#fff'
    });
  });
  $('#tarifs li').mouseout(function() {
    $(this).find('.micro a').css({
      background: '#f6f6f6',
      color: '#555a61'
    });
  });

  ////////////////////////////////////////////////////// top icons menu hover //
  //////////////////////////////////////////////////////////////////////////////

  $('.menu-client-icon.phone a, .tel2 a').mouseover(function() {
    $('.menu-client-icon.phone a, .tel2 a').css({
      color: '#EA2A6A',
      WebkitTransition : '0.5s',
      MozTransition    : '0.5s',
      MsTransition     : '0.5s',
      OTransition      : '0.5s',
      transition       : '0.5s'
    });
  });
  $('.menu-client-icon.phone a, .tel2 a').mouseout(function() {
    $('.menu-client-icon.phone a, .tel2 a').css({
      color: '#32A1CC',
      WebkitTransition : '0.5s',
      MozTransition    : '0.5s',
      MsTransition     : '0.5s',
      OTransition      : '0.5s',
      transition       : '0.5s'
    });
  });

  $('.fileinput-button').click(function() {
    $('.fustart, .fucancel, .fudelete').css({
      opacity: '1',
      cursor: 'pointer'
    });
  });

  ///////////////////////////////////////////////////////////// smooth scroll //
  //////////////////////////////////////////////////////////////////////////////

  // Select all links with hashes
  $('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          }
        });
      }
    }
  });


  ///////////////////////////////////////////////////////// Magnific Lightbox //
  //////////////////////////////////////////////////////////////////////////////
  $('.gallery-item a').magnificPopup({
    type:'image',
    image: {
      verticalFit: true
    },
    gallery: {
      enabled: true
    }
  });


  $('.lightboxGallery').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
          enabled:true
        }
    });
  });

  ///////////////////////////////////////////// affichage conditionnel mobile //
  //////////////////////////////////////////////////////////////////////////////
  var isMobile = window.matchMedia("only screen and (max-width: 760px)");
  if (isMobile.matches) {

  } else {

  }

});

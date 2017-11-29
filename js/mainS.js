//------------------------------------------------------------------------------
//                                                                        JQUERY
//------------------------------------------------------------------------------
jQuery(document).ready(function ($) {
	//////////////////////////////////////////////////////////////// quantité+- //
  $("#spinner").spinner();

  //////////////////////////////////////////// bouton close messages d'erreur //
  //////////////////////////////////////////////////////////////////////////////

  $(document).on('click', '.closeButton', function() {
    $('.closeButton').parent().fadeOut();
    $('.box_info').fadeOut();
    $('.box_warning').fadeOut();
  });

  // bouton close tooltips
  $('.helpText, #acclient_sub, #panier_sub').append('<button class="closeB"><i class="ion-ios-close-empty" aria-hidden="true"></i></button>');
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

  //////////////////////////////////////////////////////// home buttons hover //
  //////////////////////////////////////////////////////////////////////////////
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
  $('#tarifs2 li').mouseover(function() {
    $(this).find('.micro a').css({
      background: '#EA2A6A',
      color: '#fff'
    });
  });
  $('#tarifs2 li').mouseout(function() {
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

  //////////////////////////////////////////////// warning configurateur lity //
  //////////////////////////////////////////////////////////////////////////////

  if (window.location.href.indexOf("vos-devis") != -1) {

    var currentUrl = window.location.href;
    $(document).on('lity:open', function(event, instance) {

      instance.element().addClass('lity-iframe')
      .off('click', '[data-lity-close]')
      .on('click', '[data-lity-close]', function(e) {
          if (e.target === this) {
            if (!confirm('ATTENTION: êtes-vous sûr de vouloir fermer cette fenêtre ?')) {
              return;
            }
            instance.close();
            $('#fbcart_fileupload3').load('index.php #fbcart_fileupload3');
            $('modal-gallery').show();
            $('#fbcart_lastcomment').show();
          }
      });
    });
  }

  /////////////////////////////////////////////////////////// toggle adresses //
  $(".checkbox").change(function() {
    if(this.checked) {
      $(".blocAdresse").removeClass('blocSelect');
      $('.blocAdresseSelect').removeClass('headSelect');
      $('.adresseLiv').hide();

      $(this).closest(".blocAdresse").addClass('blocSelect');
      $(this).closest('.blocAdresseSelect').addClass('headSelect');
    }
    $('#adresseCheck').submit();
  });

  var check = $('#adresseCheck');
  check.submit(function (e) {
    e.preventDefault();

    $.ajax({
      type: check.attr('method'),
      url: check.attr('action'),
      data: check.serialize(),
      success: function (data) {

      },
      complete: function(data) {
        var r = confirm('L\'adresse de livraison a bien été mise à jour. Retourner sur votre commande ?');
        if (r == true) {
          window.location.href = check.attr('action');
        } else {
          window.location.href = window.location.href
        }
      },
      error: function (data) {
        alert('une erreur s\'est produite, veuillez réessayer.');
      },
    });
  });
  //----------------------------------- affichage conditionnel mobile/desktop //
  //////////////////////////////////////////////////////////////////////////////
  var isDesktop = window.matchMedia("only screen and (min-width: 1024px)");

  if (isDesktop.matches) {
    /////////////////// hover accès client: affichage du module de connection //
    ////////////////////////////////////////////////////////////////////////////
    $('.menu-client--devis').mouseover(function() {
      $('#acclient_sub').show();
    });
    $('.menu-client--panier').mouseover(function() {
      $('#panier_sub').show();
    });
    $('.menu-client--panier, #content_bg_top').mouseover(function() {
      $('#acclient_sub').hide();
    });
    $('#content_bg_top, .menu-client--devis').mouseover(function() {
      $('#panier_sub').hide();
    });

    // disparition au clic outside
    $(document).mouseup(function(e) {
      var container = $("#acclient_sub");
      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0)  {
          container.fadeOut();
      }
    });

		///////////////////////////////////////////////////////////// sticky menu //
		////////////////////////////////////////////////////////////////////////////

		$(window).scroll(function() {
	    if ($(window).scrollTop() > 150) {
	      $("nav").addClass('fixed');
				$('.navContainer').addClass('fixed');
				$('.logoSmall').css('display','inline-block');
				$('.izoneLeft, .izoneRight').css('top','50px');
	    } else {
	      $("nav").removeClass('fixed');
				$('.navContainer').removeClass('fixed');
				$('.logoSmall').css('display','none');
				$('.izoneLeft, .izoneRight').css('top','0');
	    }
		});

    ////////////////////////////////////////////////////////////////// Promos //
    //---------------------------------------------------------------- gauche //
    var imageLeft = new Array ();
    imageLeft[0] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoAkilux.png" title="panneaux akilux pas cher" alt="akilux agence immobilière" />';
    imageLeft[1] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoGoutte.png" title="promo oriflamme beachflag" alt="promo oriflamme" />';
    imageLeft[2] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoRollup.png" title="Rollup meilleur prix: 28€" alt="promo kakemono rollup" />';
    imageLeft[3] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoKakemono2.png" title="kakemono tissu, totem plv" alt="kakemono tissu pas cher" />';
	/*imageLeft[4] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoLeftstand.png" title="Stand Expo Bag Promo" alt="Stand Promotion" />';
	imageLeft[5] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichefluoLeft.png" title="Affiche fluo Promo" alt="Affiche 120gr Fluo" />';
	imageLeft[6] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichequadriLeft.png" title="Affiche quadri" alt="Affiche 120gr dos bleu" />';*/

    var linkLeft = new Array ();
    linkLeft[0] = '<a href="https://www.france-banderole.com/panneaux-akilux" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkLeft[1] = '<a href="https://www.france-banderole.com/oriflammes" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkLeft[2] = '<a href="https://www.france-banderole.com/roll-up" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkLeft[3] = '<a href="https://www.france-banderole.com/totem" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	/*linkLeft[4] = '<a href="https://www.france-banderole.com/plv-interieur" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	linkLeft[5] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	linkLeft[6] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';*/

    //---------------------------------------------------------------- droite //
    var imageRight = new Array ();
    imageRight[0] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoStands.png" title="meilleur prix stand parapluie tissu tendu : 257€ !" alt="stand tissu pas cher" />';
    imageRight[1] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoLux.png" title="roll-up conçu pour durer" alt="roll-up luxe modulable" />';
    imageRight[2] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoTente.png" title="meilleur prix tentes publicitaires : 347€ !" alt="tente publicitaire pas cher" />';
    imageRight[3] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoKakemono.png" title="kakemono tissu, totem plv" alt="kakemono tissu pas cher" />';
	/*imageRight[4] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoRightstand.png" title="Stand Expo Bag Promo" alt="Stand Promotion" />';
	imageRight[5] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichefluoRight.png" title="Affiche fluo Promo" alt="Affiche 120gr Fluo" />';
	imageRight[6] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichequadriRight.png" title="Affiche quadri" alt="Affiche 120gr dos bleu" />';*/

    var linkRight = new Array ();
    linkRight[0] = '<a href="https://www.france-banderole.com/stand-parapluie/" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkRight[1] = '<a href="https://www.france-banderole.com/roll-up" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkRight[2] = '<a href="https://www.france-banderole.com/tente-publicitaire-barnum" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
    linkRight[3] = '<a href="https://www.france-banderole.com/totem" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	/*linkRight[4] = '<a href="https://www.france-banderole.com/plv-interieur" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	linkRight[5] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
	linkRight[6] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
*/
    //------------------------------------------------------------- randomize //
    var sizeL = imageLeft.length;
    var sizeR = imageRight.length;
    var x = Math.floor(sizeL*Math.random());
    var y = Math.floor(sizeR*Math.random());
    $('.izoneInL').append(imageLeft[x]+linkLeft[x]);
    $('.izoneInR').append(imageRight[y]+linkRight[y]);

		/////////////////////////////////////////////////////////////// addtocart //
		////////////////////////////////////////////////////////////////////////////
		var frm = jQuery('#cart_form');
		frm.submit(function (e) {
			e.preventDefault();

			jQuery.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
					//Select item image and pass to the function
					var itemImg = jQuery('#submit_cart');
					flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
          $("#menuPanier").load("index.php #menuPanier");
				},
				complete: function(data) {
					//location.href = location.href;
				},
				error: function (data) {
					alert('une erreur s\'est produite, veuillez réessayer.');
				},
			});
		});

    //-------------------------------------------------addtocart modèle page PLV
    $("[data-cartform]").submit(function(e) {
        var frm2 = $(this);
        var itemImg = $('.prom_sub');
        e.preventDefault();

       jQuery.ajax({
         type: frm2.attr('method'),
         url: frm2.attr('action'),
         data: frm2.serialize(),
         success: function (data) {
           flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
           $("#menuPanier").load("index.php #menuPanier");
         },
         complete: function(data) {
           //location.href = location.href;
         },
         error: function (data) {
           alert('une erreur s\'est produite, veuillez réessayer.');
         },
       });
    });


  //-----------------------------------------------------------------fin desktop
  }else{
		var frm = jQuery('#cart_form');
		frm.submit(function (e) {
			e.preventDefault();

			jQuery.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
        	jQuery('html, body').animate({
						'scrollTop' : jQuery(".menu-client--panier").position().top
					});
					//Select item image and pass to the function
					var itemImg = jQuery('#submit_cart');
					flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
          $("#menuPanier").load("index.php #menuPanier");
				},
				complete: function(data) {
					//location.href = location.href;
				},
				error: function (data) {
					alert('une erreur s\'est produite, veuillez réessayer.');
				},
			});
		});
	}
  //------------------------------------------------------------------fin mobile

  //----------------------------------------------------------script fly to cart
  function flyToElement(flyer, flyingTo) {
    var $func = jQuery(this);
    var divider = 3;
    var flyerClone = jQuery(flyer).clone();
    jQuery(flyerClone).css({position: 'absolute', top: jQuery(flyer).offset().top + "px", left: jQuery(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
    jQuery('body').append(jQuery(flyerClone));
    var gotoX = jQuery(flyingTo).offset().left + (jQuery(flyingTo).width() / 2) - (jQuery(flyer).width()/divider)/2;
    var gotoY = jQuery(flyingTo).offset().top + (jQuery(flyingTo).height() / 2) - (jQuery(flyer).height()/divider)/2;

    jQuery(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: jQuery(flyer).width()/divider,
        height: jQuery(flyer).height()/divider
    }, 700,
    function () {
        jQuery(flyingTo).fadeOut('fast', function () {
            jQuery(flyingTo).fadeIn('fast', function () {
                jQuery(flyerClone).fadeOut('fast', function () {
                    jQuery(flyerClone).remove();
                });
            });
        });
    });
  }

});

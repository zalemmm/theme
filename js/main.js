//------------------------------------------------------------------------------
//                                                                       VANILLA
//------------------------------------------------------------------------------

//----------------affichage des tooltips / sous menus hover --------------------
function tipShow(id) {
   var e = document.getElementById(id);
  	e.style.visibility="visible";
}

function tipHide(id) {
   var e = document.getElementById(id);
  	e.style.visibility="hidden";
}

var toCopy  = document.getElementById( 'to-copy' ),
    btnCopy = document.getElementById( 'copy' );

btnCopy.addEventListener( 'click', function(){
  toCopy.select();
  document.execCommand( 'copy' );

  if ( document.execCommand( 'copy' ) ) {
      btnCopy.classList.add( 'copied' );

      var temp = setInterval( function(){
        btnCopy.classList.remove( 'copied' );
        clearInterval(temp);
      }, 600 );

  } else {
    console.info( 'document.execCommand went wrong…' );
  }

  return false;
} );

//------------------------------------------------------------------------------
//                                                                        JQUERY
//------------------------------------------------------------------------------

jQuery(document).ready(function ($) {

  $('.btn').removeClass('.ui-button');

  $(".deactive").css("opacity", 0.2);

	//------------------------------ quantité+- ----------------------------------
  $("#spinner").spinner();

  //------------------ bouton close messages d'erreur --------------------------
  //----------------------------------------------------------------------------
  $(document).on('click', '.closeTip', function() {
    $(this).parent().fadeOut();
  });

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

  //---------------- ajout icone info dans pages devis -------------------------
  //----------------------------------------------------------------------------

  $('#buying h3').append('<a class="aideDevis modal-link" href="//www.france-banderole.com/un-devis/" title="Aide pour le devis en ligne" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>');

  //---------------- SlidesJS (slider carré des pages produits) ----------------
  //----------------------------------------------------------------------------

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

  //----------------------- toggle (texte déroulant) ---------------------------
  //----------------------------------------------------------------------------

  $('.toggle-button').click(function() {
    $('.toggle-block').slideToggle('slow');
  });

  //-------------------------- home buttons hover ------------------------------
  //----------------------------------------------------------------------------
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

  //-----------------------top icons menu hover --------------------------------
  //----------------------------------------------------------------------------

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

  //-------------------------smooth scroll -------------------------------------
  //----------------------------------------------------------------------------

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


  //-------------------------------- Magnific Lightbox -------------------------
  //----------------------------------------------------------------------------
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

  //----------------------------- initialisation popup confirmation ajout panier
  $('.open-popup-link').magnificPopup({
    type:'inline',
    midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
  });

  $('.btContinue').click(function(){
    $.magnificPopup.close();
  });

  //-------------------------warning configurateur lity ------------------------
  //----------------------------------------------------------------------------

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

  //-----------------------------------------------------------demande de rappel
  function explode(){
    $('#butrappel').toggle( "slide" )
  }
  setTimeout(explode, 60000);

  var rappel = jQuery('#subrappel');
  rappel.submit(function(e) {
    e.preventDefault();
     jQuery.ajax({
       type: rappel.attr('method'),
       url: rappel.attr('action'),
       data: rappel.serialize(),
       success: function (data) {
         $(".modalContent").html("<div class='successmsg'>Merci, un conseiller va vous rappeler!<div>");
         $("#butrappel").fadeOut();
       },
       complete: function(data) {

      },
       error: function (data) {
         alert('une erreur s\'est produite, veuillez réessayer.');
       },
     });
  });

  //------------------------------------------------------------ toggle adresses
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
          window.location.href = window.location.href;
        }
      },
      error: function (data) {
        alert('une erreur s\'est produite, veuillez réessayer.');
      },
    });
  });

  //-------------------------------- export devis ------------------------------
  //----------------------------------------------------------------------------

  var expfrm = $('#marge');
  expfrm.submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: expfrm.attr('method'),
      url: expfrm.attr('action'),
      data: expfrm.serialize(),
      success: function(data) {
        var marge = $("#amount").val();
        var ht = $("#toutht").val();
        ht = ht.toString().replace(/\,/g, '.');
        ht = ht.toString().replace(/\€/g, '');

        var totalmarge = ht*marge/100;
        var totalht = parseFloat(ht) + parseFloat(totalmarge);
        totalht = parseFloat(totalht).toFixed(2);
        var tva = parseFloat(totalht*20/100).toFixed(2);
        var totalttc = parseFloat(totalht) + parseFloat(tva);
        totalttc = parseFloat(totalttc).toFixed(2);

        var numItems = $('.prixu').length;
        var sharedMarge = totalmarge/numItems;

        $(".produit").each(function(i) {
          var prixu = $(this).find('.prixu').attr("data-id");
          var qte = $(this).find('.qte').attr("data-id");
          var sharedAg = sharedMarge/qte;
          var prixrevu = parseFloat(prixu) + parseFloat(sharedAg);
          var prixtt = prixrevu*(qte);
          prixrevu = parseFloat(prixrevu).toFixed(2);
          prixtt = parseFloat(prixtt).toFixed(2);
          $(this).find('.prixu').text(prixrevu + ' €');
          $(this).find('.prixi').text(prixtt + ' €');
        });

        $("#totalMarge").text('+' + totalmarge.toFixed(2) + ' €');
        $("#loadht").text(totalht + ' €');
        $("#loadtva").text(tva + ' €');
        $("#loadttc").text(totalttc + ' €');
      },
      error: function (data) {
        alert('une erreur s\'est produite, veuillez réessayer.');
      }
    });

  });


  //---------------------- affichage conditionnel desktop ----------------------
  //----------------------------------------------------------------------------

  var isDesktop = window.matchMedia("only screen and (min-width: 1024px)");

  if (isDesktop.matches) {
    //-------------------- hover accès client: affichage du module de connection

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

		//-------------------------------------------------------------- sticky menu

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

		//---------------------------------------------------------------- addtocart
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
          $("#nomp").load("index.php #nomp");
					flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
          $("#menuPanier").load("index.php #menuPanier");
				},
				complete: function(data) {
          setTimeout(function(){
            $.magnificPopup.open({
                  items: {
                      src: '#cartConfirm',
                  },
                  type: 'inline'
            });
          }, 700);
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
           $("#nomp").load("index.php #nomp");
           flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
           $("#menuPanier").load("index.php #menuPanier");
         },
         complete: function(data) {
           setTimeout(function(){
             $.magnificPopup.open({
                   items: {
                       src: '#cartConfirm',
                   },
                   type: 'inline'
             });
           }, 700);
 				},
         error: function (data) {
           alert('une erreur s\'est produite, veuillez réessayer.');
         },
       });
    });




  //---------------------- affichage conditionnel mobile -----------------------
  //----------------------------------------------------------------------------
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
          $("#nomp").load("index.php #nomp");
					flyToElement(jQuery(itemImg), jQuery('.menu-client--panier'));
          $("#menuPanier").load("index.php #menuPanier");
				},
        complete: function(data) {
          setTimeout(function(){
            $.magnificPopup.open({
                  items: {
                      src: '#cartConfirm',
                  },
                  type: 'inline'
            });
          }, 700);
				},
				error: function (data) {
					alert('une erreur s\'est produite, veuillez réessayer.');
				},
			});
		});
	}
  //------------------------------------------------------------------fin mobile

  //--------------------------script fly to cart--------------------------------
  //----------------------------------------------------------------------------
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

  //-------------------------- print -------------------------------------------
  //----------------------------------------------------------------------------
  function print(selector) {
    //$('#cgv').addClass('noprint');
    var $print = $(selector)
        .clone()
        .addClass('print')
        .prependTo('body');

    //window.print() stops JS execution
    window.print();

    //Remove div once printed
    $print.remove();
  }

  //-------------------------------------------------------------/ export pdf //
  //----------------------------------------------------------------------------
  /*var doc = new jsPDF('portrait', 'mm', 'a4');

  $('#cmd').click(function () {
    $('#order_inscription, #cmd, #print, #curseurWrapper').hide();
    $('#modalDevis').css({
      margin: '20px auto 0',
      background: '#fff',
      border: 'none'
    });
    $('#modalDevis table').css({
      width: '90%',
      background: '#fff'
    });
    $('#modalDevis table#fbcart_check').css({
      width: '45%',
      marginRight: '10%',
      background: '#fff'
    });
    $('#modalDevis table td').css({
      background: '#fff'
    });
    doc.addHTML($('#modalDevis')[0], 15, 15, {
    }, function() {
      doc.save('devis.pdf');
    });
    $('#order_inscription, #cmd, #print, #curseurWrapper').show();
  });*/

  //-----------------------------------modes de paiement: affichage bouton payer
  $('input[value=carte]').click(function() {
    $('.pch, .pvi, .p30, .p60, .pad').css('display', 'none');
    $('.pcb').fadeIn().css('display', 'block');
  });

  $('input[value=cheque]').click(function() {
    $('.pcb, .pvi, .p30, .p60, .pad').css('display', 'none');
    $('.pch').fadeIn().css('display', 'block');
  });

  $('input[value=virement]').click(function() {
    $('.pcb, .pch, .p30, .p60, .pad').css('display', 'none');
    $('.pvi').fadeIn().css('display', 'block');
  });

  $('input[value=trente]').click(function() {
    $('.pcb, .pvi, .pch, .p60, .pad').css('display', 'none');
    $('.pc30').fadeOut();
    $('.p30').fadeIn().css('display', 'block');
  });

  $('input[value=soixante]').click(function() {
    $('.pcb, .pvi, .pch, .p30, .pad').css('display', 'none');
    $('.pc60').fadeOut();
    $('.p60').fadeIn().css('display', 'block');
  });

  $('input[value=administratif]').click(function() {
    $('.pcb, .pvi, .pch, .p30, .p60').css('display', 'none');
    $('.pcAD').fadeOut();
    $('.pad').fadeIn().css('display', 'block');
  });

  //------------------------------------------------------------- validation cgv
  $('#suivant_reg').click(function(){
    $(this)
    .html('<i class="fa fa-check" aria-hidden="true"></i> OK')
    .css({
      background: '#ececec',
      border: '1px solid #e0e0e0',
      color: '#ccc',
      cursor: 'default'
    });
  });


  // ------------------------------------------------------------------------FIN
});

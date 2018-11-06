//------------------------------------------------------------------------------
//                                                                       VANILLA
//------------------------------------------------------------------------------

//-------------------------------------affichage des tooltips / sous menus hover
function tipShow(id) {
  var e = document.getElementById(id);
  e.style.visibility="visible";
}

function tipHide(id) {
  var e = document.getElementById(id);
  e.style.visibility="hidden";
}

//------------------------------------------------------bouton copier url panier

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
});


// UPLOAD PAR PRODUITS
//------------------------------------------ affichage des fichiers sélectionnés

var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input ) {
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;
  var button = label.nextElementSibling;

	input.addEventListener( 'change', function( e )	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName ){
			label.querySelector( 'span' ).innerHTML = fileName;
      button.classList.remove('deactive');}
		else
			label.innerHTML = labelVal;
	});
});


//------------------------------------------------------------------------------
//                                                                        JQUERY
//------------------------------------------------------------------------------

jQuery(document).ready(function ($) {

  $('.btn').removeClass('.ui-button');

	//------------------------------ quantité+- ----------------------------------
  $("#spinner").spinner();

  //--------------------------------------------- bouton close messages d'erreur

  $(document).on('click', '.closeTip', function() {
    $(this).parent().fadeOut();
  });

  // bouton close tooltips
  $(document).on('click', '.closeButton', function() {
    $('.closeButton').parent().fadeOut();
    $('.box_info').fadeOut();
    $('.box_warning').fadeOut();
  });

  $(document).on('click', '.closeB', function() {
    $('.closeB').parent().fadeOut();
  });

  //-----------------------------------------------------------helptext tooltips

  $('.helpButton').mouseover(function(){
    $('.helpText').css('visibility', 'hidden');
    var thishelper = $(this).find('.helpText');
    thishelper.css('visibility', 'visible').fadeIn();
  });

  $('.helpButton').mouseout(function(){
    $('.helpText').css('visibility', 'hidden');
    var thishelper = $(this).find('.helpText');
    thishelper.css('visibility', 'hidden').fadeOut();
  });

  //--------------------------------- SlidesJS (slider carré des pages produits)

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

  //--------------------------------------------------- toggle (texte déroulant)

  $('.toggle-button').click(function() {
    $('.toggle-block').slideToggle('slow');
  });


  //------------------------------------------------------- top icons menu hover

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
      color: '#4f4f4f',
      WebkitTransition : '0.5s',
      MozTransition    : '0.5s',
      MsTransition     : '0.5s',
      OTransition      : '0.5s',
      transition       : '0.5s'
    });
  });

  //------------------------------------------------------ boutons module upload

  $('.fileinput-button').click(function() {
    $('.fustart, .fucancel, .fudelete').css({
      opacity: '1',
      cursor: 'pointer'
    });
  });

  //---------------------------------------------------------------- drag & drop
  $('.dropin').on('dragenter', function() {
    $(this).css({'background-color' : 'rgba(0,0,0,0.1)'});
  });

  $('.dropin').on('dragleave', function() {
    $(this).css({'background-color' : ''});
  });

  //-------------------------------------------------------------- smooth scroll
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


  //---------------------------------------------------------- Magnific Lightbox

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

  //--------------------------------------------------------- variables commande

  var siteurl;
  var sitebase = window.location.protocol + '//' + window.location.hostname;
  if (sitebase.indexOf('127.0.0.1') !== -1 || sitebase.indexOf('localhost') !== -1)
    siteurl = sitebase + '/wordpress';
  else siteurl = sitebase;

  var orderid = $('#number').text();
  var orderurl = siteurl + '/vos-devis/?detail=' + orderid;

  // UPLOAD PAR PRODUITS
  //------------------------------------------------------------ upload fichiers

  $("[data-upload]").submit(function(e) {
    var frm = $(this);
    var form = $(this)[0];
    var progress = frm.find(".progress");
		// Create an FormData object
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
    data.append("CustomField", "This is some extra data, testing");

    e.preventDefault();

    $.ajax({
      type		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url	   	: frm.attr('action'), // the url where we want to POST
      data		: data, // our data object
      cache: false,
      contentType: false,
      processData: false,

      // this part is progress bar
      xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (evt) {
              if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  percentComplete = parseInt(percentComplete * 100);
                  $('.myprogress').text(percentComplete + '%');
                  $('.myprogress').css('width', percentComplete + '%');
              }
          }, false);
          return xhr;
      },

      beforeSend: function(){
        frm.find('.progress.prodprog').css('display','block');
        frm.find('.freeSubmit').html('<i class="fa fa-spinner fa-pulse"></i> Veuillez patienter...').addClass('wait');
      },

      success: function (data) {

        frm.find('.freeSubmit').html('<i class="fa fa-check" aria-hidden="true"></i>  Fichier envoyé !').removeClass('wait').addClass('done');
        $(document).ajaxStop(function(){
            window.location = window.location.href;
        });
      },

      error: function (e) {

      }
    });
  });

  $('.inputfile').on('change', function() {
    //xhr.abort();

    var fsize = $(this)[0].files[0].size,
    ftype = $(this)[0].files[0].type,
    fname = $(this)[0].files[0].name,
    fextension = fname.substring(fname.lastIndexOf('.')+1).toLowerCase();
    validExtensions = ['pdf','jpg','jpeg','png','svg','eps','ai','psd'];

    if ($.inArray(fextension, validExtensions) == -1){
      $(this).nextAll('.freeSubmit').addClass('deactwarn').html('<i class="fa fa-warning fa-pulse"></i> Format non accepté!');
      return false;

    }else{
      if(fsize > 125829120){/*1048576-1MB(You can change the size as you want)*/
        $(this).nextAll('.freeSubmit').addClass('deactwarn').html('<i class="fa fa-warning fa-pulse"></i> Taille maximale 120MB!');
        return false;
      }

      $(this).nextAll('.freeSubmit').removeClass('deactwarn').removeClass('deactwarn').html('<i class="fa fa-check"></i> Envoyer');
      return true;
    }
  });

  $('.upCont').mouseover(function(){
    $(this).find('.multup').css('display','block');
  }).mouseout(function(){
    $(this).find('.multup').css('display','none');
  });

  $('.upCont').click(function(){
    $(this).find('.maqupload').css('display','none');
    $(this).find('.freeUp').css('display','block');
  });

  $('.capt').mouseover(function(){
    $(this).find('.viewmaq, .delmaq').css('display','block');
  }).mouseout(function(){
    $('.viewmaq, .delmaq').css('display','none');
  });

  /*$('.cancelup').click(function(){
    $(this).parent('.freeSubmit').html('<i class="fa fa-check"></i>  Envoyer').removeClass('wait').nextAll('.progress').css('display','none');;
    xhr.abort();
  });*/


  //--------------------------------------------------------------- export devis

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


  //------------------------------------------------------------tooltip paiement
  $('.paiements_right_con').mouseover(function(){
    $(this).find('.helpPay').css('visibility', 'visible');
  });
  $('.paiements_right_con').mouseout(function(){
    $(this).find('.helpPay').css('visibility', 'hidden');
  });

  $('.radiod').prop("disabled", true);


  //---------------------------------------------------------------- détecter IE
  function GetIEVersion() {
    var sAgent = window.navigator.userAgent;
    var Idx = sAgent.indexOf("MSIE");

    // If IE, return version number.
    if (Idx > 0)
    return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

    // If IE 11 then look for Updated user agent string.
    else if (!!navigator.userAgent.match(/Trident\/7\./))
    return 11;

    else
    return 0; //It is not IE
  }
  //---------------------------------------- désactiver boutons maquette sous IE

  if (GetIEVersion() > 0) { //
    $('.maquette').addClass('deactive');
    $('.mtip').addClass('mtipIE');
  }

  //============================================== affichage conditionnel mobile

  var isnotDesktop = window.matchMedia("only screen and (max-width: 1279px)");

  //----------------------------------------- désactiver boutons maquette mobile
  if (isnotDesktop.matches) { // écrans moins de 1280px
    $('.maquette').addClass('deactive');
    $('.mtip').addClass('mtipSm');
    $('.mtip').html('<i class="fa fa-exclamation-triangle exclam" aria-hidden="true"></i><span class="alertText">Pour créer votre maquette en ligne il vous faut être sur un ordinateur avec un écran de minimum 1280 pixels de large.<span class="closeTip"><i class="ion-ios-close-empty" aria-hidden="true"></i></span>');
  }

  //============================================= affichage conditionnel desktop

  var isDesktop = window.matchMedia("only screen and (min-width: 1024px)");

  if (isDesktop.matches) {
    //------------------------------------------------------- tips espace client
    setTimeout(function(){
      $('.otip').toggle( "slide" );
    }, 2000);

    //---------------------------------------------------------helptext tooltips
    $('li.form-line.select').focusin(function(){
      $(this).find('.helpText').css('visibility', 'visible').fadeIn();
    });
    $('li.form-line.select').change(function() {
      $(this).find('.helpText').css('visibility', 'hidden').fadeOut();
    });
    $('li.form-line.select').focusout(function(){
      $(this).find('.helpText').css('visibility', 'hidden').fadeOut();
    });

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

    //---------------------------------------------- disparition au clic outside
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
				$('.izoneLeft, .izoneRight').css('top','50px');
        $('.log_info').css('display','none');
	    } else {
	      $("nav").removeClass('fixed');
				$('.navContainer').removeClass('fixed');
				$('.izoneLeft, .izoneRight').css('top','0');
        $('.log_info').css('display','block');
	    }
		});

    //---------------------------------------------------------demande de rappel

    function explode(){
      var curdate = new Date();
      var curhour = curdate.getHours();
      if(curdate.getDay() != 6 && curdate.getDay() != 0) { // si ce n'est pas le week end
        if ((curhour >= 9 && curhour < 12) || (curhour >= 14 && curhour < 18) ) { // et si on est dans les horaires bureau
          $('#butrappel').toggle( "slide" ); // affiche le bouton demande rappel
        }
      }
    }
    setTimeout(explode, 10000); // apparait au bout de 20 secondes

    var rappel = jQuery('#subrappel');
    rappel.submit(function(e) {
      e.preventDefault();
       jQuery.ajax({
         type: rappel.attr('method'),
         url: rappel.attr('action'),
         data: rappel.serialize(),
         success: function (data) {
           $("#rappel .modalContent").html("<div class='successmsg'>Merci, un conseiller va vous rappeler!<div>");
           $("#butrappel").fadeOut();
         },
         complete: function(data) {
         },
         error: function (data) {
           alert('une erreur s\'est produite, veuillez réessayer.');
         },
       });
    });

    //-------------------------------------------------addtocart modèle page PLV
    $("[data-cartform]").submit(function(e) {
      var frm2 = $(this);
      var itemImg = $('.imgtd');
      e.preventDefault();
      $.magnificPopup.close();
      $('.loader').show();

      //------------------------------------------------------------- update dom
      $("#nomp").load("index.php #nomp");
      $("#menuPanier").load("index.php #menuPanier");

      jQuery.ajax({
        type: frm2.attr('method'),
        url: frm2.attr('action'),
        data: frm2.serialize(),

        success: function (data) {

        },

        complete: function(data) {
          $('.loader').hide();
          // --------------------------------- afficher la popup de confrimation
          $.magnificPopup.open({
            items: {
              src: '#cartConfirm',
            },
            type: 'inline'
          });
        },

        error: function (data) {
          alert('une erreur s\'est produite, veuillez réessayer.');
        },
      });
    });
  } // fin affichage conditionnel desktop


  //---------------------------------------------------------------------- print
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

  // ------------------------------------------------------------------------FIN
});

jQuery(document).ready(function ($) {
////////////////////////////////////////////////////////////////// Promos //
//---------------------------------------------------------------- gauche //
var imageLeft = new Array ();
imageLeft[0] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoAkilux.png" title="promo akilux" />';
imageLeft[1] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoGoutte.png" title="promo oriflamme beachflag" alt="promo oriflamme" />';
imageLeft[2] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoRollup.png" title="Rollup meilleur prix: 28€" alt="promo kakemono rollup" />';
imageLeft[3] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoKakemono2.png" title="kakemono tissu, totem plv" alt="kakemono tissu pas cher" />';
/*imageLeft[4] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/nappeLeft.png" title="nappe publicitaire" alt="nappe tissu pas cher" />';*/
/*imageLeft[4] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoLeftstand.png" title="Stand Expo Bag Promo" alt="Stand Promotion" />';
imageLeft[5] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichefluoLeft.png" title="Affiche fluo Promo" alt="Affiche 120gr Fluo" />';
imageLeft[6] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichequadriLeft.png" title="Affiche quadri" alt="Affiche 120gr dos bleu" />';*/

var linkLeft = new Array ();
linkLeft[0] = '<a href="https://www.france-banderole.com/panneaux-akilux" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkLeft[1] = '<a href="https://www.france-banderole.com/oriflammes" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkLeft[2] = '<a href="https://www.france-banderole.com/roll-up" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkLeft[3] = '<a href="https://www.france-banderole.com/totem" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
/*linkLeft[4] = '<a href="https://www.france-banderole.com/nappes-publicitaires" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';*/
/*linkLeft[4] = '<a href="https://www.france-banderole.com/plv-interieur" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkLeft[5] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkLeft[6] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';*/

//---------------------------------------------------------------- droite //
var imageRight = new Array ();
//imageRight[0] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoAkilux.png" title="promo akilux" alt="promo akilux" />';
imageRight[0] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoLux.png" title="roll-up conçu pour durer" alt="roll-up luxe modulable" />';
imageRight[1] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoTente.png" title="meilleur prix tentes publicitaires : 347€ !" alt="tente publicitaire pas cher" />';
imageRight[2] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/promoKakemono.png" title="kakemono tissu, totem plv" alt="kakemono tissu pas cher" />';
/*imageRight[3] = '<img class="iz1" src="https://www.france-banderole.com/wp-content/themes/fb/images/nappeRight.png" title="nappe personnalisée" alt="nappe tissu pas cher" />';*/
/*imageRight[4] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/promoRightstand.png" title="Stand Expo Bag Promo" alt="Stand Promotion" />';
imageRight[5] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichefluoRight.png" title="Affiche fluo Promo" alt="Affiche 120gr Fluo" />';
imageRight[6] = '<img class="iz1"  src="https://www.france-banderole.com/wp-content/themes/fb/images/affichequadriRight.png" title="Affiche quadri" alt="Affiche 120gr dos bleu" />';*/

var linkRight = new Array ();
//linkRight[0] = '<a href="https://www.france-banderole.com/panneaux-akilux/ " class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkRight[0] = '<a href="https://www.france-banderole.com/roll-up" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkRight[1] = '<a href="https://www.france-banderole.com/tente-publicitaire-barnum" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkRight[2] = '<a href="https://www.france-banderole.com/totem" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
/*linkRight[3] = '<a href="https://www.france-banderole.com/nappes-publicitaires" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';*/
/*linkRight[4] = '<a href="https://www.france-banderole.com/plv-interieur" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkRight[5] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
linkRight[6] = '<a href="https://www.france-banderole.com/promotions" class="metaButton promo">Voir <i class="fa fa-caret-right"></i></a>';
*/
//-------------------------------------------------------------------- randomize
var sizeL = imageLeft.length;
var sizeR = imageRight.length;
var x = Math.floor(sizeL*Math.random());
var y = Math.floor(sizeR*Math.random());
$('.izoneInL').append(imageLeft[x]+linkLeft[x]);
$('.izoneInR').append(imageRight[y]+linkRight[y]);

//--------------------------------------------------------------------------snow
(function($){$.fn.snow=function(options){var $flake=$('<div id="flake" />').css({'position':'absolute','top':'-50px'}).html('&#10052;'),documentHeight=$(document).height(),documentWidth=$(document).width(),defaults={minSize:10,maxSize:20,newOn:500,flakeColor:"#FFFFFF"},options=$.extend({},defaults,options);var interval=setInterval(function(){var startPositionLeft=Math.random()*documentWidth-100,startOpacity=0.5+Math.random(),sizeFlake=options.minSize+Math.random()*options.maxSize,endPositionTop=documentHeight-40,endPositionLeft=startPositionLeft-100+Math.random()*200,durationFall=documentHeight*10+Math.random()*5000;$flake.clone().appendTo('body').css({left:startPositionLeft,opacity:startOpacity, 'z-index': 9999,'font-size':sizeFlake,color:options.flakeColor}).animate({top:endPositionTop,left:endPositionLeft,opacity:0.2},durationFall,'linear',function(){$(this).remove()});},options.newOn);};})(jQuery);

//$.fn.snow({ minSize: 3, maxSize: 20, newOn: 1000, flakeColor: '#ffffff' });

});

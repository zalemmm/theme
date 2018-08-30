<?php
  /**
  * @package WordPress
  * @subpackage Classic_Theme
  */
  if (is_front_page() OR (1==1)) {
?>

</div>

<!--Footer part1 -------------------------------------------------------------->

<ul id="introBlocs">

  <li class="b-it1">
    <i class="ion-ribbon-b"></i>
    <h4 class="keepTxtColor">Fabrication française</h4>
    Réalisation, impression et façonnage réalisés en France métropolitaine
  </li>

  <li class="b-it2">
    <i class="ion-easel"></i>
    <h4 class="keepTxtColor">Imprimeur grand format</h4>
     Banderole géante jusqu'à 50m sur 5m.<br /> 9 matières de bâches : écologique, anti-feu, PVC, micro-perforée, tissu...
  </li>


  <li class="b-it3">
    <i class="ion-paintbucket"></i>
    <h4 class="keepTxtColor">IMPRESSION NUMÉRIQUE HD</h4>
    <b>600 & 1440 DPI</b><br /> Tenue et respect des couleurs garantie en exterieur jusqu'à 4 ans en impression UV<br />
  </li>

  <li class="b-it4">
    <i class="ion-ios-stopwatch"></i>
    <h4 class="keepTxtColor">RAPIDITÉ D'EXÉCUTION</h4>
    Possibilité de fabrication et livraison de votre commande le jour-même (après-midi) ou en 24h/48h
  </li>

</ul>

<!--Footer part2 -------------------------------------------------------------->

<div id="main2">
  <?php
  global $wpdb;
  $prefix = $wpdb->prefix;
  $fb_tablename_tel = $prefix."fbs_tel";

  $prodpages = is_page('stand-parapluie') || is_page('roll-up') || is_page('promotions') || is_page('nappes-publicitaires') || is_page('totem') || is_page('plv-interieur') || is_page('banderoles') || is_page('tente-publicitaire-barnum') || is_page('oriflammes') || is_page('plv-exterieur') || is_page('flyers') || is_page('depliants') || is_page('cartes') || is_page('affiches') || is_page('panneaux-akilux-3mm') || is_page('panneaux-akilux-3_5mm') || is_page('panneaux-akilux-5mm') || is_page('pvc-300-microns') || is_page('panneaux-forex-3mm') || is_page('panneaux-forex-5mm') || is_page('panneaux-alu-dibond') || is_page('panneaux-komadur') || is_page('autocollant') || is_page('sticker-predecoupe') || is_page('sticker-lettrage-predecoupe') || is_page('vitrophanie') || is_page('sticker-mural') || is_page('cadre-tissu') || is_page('enseigne-suspendue-textile') || is_page('stand-exposition-plv-interieur') || is_page('signaletique-exterieur') || is_page('stickers') || is_page('imprimerie-papier');

  //--------------------------------------------------------popup demande rappel
  if ($prodpages) {
    $bg = array('bg-01.png', 'bg-02.png' ); // array of filenames
    $i = rand(0, count($bg)-1); // generate random number size of the array
    $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen

    $qt = array('perdu(e)?', 'besoin d\'aide?', 'quoi choisir?' ); // array of titles
    $y = rand(0, count($qt)-1); // generate random number size of the array
    $selectedQt = "$qt[$y]"; // set variable equal to which random title was chosen

    echo $specialStyle;
    if(isset($_POST['tel'])) {
      $now = date('d-m-Y H:i');
      $tel = $_POST["tel"];
      $heure = $_POST["heure"];
      $savetel = $wpdb->query("INSERT INTO `$fb_tablename_tel` VALUES( '', '$_POST[tel]', '$now', '$_POST[heure]' )");
    }

    echo '<div id="butrappel" style="background: url('.get_bloginfo('stylesheet_directory').'/images/'.$selectedBg.'") no-repeat;><button class="closeButton"><i class="ion-ios-close-empty" aria-hidden="true"></i></button><a href="#rappel" class="open-popup-link">
    <h3>'.$selectedQt.'</h3>Un conseiller France-Banderole<br/> vous rappelle gratuitement</a></div>
    <div id="rappel" class="white-popup mfp-hide">
      <div class="modalContent">

        <h3>Un conseiller vous rappelle quand vous le souhaitez :</h3>
        <p>Entrez votre numéro de téléphone</p>
        <form action="" method="post" name="rappel" id="subrappel">
          <input type="text" name="tel" placeholder="téléphone" />
          <select name="heure" id="">
            <option value="dès que possible">Dès que possible</option>
            <option value="dans 10min">dans 10min</option>
            <option value="dans 30min">dans 30min</option>
            <option value="dans 1h">dans 1h</option>
          </select>
          <button name="subrappel" type="submit">Envoyer</button>
          <p><i class="fa fa-info-circle"></i> Nos conseillers sont là pour vous aider du lundi au vendredi de <strong>9 à 12h</strong> et de <strong>14 à 18h</strong><br />
          <small>- Votre n° de téléphone ne sera ni conservé, ni utilisé à des fin marketing -</small></p>
        </form>
      </div>
    </div>';
    //'.do_shortcode(' 	[ninja_form id=2] ').'

  }

  ?>
  <div id="footer2">

    <!--Lien réalisations-->
    <div class="lightboxGallery">
      <a class="gorea" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-17.jpg" title="kakemono 120x200cm"><i class="ion-images"></i></a><br />
      <!--galerie réalisations-->
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-04.jpg" title="banderole PVC géante 1000x160cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-06.jpg" title="kakemono "></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-05.jpg" title="banderole 400x80cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-07.jpg" title="impression bâche 600x250cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-08.jpg" title="calicot 350x90cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-18.jpg" title="kakemono 150x200cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-09.jpg" title="bâche imprimée 1000x100cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-10.jpg" title="banderole communication 300x80cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-11.jpg" title="banderolle 200x80cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-07.jpg" title="kakemonos"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-08.jpg" title="totems publicitaires"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-09.jpg" title="rollup"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-12.jpg" title="banderole publicité 150x100cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-13.jpg" title="banderoles PVC 400x80cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-01.jpg" title="kakemono roll-up"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-14.jpg" title="banderoles 700x60cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-15.jpg" title="kakemono hall d'entrée"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-16.jpg" title="kakemono salon exposition"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-17.jpg" title="kakemono 120x200cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-15.jpg" title="banderole de marché"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-16.jpg" title="banderole de foire"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-13.jpg" title="KAKEMONO"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-17.jpg" title="impression sur bache 16m x 1m"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-18.jpg" title="banderole intissée 400x80cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-19.jpg" title="banderole personnalisée"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-20.jpg" title="banderole PVC 500x50cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-21.jpg" title="impression sur bache 650x250cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-22.jpg" title="banderole exterieur PVC"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-23.jpg" title="bâches publicitaires"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-24.jpg" title="banderoles publicitaires"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-25.jpg" title="bache imprimée PVC 4mx1m"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-02.jpg" title="kakemono enrouleur"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-03.jpg" title="kakemonos publicitaires"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-04.jpg" title="totem 85x200cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-05.jpg" title="kakemono imprimé 80x200cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-10.jpg" title="roll-up"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-11.jpg" title="kakemonos enrouleurs"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-12.jpg" title="kakemono stand"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-14.jpg" title="KAKEMONOS"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-19.jpg" title="kakemono 100x200cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-20.jpg" title="kakemono écologique"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-21.jpg" title="impression kakemono"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-22.jpg" title="kakemono toile PVC"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-23.jpg" title="kakemono anti-feu"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-24.jpg" title="totem roll-up"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/kakemono-25.jpg" title="roll-up imprimés"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-06.jpg" title="banderoles fete fin d année"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-02.jpg" title="banderole de noel 400x100cm"></a>
      <a class="dis0" href="<?php bloginfo('url'); ?>/wp-content/uploads/2010/04/banderole-03.jpg" title="banderole publicitaire 250x103cm"></a>
    </div>

    <p class="exrea">Exemples de réalisations</p>
    <hr class="bottom_hr" />

    <div id="banners">

      <ul class="banner0">
        <h3><i class="fa fa-lightbulb-o"></i> Comment faire ?</h3>
        <li>- <a href="<?php bloginfo('url'); ?>/les-maquettes/" class="modal-link">les maquettes</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/un-devis/" class="modal-link">un devis</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/choisir-sa-bache/" class="modal-link">choisir sa bâche</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/choisir-son-kakemono/" class="modal-link">choisir son kakemono</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/telecharger-une-maquette/" class="modal-link">télécharger une maquette</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/payer-sa-commande/" class="modal-link">payer sa commande</a></li>
        <li>- <a href="<?php bloginfo('url'); ?>/etre-livre-rapidement/" class="modal-link">être livré rapidement</a></li>
      </ul>

      <!--charte écologique-->
      <a href="<?php bloginfo('url'); ?>/la-ceddre/" class="banner1 modal-link">
        <img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/ceddre.png" alt="impression banderole écologique" />
        <p>Charte éco-citoyenne<br /><i class="ion-leaf"></i> France Banderole</p>
      </a>



      <!--boutons contact, cgv... -->
      <div class="banner2">

          <a href="<?php bloginfo('url'); ?>/contact/" class="noticeFooter modal-link" title="contact"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>contact</span></a>
          <a href="<?php bloginfo('url'); ?>/france-banderole/" class="noticeFooter modal-link" title="qui est france banderole"><i class="fa fa-question" aria-hidden="true"></i> <span>Qui sommes nous</span></a>
          <a href="<?php bloginfo('url'); ?>/references/" class="noticeFooter modal-link" title="références"><i class="fa fa-address-book" aria-hidden="true"></i> <span>Références</span></a>
          <a href="<?php bloginfo('url'); ?>/cgv/" class="noticeFooter modal-link" title="conditions générales de vente"><i class="fa fa-money" aria-hidden="true"></i> <span>Conditions de vente</span></a>
          <a href="<?php bloginfo('url'); ?>/etre-livre-rapidement/" class="noticeFooter modal-link" title="être livré rapidement"><i class="fa fa-truck" aria-hidden="true"></i> <span>livraison</span></a>
          <a href="<?php bloginfo('url'); ?>/tarifs-revendeurs/" class="noticeFooter modal-link" title="tarifs revendeurs"><i class="fa fa-eur" aria-hidden="true"></i> <span>tarifs revendeurs</span></a>

      </div>

      <div class="clear"></div>


    </div>

    <!--derniers commentaires--->
    <div id="derniers">
      <?php
        $prefix = $wpdb->prefix;
        $fb_tablename_rating = $prefix."fbs_rating";
        $moyenne = $wpdb->get_row("SELECT AVG((fir+sec+thi)/3) AS moy FROM `$fb_tablename_rating`");
        $strmoyenne1 = round($moyenne->moy,2);
        $strmoyenne2 = "/5 - ";
        $total = $wpdb->get_row("SELECT COUNT(*) AS nb_avis FROM `$fb_tablename_rating` WHERE exist='true'");
        $strmoyenne3 = $total->nb_avis;
        $strmoyenne4 = " avis";
      ?>

      <div  itemscope itemtype="http://schema.org/AggregateRating" itemprop="aggregateRating">
        <h4 class="clients_reviews_titre"><span><a href="<?php bloginfo('url'); ?>/avis_france_banderole/">Avis Clients sur <span  itemprop="itemReviewed">France Banderole</span></a></span></h4>
        <div class="clients_reviews">
          <a href="<?php bloginfo('url'); ?>/avis_france_banderole/">
          <span class="client_reviews_1"  itemprop="ratingValue"><?php echo $strmoyenne1; ?></span>
          <span><?php echo $strmoyenne2; ?></span>
          <span  itemprop="ratingCount"><?php echo $strmoyenne3; ?></span>
          <span><?php echo $strmoyenne4; ?></span>
          <span class="star-note"><img src="<?php get_bloginfo("url"); ?>/wp-content/themes/fb/images/star-4_7.png" /></span><br />
          </a>
        </div>
      </div>

      <a href="<?php echo get_bloginfo("url"); ?>/avis_france_banderole/" class="floatRight"></a>
      <div id="ratinghome"><?php get_rating_home(); ?></div>
    </div>

  </div>

<!--Footer part3 (linking)----------------------------------------------------->

  <div id="footer3">
    <a href="#header" class="gotop" title="haut de page"><i class="ion-chevron-up"></i></a>
    <hr class="bottom_hr" />
    <span id="footer_links2">
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/">Accueil</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/banderoles/">Banderoles</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/roll-up/">Kakemono Roll Up</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/totem/">Kakemono Totem</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/stand-parapluie/">Stand parapluie</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/oriflammes/">Oriflammes</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/panneaux-forex-dibond/">panneaux forex dibond</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/panneaux-akilux/">panneaux akilux PVC</a> </span> <br />
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/tente-publicitaire-barnum/">Tentes publicitaires barnum</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/plv-intérieur/">PLV intérieur</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/plv-exterieur/">PLV exterieur</a> | </span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/stickers/">Adhésifs &amp; Stickers</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/flyers/">Flyers</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/affiches/">Affiches</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/cartes/">Cartes de visite</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/depliants/">Depliants</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/accessoires/">PROMOTIONS</a> |</span>
      <span class="split"><a href="<?php echo get_bloginfo("url"); ?>/contact/">contact</a></span>
    </span>

<!--Footer part4 (copyright)--------------------------------------------------->

    <div id="copy">
      <div class="copyright">
        <p class="bloc"><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/logoblanc.png" alt="logo france banderole" /><br /><span class="split">2008-2017 copyright</span> <span class="split">&copy; France Banderole SAS</span></p>
        <p class="bloc small"><span class="split">Images interdites de reproduction </span> - <span class="split"><a href="http://france-banderole.com" title="banderole" target="_blank">france-banderole.com</a></span  class="split"></p>
      </div>

      <h2 class="footer-keywords">Banderole - </h2>
      <h2 class="footer-keywords">Banderole publicitaire - </h2>
      <h2 class="footer-keywords">Impression banderole - </h2>
      <h2 class="footer-keywords">Impression banderoles - </h2>
      <h2 class="footer-keywords">Bache - </h2>
      <h2 class="footer-keywords">Fabricant banderole - </h2>
      <h2 class="footer-keywords">Banderole Marseille - </h2>
      <h2 class="footer-keywords">Bâche publicitaire - </h2>
      <h2 class="footer-keywords">Banderolle - </h2>
      <h2 class="footer-keywords">banderole Paris - </h2>
      <h2 class="footer-keywords">fabricant banderole - </h2>
      <h2 class="footer-keywords">kakemono - </h2>
      <h2 class="footer-keywords">kakemonos - </h2>
      <h2 class="footer-keywords">kakemonos publicitaire - </h2>
      <h2 class="footer-keywords">roll-up - rollup - enrouleur - </h2>
      <h2 class="footer-keywords">totem publicitaire - </h2>
      <h2 class="footer-keywords">totem banner - </h2>
      <h2 class="footer-keywords">rollups - </h2>
      <h2 class="footer-keywords">rolup - </h2>
      <h2 class="footer-keywords">stand enrouleur - </h2>
      <h2 class="footer-keywords">stand parapluie - </h2>
      <h2 class="footer-keywords">stand tissu - </h2>
      <h2 class="footer-keywords">stand exposition - </h2>
      <h2 class="footer-keywords">impression kakemono - </h2>
      <h2 class="footer-keywords">impression stand tissu easyquick - </h2>
      <h2 class="footer-keywords">impression bache grand format - </h2>
      <h2 class="footer-keywords">imprimerie grand format</h2>
    </div>
  </div>

</div>

<?php
}
?>

<?php
include('nom_du_fichier_de_conf.php');
?>

<?php wp_footer(); ?>

<!-- javascript  -------------------------------------------------------------->

    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.slides.min.js"></script> <!-- sliders pages produits -->
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.magnific-popup.min.js"></script> <!-- lightbox images -->
    <script src="<?php bloginfo('stylesheet_directory'); ?>/js/lity.min.js"></script> <!-- ouvre les iframes dans une lightbox -->

    <!--<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/html2canvas.min.js"></script>-->
    <!--<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/fabric.min.js"></script>-->

    <script type="text/javascript">
    if(!document.documentMode ){ // ne pas charger ce script sous IE (8-11)
      document.write('<script src="<?php bloginfo('stylesheet_directory'); ?>\/js\/dom-to-image.min.js"><\/script>');
    }
    </script>

    <!--<![endif]-->
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.spinner.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/promo.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/help.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js"></script> <!-- js global -->

    <!-- jquery ui seulement sur pages spécifiques ---------------------------->
    <?php if (is_page('vos-devis')){
			echo '<script src="'.get_bloginfo('stylesheet_directory').'/js/jquery-ui.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        $("#curseur").slider({
            value: 0,
            min: 0,
            max: 100,
            step: 1,
            slide: function( event, ui ) {
              $("#amount").val( ui.value );
            }
        });

        $("#amount").val($("#curseur").slider("value"));
      });
      </script>
      ';
		}else{

    }
		?>

    <!-- api google+ -->
    <?php
    if (strpos($_SERVER['REQUEST_URI'], 'vos-devis') == false) {?>
      <!-- Smartsupp Live Chat script -->
      <script type="text/javascript">
        var _smartsupp = _smartsupp || {};
        _smartsupp.key = 'aa96cf08ffab720bc4442f3af79d2257a0b5aac7';
        window.smartsupp||(function(d) {
        	var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
        	s=d.getElementsByTagName('script')[0];c=d.createElement('script');
        	c.type='text/javascript';c.charset='utf-8';c.async=true;
        	c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
        })(document);
      </script>
    <?php
    }
    ?>

    <!-- Google analytics -->
    <script type="text/javascript">
      var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-3325076-4']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();
    </script>

  </body>
</html>

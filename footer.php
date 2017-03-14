<?php
/**
* @package WordPress
* @subpackage Classic_Theme
*/
if (is_front_page() OR (1==1)) {
  ?>
  <script type="text/javascript" src="<?php bloginfo("url"); ?>/wp-content/uploads/shadowbox-js/cd4fb98ee8442d29f2a3dff0be2f9d3b.js?ver=3.0.3"></script>

  <script type="text/javascript">
  window.___gcfg = {lang: 'fr'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  </script>
</div>

<div id="main2">
  <div id="footer2">
    <hr class="bottom_hr" />

    <!--<div id="flink2"><a href="http://www.france-banderole.com/buralistes/"><img class="floatLeft"  src="<?php bloginfo('stylesheet_directory'); ?>/images/bt-buraliste2.png" alt="buraliste" /></a></div>-->

    <div id="derniers">
      <?php /*?>
      Moyenne des avis sur France banderole :<br />
      <strong><?php
      $prefix = $wpdb->prefix;
      $fb_tablename_rating = $prefix."fbs_rating";
      $moyenne = $wpdb->get_row("SELECT AVG((fir+sec+thi)/3) AS moy FROM `$fb_tablename_rating`");
      echo round($moyenne->moy,2);
      ?>/5</strong> pour <strong>
      <?php
      $total = $wpdb->get_row("SELECT COUNT(*) AS nb_avis FROM `$fb_tablename_rating` WHERE exist='true'");
      echo $total->nb_avis;
      ?> avis</strong>
      <?php */?>

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

      <h4 class="clients_reviews_titre"><span>Avis Clients sur France Banderole</span></h4>
      <div class="clients_reviews">
        <span class="client_reviews_1">
          <?php echo $strmoyenne1; ?>
        </span><?php echo $strmoyenne2 . $strmoyenne3 . $strmoyenne4; ?>


        <span class="star-note"><img src="<?php get_bloginfo("url"); ?>http://www.france-banderole.com/wp-content/themes/fb/images/star-4_7.jpg" /></span><br />

      </div>

      <a href="<?php echo get_bloginfo("url"); ?>/avis/" class="floatRight"></a>
    </div>
    <div id="ratinghome"><?php get_rating_home(); ?></div>
    <div id="footer3">
      <hr class="bottom_hr" />
      <span id="footer_links2"><a href="<?php echo get_bloginfo("url"); ?>/">Banderole</a> | <a href="<?php echo get_bloginfo("url"); ?>/kakemonos/">Kakemonos &amp; Roll Up</a> | <a href="<?php echo get_bloginfo("url"); ?>/banderoles/">Banderoles</a> | <a href="<?php echo get_bloginfo("url"); ?>/oriflammes/">Oriflammes</a> | <a href="<?php echo get_bloginfo("url"); ?>/stand-parapluie/">Stand parapluie</a> | <a href="<?php echo get_bloginfo("url"); ?>/plv-exterieur/">PLV exterieur</a> | <a href="<?php echo get_bloginfo("url"); ?>/panneaux-akilux-forex-dibond/">panneaux akilux forex dibond</a> |<a href="<?php echo get_bloginfo("url"); ?>/stickers/">Adhésifs &amp; Stickers</a> |<br />  <a href="<?php echo get_bloginfo("url"); ?>/accessoires/">PROMOTIONS</a>| <a href="<?php echo get_bloginfo("url"); ?>/france-banderole/">France Banderole</a> | <a href="<?php echo get_bloginfo("url"); ?>/realisation/">Impression grand format</a> | <a href="<?php echo get_bloginfo("url"); ?>/references/">Références</a> | <a href="<?php echo get_bloginfo("url"); ?>/cgv/">C.G.V.</a> | <a href="<?php echo get_bloginfo("url"); ?>/acces-client/">Accès Client</a> | <a href="<?php echo get_bloginfo("url"); ?>/top-ten/">Top Ten</a> | <a href="<?php echo get_bloginfo("url"); ?>/la-ceddre/">Nos Engagements</a> | <a href="<?php echo get_bloginfo("url"); ?>/contact/">Contact</a> | <a href="/imprimeur-numerique-discount-Paris-30840.html">Impression grand format Paris</a></span>
      <div id="copy">
        <p class="copyright">2008-2014 Copyright &copy; France banderole SAS - Images interdites de reproduction <a href="http://france-banderole.com" title="banderole" target="_blank">france-banderole.com</a></p>
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
        <h2 class="footer-keywords">imprimerie grand format</h2></div>
      </div>
    </div>
  </div>

  <?php
} else {
  ?>
  <script type="text/javascript">
  function mySbOpen(){
    var c = Shadowbox.getCurrent();
    var pageLink = c.link.ownerDocument.URL;
    if(pageLink.indexOf('?')>1){
      pageLink = pageLink.split('?')[0]
    }
    var link2image = pageLink+"?the_item="+c.link.shadowboxCacheKey;
    var newDiv = jQuery('<div id="sb-mylink">'+'</div>');
    if(jQuery('div#sb-mylink')!=null){
      jQuery('div#sb-mylink').remove();
    }
    newDiv.insertAfter(jQuery('div#sb-counter'));
    jQuery('a#printMe').click(function(){
      var theWork =  window.open('','PrintWindow');
      var html = "<html><head><title>Print An Image</title>";
      html = html + "<link rel='stylesheet' href='http://france-banderole.com/wp-content/plugins/shadowbox-js/shadowbox/shadowbox.css' type='text/css' /><style>#sb-info{display:none;}div#sb-wrapper{left:20px !important;top:40px !important}</style></head>";
      html = html + "<body><div id='myprint'>"+jQuery('#sb-container').clone().html()+"</div></body></html>";

      theWork.document.open();
      theWork.document.write(html);
      theWork.document.close();
      theWork.print();
      theWork.close()
      return false;
    });
  }
  </script><script type="text/javascript">
  var shadowbox_conf = {
    animate: true,
    animateFade: true,
    animSequence: "sync",
    autoDimensions: false,
    modal: false,
    showOverlay: true,
    overlayColor: "#000",
    overlayOpacity: 0.8,
    flashBgColor: "#000000",
    autoplayMovies: true,
    showMovieControls: true,
    slideshowDelay: 3.50,
    resizeDuration: 0.35,
    fadeDuration: 0.35,
    displayNav: true,
    continuous: false,
    displayCounter: true,
    counterType: "default",
    counterLimit: 10,
    viewportPadding: 20,
    handleOversize: "resize",
    handleUnsupported: "link",
    initialHeight: 160,
    initialWidth: 320,
    enableKeys: true,
    skipSetup: false,
    flashParams: {bgcolor:"#000000", allowFullScreen:true},
    flashVars: {},
    flashVersion: "9.0.0",
    onFinish: mySbOpen

  };
  Shadowbox.init(shadowbox_conf);
  </script>
</div>
<div id="main2">
  <div id="footer">
    <hr class="bottom_hr" />
    <a href="http://www.france-banderole.com/buralistes/"><img class="floatLeft"  src="<?php bloginfo('stylesheet_directory'); ?>/images/bt-buraliste2.png" alt="buraliste" /></a>
    <span id="footer_links">
      <a href="<?php echo get_bloginfo("url"); ?>/">Banderole</a> | <a href="<?php echo get_bloginfo("url"); ?>/kakemonos/">Kakemonos &amp; Roll Up</a> | <a href="<?php echo get_bloginfo("url"); ?>/banderoles/">Banderoles</a> | <a href="<?php echo get_bloginfo("url"); ?>/oriflammes/">Oriflammes</a> | <a href="<?php echo get_bloginfo("url"); ?>/stand-parapluie/">Stand parapluie</a> | <a href="<?php echo get_bloginfo("url"); ?>/plv-exterieur/">PLV exterieur</a><br /><a href="<?php echo get_bloginfo("url"); ?>/panneaux-akilux-forex-dibond/">Panneaux akilux forex dibond</a> |<a href="<?php echo get_bloginfo("url"); ?>/stickers/">Adhésifs &amp; Stickers</a> |  <a href="<?php echo get_bloginfo("url"); ?>/accessoires/">PROMOTIONS</a>| <a href="<?php echo get_bloginfo("url"); ?>/france-banderole/">France Banderole</a> | <a href="<?php echo get_bloginfo("url"); ?>/realisation/">Impression grand format</a><br /><a href="<?php echo get_bloginfo("url"); ?>/references/">Références</a> | <a href="<?php echo get_bloginfo("url"); ?>/cgv/">C.G.V.</a> | <a href="<?php echo get_bloginfo("url"); ?>/acces-client/">Accès Client</a> | <a href="<?php echo get_bloginfo("url"); ?>/top-ten/">Top Ten</a> | <a href="<?php echo get_bloginfo("url"); ?>/la-ceddre/">Nos Engagements</a> | <a href="<?php echo get_bloginfo("url"); ?>/contact/">Contact</a>
    </span>
    <div id="copy">2008 - 2015 Copyright &copy; France banderole SAS - Images interdites de reproduction <a href="http://france-banderole.com" title="banderole" target="_blank">france-banderole.com</a><br/>
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
      <h2 class="footer-keywords">imprimerie grand format</h2></div>
    </div>
  </div>

  <?php
}
?>

<?php
include('nom_du_fichier_de_conf.php');
?>
<div id="mainnew" align="center"><h2><a href="http://www.express-impression.com" title="imprimeur pas cher rapide banderole kakemono flyers depliants" target="_blank" >Imprimeur numérique grand format</a></h2></div>

<?php wp_footer(); ?>

<script>jQuery.noConflict();</script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

<script>
jQuery(document).ready(function ($) {
  //img flip plugin
  $(function(){
      $("#top_info").flip({
          trigger: 'hover',
          axis: 'y'
      });
  });

  //toggle
  $('.toggle-button').click(function() {
    $('.toggle-block').slideToggle('slow');
  });
});
</script>

</body>
</html>

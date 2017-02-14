<?php
/*
Template Name: Page Buraliste
*/

get_template_part('header-buralistes');

?>

    
<div class="main">
<?php 
	if ( have_posts() ) while ( have_posts() ) { 

		the_post(); 

		the_content(); 
		
	} 
?>




    <div class="m-btm">
    	<p>(*) prix généralement constaté </p>
    </div>
</div> <!-- /main -->
    
    <footer>
    	<div class="foot-lft">
        	<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="logo">
            <p>2008 - 2014 Copyright &copy; France banderole SAS</p>
        </div>
      <div class="foot-mid">
      	<div class="f-line"></div>
        <div class="f-line-rgt"></div>
       	<address>
            	<strong>Passez votre commande par téléphone : </strong><br>
                <span>0442 401 401</span><br><br>
                <strong>Passez votre commande par courrier : </strong><br>
                Imprimez directement votre bon de commande<br>
                <a href="http://www.france-banderole.com/wp-content/themes/fb/images/bondecommande.pdf" target="_blank">en cliquant ici</a>
          </address>
        </div>
        <div class="foot-rgt">
        	<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/f-logo-1.png" alt=""></a>
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/f-logo-2.png" alt=""></a>
        </div>
        <div class="cb"></div>
    </footer>
</div> <!-- /wrapper -->
<script type="text/javascript" src="<?php bloginfo("url"); ?>/wp-content/uploads/shadowbox-js/cd4fb98ee8442d29f2a3dff0be2f9d3b.js?ver=3.0.3"></script>
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
<script type="text/javascript">
  window.___gcfg = {lang: 'fr'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

</body>
</html>

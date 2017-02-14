<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
get_header();
?>
<div id="content"><div id="content_bg_top"><div id="content_zawartosc">

<?php 
$email_to_use = addslashes(htmlentities(filter_input(INPUT_GET, 'unsubscribe')));

//echo "email=".$email_to_use;

if($email_to_use!=""){
	global $wpdb;
	$wpdb->insert(
		"wp_stop_nl",
		array(
			'id' => NULL,
			'email' => $email_to_use
		),
		array(
			'%d',
			'%s'
		)
	);

//exit( var_dump( $wpdb->last_query ) );
	  ?>
  
		  <h1>Vous êtes maintenant désinscrit de la newsletter.</h1>
		  <script>
			  setInterval(function() {
				  window.location.href = "/";
			  }, 2500);
		  </script>
	  <?php

}

?>


<div style="clear:both"></div>
</div></div></div>


<?php get_footer(); ?>

<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
get_header();
include_once(ABSPATH . '/fbshop/fb_admin_expedition.php');
$id_utilisateur_expedition = 4;
?>
<div id="content"><div id="content_bg_top"><div id="content_zawartosc">

<?php 
the_content();

/* !Expeditions!2015% */
/* On appelle la fonction que si l'utilisateur est loggué et que son ID = 4 */
if ( ! post_password_required() ) {

if(is_user_logged_in() && $id_utilisateur_expedition == get_current_user_id()){
	 fb_admin_expedition();
}else{	
	wp_login_form();
}

}else{
echo "Saisir le mot de passe pour l'expédition des commandes...";	
}
?>


<div style="clear:both"></div>
</div></div></div>


<?php get_footer(); ?>

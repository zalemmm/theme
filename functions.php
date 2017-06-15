<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
automatic_feed_links();

if(!function_exists('getPageContent'))
{
	function getPageContent($pageId)
	{
		if(!is_numeric($pageId))
		{
			return;
		}

		global $wpdb;
		$sql_query = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
		' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
		$posts = $wpdb->get_results($sql_query);

		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				return $post->post_content;
			}
		}
	}
}

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => '',
	));
add_theme_support( 'post-thumbnails' );
remove_action('wp_head', 'wp_generator');
remove_filter('wp_head', 'wp_widget_recent_comments_style' );
function remove_wp_widget_recent_comments_style() {
	if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style' );
	}
}
add_filter( 'wp_head', 'remove_wp_widget_recent_comments_style', 1 );

add_image_size('thumb2', 238, 145, true);

function get_another_images($id) {
	$return = '';
	$c = get_post_meta($id, 'Photos', false);
	if ($c) {
		$return = '<div class="tab_container">';
		$x=0;
		foreach($c as $pic) {
			$x++;
			$img_mini = wp_get_attachment_image_src($pic, $size='thumb2');
			$img_full = wp_get_attachment_image_src($pic, $size='full');
			$return .= '<div id="tab'.$x.'" class="tab_content"><img src="'.$img_mini[0].'" alt="'.get_the_title().'" /></div>';
		}
		$count = $x+1;
	$return .= '</div>';
	$return .= '<script type="text/javascript">jQuery(document).ready(function() { var newsinterval = 0; var interid = 1; var ncurid = 1; var curid = 1; var activeTab = jQuery("#tab1"); jQuery(".tab_content").hide(); jQuery(".tab_content:first").show(); function productpageSlideshow() { window.clearInterval(newsinterval); interid = ncurid+1; if (interid < '.$count.') { newsinterval = window.setInterval(function(){changeSlide(interid);},3000); } } function changeSlide(id) { jQuery("#tab"+ncurid).fadeOut(300); jQuery("#tab"+ncurid).hide(); jQuery("#tab"+id).fadeIn(); ncurid = id; productpageSlideshow(); } productpageSlideshow(); });</script>';
	}
	return $return;
}

function get_opis_wartosc($id, $p) {
	return get_post_meta($id, $p, true);
}

$home = false;
$url_test = $_SERVER['REQUEST_URI'];
if($url_test == "/index.php" || $url_test == "/"){
	$home = true;
}

if (!is_admin() && $home == false) {
function modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_bloginfo("template_url").'/js/jquery-3.1.1.min.js', false, '3.1.1'); // en cas de probleme revenir à jquery.191.min.js
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');
}

?>

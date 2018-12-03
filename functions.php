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

function show_favicon() {
	if( $_GET['page'] == 'ari-adminer-run-adminer' )
	echo '<link href="'.get_bloginfo("stylesheet_directory").'/images/datab.png" rel="icon" type="image/png">';
	else if( strpos( $_GET['page'], 'fb' ) !== false  )
	echo '<link href="'.get_bloginfo("stylesheet_directory").'/images/fbshop.png" rel="icon" type="image/png">';
	else if( $_GET['action'] == 'edit' )
	echo '<link href="'.get_bloginfo("stylesheet_directory").'/images/pencil.png" rel="icon" type="image/png">';
	else
  echo '<link href="'.get_bloginfo("stylesheet_directory").'/images/favadm.png" rel="icon" type="image/png">';
}
add_action('admin_head', 'show_favicon');

//add_action('admin_init', 'filter_the_plugins');
function filter_the_plugins() {
    global $current_user;
    if ($current_user->display_name == '3') {
			activate_plugins(
        array(
          '/html-editor-syntax-highlighter/html-editor-syntax-highlighter.php',
					'/wp-emmet/wp-emmet.php'
        ),
        '', // redirect url, does not matter (default is '')
        false, // network wise
        true // silent mode (no activation hooks fired)
      );
    } else { // activate for those than can use it
			deactivate_plugins( // deactivate for media_manager
				array(
					'/html-editor-syntax-highlighter/html-editor-syntax-highlighter.php',
					'/wp-emmet/wp-emmet.php'
				),
				true, // silent mode (no deactivation hooks fired)
				false // network wide
			);
    }
}


?>

<?php
/**
* @package WordPress
* @subpackage Classic_Theme
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="keywords" content="Banderole, Banderoles, Banderole publicitaire,  banderole de, banderole d', banderoles publicitaires, bache, baches, bâche, bâches, calicot, calicots, kakemono, kakemonos, banderole de pub, banderole de marché, banderole de foire, banderole exposition, forain, banderole evenementiel, banderole de communication, communication, banderole de publicité, banderole+paris, banderole+lyon, banderole+marseille, banderole+lille, banderole+strasbourg, banderole+auxerre, banderole+montpellier, banderole+toulouse, banderole+beziers, banderole+perpignan, banderole+dijon, banderole+metz, banderole+bordeaux, pas cher " />
	<meta name="Author" content="france banderole" />
	<meta name="Publisher" content="france banderole" />
	<meta name="Copyright" content="france banderole" />

	<link rel="icon" type="image/png" href="http://www.france-banderole.com/wp-content/themes/fb/images/favicon.png" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="favicon.ico" /><![endif]-->

	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<style type="text/css" media="screen">@import url( <?php echo bloginfo("template_url") ?>/css/style.css?d=11062012 );</style>
	<style type="text/css" media="screen">@import url( <?php echo bloginfo("template_url") ?>/motscles.css?d=11062012 );</style>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/pokaz.js"></script>
	<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/styleie.css" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" />
	<script type="text/javascript">var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-3325076-4']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })(); </script>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<!--<script type="text/javascript">document.oncontextmenu = function(){return false;};		</script>-->
	<?php
	if (isset($_GET['detail'])) { ?>
		<link rel="stylesheet" href="<?php bloginfo("url") ?>/wp-content/plugins/fbshop/js/juploader/css/jquery.fileupload-ui.css" />
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<?php } ?>

	</head>

	<body>

		<div id="main">

			<div id="header">

				<a href="<?php bloginfo('url'); ?>/index.php" id="logo" title="fabricant banderole"></a>

				<div class="site-head">
					<div class="site-title">France Banderole</div>
					<div class="site-subtitle">La qualité sans en payer le prix</div>
				</div>

				<ul class="menu-client">
					<li class="menu-client-item item1">
						<span class="menu-client-icon phone"><i class="fa fa-phone" aria-hidden="true"></i></span>

						<span class="menu-client-label tel1">Nos téléconseillers</span><br />
						<span class="menu-client-label tel2">0442 401 401</span><br />
						<span class="menu-client-label tel3">9h-12h | 14h-18h</span>
					</li>
					<li class="menu-client-item menu-client--devis">
						<span class="menu-client-icon"><a href="<?php bloginfo('url'); ?>/vos-devis/"><i class="fa fa-lock" aria-hidden="true"></i></a></span>
						<span class="menu-client-label"><a href="<?php bloginfo('url'); ?>/vos-devis/">Espace Client</a></span>
					</li>
					<li class="menu-client-item menu-client--panier">
						<span class="menu-client-icon"><a href="<?php bloginfo('url'); ?>/votre-panier/"><?php echo getCartCount(); ?> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></span>
						<span class="menu-client-label"><a href="<?php bloginfo('url'); ?>/votre-panier/">Panier</li></a></span>
				</ul>

				<ul id="menu_top">
					<li onmouseover="pokazt('produit_sub');" onmouseout="ukryjt('produit_sub');"><a href="<?php bloginfo('url'); ?>/index.php"<?php if(is_page('Accueil')) echo ' id="active"'; ?>>Tarifs en ligne</a>

						<ul id="produit_sub">
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/banderoles/" class="menu_sub"<?php if(is_page('banderoles')) echo ' id=active_sub'; ?>>banderole</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/roll-up/" class="menu_sub"<?php if(is_page('roll-up')) echo ' id=active_sub'; ?>>roll-up</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/totem/" class="menu_sub"<?php if(is_page('totem')) echo ' id=active_sub'; ?>>totem</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/stickers/" class="menu_sub"<?php if(is_page('stickers')) echo ' id=active_sub'; ?>>sticker</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/oriflammes/" class="menu_sub"<?php if(is_page('oriflammes')) echo ' id=active_sub'; ?>>oriflamme</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/panneaux-forex-dibond/" class="menu_sub"<?php if(is_page('panneaux-forex-dibond')) echo ' id=active_sub'; ?>>enseigne</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/panneaux-akilux/" class="menu_sub"<?php if(is_page('panneaux-akilux')) echo ' id=active_sub'; ?>>panneau akilux</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/plv-interieur/" class="menu_sub"<?php if(is_page('plv-interieur')) echo ' id=active_sub'; ?>>plv intérieur</a></li>
							<li><a href="<?php bloginfo('url'); ?>/plv-exterieur/" class="menu_sub"<?php if(is_page('plv-exterieur')) echo ' id=active_sub'; ?>>plv extérieur</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/stand-parapluie/" class="menu_sub"<?php if(is_page('stand-parapluie')) echo ' id=active_sub'; ?>>stand parapluie</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/flyers/" class="menu_sub"<?php if(is_page('flyers')) echo ' id=active_sub'; ?>>flyer</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/affiches/" class="menu_sub"<?php if(is_page('affiches')) echo ' id=active_sub'; ?>>affiche</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/cartes/" class="menu_sub"<?php if(is_page('cartes')) echo ' id=active_sub'; ?>>carte de visite</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/depliants/" class="menu_sub"<?php if(is_page('depliants')) echo ' id=active_sub'; ?>>dépliant</a></li>

						</ul>
					</li>

					<li onmouseover="pokazt('comment_sub');" onmouseout="ukryjt('comment_sub');"><a href="<?php bloginfo('url'); ?>/les-maquettes/"<?php if(is_page('les-maquettes') || is_page('un-devis') || is_page('choisir-sa-bache') || is_page('choisir-son-kakemono') || is_page('telecharger-une-maquette') || is_page('payer-sa-commande') || is_page('etre-livre-rapidement') || is_page('tarifs-revendeurs')) echo ' id="active"'; ?>>comment faire?</a>
						<ul id="comment_sub">
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/les-maquettes/" class="menu_sub"<?php if(is_page('les-maquettes')) echo ' id=active_sub'; ?>>les maquettes</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/un-devis/" class="menu_sub"<?php if(is_page('un-devis')) echo ' id=active_sub'; ?>>un devis</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/choisir-sa-bache/" class="menu_sub"<?php if(is_page('choisir-sa-bache')) echo ' id=active_sub'; ?>>choisir sa bâche</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/choisir-son-kakemono/" class="menu_sub"<?php if(is_page('choisir-son-kakemono')) echo ' id=active_sub'; ?>>choisir son kakemono</a></li>
							<li class="highest"><a href="<?php bloginfo('url'); ?>/france-banderole/telecharger-une-maquette/" class="menu_sub2"<?php if(is_page('telecharger-une-maquette')) echo ' id=active_sub'; ?>>télécharger une maquette</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/payer-sa-commande/" class="menu_sub"<?php if(is_page('payer-sa-commande')) echo ' id=active_sub'; ?>>payer sa commande</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/etre-livre-rapidement/" class="menu_sub"<?php if(is_page('etre-livre-rapidement')) echo ' id=active_sub'; ?>>être livré rapidement</a></li>
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/tarifs-revendeurs/" class="menu_sub"<?php if(is_page('tarifs-revendeurs')) echo ' id=active_sub'; ?>>tarifs revendeurs</a></li>
						</ul>
					</li>
					<li onmouseover="pokazt('qui_sub');" onmouseout="ukryjt('qui_sub');"><a href="<?php bloginfo('url'); ?>/france-banderole/"<?php if(is_page('france-banderole') || is_page('cgv') || is_page('realisation') || is_page('references')) echo ' id="active"'; ?>>QUI SOMMES-NOUS</a>
						<ul id="qui_sub">
							<li><a href="<?php bloginfo('url'); ?>/france-banderole/" class="menu_sub"<?php if(is_page('france-banderole')) echo ' id=active_sub'; ?>>FRANCE BANDEROLE</a></li>
							<li><a href="<?php bloginfo('url'); ?>/la-ceddre/" class="menu_sub"<?php if(is_page('la-ceddre')) echo ' id="active_sub"'; ?>>Charte écocitoyenne</a></li>
							<li><a href="<?php bloginfo('url'); ?>/realisation/" class="menu_sub"<?php if(is_page('realisation')) echo ' id=active_sub'; ?>>Réalisation</a></li>
							<li><a href="<?php bloginfo('url'); ?>/references/" class="menu_sub"<?php if(is_page('references')) echo ' id=active_sub'; ?>>Références</a></li>
							<li><a href="<?php bloginfo('url'); ?>/avis/" class="menu_sub"<?php if(is_page('avis')) echo ' id="active_sub"'; ?>>Avis France Banderole</a></li>
							<li><a href="<?php bloginfo('url'); ?>/cgv/" class="menu_sub"<?php if(is_page('cgv')) echo ' id=active_sub'; ?>>C.G.V.</a></li>
						</ul>
					</li>
					<?php if (is_cart_not_empty()) {
						$link = get_bloginfo("url").'/votre-panier/';
					} else {
						$link = get_bloginfo("url").'/vos-devis/';
					}
					?>
					<li><a href="<?php bloginfo('url'); ?>/contact/"<?php if(is_page('contact')) echo ' id="active"'; ?>>CONTACT</a></li>
				</ul>
				<!--	<form name="search" id="search" method="get" action="<?php bloginfo('url'); ?>">
				<input type="text" name="s" value="RECHERCHER" onfocus="if (this.value == 'RECHERCHER') {this.value = ''; this.style.color = '#000000';}" onblur="if (this.value == '') {this.value = 'RECHERCHER';this.style.color = '#e88c07';}" />
				<input type="submit" id="submit_search" value="" />
			</form>-->

			<a href="<?php bloginfo('url'); ?>/vos-devis/" id="corner_button"></a>
			<a href="<?php bloginfo('url'); ?>/votre-panier/" id="corner_button_cart"><?php echo getCartCount(); ?><i class="fa fa-shopping-cart" aria-hidden="true"></i>
</a>
		</div>

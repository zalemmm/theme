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
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

		<style type="text/css" media="screen">@import url( <?php echo bloginfo("template_url") ?>/css/style.css?d=11062012 );</style> <!--feuille de style globale-->
		<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/wp-content/themes/fb/images/favicon.png" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.css"> <!-- lightbox pour les iframes, pdf, etc.-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"> <!-- lightbox pour les images -->
		<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" /> <!--feuille de style pour le print-->
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php wp_head(); ?>
	</head>

	<body>

		<div id="main">

			<div id="header">

				<!-- Publicités sur les côtés -->
				<?php
				if(is_page('oriflammes') || is_page('banderoles') || is_page('plv-exterieur') || is_page('tente-publicitaire-barnum')) {
					echo '<div class="izoneLeft"><a href="'.get_bloginfo('url').'/tente-publicitaire-barnum"><img class="iz1"  src="'.get_bloginfo("template_url").'/images/promoTentes.png" title="promo tentes" alt="promo tente publicitaire"></a></div>';
					echo '<div class="izoneRight"><a href="'.get_bloginfo('url').'/oriflammes"><img class="iz1" src="'.get_bloginfo("template_url").'/images/promoGoutte.png" title="promo oriflamme beachflag" alt="promo oriflamme"></a></div>';
				}else if(is_page('stand-parapluie') || is_page('roll-up') || is_page('totem')) {
					echo '<div class="izoneLeft"><a href="'.get_bloginfo('url').'/roll-up"><img class="iz1"  src="'.get_bloginfo("template_url").'/images/promoRollup.png" title="promo Rollup" alt="promo kakemono rollup"></a></div>';
					echo '<div class="izoneRight"><a href="'.get_bloginfo('url').'/totem"><img class="iz1" src="'.get_bloginfo("template_url").'/images/promoXscreen.png" title="promo oriflamme" alt="promo oriflamme"></a></div>';
				}else{
					echo '<div class="izoneLeft"><a href="'.get_bloginfo('url').'/stand-parapluie"><img class="iz1"  src="'.get_bloginfo("template_url").'/images/promoStand.png" title="promo stand tissu" alt="promo stand tissu"></a></div>';
					echo '<div class="izoneRight"><a href="'.get_bloginfo('url').'/oriflammes"><img class="iz1" src="'.get_bloginfo("template_url").'/images/promoOriflamme.png" title="promo oriflamme" alt="promo oriflamme"></a></div>';
				}
				?>

				<!-- LOGO -->
				<a href="<?php bloginfo('url'); ?>/index.php" id="logo" title="fabricant banderole"></a>

				<div class="site-head">
					<div class="site-title"><a href="<?php bloginfo('url'); ?>/index.php">France Banderole</a></div>
					<div class="site-subtitle">La qualité sans en payer le prix</div>
				</div>

				<!-- MENU CLIENT -->
				<ul class="menu-client">

					<li class="menu-client-item item1">
						<div class="menu-client-icon phone"><a href="tel:+33442401401"><i class="fa fa-phone" aria-hidden="true"></i></a></div>
						<div class="menu-client-phone">
							<span class="menu-client-label tel1 split">Nos téléconseillers</span><br />
							<span class="menu-client-label tel2 split"><a href="tel:+33442401401">0442 401 401</a></span>
							<span class="menu-client-label tel3 split">9h-12h | 14h-18h</span>
						</div>
					</li>

					<li class="menu-client-item menu-client--devis">
						<span class="menu-client-icon"><a href="<?php bloginfo('url'); ?>/vos-devis/"><i class="fa fa-lock" aria-hidden="true"></i></a></span>
						<span class="menu-client-label">Espace Client</span>
					</li>

					<li class="menu-client-item menu-client--panier">
						<span class="menu-client-icon"><a href="<?php bloginfo('url'); ?>/votre-panier/"><?php echo getCartCount(); ?> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></span>
						<span class="menu-client-label">Panier</span>
					</li>
					</ul>

					<!-- MENU GLOBAL -->
					<ul id="menu_top">
						<li onmouseover="pokazt('produit_sub');" onmouseout="ukryjt('produit_sub');"><a href="<?php bloginfo('url'); ?>/index.php"<?php if(is_page('Accueil')) echo ' id="active"'; ?>>Tarifs en ligne</a>

							<ul id="produit_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/banderoles/" class="menu_sub"<?php if(is_page('banderoles')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-banderole.png" alt="banderoles">banderole</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/roll-up/" class="menu_sub"<?php if(is_page('roll-up')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-roll-up.png" alt="kakemono roll-up">roll-up</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/totem/" class="menu_sub"<?php if(is_page('totem')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-totem.png" alt="kakemono totem">totem</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/stand-parapluie/" class="menu_sub"<?php if(is_page('stand-parapluie')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stand.png" alt="stand expo parapluie">stand parapluie</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/oriflammes/" class="menu_sub"<?php if(is_page('oriflammes')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-oriflamme.png" alt="oriflammes, beachflags, windflags">oriflamme</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/panneaux-forex-dibond/" class="menu_sub"<?php if(is_page('panneaux-forex-dibond')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-enseigne.png" alt="panneau forex dibond">enseigne</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/panneaux-akilux/" class="menu_sub"<?php if(is_page('panneaux-akilux')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-panneau.png" alt="panneau akilux PVC">panneau akilux</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/tente-publicitaire-barnum/" class="menu_sub"<?php if(is_page('tente-pliante-exposition')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-tentes.png" alt="tentes publicitaires barnum">tente publicitaire Barnum</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/plv-interieur/" class="menu_sub"<?php if(is_page('plv-interieur')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-PLV-int.png" alt="plv intérieur">plv intérieur</a></li>
								<li><a href="<?php bloginfo('url'); ?>/plv-exterieur/" class="menu_sub"<?php if(is_page('plv-exterieur')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-PLV-ext.png" alt="plv extérieur">plv extérieur</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/stickers/" class="menu_sub"<?php if(is_page('stickers')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stickers.png" alt="stickers, autocollants, vitrophanie">sticker</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/flyers/" class="menu_sub"<?php if(is_page('flyers')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-flyer.png" alt="flyers">flyer</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/affiches/" class="menu_sub"<?php if(is_page('affiches')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-affiche.png" alt="affiches">affiche</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/cartes/" class="menu_sub"<?php if(is_page('cartes')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-carte.png" alt="cartes de visite">carte de visite</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/depliants/" class="menu_sub"<?php if(is_page('depliants')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-depliant.png" alt="dépliants">dépliant</a></li>

							</ul>
						</li>

						<li onmouseover="pokazt('comment_sub');" onmouseout="ukryjt('comment_sub');"><a href="<?php bloginfo('url'); ?>/les-maquettes/"<?php if(is_page('les-maquettes') || is_page('un-devis') || is_page('choisir-sa-bache') || is_page('choisir-son-kakemono') || is_page('telecharger-une-maquette') || is_page('payer-sa-commande') || is_page('etre-livre-rapidement') || is_page('tarifs-revendeurs')) echo ' id="active"'; ?>>comment faire?</a>

							<ul id="comment_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/les-maquettes/" class="menu_sub"<?php if(is_page('les-maquettes')) echo ' id=active_sub'; ?>>les maquettes</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/un-devis/" class="menu_sub"<?php if(is_page('un-devis')) echo ' id=active_sub'; ?>>un devis</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/choisir-sa-bache/" class="menu_sub"<?php if(is_page('choisir-sa-bache')) echo ' id=active_sub'; ?>>choisir sa bâche</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/choisir-son-kakemono/" class="menu_sub"<?php if(is_page('choisir-son-kakemono')) echo ' id=active_sub'; ?>>choisir son kakemono</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/telecharger-une-maquette/" class="menu_sub"<?php if(is_page('telecharger-une-maquette')) echo ' id=active_sub'; ?>>télécharger une maquette</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/payer-sa-commande/" class="menu_sub"<?php if(is_page('payer-sa-commande')) echo ' id=active_sub'; ?>>payer sa commande</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/etre-livre-rapidement/" class="menu_sub"<?php if(is_page('etre-livre-rapidement')) echo ' id=active_sub'; ?>>être livré rapidement</a></li>
								<li><a href="<?php bloginfo('url'); ?>/france-banderole/tarifs-revendeurs/" class="menu_sub"<?php if(is_page('tarifs-revendeurs')) echo ' id=active_sub'; ?>>tarifs revendeurs</a></li>
							</ul>
						</li>

						<li onmouseover="pokazt('qui_sub');" onmouseout="ukryjt('qui_sub');"><a href="<?php bloginfo('url'); ?>/france-banderole/"<?php if(is_page('france-banderole') || is_page('cgv') || is_page('realisation') || is_page('references')) echo ' id="active"'; ?>>QUI SOMMES-NOUS</a>

							<ul id="qui_sub" class="menu_hover">
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


			</div>

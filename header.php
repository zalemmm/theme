<?php
/**
* @package WordPress
* @subpackage Classic_Theme
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">

		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="keywords" content="Banderole, Banderoles, Banderole publicitaire,  banderole de, banderole d', banderoles publicitaires, bache, baches, bâche, bâches, calicot, calicots, kakemono, kakemonos, banderole de pub, banderole de marché, banderole de foire, banderole exposition, forain, banderole evenementiel, banderole de communication, communication, banderole de publicité, banderole+paris, banderole+lyon, banderole+marseille, banderole+lille, banderole+strasbourg, banderole+auxerre, banderole+montpellier, banderole+toulouse, banderole+beziers, banderole+perpignan, banderole+dijon, banderole+metz, banderole+bordeaux, pas cher " />
		<meta name="Author" content="france banderole" />
		<meta name="Publisher" content="france banderole" />
		<meta name="Copyright" content="france banderole" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

		<style type="text/css" media="screen">@import url( <?php echo bloginfo("template_url") ?>/css/style.css?v=2.92 );</style> <!--feuille de style globale-->

		<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/lity.min.css"> <!-- lightbox pour les iframes, pdf, etc.-->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/magnific-popup.css"> <!-- lightbox pour les images -->
		<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/css/print.css" /> <!--feuille de style pour le print-->
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php if (is_page('vos-devis')){
			echo '<link rel="stylesheet" href="'.get_bloginfo('stylesheet_directory').'/css/jquery-ui.min.css">';
		}
		?>
		<?php wp_head(); ?>

	</head>

	<body>

		<div class="loader">
			<i class="fa fa-circle-o-notch fa-spin" style="font-size:100px"></i>
		</div>

		<header id="header">

			<div class="izoneLeft"><div class="izoneInL"></div></div>
			<div class="izoneRight"><div class="izoneInR"></div></div>

			<a href="<?php bloginfo('url'); ?>/index.php" id="logo" title="fabricant banderole"></a>

			<div class="site-head">
				<div class="site-title"><a href="<?php bloginfo('url'); ?>/index.php">France Banderole</a></div>
				<div class="site-subtitle">La qualité sans en payer le prix</div>
			</div>

			<div class="navContainer">

				<nav>
					<ul class="menu-client">

						<!--phone-->
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
							<span class="menu-client-label">Espace client</span>

							<ul id="acclient_sub" class="menu_hover">
							<?php
								session_start();
								$logstatus = '<i class="fa fa-unlock-alt" aria-hidden="true"></i> Vous n\'êtes pas connecté';
								$login = $_POST['loginname'];
								$pass = $_POST['loginpass'];
								$user = $wpdb->get_row("SELECT * FROM `$fb_tablename_users` WHERE login='$login' AND pass='$pass'");
								$name = $_SESSION['loggeduser'];
								//echo 'user -> ' .$_COOKIE['user'];

								if (fb_is_logged()) {
									$acclient = '<p class="bonjour">Bienvenue '.stripslashes($name->f_name).' !</p>
									<a href="'.get_bloginfo('url').'/inscription/" class="bt_compte">Mon compte</a> | <a href="'.get_bloginfo('url').'/vos-devis/" class="bt_compte">Mes commandes</a>
									<a href="'.get_bloginfo('url').'/?logout=true" class="bt_deconnect">Se déconnecter </a>';

									$logstatus = '<i class="fa fa-lock" aria-hidden="true"></i> Bonjour '.stripslashes($name->f_name).' | Vous êtes connecté';

								}else if ($_POST['logme']=='logme') {
									$acclient = '<p class="bonjour">Bienvenue '.$login.' !</p>
									<a href="'.get_bloginfo('url').'/inscription/" class="bt_compte">Mon compte</a> | <a href="'.get_bloginfo('url').'/vos-devis/" class="bt_compte">Mes commandes</a>
									<a href="'.get_bloginfo('url').'/?logout=true" class="bt_deconnect">Se déconnecter </a>';

									$logstatus = '<i class="fa fa-lock" aria-hidden="true"></i> Bonjour '.$login.' | Vous êtes connecté';

								}else{
									$acclient = '<form id="loginform" name="loginform" method="post" action="'.get_bloginfo('url').'/vos-devis/">
									<input type="hidden" name="logme" value="logme" />
									<label class="loginlabel_sub" for="loginname">nom d\'utilisateur:</label>
									<input class="logininput_sub" type="text" name="loginname" />
									<label class="loginlabel_sub" for="loginpass">mot de passe:</label>
									<input class="logininput_sub"type="password" name="loginpass" />
									<button class="bt_connect" type="submit">Se connecter</button>
									</form>
									<a href="'.get_bloginfo('url').'/acces-client/?resend=pass" class="bt_bottom">Mot de passe oublié ?</a> |
									<a href="'.get_bloginfo('url').'/inscription" class="bt_bottom"> Pas encore inscrit ?</a>';
								}
								echo $acclient;
							?>
							</ul>

						</li>

						<li class="menu-client-item menu-client--panier" id="menuPanier">
							<span class="menu-client-icon"><a href="<?php bloginfo('url'); ?>/votre-panier/"><span class="cartCount"><?php echo getCartCount(); ?></span> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></span><span class="menu-client-label">Panier</span>

							<ul id="panier_sub" class="menu_hover">
							<?php
							if (is_cart_not_empty()) {
								$products = $_SESSION['fbcart'];
								$user = $_SESSION['loggeduser'];
								$panier .= '';
								$licznik = 0;
								$totalHT = 0;
								foreach ( $products as $products => $item ) {
									$licznik++;
									$pict = '';
									if(!empty($item['image'])) {
										$pict = '<img src="'.$item['image'].'" alt="image produit" class="prodpicCart" />';
									}
									$panier .= '<div class="ct_item">
										<span class="ct_itname">'.$pict.$item['rodzaj'].'</span>
										<span class="ct_qte">'.$item['ilosc'].'</span>
										<span class="ct_total">'.$item['total'].'</span>
										<form name="delcart_form" id="delcart_form" action="'.get_bloginfo('url').'/votre-panier/" method="post"><input type="hidden" name="delfromcart" value="delfromcart" /><input type="hidden" name="rodzaj" value="'.$item['rodzaj'].'" /><input type="hidden" name="opis" value="'.$item['opis'].'" /><input type="hidden" name="ilosc" value="'.$item['ilosc'].'" /><input type="hidden" name="licznik" value="'.$licznik.'" />
										<button id="delcart" type="submit">DEL</button>
										</form>
									</div>';
									$totalItems = str_replace(',', '.', $item['total']);
									$totalHT = $totalHT + $totalItems;
									$fraisPort = $fraisPort + $item['transport'];
								}
								$totalHT = $totalHT + $fraisPort;
								$panier .='<span class="ct_totalt">Total HT: '.$totalHT.' &euro;</span>
									<a href="'.get_bloginfo('url').'/votre-panier/" class="bt_deconnect">Voir mon panier </a>
								';
							} else {
								$panier .= '<p class="emptyCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></p> <p>Votre panier est vide !</p>';
							}
							echo $panier;
							?>
							</ul>
						</li>
					</ul>

					<ul id="menu_top">
					<!--<a href="<?php bloginfo('url'); ?>/index.php"><img class="logoSmall" src="https://www.france-banderole.com/wp-content/themes/fb/images/logoSmall.png" alt="logo france banderole" /></a>-->

						<!--<li onmouseover="tipShow('band_sub');" onmouseout="tipHide('band_sub');"><a href="<?php bloginfo('url'); ?>/index.php">Banderoles & bâches</a>-->
						<li><a href="<?php bloginfo('url'); ?>/banderoles/" <?php if(is_page('banderoles')) echo ' id=active'; ?>>Banderoles<br /> & bâches</a>
							<!--<ul id="band_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/banderoles/" class="menu_sub"<?php if(is_page('banderoles')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-banderole.png" alt="banderoles">banderole</a></li>
								<li><a href="<?php bloginfo('url'); ?>/choisir-sa-bache/" class="menu_sub"<?php if(is_page('choisir-sa-bache')) echo ' id=active_sub'; ?>>choisir sa bâche</a></li>
							</ul>-->
						</li>

						<li onmouseover="tipShow('plv_sub');" onmouseout="tipHide('plv_sub');"><a href="<?php bloginfo('url'); ?>/stand-exposition-plv-interieur/" <?php if(is_page('stand-exposition-plv-interieur') || is_page('roll-up') || is_page('totem') || is_page('stand-parapluie') || is_page('nappes-publicitaires') || is_page('plv-interieur') || is_page('cadre-tissu') || is_page('enseigne-suspendue-textile')) echo ' id="active"'; ?>>Stand Expo <br />& PLV</a>

							<ul id="plv_sub" class="menu_hover">

								<li><a href="<?php bloginfo('url'); ?>/cadre-tissu/" class="menu_sub"<?php if(is_page('cadre-tissu')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-cadre.png" alt="cadre textile plv pas cher">Cadre textile</a></li>
								<li><a href="<?php bloginfo('url'); ?>/enseigne-suspendue-textile/" class="menu_sub"<?php if(is_page('enseigne-suspendue-textile')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-susp.png" alt="enseignes suspendues pas cher">Enseigne suspendue textile</a></li>

								<li><a href="<?php bloginfo('url'); ?>/roll-up/" class="menu_sub"<?php if(is_page('roll-up')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-roll-up.png" alt="kakemono roll-up">roll-up</a></li>
								<li><a href="<?php bloginfo('url'); ?>/totem/" class="menu_sub"<?php if(is_page('totem')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-totem.png" alt="kakemono totem">totem</a></li>

								<li><a href="<?php bloginfo('url'); ?>/stand-parapluie/" class="menu_sub"<?php if(is_page('stand-parapluie')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stand.png" alt="stand expo parapluie">stand parapluie</a></li>
								<li><a href="<?php bloginfo('url'); ?>/nappes-publicitaires/" class="menu_sub"<?php if(is_page('nappes-publicitaires')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-nappes.png" alt="dépliants">nappe publicitaire</a></li>
								<li><a href="<?php bloginfo('url'); ?>/plv-interieur/" class="menu_sub"<?php if(is_page('plv-interieur')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-PLV-int.png" alt="plv intérieur">plv intérieur</a></li>
							</ul>
						</li>

						<li onmouseover="tipShow('ext_sub');" onmouseout="tipHide('ext_sub');"><a href="<?php bloginfo('url'); ?>/signaletique-exterieur" <?php if(is_page('signaletique-exterieur') || is_page('oriflammes') || is_page('tente-publicitaire-barnum') || is_page('panneaux-alu-dibond') || is_page('panneaux-akilux') || is_page('plv-exterieur') || is_page('panneaux-forex-3mm') || is_page('panneaux-forex-5mm') || is_page('panneaux-alu-dibond') || is_page('panneaux-akilux-3_5mm') || is_page('panneaux-akilux-3mm') || is_page('panneaux-akilux-5mm') || is_page('pvc-300-microns')) echo ' id="active"'; ?>>Signalétique extérieur</a>

							<ul id="ext_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/oriflammes/" class="menu_sub"<?php if(is_page('oriflammes')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-oriflamme.png" alt="oriflammes, beachflags, windflags">oriflamme</a>
								</li>

								<li><a href="<?php bloginfo('url'); ?>/tente-publicitaire-barnum/" class="menu_sub" <?php if(is_page('tente-publicitaire-barnum')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-tentes.png" alt="tentes publicitaires barnum">tente publicitaire Barnum</a>
								</li>

								<li><a href="<?php bloginfo('url'); ?>/panneaux-alu-dibond/" class="menu_sub"<?php if(is_page('panneaux-alu-dibond')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-enseigne.png" alt="panneau forex dibond">enseigne</a>
									<div class="menu-details">
										<a href="<?php bloginfo('url'); ?>/panneaux-forex-3mm/">Forex 3mm</a>
										<a href="<?php bloginfo('url'); ?>/panneaux-forex-5mm/">Forex 5mm</a>
										<a href="<?php bloginfo('url'); ?>/panneaux-alu-dibond/">Dibond</a>
										<a href="<?php bloginfo('url'); ?>/panneaux-komadur/">Kömadur</a>
									</div>
								</li>

								<li><a href="<?php bloginfo('url'); ?>/panneaux-akilux/" class="menu_sub" <?php if(is_page('panneaux-akilux')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-panneau.png" alt="panneau akilux PVC">panneau akilux</a>
									<div class="menu-details">
										<a href="<?php bloginfo('url'); ?>/panneaux-akilux-3mm/">3mm</a>
										<a href="<?php bloginfo('url'); ?>/panneaux-akilux-3_5mm/">3.5mm</a>
										<a href="<?php bloginfo('url'); ?>/panneaux-akilux-5mm/">5mm</a>
										<a href="<?php bloginfo('url'); ?>/pvc-300-microns/">PVC</a>
									</div>
								</li>

								<li><a href="<?php bloginfo('url'); ?>/plv-exterieur/" class="menu_sub"<?php if(is_page('plv-exterieur')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-PLV-ext.png" alt="plv extérieur">plv extérieur</a></li>
							</ul>
						</li>

						<li onmouseover="tipShow('sti_sub');" onmouseout="tipHide('sti_sub');"><a href="<?php bloginfo('url'); ?>/stickers/" <?php if(is_page('stickers') || is_page('autocollant') || is_page('sticker-predecoupe') || is_page('sticker-lettrage-predecoupe') || is_page('vitrophanie') || is_page('sticker-mural')) echo ' id=active'; ?>>Stickers & autocollants</a>

							<ul id="sti_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/autocollant/" class="menu_sub"<?php if(is_page('autocollant')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-autocollant.png" alt="stickers, autocollants, vitrophanie">autocollant</a></li>
								<li><a href="<?php bloginfo('url'); ?>/sticker-predecoupe/" class="menu_sub"<?php if(is_page('sticker-predecoupe')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stickers-predecoupe.png" alt="stickers, autocollants, vitrophanie">sticker prédécoupé</a></li>
								<li><a href="<?php bloginfo('url'); ?>/sticker-lettrage-predecoupe/" class="menu_sub"<?php if(is_page('sticker-lettrage-predecoupe')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stickers-lettrage-predec.png" alt="stickers, autocollants, vitrophanie">sticker lettrage</a></li>
								<li><a href="<?php bloginfo('url'); ?>/vitrophanie/" class="menu_sub"<?php if(is_page('vitrophanie')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-vitrophanie.png" alt="stickers, autocollants, vitrophanie">vitrophanie</a></li>
								<li><a href="<?php bloginfo('url'); ?>/sticker-mural/" class="menu_sub"<?php if(is_page('stickers-mural')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-stickers-mur.png" alt="stickers, autocollants, vitrophanie">sticker mural</a></li>
							</ul>
						</li>

						<li onmouseover="tipShow('pap_sub');" onmouseout="tipHide('pap_sub');"><a href="<?php bloginfo('url'); ?>/imprimerie-papier"<?php if(is_page('imprimerie-papier') || is_page('affiches') || is_page('cartes') || is_page('flyers')) echo ' id="active"'; ?>>Imprimerie<br /> papier <span class="dn960">& affiches</span></a>

							<ul id="pap_sub" class="menu_hover">
								<li><a href="<?php bloginfo('url'); ?>/affiches/" class="menu_sub"<?php if(is_page('affiches')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-affiche.png" alt="affiches">affiche</a></li>
								<li><a href="<?php bloginfo('url'); ?>/cartes/" class="menu_sub"<?php if(is_page('cartes')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-carte.png" alt="cartes de visite">carte de visite</a></li>
								<li><a href="<?php bloginfo('url'); ?>/flyers/" class="menu_sub"<?php if(is_page('flyers')) echo ' id=active_sub'; ?>><img src="<?php bloginfo('url'); ?>/wp-content/themes/fb/images/btm/bt-flyer.png" alt="flyers">flyer - dépliant</a></li>
							</ul>
						</li>

						<li><a href="<?php bloginfo('url'); ?>/contact/" <?php if(is_page('contact')) echo ' id=active'; ?>>Nous <br /> Contacter</a>
						</li>

						<?php if (is_cart_not_empty()) {
							$link = get_bloginfo("url").'/votre-panier/';
						} else {
							$link = get_bloginfo("url").'/vos-devis/';
						}
						?>

						<!--<li><a href="<?php bloginfo('url'); ?>/contact/"<?php if(is_page('contact')) echo ' id="active"'; ?>>CONTACT</a></li>-->
					</ul>
				</nav>
			</ul>

			<!-- Button trigger modal
			<a href="#test-popup" class="open-popup-link">Show inline popup</a>-->

			<div id="cartConfirm" class="white-popup mfp-hide">
				<div class="modalContent">
					<?php
					$products = $_SESSION['fbcart'];
					$lastit = array_values(array_slice($products, '-1'))[0];
					$pic = '';
					if(!empty($lastit['image'])) $pic = '<img class="prodpicModal" src="'.$lastit['image'].'" alt="image produit" /><br />';
					if ($lastit['ilosc'] == 1) $qtit = '';
					else $qtit = ' (<span class="small">x</span>'.$lastit['ilosc'].') ';
					$confirm = 	$pic.'Votre '.$lastit['rodzaj'].$qtit.' a bien été ajouté(e) au panier.';


					//-----------------------------------------------définition catégories
					if(is_page('roll-up') || is_page('test-roll-up') ) $cat='Roll';             if(is_page('banderoles')) $cat='Banderole';       if(is_page('nappes-publicitaires')) $cat='Nappe';
					if(is_page('stand-parapluie')) $cat='Stand';    if(is_page('totem')) $cat='Totem';                if(is_page('oriflammes')) $cat='Oriflamme';
					if(is_page('affiches')) $cat='Affiche';         if(is_page('panneaux-alu-dibond')) $cat='Dibond';     if(is_page('panneaux-komadur')) $cat='Komadur';   if(is_page('tente-publicitaire-barnum')) $cat='Tente';
					if(is_page('flyers')) $cat='Flyer';             if (is_page('depliants')) $cat='Depliant';        if(is_page('cartes')) $cat='Cartes';
					if(is_page('cadre-tissu')) $cat='Cadre';        if (is_page('enseigne-suspendue-textile')) $cat='Enseigne';
					if(is_page('panneaux-forex-3mm') || is_page('panneaux-forex-5mm')) $cat='Forex';                  if(is_page('pvc-300-microns')) $cat='PVC';
					if(is_page('panneaux-akilux-3mm') || is_page('panneaux-akilux-3_5mm') || is_page('panneaux-akilux-5mm')) $cat='Akilux';
					if(is_page('autocollant') || is_page('sticker-predecoupe') || is_page('sticker-lettrage-predecoupe') || is_page('vitrophanie') || is_page('sticker-mural')) $cat='Sticker';

					//---------------------------------------------------------temp popups
					if(is_page('promotions') || is_page('nappes-publicitaires') || is_page('totem') || is_page('plv-interieur') || is_page('cadre-tissu') || is_page('enseigne-suspendue-textile')) {
						$view = '
						<div class="box_info">Pour la communication et publicités sur lieu de vente en intérieur, salons, expositions, retrouvez tous nos produits dans les rubriques:</div>
						<ul class="modalMore">
							<li><a href="'.get_bloginfo('url').'/roll-up/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-roll-up.png" alt="roll-up"><br />roll-up</a></li>
							<li><a href="'.get_bloginfo('url').'/totem/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-totem.png" alt="roll-up"><br />totem</a></li>
							<li><a href="'.get_bloginfo('url').'/nappes-publicitaires/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-nappes.png" alt="banderoles"><br />Nappe</a></li>
							<li><a href="'.get_bloginfo('url').'/stand-exposition-plv-interieur/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-merge-int.png" alt="roll-up"><br />stand expo & plv</a></li>
						</ul>';
					}else if(is_page('banderoles') || is_page('oriflammes') || is_page('plv-exterieur')) {
						$view = '
            <div class="box_info">Pour vos évènements et communication en extérieur retrouvez tous nos produits dans les rubriques:</div>
						<ul class="modalMore">
							<li><a href="'.get_bloginfo('url').'/banderoles/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-banderole.png" alt="roll-up"><br />banderoles</a></li>
							<li><a href="'.get_bloginfo('url').'/tente-publicitaire-barnum/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-tentes.png" alt="roll-up"><br />tente barnum</a></li>
							<li><a href="'.get_bloginfo('url').'/oriflammes/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-oriflamme.png" alt="roll-up"><br />oriflamme</a></li>
							<li><a href="'.get_bloginfo('url').'/plv-exterieur/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-PLV-ext.png" alt="banderoles"><br />PLV</a></li>
						</ul>';
					}else	if(is_page('flyers') || is_page('depliants') || is_page('cartes') || is_page('affiches')) {
						$confirm = 'Vos '.$lastit['rodzaj'].' ont bien été ajouté(<span class="small">e</span>)s au panier.';
						$view = '
            <div class="box_info">Retrouvez toute notre gamme impression papier dans les rubriques:</div>
						<ul class="modalMore">
							<li><a href="'.get_bloginfo('url').'/flyers/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-flyer.png" alt="roll-up"><br />flyers</a></li>
							<li><a href="'.get_bloginfo('url').'/depliants/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-depliant.png" alt="roll-up"><br />dépliants</a></li>
							<li><a href="'.get_bloginfo('url').'/cartes/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-carte.png" alt="roll-up"><br />cartes</a></li>
							<li><a href="'.get_bloginfo('url').'/affiches/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-affiche.png" alt="banderoles"><br />affiche</a></li>
						</ul>';
					}else if(is_page('panneaux-akilux-3mm') || is_page('panneaux-akilux-3_5mm') || is_page('panneaux-akilux-5mm') || is_page('pvc-300-microns') || is_page('panneaux-forex-3mm') || is_page('panneaux-forex-5mm') || is_page('panneaux-alu-dibond')  || is_page('panneaux-komadur') || is_page('autocollant') || is_page('sticker-predecoupe') || is_page('sticker-lettrage-predecoupe') || is_page('vitrophanie') || is_page('sticker-mural')) {
						$view = '
           <div class="box_info">Dévouvrez tous nos supports de signalisation muraux, vitraux, extérieur et intérieur dans les rubriques:</div>
						<ul class="modalMore">
							<li><a href="'.get_bloginfo('url').'/panneaux-akilux/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-panneau.png" alt="roll-up"><br />Akilux</a></li>
							<li><a href="'.get_bloginfo('url').'/panneaux-alu-dibond/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-enseigne.png" alt="roll-up"><br />Enseignes</a></li>
							<li><a href="'.get_bloginfo('url').'/stickers/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-stickers.png" alt="roll-up"><br />stickers</a></li>
							<li><a href="'.get_bloginfo('url').'/banderoles/" class="modalSub"><img src="'.get_bloginfo('url').'/wp-content/themes/fb/images/btm/bt-banderole.png" alt="roll-up"><br />banderoles</a></li>
						</ul>';
					//---------------------------------------------popup produits connexes
					}else{
						$view = '<div class="box_info">Avec ce produit, nos clients ont également choisi en complément :</div>
						<ul class="modalMore">'.get_accessoires($cat).'</ul>';
					}

					?>


					<h3 id="nomp" class="popTitle"><?php echo $confirm ?></h3>
					<div class="btBar">
						<a href="<?php bloginfo('url'); ?>/votre-panier/" class="btModal">Voir mon panier</a>
						<button class="btModal btContinue">Continuer mes achats</button>
					</div>
					<?php echo $view ?>
				</div>
			</div>

		<?php
		global $wpdb;
		$prefix = $wpdb->prefix;
		$fb_tablename_users_cf = $prefix."fbs_users_cf";
		$fb_tablename_users_co = $prefix."fbs_users_co";
		$user = $_SESSION['loggeduser'];
		$id = $user->f_name;
		$uid = $user->id;
		$revendeur = $wpdb->get_row("SELECT * FROM `$fb_tablename_users_cf` WHERE att_value = 'compte revendeur' AND uid = '$uid'");
		$exco = $wpdb->get_row("SELECT * FROM `$fb_tablename_users_co` WHERE uid = '$uid'");
		$log = '';

		//------------------------------------------ check user connecté / revendeur
		if ($user) {
			if ($revendeur) {
				if      ($exco->sign == 0 && $exco->coli == 0) $rev = 'noremise';
				else if ($exco->sign == 1 && $exco->coli == 0) $rev = 'revendeurRS';
				else if ($exco->sign == 0 && $exco->coli == 1) $rev = 'revendeurRC';
				else if ($exco->sign == 1 && $exco->coli == 1) $rev = 'revendeur';
				$logstatus = '<i class="fa fa-lock" aria-hidden="true"></i> Bonjour '.$id.' | vous êtes connecté en tant que <span id="'.$rev.'">revendeur</span>';
			}
			else {
				$logstatus = '<i class="fa fa-lock" aria-hidden="true"></i> Bonjour '.$id.' | vous êtes connecté';
			}
		} else {

		}

		echo '<div class="log_info">'.$logstatus.'<div>';

		?>

		</header>


		<!--<div class="box_warn noprint"><button class="closeButton"><i class="ion-ios-close-empty" aria-hidden="true"></i></button><p><span class="pink">Chers clients, veuillez prendre en compte nos congés d'hiver :<br /></span>  Nous serons fermés<strong> du 25/12 au 02/01 inclus</strong>. Vos commandes express ou demandes urgentes seront traitées par notre service commercial online si besoin. <br />Toute l'équipe de france banderole vous souhaite de joyeuses fêtes de fin d'année</p></div>-->

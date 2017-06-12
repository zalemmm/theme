<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>France Banderole :: La qualité sans en payer le prix</title>
<link href="<?php echo get_template_directory_uri(); ?>/buralistes.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body>

<div class="wrapper">
    <header>
        <div class="h-top">
            <div class="logo">
                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="logo"></a>
            </div>
            <div class="logo-buraliste">
                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-buraliste.png" alt=""></a>
            </div>
        </div>
        <div class="cb"></div>
        <div class="kit-animation">
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/kit-animation.png" alt="kit animation"></a>
        </div>
    </header> <!-- /header -->
    
    <nav>
        <div class="nav-lft">
            <p>Nos téléconseillers<br><span>04 42 401 401</span></p>
            <div class="icon-tel"></div>
        </div>
        <div class="nav-mid">
            <p>La Confédération et  la Coopérative des buralistes ont sélectionné  France Banderole pour l’impression des PLV et supports publicitaires des buralistes.</p>
        </div>
        <div class="nav-rgt">
            <a href="/votre-panier/"><div class="vair-btn"></div></a>
            <div class="cart-txt"><?php echo getCartCount(); ?></div>
            <a href="/votre-panier/"><div class="icon-cart"></div></a>
        </div>
    </nav> <!-- /nav -->
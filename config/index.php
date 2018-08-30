<?php
  session_start();
  // -----------------------------------------------connexion à la bdd wordpress
  define( 'SHORTINIT', true );
  require( '../../../../wp-load.php' );
  global $wpdb;
  $prefix = $wpdb->prefix;
  $fb_tablename_maquette = $prefix."fbs_maquette";

  //-------------------------------------------------------------------variables
  $path = $_SERVER['DOCUMENT_ROOT'];
  $nbcom = $_GET['number'];
  $nbname = $_GET['name'];
  $nbdesc = $_GET['desc'];
  $nbh = $_GET['hauteur'];
  $nbl = $_GET['largeur'];
  $verso = $_GET['verso'];
  $ref = $_GET['ref'];
  $_SESSION['nbcom'] = $nbcom;
  $_SESSION['nbname'] = $nbname;
  $_SESSION['nbdesc'] = $nbdesc;
  $_SESSION['nbh'] = $nbh;
  $_SESSION['nbl'] = $nbl;
  $_SESSION['ref'] = $ref;

  // cas particuliers

  $find = '/verso/';
  $rectoVerso = preg_match_all($find, $nbdesc, $resultat);
  $rectoVerso = count($resultat[0]);

  $find2 = '/minia3/';
  $minia3 = preg_match_all($find2, $nbdesc, $resultat2);
  $minia3 = count($resultat2[0]);

  $find3 = '/minia4/';
  $minia4 = preg_match_all($find3, $nbdesc, $resultat3);
  $minia4 = count($resultat3[0]);

  $find4 = '/fourreaux haut/';
  $fhb = preg_match_all($find4, $nbdesc, $resultat4);
  $fhb = count($resultat4[0]);

  $find5 = '/fourreaux gauche/';
  $fgd = preg_match_all($find5, $nbdesc, $resultat5);
  $fgd = count($resultat5[0]);

  //---------------------création d'un numéro unique maquette pour la sauvegarde
  $saveref = $nbcom.'-'.$nbname.$nbh.'x'.$nbl.'-'.$verso.$ref;
  $_SESSION['saveref'] = $saveref;

  //------------------------- vérifier s'il existe une sauvegarde de la maquette
  // dans la bdd
  $maquette = $wpdb->get_row("SELECT * FROM `$fb_tablename_maquette` WHERE item = '$saveref'");
  // dans le json
  $from = (__DIR__).'/../../../../uploaded/'.$nbcom.'/'.$saveref.'.json';

  if (!file_exists($from) && !$maquette){
    $save = 'non';
    $json = '';
  }elseif (file_exists($from)){
    $save = 'oui';
    $json = file_get_contents($from);
  }elseif($maquette) {
    $save = 'oui';
    $json = $maquette->json;
  }

  $dashdesc = 'Gardez vos textes, logos à l\'intérieur des pointillés gris (marge technique).';

  if ($nbname == 'Nappe') $dashdesc = 'A l\'intérieur des pointillés: votre visuel plateau, à l\'extérieur placez les éléments à imprimer sur la retombée de la nappe.';
  if ($nbname == 'Stand Tissu') $dashdesc = 'Les pointillés englobent le visuel frontal, l\'espacement à gauche et à droite représentent les retours cotés.';
  if ($fgd >= 1) $dashdesc = 'Les espaces à gauche et à droite des pointillés représentent le repli de matière des fourreaux: attention ce que vous placerez ici ne sera pas visible!';
  if ($fhb >= 1) $dashdesc = 'Les espaces au dessus et au dessous des pointillés représentent le repli de matière des fourreaux: attention ce que vous placerez ici ne sera pas visible!';
  //----------------------------------------------------------------------------
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Créez votre maquette en ligne - France-Banderole.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="msapplication-TileColor">
  <meta name="theme-color">

  <!-- Google Analytics -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-3325076-4', 'auto');
  ga('send', 'pageview');
  </script>
  <!-- End Google Analytics -->

  <link href='https://fonts.googleapis.com/css?family=Lato:400,300|Source+Sans+Pro:400,700,700i,900|Architects+Daughter|Roboto|Oswald|Montserrat|Lora|PT+Sans|Ubuntu|Roboto+Slab|Fjalla+One|Indie+Flower|Playfair+Display|Poiret+One|Dosis|Oxygen|Lobster|Play|Shadows+Into+Light|Pacifico|Dancing+Script|Kaushan+Script|Gloria+Hallelujah|Black+Ops+One|Lobster+Two|Satisfy|Pontano+Sans|Domine|Russo+One|Handlee|Courgette|Special+Elite|Amaranth|Vidaloka' rel='stylesheet' type='text/css'>

  <!-- CSS Start -->
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" >
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="css/normalize.css" >
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" >
  <link rel="stylesheet" type="text/css" href="css/ng-scrollbar.min.css" >
  <link rel="stylesheet" type="text/css" href="css/style.css" >
  <link rel="stylesheet" type="text/css" href="css/fonts.css" >
  <link rel="stylesheet" type="text/css" href="css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" type="text/css" href="css/angular-material.css">
  <link rel="icon" href="images/favicon.png" type="image/png">
  <!-- CSS End -->

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body id="body">

<div class="container ng-scope" ng-controller="ProductCtrl" ng-app="productApp" id="productApp">
    <!--<div ng-show="loading" class="loading">
        <h1 class="lodingMessage">Initialisation<img src="images/ajax-loader.gif" alt="loading" /></h1>
    </div>-->
    <div class="row clearfix" ng-cloak>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 editor_section">
            <div id="content" class="tabing">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a ng-click="deactivateAll()" href="#Products" class="products" data-toggle="tab"><i class="fa fa-info-circle"></i>Info</a></li>
                    <li><a ng-click="deactivateAll()" href="#Graphics" class="graphics" data-toggle="tab"><i class="fa fa-picture-o" aria-hidden="true"></i>Image</a></li>
                    <li><a ng-click="deactivateAll()" href="#Text" class="text" data-toggle="tab"><i class="fa fa-font" aria-hidden="true"></i>Texte</a></li>
                    <li><a ng-click="layers()" href="#Layers"  class="calques" data-toggle="tab" data-toggle="tab"><i class="fa fa-object-ungroup"></i>Calques</a></li>
                </ul>
                <div id="my-tab-content" class="tab-content action_tabs">
                    <div class="tab-pane active clearfix" id="Products">
                      <h5>commande n° <span id="number"><?php echo $nbcom;?></span></h5>

                      <div class="encart">
                        <h2 id="produit"><?php echo $nbname; ?></h2>
                        <p>Gabarit <?php
                          if ($minia3 >= 1){echo 'A3';}
                          if ($minia4 >= 1){echo 'A4';} ?>
                          <span id="hauteur"><?php echo $nbh; ?></span> x <span id="largeur"><?php echo $nbl; ?></span> cm
                          <?php if ($rectoVerso >= 1){
                            if ($verso != 1) {
                              echo '<span id="rectvers">Recto</span>';
                            }else if ($verso == 1){
                              echo '<span id="rectvers">Verso</span>';
                            }else{}
                          } ?>
                          <span class="sauvegarde">
                             / sauvegarde: <span id="saved"><?php echo $save; ?></span>
                            <span id="json"><?php echo $json; ?></span>
                            <span id="rset">non</span>
                          </span>
                        </p>

                      </div>

                        <h4>Créez votre maquette en quelques clics:</h4>
                        <span id="desc" style="display:none;"><?php echo $nbdesc; ?></span>
                        <div class="aide">

                          <div class="intro">
                            <p><span>1</span> Vous pouvez commencer par cliquer sur votre gabarit pour changer sa couleur de fond </p>
                            <p><span>2</span> Importez vos <strong><i class="fa fa-picture-o" aria-hidden="true"></i> images</strong> et entrez du <strong><i class="fa fa-font" aria-hidden="true"></i> texte</strong> à l'aide des boutons ci-dessus  </p>
                            <p><span>3</span> Agencez vos calques : un simple clic dessus pour les déplacer, les redimentionner, etc. <br />
                              Dans <strong><i class="fa fa-object-ungroup"></i> calques</strong> vous pouvez gérer l'ordre de superposition de vos éléments</p>
                            <p><span>4</span> Lorsque vous êtes satisfait de votre création, cliquez sur <br /><strong><i class="fa fa-send"></i> envoyer </strong> pour nous la transmettre.</p>
                            <p><i class="fa fa-warning" style="color:#ea2a6a"></i> L'envoi peut prendre quelques minutes, attendez le message de confirmation avant de quitter l'application !</p>

                            <p class="dashed"><?php echo $dashdesc; ?></p>

                            <!-- modal mode avancé -->
                            <div id="avance" class="modal" tabindex="-1" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                                                    <h4 class="h4adv alert alert-info">Mode utilisateur avancé :</h4>
                                                    <p class="alert alert-info">
                                                        <strong>Le mode utilisateur avancé</strong> vous permet de manipuler librement votre maquette dans l'espace de travail (zoom / déplacement). Utiles pour travailler avec plus de précision, ces manipulations peuvent cependant causer des décalages de mise en page à l'enregistrement. Pour les éviter, veuillez suivre les instructions ci-dessous.<br />
                                                    </p>
                                                    <p class="alert alert-info">
                                                        <strong>Avant d'enregister votre maquette en mode avancé</strong>, assurez-vous de la disposer de manière à ce qu'elle soit <strong>entièrement visible</strong> dans l'espace de travail : '<i class="fa fa-object-group"></i> Tout sélectionner' vous permet de déplacer tous vos calques ensemble sans décaler la mise en page. Si besoin, réduire le zoom ou appuyez sur le bouton <i class="fa fa-undo"></i> de l'outil zoom pour revenir à la taille initiale.
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- fin modal mode avancé -->

                            <!-- modal astuces -->
                            <div id="faq" class="modal" tabindex="-1" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="alert alert-info"><i class="fa fa-question-circle"></i> Astuces / FAQ</h4>
                                                    <p class="alert alert-warning">
                                                        <i class="fa fa-warning"></i> <strong>attention si vous importez vos images dans cette application:</strong> Les images que vous importez doivent être d'assez haute résolution pour une impression de bonne qualité. Cependant pour des raisons de charge serveur et pour garantir la sauvegarde de votre maquette il est important de ne pas surcharger cette application: il est donc conseillé de ne pas en importer plus de 2/3 idéalement (5 max suivant les résolutions) et de privilégier au maximum les ressources intégrées à l'application (textes, formes, icones etc). Vous pouvez par contre importer sans limite des ressources au format 'svg': ce type d'image est redimentionnable sans souci de charge serveur et de résolution. Si votre composition requier d'importer beaucoup d'images de type 'jpeg' ou 'png', il est vivement conseillé de passer par une solution logicielle type Photoshop.
                                                    </p>

                                                    <p  class="alert alert-info">
                                                        <strong>J'ai sauvegardé ma maquette mais lorsque je rouvre l'application elle n'apparait pas et plus rien ne fonctionne</strong>
                                                        Celà peut se produire si vous avez importé plusieurs images d'assez grosse résolution. Pour débloquer le configurateur contactez un conseiller par commentaire dans votre espace client et demandez la réinitialisation de votre maquette. Reportez-vous au paragraphe précédent pour savoir comment mieux gérer votre composition et vos images importées.
                                                    </p>

                                                    <p  class="alert alert-info">
                                                        <strong>J'ai déjà envoyé ma maquette mais je souhaiterais la modifier :</strong><br /> Il est plutôt conseillé de bien vérifier sa maquette avant l'envoi mais la modification après est tout à fait possible puisqu'une sauvegarde est faite automatiquement, veuillez alors :<br />
                                                        - soit directement après l'envoi rafraichir la page<br />
                                                        - soit depuis votre accès client cliquer sur le bouton "finir la maquette" ou le bouton de l'élément (recto/verso par ex.) que vous souhaitez modifier.<br />
                                                        Faites vos modifications, renvoyez votre fichier, puis retournez dans votre accès client pour nous écrire un commentaire indiquant que vous avez modifié votre maquette et de prendre en compte votre fichier le plus récent.
                                                    </p>

                                                    <p class="alert alert-info">
                                                        <strong>Lorsque vous envoyez votre maquette, attendez le message confirmation </strong> avant de fermer l'application. Votre maquette sera ensuite contrôlée par un infographiste qui vous la retournera sous forme de BAT à valider.
                                                    </p>

                                                    <p class="alert alert-info">
                                                        <strong>Les pointillés gris / marge grise :</strong> ce calque est indicatif et sera automatiquement retiré à l'enregistrement. Il sert de repère pour vos textes ou logos et éviter qu'ils soient tronqués à l'impression. <br>
                                                        <strong>Pour le produit actuel:</strong>  <?php echo $dashdesc; ?>
                                                    </p>

                                                    <p  class="alert alert-info">
                                                        <strong>L'application ne fonctionne pas !</strong><br /> Cette application est conçue pour être utilisée sur un ordinateur avec une résolution d'écran minimum de  1280x720 pixels, avec un navigateur récent (ex: fonctionne bien avec Edge mais pas Internet Explorer). Si vous remarquez des anomalies, essayez de mettre votre navigateur à jour ou installez les dernières versions de Chrome ou Firefox pour lesquels notre application est optimisée.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- fin modal astuces -->

                            <button class="astuces" data-toggle="modal" data-target="#faq"><i class="fa fa-question-circle"></i> Plus d'astuces / FAQ</button>
                          </div><!-- fin div intro -->

                        </div><!-- fin modal aide -->


                    </div><!-- fin modal astuces -->

                    <div class="tab-pane clearfix" id="Graphics">

                    <div class="graphic_options clearfix">
                        <ul>
                            <li class="butLoad col-lg-4 col-md-4 col-sm-4 col-xs-6 active">
                                <div>
                                    <a class="" href="#clip_arts" aria-controls="clip_arts" role="tab" data-toggle="tab" ng-click="exitDrawing()">
                                        <i class="fa  fa-smile-o"></i>
                                        <span>Formes & icones</span>
                                    </a>
                                </div>
                            </li>
                            <li class="butLoad col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <div>
                                    <a class="" href="#upload_own" aria-controls="upload_own" role="tab" data-toggle="tab" ng-click="exitDrawing()">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span>Importer une image</span>
                                    </a>
                                </div>
                            </li>
                            <!--<li class="butLoad col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                <div>
                                    <a class="" href="#qr_code" aria-controls="qr_code" role="tab" data-toggle="tab" ng-click="exitDrawing()">
                                        <i class="fa fa-qrcode"></i>
                                        <span>Qr code</span>
                                    </a>
                                </div>
                            </li>-->
                            <li class="butLoad col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <div>
                                    <a class="" href="#hand_draw" aria-controls="hand_draw" role="tab" data-toggle="tab" ng-click="enterDrawing()">
                                        <i class="fa fa-pencil-square-o"></i>
                                        <span>Dessiner</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade in active" id="clip_arts">
                                <div class="graphic_types clearfix" ng-show="!graphic_icons">
                                    <div ng-repeat="graphicsCategory in graphicsCategories" value="{{graphicsCategory}}"  ng-click="loadByGraphicsCat(graphicsCategory)" ng-model="graphicsCategory" >
                                      <div class="{{graphicsCategory.split(' ').join('') | lowercase}}" ></div>
                                       <span>
                                          <!--{{graphicsCategory}}-->
                                        </span>
                                    </div>
                                </div>
                                <span ng-show="graphic_icons" class="back_to_graphic" ng-click="ShowGraphicIcons()">
                                    <i class="fa fa-angle-left"></i> Retour
                                </span>
                                <div class="graphic_icons" ng-show="!graphic_icons">
                                  <div class="filter_by_cat">
                                        <md-input-container class="tooltip-wide" data-toggle="tooltip" data-placement="bottom" title="Sélectionner une catégorie.">
                                            <md-select ng-model="graphicsCategory" ng-change="loadByGraphicsCategory();" >
                                                <md-option ng-repeat="graphicsCategory in graphicsCategories" value="{{graphicsCategory}}">{{graphicsCategory}}</md-option>
                                            </md-select>
                                        </md-input-container>
                                    </div>
                                    <div class="thumb_listing scrollme" rebuild-on="rebuild:me" ng-scrollbar is-bar-shown="barShown" ng-class="fabric.selectedObject ? 'activeControls' : ''">
                                        <ul>
                                            <li ng-repeat="graphic in graphics"><a href="javascript:void(0);" ng-click='addShape(graphic)'><img data-ng-src="{{graphic}}" alt="" width="120px;"></a></li>
                                        </ul>
                                        <a ng-if="loadMore" class="loadMore" ng-click="graphics_load_more(graphicsPage)">Charger plus</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="upload_own">
                                <div class="thumb_listing">
                                    <div class="well" >
                                        <form name="myForm">
                                            <div class="fileUpload btn btn-primary">
                                                <span><i class="fa fa-plus"></i>&nbsp;&nbsp;Sélectionner une image</span>
                                                <input id="upfile" type="file" ngf-select="onFileSelect(picFile);" ng-model="picFile" name="file" accept="image/*" ngf-max-size="30MB" class="upload">
                                            </div>



                                            <input id="uploadFile" placeholdFile NameName disabled="disabled" />
                                            <span class="has-error" ng-show="myForm.file.$error.maxSize">File too large {{picFile.size / 1000000|number:1}}MB: max 30M</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="myForm.file.$error.maxWidth">File width too large : Max Width 9000px</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="myForm.file.$error.maxHeight">File height too large : Max Height 9000px</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="uploadErrorMsg">{{uploadErrorMsg}}</span>
                                        </form>

                                        <div class="alert alert-warning" style="margin-left:-10px;margin-top: 5px;width:95%;">
                                            <i class="fa fa-warning"></i> <strong>attention:</strong> Les images que vous importez doivent être d'assez haute résolution pour une impression de bonne qualité. Cependant pour des raisons de charge serveur et pour garantir la sauvegarde de votre maquette il est important de ne pas surcharger cette application: il est donc conseillé de ne pas en importer plus de 2/3 idéalement (5 max suivant les résolutions) et de privilégier au maximum les ressources intégrées à l'application (textes, formes, icones etc). Vous pouvez par contre importer sans limite des ressources au format 'svg': ce type d'image est redimentionnable sans souci de charge serveur et de résolution. Si votre composition requier d'importer beaucoup d'images de type 'jpeg' ou 'png', il est vivement conseillé de passer par une solution logicielle type Photoshop.
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--<div role="tabpanel" class="tab-pane fade" id="qr_code">
                                <div class="col-lg-12 thumb_listing">
                                    <div class="well" >
                                        <div class="row form-group">
                                            <md-input-container flex>
                                                <label>Entrer le lien ou le texte ici</label>
                                                <textarea  columns="1" id="textarea-text-qr-code" ng-model="fabric.selectedObject.textQRCode"></textarea>
                                            </md-input-container>

                                            <div class="clearfix">
                                                <md-button class="md-raised md-cornered" ng-click="addQRCode(fabric.selectedObject.textQRCode);" aria-label="Add QR Code"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add QR Code</md-button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>-->

                            <div role="tabpanel" class="tab-pane fade" id="hand_draw">
                                <div class="thumb_listing">
                                    <div class="well" >
                                        <div class="row form-group">
                                            <div class="clearfix">
                                                <center><md-button class="md-raised md-cornered" ng-click="enterDrawingMode();" aria-label="{{enter_drawing_mode}}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{enter_drawing_mode}}</md-button></center>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row form-group">
                                            <md-radio-group ng-model="drawing_mode_selector" ng-if="enter_drawing_mode == 'Sortir du mode dessin'">
                                                <md-radio-button value="Pencil" class="md-primary" ng-click="changeDrawingMode('Pencil');"> <i class="fa fa-paint-brush" aria-hidden="true"></i> </md-radio-button>
                                                <md-radio-button value="Circle" class="md-primary" ng-click="changeDrawingMode('Circle');"> <i class="fa fa-circle" aria-hidden="true"></i></md-radio-button>
                                                <md-radio-button value="Spray" class="md-primary" ng-click="changeDrawingMode('Spray');"><i class="ti-spray"></i></md-radio-button>
                                                <!--<p style="clear:both;">Motifs / patterns :</p>
                                                <md-radio-button value="Pattern" class="md-primary" ng-click="changeDrawingMode('Pattern');"> <i class="fa fa-circle" aria-hidden="true"></i></md-radio-button>
                                                <md-radio-button value="hline" class="md-primary" ng-click="changeDrawingMode('hline');"> <i class="fa fa-arrows-h" aria-hidden="true"></i></md-radio-button>
                                                <md-radio-button value="vline" class="md-primary" ng-click="changeDrawingMode('vline');"> <i class="fa fa-arrows-v" aria-hidden="true"></i></md-radio-button>
                                                <md-radio-button value="square" class="md-primary" ng-click="changeDrawingMode('square');"><i class="fa fa-stop" aria-hidden="true"></i></md-radio-button>-->
                                            </md-radio-group>

                                        </div>

                                        <br /><br />
                                        <div class="col-sm-12 input-group colorPicker2" ng-if="enter_drawing_mode == 'Sortir du mode dessin'">
                                            <md-input-container flex>
                                                 <label for="Line color">Couleur:</label>
                                                 <input type="text" value="" class="" colorpicker ng-model="drawing_color" ng-change="fillDrawing(drawing_color);"/>
                                            </md-input-container>
                                            <span class="input-group-addon" style="border: medium none #000000; background-color: {{drawing_color}}"><i></i></span>
                                        </div>

                                        <br />
                                        <div class="row form-group handtool">
                                            <md-input-container flex ng-if="enter_drawing_mode == 'Sortir du mode dessin'">
                                                <label for="Line width">Epaisseur du trait:</label>
                                                <input class='col-sm-12' title="Line width" type='range' min="0" max="150" step=".01" ng-model="drawing_line_width" ng-change="changeDrawingWidth(drawing_line_width);"/>
                                            </md-input-container>
                                        </div>


                                      <!--  <div class="row form-group handtool">
                                            <md-input-container flex ng-if="enter_drawing_mode == 'Sortir du mode dessin'">
                                                <label for="Line shadow">Ombre:</label>
                                                <input class='col-sm-12' title="Line shadow" type='range' min="0" max="50" step=".01" ng-model="drawing_line_shadow" ng-change="changeDrawingShadow(drawing_line_shadow);"/>
                                            </md-input-container>
                                        </div>-->

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane clearfix" id="Text">
<!--                        <div class="graphic_options clearfix">
                            <ul>
                            <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6 active">
                                <div>
                                    <a href="#text_design" aria-controls="text_design" role="tab" data-toggle="tab">
                                        <i class="fa fa-font"></i>
                                        <span>Texte</span>
                                    </a>
                                </div>
                            </li>
                            <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div>
                                    <a href="#word_cloud" aria-controls="word_cloud" role="tab" data-toggle="tab">
                                        <i class="fa fa-cloud"></i>
                                        <span>Word Cloud</span>
                                    </a>
                                </div>
                            </li>
                            </ul>
                        </div>-->

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade in active" id="text_design">

                                <div class="thumb_listing">
                                    <div class="well" >
                                        <div class="row form-group">
                                            <md-input-container flex>
                                                <textarea  columns="1" id="textarea-text" style="text-align: {{ fabric.selectedObject.textAlign }}" ng-model="fabric.selectedObject.text" placeholder="Votre texte..."></textarea>
                                            </md-input-container>

                                            <div class="clearfix">
                                                <md-button class="md-raised md-cornered" ng-click="addText()" aria-label="Add Text"><i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter du texte</md-button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
<!--                            <div role="tabpanel" class="tab-pane fade" id="word_cloud">
                                <div class="col-lg-12 thumb_listing">
                                    <div class="well" >
                                        <div class="row form-group">
                                            <md-input-container flex>
                                                <label>Entrez votre texte</label>
                                                <textarea  columns="1" id="textarea-text-word-cloud" style="text-align: {{ fabric.selectedObject.textAlign }}" ng-model="fabric.selectedObject.textWordCloud"></textarea>
                                            </md-input-container>
                                            <div class="clearfix">
                                                <md-button class="md-raised md-cornered" ng-click="addWordCloud()" aria-label="Add Word Cloud"><i class="fa fa-plus"></i>&nbsp;&nbsp;Créer un nuage de mots</md-button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>-->
                        </div>

                    </div>

                    <div class="tab-pane clearfix" id="Layers">
                        <div class="layer_listing scrollme" rebuild-on="rebuild:layer" ng-scrollbar is-bar-shown="barShown">

                        <ul class="ul_layer_canvas row">

                                <li ng-repeat="layer in objectLayers" class="ng-scope">
                                    <span>{{layer.id}}</span>
                                    <div class="imgbg"><img ng-src="{{layer.src}}" alt=""/></div>

                                    <div class="f-right inner">
                                        <ul class="ulInner actions">
                                            <li class="liActions"><a href="javascript:void(0)" ng-click="deleteObject(layer.object);"><i class="fa fa-trash"></i></a></li>
                                            <li class="liActions"><a href="javascript:void(0)" ng-click="objectForwardSwap(layer.object);"><i class="fa fa-chevron-up"></i></a></li>
                                            <li class="liActions"><a href="javascript:void(0)" ng-click="objectBackwordSwap(layer.object);"><i class="fa fa-chevron-down"></i></a></li>
                                            <li class="liActions"><a href="javascript:void(0)" ng-click="lockLayerObject(layer.object);"><i class="fa" ng-class="isObjectLocked(layer.object) ? 'fa-lock' : 'fa-unlock'"></i></a></li>
                                        </ul>
                                    </div>

                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>


            <!---->
            <div ng-class="fabric.selectedObject ? 'activeControlsElem' : ''" ng-if='fabric.selectedObject.type' ng-switch='fabric.selectedObject.type'>

                <!--<div class="close-circle"><i class="fa fa-angle-left" ng-click="deactivateAll();"><span>Retour</span></i></div>-->

                <div class="well">

                    <div class="row form-group enterText" ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'">
                        <md-input-container flex>
                            <textarea  columns="1" id="textarea-text" style="text-align: {{ fabric.selectedObject.textAlign }}" ng-model="fabric.selectedObject.text"></textarea>
                        </md-input-container>
                    </div>

                    <div class="row form-group" ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'" style="position: relative;">
                        <md-button class="md-raised md-cornered dropdown-toggle" data-toggle="dropdown" aria-label="Font Family"><span class='object-font-family-preview' style='font-family: "{{ fabric.selectedObject.fontFamily }}";'><i class="fa fa-font"></i> Typo : {{ fabric.selectedObject.fontFamily }} </span> <span class="caret"></span></md-button>

                        <ul class="dropdown-menu">
                            <li ng-repeat='font in FabricConstants.fonts' ng-click='toggleFont(font.name);' style='font-family: "{{ font.name }}";'> <a>{{ font.name }}</a> </li>
                        </ul>
                    </div>

                    <div class="row row-margin">
                        <div class="row col-lg-6" title="Font size" ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'">

                            <md-input-container flex>
                                <label><i class="fa fa-text-height"></i> (taille)</label>
                                <input type='number' class="" ng-model="fabric.selectedObject.fontSize" />
                            </md-input-container>

                        </div>
                        <div class="row col-lg-6" title="Line height" ng-show="fabric.selectedObject.type == 'text'">
                            <md-input-container flex>
                                <label><i class="fa fa-align-left"></i> (interligne)</label>
                                <input type='number' class="" ng-model="fabric.selectedObject.lineHeight" step=".1" />
                            </md-input-container>

                        </div>
                         <div class="row col-lg-6" title="Reverse" ng-show="fabric.selectedObject.type == 'curvedText'">
                            <md-checkbox ng-model="fabric.selectedObject.isReversed" aria-label="Reverse" ng-click="toggleReverse(fabric.selectedObject.isReversed);">Reverse </md-checkbox>
                        </div>
                    </div>

                    <div class='row form-group' ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'">
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.selectedObject.textAlign == 'left' }" ng-click="fabric.selectedObject.textAlign = 'left'" aria-label="Align Left"><i class='fa fa-align-left'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.selectedObject.textAlign == 'center' }" ng-click="fabric.selectedObject.textAlign = 'center'" aria-label="Align Center"><i class='fa fa-align-center'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.selectedObject.textAlign == 'right' }" ng-click="fabric.selectedObject.textAlign = 'right'" aria-label="Align Right"><i class='fa fa-align-right'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.isBold() }" ng-click="toggleBold()" aria-label="Bold"><i class='fa fa-bold'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.isItalic() }" ng-click="toggleItalic()" aria-label="Italic"><i class='fa fa-italic'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.isUnderline() }" ng-click="toggleUnderline()" aria-label="Underline"><i class='fa fa-underline'></i></md-button>
                        <md-button class="md-raised md-cornered" ng-class="{ active: fabric.isLinethrough() }" ng-click="toggleLinethrough()" aria-label="Strike through"><i class='fa fa-strikethrough'></i></md-button>
                    </div>
                    <div class='row form-group curved_text' ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'">
                        <md-switch ng-model="fabric.selectedObject.isCurved" aria-label="Switch 1" ng-change="curveText();">Texte incuvé</md-switch>
                    </div>
                    <div class="row form-group transparency" title="Radius" ng-show="fabric.selectedObject.type == 'curvedText'" style="margin-bottom: 0px;">
                        <md-input-container flex>
                            <label for="Radius">Rayon:</label>
                            <input class='col-sm-12' title="Radius" type='range' min="50" max="200" value="100" ng-model="fabric.selectedObject.radius" ng-change="radius(fabric.selectedObject.radius);"/>
                        </md-input-container>
                    </div>


                    <div class="row form-group transparency" title="Spacing" ng-show="fabric.selectedObject.type == 'curvedText'" style="margin-bottom: 35px;">
                        <md-input-container flex>
                            <label for="Spacing">Espacement:</label>
                            <input class='col-sm-12' title="Spacing" type='range' min="5" max="30" value="10" ng-model="fabric.selectedObject.spacing" ng-change="spacing(fabric.selectedObject.spacing);"/>
                        </md-input-container>
                    </div>

                    <!--<div class="row form-group input-group colorPicker2" ng-show="fabric.selectedObject.type != 'image' && fabric.selectedObject.type != 'path'">
                            <md-input-container flex>
                                <label for="Color">Couleur:</label>
                                <input type="text" value="" class="" colorpicker" />
                            </md-input-container>
                            <span class="input-group-addon" colorpicker ng-model="fabric.selectedObject.fill" ng-change="fillColor(fabric.selectedObject.fill);" style="border: 2px solid #ccc; background-color: {{fabric.selectedObject.fill}}"><i></i></span>
                    </div>-->

                    <!-- on remplace le bloc précédent par le sélecteur cmyk ci dessous -->

                    <div class="w3-container w3-padding-large" ng-show="fabric.selectedObject.type != 'image' && fabric.selectedObject.type != 'path'">
                    <div class="w3-row1">
                      <input id="result01" class="w3-col m2" value="{{fabric.selectedObject.fill}}" ng-model="fabric.selectedObject.fill" ng-change="fillColor(fabric.selectedObject.fill);" style="background-color: {{fabric.selectedObject.fill}}" type="text" onclick="setFullColor();">

                      <div class="w3-col m8">
                        <div class="w3-large" style="font-family:Consolas, 'courier new';">

                          <input id="cmyk01" class="w3-input w3-border" value="{{fabric.selectedObject.fill}}" ng-model="fabric.selectedObject.fill" ng-change="fillColor(fabric.selectedObject.fill);" type="text" onclick="setFullColor();">

                          <div style="display:none">
                            <div id="hex01" class="w3-margin-top"></div>
                            <div id="rgb01" class="w3-margin-top"></div>
                            <div id="hsl01" class="w3-margin-top"></div>
                          </div>

                        </div>

                        <div class="swatch-selector" id="color-1">
                          <button class="swatch" style="background-color:#000000;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#000000');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#444444;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#444444');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#9e9e9e;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#9e9e9e');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#cccccc;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#cccccc');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#ffffff;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#ffffff');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#ffff00;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#ffff00');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#ffed00;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#ffed00');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#ff9f1c;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#ff9f1c');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#137547;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#137547');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#009036;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#009036');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#009cdd;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#009cdd');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#028482;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#028482');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#172983;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#172983');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#011627;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#011627');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#4c0055;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#4c0055');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#6b0f1a;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#6b0f1a');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#e2001a;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#e2001a');" onclick="setFullColor();"></button>
                          <button class="swatch" style="background-color:#ff0066;" ng-model="fabric.selectedObject.fill" ng-click="fillColor(fabric.selectedObject.fill = '#ff0066');" onclick="setFullColor();"></button>
                        </div>
                      </div>

                    <hr style="border-color:#d3d3d3" class="w3-hide-medium w3-hide-large">
                    <br>
                    <div class="w3-row">
                      <div class="w3-col colorinput">
                        <div class="cmjnLetter">C</div>
                        <input class="cInput" id="c01" oninput="setColor(this)" value="0" type="number">
                        </div>
                      <div class="w3-rest colorslider">
                        <div id="cyantable"><table class="tableslider"><tbody><tr><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer0" style="display: none;"><div>0</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer1" style="display: none;"><div>1</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer2" style="display: none;"><div>2</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer3" style="display: none;"><div>3</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer4" style="display: none;"><div>4</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer5" style="display: none;"><div>5</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer6" style="display: none;"><div>6</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer7" style="display: none;"><div>7</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer8" style="display: none;"><div>8</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer9" style="display: none;"><div>9</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer10" style="display: none;"><div>10</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer11" style="display: none;"><div>11</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer12" style="display: none;"><div>12</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer13" style="display: none;"><div>13</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer14" style="display: none;"><div>14</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer15" style="display: none;"><div>15</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer16" style="display: none;"><div>16</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer17" style="display: none;"><div>17</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer18" style="display: none;"><div>18</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer19" style="display: none;"><div>19</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer20" style="display: none;"><div>20</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer21" style="display: none;"><div>21</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer22" style="display: none;"><div>22</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer23" style="display: none;"><div>23</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer24" style="display: none;"><div>24</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer25" style="display: none;"><div>25</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer26" style="display: none;"><div>26</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer27" style="display: none;"><div>27</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer28" style="display: none;"><div>28</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer29" style="display: none;"><div>29</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer30" style="display: none;"><div>30</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer31" style="display: none;"><div>31</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer32" style="display: none;"><div>32</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer33" style="display: none;"><div>33</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer34" style="display: none;"><div>34</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer35" style="display: none;"><div>35</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer36" style="display: none;"><div>36</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer37" style="display: none;"><div>37</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer38" style="display: none;"><div>38</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer39" style="display: none;"><div>39</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer40" style="display: none;"><div>40</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer41" style="display: inline;"><div>41</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer42" style="display: none;"><div>42</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer43" style="display: none;"><div>43</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer44" style="display: none;"><div>44</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer45" style="display: none;"><div>45</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer46" style="display: none;"><div>46</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer47" style="display: none;"><div>47</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer48" style="display: none;"><div>48</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer49" style="display: none;"><div>49</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer50" style="display: none;"><div>50</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer51" style="display: none;"><div>51</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer52" style="display: none;"><div>52</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer53" style="display: none;"><div>53</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer54" style="display: none;"><div>54</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer55" style="display: none;"><div>55</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer56" style="display: none;"><div>56</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer57" style="display: none;"><div>57</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer58" style="display: none;"><div>58</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer59" style="display: none;"><div>59</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer60" style="display: none;"><div>60</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer61" style="display: none;"><div>61</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer62" style="display: none;"><div>62</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer63" style="display: none;"><div>63</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer64" style="display: none;"><div>64</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer65" style="display: none;"><div>65</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer66" style="display: none;"><div>66</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer67" style="display: none;"><div>67</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer68" style="display: none;"><div>68</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer69" style="display: none;"><div>69</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer70" style="display: none;"><div>70</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer71" style="display: none;"><div>71</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer72" style="display: none;"><div>72</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer73" style="display: none;"><div>73</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer74" style="display: none;"><div>74</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer75" style="display: none;"><div>75</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer76" style="display: none;"><div>76</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer77" style="display: none;"><div>77</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer78" style="display: none;"><div>78</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer79" style="display: none;"><div>79</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer80" style="display: none;"><div>80</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer81" style="display: none;"><div>81</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer82" style="display: none;"><div>82</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer83" style="display: none;"><div>83</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer84" style="display: none;"><div>84</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer85" style="display: none;"><div>85</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer86" style="display: none;"><div>86</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer87" style="display: none;"><div>87</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer88" style="display: none;"><div>88</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer89" style="display: none;"><div>89</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer90" style="display: none;"><div>90</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer91" style="display: none;"><div>91</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer92" style="display: none;"><div>92</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer93" style="display: none;"><div>93</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer94" style="display: none;"><div>94</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer95" style="display: none;"><div>95</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer96" style="display: none;"><div>96</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer97" style="display: none;"><div>97</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer98" style="display: none;"><div>98</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer99" style="display: none;"><div>99</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="cyanpointer100" style="display: none;"><div>100</div><i class="fa fa-caret-down"></i></div></td></tr><tr><td style="background-color:rgb(255, 255, 255);" class="colorSample" onmousemove="tooltip(0, 0)" onclick="clickCyan(0)"></td><td style="background-color:rgb(252, 255, 255);" class="colorSample" onmousemove="tooltip(0, 1)" onclick="clickCyan(1)"></td><td style="background-color:rgb(250, 255, 255);" class="colorSample" onmousemove="tooltip(0, 2)" onclick="clickCyan(2)"></td><td style="background-color:rgb(247, 255, 255);" class="colorSample" onmousemove="tooltip(0, 3)" onclick="clickCyan(3)"></td><td style="background-color:rgb(245, 255, 255);" class="colorSample" onmousemove="tooltip(0, 4)" onclick="clickCyan(4)"></td><td style="background-color:rgb(242, 255, 255);" class="colorSample" onmousemove="tooltip(0, 5)" onclick="clickCyan(5)"></td><td style="background-color:rgb(240, 255, 255);" class="colorSample" onmousemove="tooltip(0, 6)" onclick="clickCyan(6)"></td><td style="background-color:rgb(237, 255, 255);" class="colorSample" onmousemove="tooltip(0, 7)" onclick="clickCyan(7)"></td><td style="background-color:rgb(235, 255, 255);" class="colorSample" onmousemove="tooltip(0, 8)" onclick="clickCyan(8)"></td><td style="background-color:rgb(232, 255, 255);" class="colorSample" onmousemove="tooltip(0, 9)" onclick="clickCyan(9)"></td><td style="background-color:rgb(230, 255, 255);" class="colorSample" onmousemove="tooltip(0, 10)" onclick="clickCyan(10)"></td><td style="background-color:rgb(227, 255, 255);" class="colorSample" onmousemove="tooltip(0, 11)" onclick="clickCyan(11)"></td><td style="background-color:rgb(224, 255, 255);" class="colorSample" onmousemove="tooltip(0, 12)" onclick="clickCyan(12)"></td><td style="background-color:rgb(222, 255, 255);" class="colorSample" onmousemove="tooltip(0, 13)" onclick="clickCyan(13)"></td><td style="background-color:rgb(219, 255, 255);" class="colorSample" onmousemove="tooltip(0, 14)" onclick="clickCyan(14)"></td><td style="background-color:rgb(217, 255, 255);" class="colorSample" onmousemove="tooltip(0, 15)" onclick="clickCyan(15)"></td><td style="background-color:rgb(214, 255, 255);" class="colorSample" onmousemove="tooltip(0, 16)" onclick="clickCyan(16)"></td><td style="background-color:rgb(212, 255, 255);" class="colorSample" onmousemove="tooltip(0, 17)" onclick="clickCyan(17)"></td><td style="background-color:rgb(209, 255, 255);" class="colorSample" onmousemove="tooltip(0, 18)" onclick="clickCyan(18)"></td><td style="background-color:rgb(207, 255, 255);" class="colorSample" onmousemove="tooltip(0, 19)" onclick="clickCyan(19)"></td><td style="background-color:rgb(204, 255, 255);" class="colorSample" onmousemove="tooltip(0, 20)" onclick="clickCyan(20)"></td><td style="background-color:rgb(201, 255, 255);" class="colorSample" onmousemove="tooltip(0, 21)" onclick="clickCyan(21)"></td><td style="background-color:rgb(199, 255, 255);" class="colorSample" onmousemove="tooltip(0, 22)" onclick="clickCyan(22)"></td><td style="background-color:rgb(196, 255, 255);" class="colorSample" onmousemove="tooltip(0, 23)" onclick="clickCyan(23)"></td><td style="background-color:rgb(194, 255, 255);" class="colorSample" onmousemove="tooltip(0, 24)" onclick="clickCyan(24)"></td><td style="background-color:rgb(191, 255, 255);" class="colorSample" onmousemove="tooltip(0, 25)" onclick="clickCyan(25)"></td><td style="background-color:rgb(189, 255, 255);" class="colorSample" onmousemove="tooltip(0, 26)" onclick="clickCyan(26)"></td><td style="background-color:rgb(186, 255, 255);" class="colorSample" onmousemove="tooltip(0, 27)" onclick="clickCyan(27)"></td><td style="background-color:rgb(184, 255, 255);" class="colorSample" onmousemove="tooltip(0, 28)" onclick="clickCyan(28)"></td><td style="background-color:rgb(181, 255, 255);" class="colorSample" onmousemove="tooltip(0, 29)" onclick="clickCyan(29)"></td><td style="background-color:rgb(179, 255, 255);" class="colorSample" onmousemove="tooltip(0, 30)" onclick="clickCyan(30)"></td><td style="background-color:rgb(176, 255, 255);" class="colorSample" onmousemove="tooltip(0, 31)" onclick="clickCyan(31)"></td><td style="background-color:rgb(173, 255, 255);" class="colorSample" onmousemove="tooltip(0, 32)" onclick="clickCyan(32)"></td><td style="background-color:rgb(171, 255, 255);" class="colorSample" onmousemove="tooltip(0, 33)" onclick="clickCyan(33)"></td><td style="background-color:rgb(168, 255, 255);" class="colorSample" onmousemove="tooltip(0, 34)" onclick="clickCyan(34)"></td><td style="background-color:rgb(166, 255, 255);" class="colorSample" onmousemove="tooltip(0, 35)" onclick="clickCyan(35)"></td><td style="background-color:rgb(163, 255, 255);" class="colorSample" onmousemove="tooltip(0, 36)" onclick="clickCyan(36)"></td><td style="background-color:rgb(161, 255, 255);" class="colorSample" onmousemove="tooltip(0, 37)" onclick="clickCyan(37)"></td><td style="background-color:rgb(158, 255, 255);" class="colorSample" onmousemove="tooltip(0, 38)" onclick="clickCyan(38)"></td><td style="background-color:rgb(156, 255, 255);" class="colorSample" onmousemove="tooltip(0, 39)" onclick="clickCyan(39)"></td><td style="background-color:rgb(153, 255, 255);" class="colorSample" onmousemove="tooltip(0, 40)" onclick="clickCyan(40)"></td><td style="background-color:rgb(150, 255, 255);" class="colorSample" onmousemove="tooltip(0, 41)" onclick="clickCyan(41)"></td><td style="background-color:rgb(148, 255, 255);" class="colorSample" onmousemove="tooltip(0, 42)" onclick="clickCyan(42)"></td><td style="background-color:rgb(145, 255, 255);" class="colorSample" onmousemove="tooltip(0, 43)" onclick="clickCyan(43)"></td><td style="background-color:rgb(143, 255, 255);" class="colorSample" onmousemove="tooltip(0, 44)" onclick="clickCyan(44)"></td><td style="background-color:rgb(140, 255, 255);" class="colorSample" onmousemove="tooltip(0, 45)" onclick="clickCyan(45)"></td><td style="background-color:rgb(138, 255, 255);" class="colorSample" onmousemove="tooltip(0, 46)" onclick="clickCyan(46)"></td><td style="background-color:rgb(135, 255, 255);" class="colorSample" onmousemove="tooltip(0, 47)" onclick="clickCyan(47)"></td><td style="background-color:rgb(133, 255, 255);" class="colorSample" onmousemove="tooltip(0, 48)" onclick="clickCyan(48)"></td><td style="background-color:rgb(130, 255, 255);" class="colorSample" onmousemove="tooltip(0, 49)" onclick="clickCyan(49)"></td><td style="background-color:rgb(128, 255, 255);" class="colorSample" onmousemove="tooltip(0, 50)" onclick="clickCyan(50)"></td><td style="background-color:rgb(125, 255, 255);" class="colorSample" onmousemove="tooltip(0, 51)" onclick="clickCyan(51)"></td><td style="background-color:rgb(122, 255, 255);" class="colorSample" onmousemove="tooltip(0, 52)" onclick="clickCyan(52)"></td><td style="background-color:rgb(120, 255, 255);" class="colorSample" onmousemove="tooltip(0, 53)" onclick="clickCyan(53)"></td><td style="background-color:rgb(117, 255, 255);" class="colorSample" onmousemove="tooltip(0, 54)" onclick="clickCyan(54)"></td><td style="background-color:rgb(115, 255, 255);" class="colorSample" onmousemove="tooltip(0, 55)" onclick="clickCyan(55)"></td><td style="background-color:rgb(112, 255, 255);" class="colorSample" onmousemove="tooltip(0, 56)" onclick="clickCyan(56)"></td><td style="background-color:rgb(110, 255, 255);" class="colorSample" onmousemove="tooltip(0, 57)" onclick="clickCyan(57)"></td><td style="background-color:rgb(107, 255, 255);" class="colorSample" onmousemove="tooltip(0, 58)" onclick="clickCyan(58)"></td><td style="background-color:rgb(105, 255, 255);" class="colorSample" onmousemove="tooltip(0, 59)" onclick="clickCyan(59)"></td><td style="background-color:rgb(102, 255, 255);" class="colorSample" onmousemove="tooltip(0, 60)" onclick="clickCyan(60)"></td><td style="background-color:rgb(99, 255, 255);" class="colorSample" onmousemove="tooltip(0, 61)" onclick="clickCyan(61)"></td><td style="background-color:rgb(97, 255, 255);" class="colorSample" onmousemove="tooltip(0, 62)" onclick="clickCyan(62)"></td><td style="background-color:rgb(94, 255, 255);" class="colorSample" onmousemove="tooltip(0, 63)" onclick="clickCyan(63)"></td><td style="background-color:rgb(92, 255, 255);" class="colorSample" onmousemove="tooltip(0, 64)" onclick="clickCyan(64)"></td><td style="background-color:rgb(89, 255, 255);" class="colorSample" onmousemove="tooltip(0, 65)" onclick="clickCyan(65)"></td><td style="background-color:rgb(87, 255, 255);" class="colorSample" onmousemove="tooltip(0, 66)" onclick="clickCyan(66)"></td><td style="background-color:rgb(84, 255, 255);" class="colorSample" onmousemove="tooltip(0, 67)" onclick="clickCyan(67)"></td><td style="background-color:rgb(82, 255, 255);" class="colorSample" onmousemove="tooltip(0, 68)" onclick="clickCyan(68)"></td><td style="background-color:rgb(79, 255, 255);" class="colorSample" onmousemove="tooltip(0, 69)" onclick="clickCyan(69)"></td><td style="background-color:rgb(77, 255, 255);" class="colorSample" onmousemove="tooltip(0, 70)" onclick="clickCyan(70)"></td><td style="background-color:rgb(74, 255, 255);" class="colorSample" onmousemove="tooltip(0, 71)" onclick="clickCyan(71)"></td><td style="background-color:rgb(71, 255, 255);" class="colorSample" onmousemove="tooltip(0, 72)" onclick="clickCyan(72)"></td><td style="background-color:rgb(69, 255, 255);" class="colorSample" onmousemove="tooltip(0, 73)" onclick="clickCyan(73)"></td><td style="background-color:rgb(66, 255, 255);" class="colorSample" onmousemove="tooltip(0, 74)" onclick="clickCyan(74)"></td><td style="background-color:rgb(64, 255, 255);" class="colorSample" onmousemove="tooltip(0, 75)" onclick="clickCyan(75)"></td><td style="background-color:rgb(61, 255, 255);" class="colorSample" onmousemove="tooltip(0, 76)" onclick="clickCyan(76)"></td><td style="background-color:rgb(59, 255, 255);" class="colorSample" onmousemove="tooltip(0, 77)" onclick="clickCyan(77)"></td><td style="background-color:rgb(56, 255, 255);" class="colorSample" onmousemove="tooltip(0, 78)" onclick="clickCyan(78)"></td><td style="background-color:rgb(54, 255, 255);" class="colorSample" onmousemove="tooltip(0, 79)" onclick="clickCyan(79)"></td><td style="background-color:rgb(51, 255, 255);" class="colorSample" onmousemove="tooltip(0, 80)" onclick="clickCyan(80)"></td><td style="background-color:rgb(48, 255, 255);" class="colorSample" onmousemove="tooltip(0, 81)" onclick="clickCyan(81)"></td><td style="background-color:rgb(46, 255, 255);" class="colorSample" onmousemove="tooltip(0, 82)" onclick="clickCyan(82)"></td><td style="background-color:rgb(43, 255, 255);" class="colorSample" onmousemove="tooltip(0, 83)" onclick="clickCyan(83)"></td><td style="background-color:rgb(41, 255, 255);" class="colorSample" onmousemove="tooltip(0, 84)" onclick="clickCyan(84)"></td><td style="background-color:rgb(38, 255, 255);" class="colorSample" onmousemove="tooltip(0, 85)" onclick="clickCyan(85)"></td><td style="background-color:rgb(36, 255, 255);" class="colorSample" onmousemove="tooltip(0, 86)" onclick="clickCyan(86)"></td><td style="background-color:rgb(33, 255, 255);" class="colorSample" onmousemove="tooltip(0, 87)" onclick="clickCyan(87)"></td><td style="background-color:rgb(31, 255, 255);" class="colorSample" onmousemove="tooltip(0, 88)" onclick="clickCyan(88)"></td><td style="background-color:rgb(28, 255, 255);" class="colorSample" onmousemove="tooltip(0, 89)" onclick="clickCyan(89)"></td><td style="background-color:rgb(26, 255, 255);" class="colorSample" onmousemove="tooltip(0, 90)" onclick="clickCyan(90)"></td><td style="background-color:rgb(23, 255, 255);" class="colorSample" onmousemove="tooltip(0, 91)" onclick="clickCyan(91)"></td><td style="background-color:rgb(20, 255, 255);" class="colorSample" onmousemove="tooltip(0, 92)" onclick="clickCyan(92)"></td><td style="background-color:rgb(18, 255, 255);" class="colorSample" onmousemove="tooltip(0, 93)" onclick="clickCyan(93)"></td><td style="background-color:rgb(15, 255, 255);" class="colorSample" onmousemove="tooltip(0, 94)" onclick="clickCyan(94)"></td><td style="background-color:rgb(13, 255, 255);" class="colorSample" onmousemove="tooltip(0, 95)" onclick="clickCyan(95)"></td><td style="background-color:rgb(10, 255, 255);" class="colorSample" onmousemove="tooltip(0, 96)" onclick="clickCyan(96)"></td><td style="background-color:rgb(8, 255, 255);" class="colorSample" onmousemove="tooltip(0, 97)" onclick="clickCyan(97)"></td><td style="background-color:rgb(5, 255, 255);" class="colorSample" onmousemove="tooltip(0, 98)" onclick="clickCyan(98)"></td><td style="background-color:rgb(3, 255, 255);" class="colorSample" onmousemove="tooltip(0, 99)" onclick="clickCyan(99)"></td><td style="background-color:rgb(0, 255, 255);" class="colorSample" onmousemove="tooltip(0, 100)" onclick="clickCyan(100)"></td></tr></tbody></table></div>
                      </div>
                    </div>
                    <div class="w3-row">
                      <div class="w3-col colorinput">
                        <div class="cmjnLetter">M</div>
                        <input class="cInput" id="m01" oninput="setColor(this)" value="0"  type="number">
                      </div>
                      <div class="w3-rest colorslider">
                        <div id="magentatable"><table class="tableslider"><tbody><tr><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer0" style="display: none;"><div>0</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer1" style="display: none;"><div>1</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer2" style="display: none;"><div>2</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer3" style="display: none;"><div>3</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer4" style="display: none;"><div>4</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer5" style="display: none;"><div>5</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer6" style="display: none;"><div>6</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer7" style="display: none;"><div>7</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer8" style="display: none;"><div>8</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer9" style="display: none;"><div>9</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer10" style="display: none;"><div>10</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer11" style="display: none;"><div>11</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer12" style="display: none;"><div>12</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer13" style="display: none;"><div>13</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer14" style="display: none;"><div>14</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer15" style="display: none;"><div>15</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer16" style="display: none;"><div>16</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer17" style="display: none;"><div>17</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer18" style="display: none;"><div>18</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer19" style="display: none;"><div>19</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer20" style="display: none;"><div>20</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer21" style="display: none;"><div>21</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer22" style="display: none;"><div>22</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer23" style="display: none;"><div>23</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer24" style="display: none;"><div>24</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer25" style="display: none;"><div>25</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer26" style="display: none;"><div>26</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer27" style="display: none;"><div>27</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer28" style="display: none;"><div>28</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer29" style="display: none;"><div>29</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer30" style="display: none;"><div>30</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer31" style="display: none;"><div>31</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer32" style="display: none;"><div>32</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer33" style="display: none;"><div>33</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer34" style="display: none;"><div>34</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer35" style="display: none;"><div>35</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer36" style="display: none;"><div>36</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer37" style="display: none;"><div>37</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer38" style="display: none;"><div>38</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer39" style="display: none;"><div>39</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer40" style="display: none;"><div>40</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer41" style="display: none;"><div>41</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer42" style="display: none;"><div>42</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer43" style="display: none;"><div>43</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer44" style="display: none;"><div>44</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer45" style="display: none;"><div>45</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer46" style="display: none;"><div>46</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer47" style="display: none;"><div>47</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer48" style="display: none;"><div>48</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer49" style="display: none;"><div>49</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer50" style="display: none;"><div>50</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer51" style="display: none;"><div>51</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer52" style="display: none;"><div>52</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer53" style="display: none;"><div>53</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer54" style="display: none;"><div>54</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer55" style="display: none;"><div>55</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer56" style="display: none;"><div>56</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer57" style="display: none;"><div>57</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer58" style="display: none;"><div>58</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer59" style="display: none;"><div>59</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer60" style="display: none;"><div>60</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer61" style="display: none;"><div>61</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer62" style="display: none;"><div>62</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer63" style="display: none;"><div>63</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer64" style="display: none;"><div>64</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer65" style="display: none;"><div>65</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer66" style="display: none;"><div>66</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer67" style="display: none;"><div>67</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer68" style="display: none;"><div>68</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer69" style="display: none;"><div>69</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer70" style="display: none;"><div>70</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer71" style="display: none;"><div>71</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer72" style="display: none;"><div>72</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer73" style="display: none;"><div>73</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer74" style="display: none;"><div>74</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer75" style="display: none;"><div>75</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer76" style="display: none;"><div>76</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer77" style="display: none;"><div>77</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer78" style="display: none;"><div>78</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer79" style="display: none;"><div>79</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer80" style="display: none;"><div>80</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer81" style="display: none;"><div>81</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer82" style="display: inline;"><div>82</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer83" style="display: none;"><div>83</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer84" style="display: none;"><div>84</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer85" style="display: none;"><div>85</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer86" style="display: none;"><div>86</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer87" style="display: none;"><div>87</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer88" style="display: none;"><div>88</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer89" style="display: none;"><div>89</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer90" style="display: none;"><div>90</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer91" style="display: none;"><div>91</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer92" style="display: none;"><div>92</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer93" style="display: none;"><div>93</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer94" style="display: none;"><div>94</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer95" style="display: none;"><div>95</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer96" style="display: none;"><div>96</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer97" style="display: none;"><div>97</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer98" style="display: none;"><div>98</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer99" style="display: none;"><div>99</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="magentapointer100" style="display: none;"><div>100</div><i class="fa fa-caret-down"></i></div></td></tr><tr><td style="background-color:rgb(255, 255, 255);" class="colorSample" onmousemove="tooltip(1, 0)" onclick="clickMagenta(0)"></td><td style="background-color:rgb(255, 252, 255);" class="colorSample" onmousemove="tooltip(1, 1)" onclick="clickMagenta(1)"></td><td style="background-color:rgb(255, 250, 255);" class="colorSample" onmousemove="tooltip(1, 2)" onclick="clickMagenta(2)"></td><td style="background-color:rgb(255, 247, 255);" class="colorSample" onmousemove="tooltip(1, 3)" onclick="clickMagenta(3)"></td><td style="background-color:rgb(255, 245, 255);" class="colorSample" onmousemove="tooltip(1, 4)" onclick="clickMagenta(4)"></td><td style="background-color:rgb(255, 242, 255);" class="colorSample" onmousemove="tooltip(1, 5)" onclick="clickMagenta(5)"></td><td style="background-color:rgb(255, 240, 255);" class="colorSample" onmousemove="tooltip(1, 6)" onclick="clickMagenta(6)"></td><td style="background-color:rgb(255, 237, 255);" class="colorSample" onmousemove="tooltip(1, 7)" onclick="clickMagenta(7)"></td><td style="background-color:rgb(255, 235, 255);" class="colorSample" onmousemove="tooltip(1, 8)" onclick="clickMagenta(8)"></td><td style="background-color:rgb(255, 232, 255);" class="colorSample" onmousemove="tooltip(1, 9)" onclick="clickMagenta(9)"></td><td style="background-color:rgb(255, 230, 255);" class="colorSample" onmousemove="tooltip(1, 10)" onclick="clickMagenta(10)"></td><td style="background-color:rgb(255, 227, 255);" class="colorSample" onmousemove="tooltip(1, 11)" onclick="clickMagenta(11)"></td><td style="background-color:rgb(255, 224, 255);" class="colorSample" onmousemove="tooltip(1, 12)" onclick="clickMagenta(12)"></td><td style="background-color:rgb(255, 222, 255);" class="colorSample" onmousemove="tooltip(1, 13)" onclick="clickMagenta(13)"></td><td style="background-color:rgb(255, 219, 255);" class="colorSample" onmousemove="tooltip(1, 14)" onclick="clickMagenta(14)"></td><td style="background-color:rgb(255, 217, 255);" class="colorSample" onmousemove="tooltip(1, 15)" onclick="clickMagenta(15)"></td><td style="background-color:rgb(255, 214, 255);" class="colorSample" onmousemove="tooltip(1, 16)" onclick="clickMagenta(16)"></td><td style="background-color:rgb(255, 212, 255);" class="colorSample" onmousemove="tooltip(1, 17)" onclick="clickMagenta(17)"></td><td style="background-color:rgb(255, 209, 255);" class="colorSample" onmousemove="tooltip(1, 18)" onclick="clickMagenta(18)"></td><td style="background-color:rgb(255, 207, 255);" class="colorSample" onmousemove="tooltip(1, 19)" onclick="clickMagenta(19)"></td><td style="background-color:rgb(255, 204, 255);" class="colorSample" onmousemove="tooltip(1, 20)" onclick="clickMagenta(20)"></td><td style="background-color:rgb(255, 201, 255);" class="colorSample" onmousemove="tooltip(1, 21)" onclick="clickMagenta(21)"></td><td style="background-color:rgb(255, 199, 255);" class="colorSample" onmousemove="tooltip(1, 22)" onclick="clickMagenta(22)"></td><td style="background-color:rgb(255, 196, 255);" class="colorSample" onmousemove="tooltip(1, 23)" onclick="clickMagenta(23)"></td><td style="background-color:rgb(255, 194, 255);" class="colorSample" onmousemove="tooltip(1, 24)" onclick="clickMagenta(24)"></td><td style="background-color:rgb(255, 191, 255);" class="colorSample" onmousemove="tooltip(1, 25)" onclick="clickMagenta(25)"></td><td style="background-color:rgb(255, 189, 255);" class="colorSample" onmousemove="tooltip(1, 26)" onclick="clickMagenta(26)"></td><td style="background-color:rgb(255, 186, 255);" class="colorSample" onmousemove="tooltip(1, 27)" onclick="clickMagenta(27)"></td><td style="background-color:rgb(255, 184, 255);" class="colorSample" onmousemove="tooltip(1, 28)" onclick="clickMagenta(28)"></td><td style="background-color:rgb(255, 181, 255);" class="colorSample" onmousemove="tooltip(1, 29)" onclick="clickMagenta(29)"></td><td style="background-color:rgb(255, 179, 255);" class="colorSample" onmousemove="tooltip(1, 30)" onclick="clickMagenta(30)"></td><td style="background-color:rgb(255, 176, 255);" class="colorSample" onmousemove="tooltip(1, 31)" onclick="clickMagenta(31)"></td><td style="background-color:rgb(255, 173, 255);" class="colorSample" onmousemove="tooltip(1, 32)" onclick="clickMagenta(32)"></td><td style="background-color:rgb(255, 171, 255);" class="colorSample" onmousemove="tooltip(1, 33)" onclick="clickMagenta(33)"></td><td style="background-color:rgb(255, 168, 255);" class="colorSample" onmousemove="tooltip(1, 34)" onclick="clickMagenta(34)"></td><td style="background-color:rgb(255, 166, 255);" class="colorSample" onmousemove="tooltip(1, 35)" onclick="clickMagenta(35)"></td><td style="background-color:rgb(255, 163, 255);" class="colorSample" onmousemove="tooltip(1, 36)" onclick="clickMagenta(36)"></td><td style="background-color:rgb(255, 161, 255);" class="colorSample" onmousemove="tooltip(1, 37)" onclick="clickMagenta(37)"></td><td style="background-color:rgb(255, 158, 255);" class="colorSample" onmousemove="tooltip(1, 38)" onclick="clickMagenta(38)"></td><td style="background-color:rgb(255, 156, 255);" class="colorSample" onmousemove="tooltip(1, 39)" onclick="clickMagenta(39)"></td><td style="background-color:rgb(255, 153, 255);" class="colorSample" onmousemove="tooltip(1, 40)" onclick="clickMagenta(40)"></td><td style="background-color:rgb(255, 150, 255);" class="colorSample" onmousemove="tooltip(1, 41)" onclick="clickMagenta(41)"></td><td style="background-color:rgb(255, 148, 255);" class="colorSample" onmousemove="tooltip(1, 42)" onclick="clickMagenta(42)"></td><td style="background-color:rgb(255, 145, 255);" class="colorSample" onmousemove="tooltip(1, 43)" onclick="clickMagenta(43)"></td><td style="background-color:rgb(255, 143, 255);" class="colorSample" onmousemove="tooltip(1, 44)" onclick="clickMagenta(44)"></td><td style="background-color:rgb(255, 140, 255);" class="colorSample" onmousemove="tooltip(1, 45)" onclick="clickMagenta(45)"></td><td style="background-color:rgb(255, 138, 255);" class="colorSample" onmousemove="tooltip(1, 46)" onclick="clickMagenta(46)"></td><td style="background-color:rgb(255, 135, 255);" class="colorSample" onmousemove="tooltip(1, 47)" onclick="clickMagenta(47)"></td><td style="background-color:rgb(255, 133, 255);" class="colorSample" onmousemove="tooltip(1, 48)" onclick="clickMagenta(48)"></td><td style="background-color:rgb(255, 130, 255);" class="colorSample" onmousemove="tooltip(1, 49)" onclick="clickMagenta(49)"></td><td style="background-color:rgb(255, 128, 255);" class="colorSample" onmousemove="tooltip(1, 50)" onclick="clickMagenta(50)"></td><td style="background-color:rgb(255, 125, 255);" class="colorSample" onmousemove="tooltip(1, 51)" onclick="clickMagenta(51)"></td><td style="background-color:rgb(255, 122, 255);" class="colorSample" onmousemove="tooltip(1, 52)" onclick="clickMagenta(52)"></td><td style="background-color:rgb(255, 120, 255);" class="colorSample" onmousemove="tooltip(1, 53)" onclick="clickMagenta(53)"></td><td style="background-color:rgb(255, 117, 255);" class="colorSample" onmousemove="tooltip(1, 54)" onclick="clickMagenta(54)"></td><td style="background-color:rgb(255, 115, 255);" class="colorSample" onmousemove="tooltip(1, 55)" onclick="clickMagenta(55)"></td><td style="background-color:rgb(255, 112, 255);" class="colorSample" onmousemove="tooltip(1, 56)" onclick="clickMagenta(56)"></td><td style="background-color:rgb(255, 110, 255);" class="colorSample" onmousemove="tooltip(1, 57)" onclick="clickMagenta(57)"></td><td style="background-color:rgb(255, 107, 255);" class="colorSample" onmousemove="tooltip(1, 58)" onclick="clickMagenta(58)"></td><td style="background-color:rgb(255, 105, 255);" class="colorSample" onmousemove="tooltip(1, 59)" onclick="clickMagenta(59)"></td><td style="background-color:rgb(255, 102, 255);" class="colorSample" onmousemove="tooltip(1, 60)" onclick="clickMagenta(60)"></td><td style="background-color:rgb(255, 99, 255);" class="colorSample" onmousemove="tooltip(1, 61)" onclick="clickMagenta(61)"></td><td style="background-color:rgb(255, 97, 255);" class="colorSample" onmousemove="tooltip(1, 62)" onclick="clickMagenta(62)"></td><td style="background-color:rgb(255, 94, 255);" class="colorSample" onmousemove="tooltip(1, 63)" onclick="clickMagenta(63)"></td><td style="background-color:rgb(255, 92, 255);" class="colorSample" onmousemove="tooltip(1, 64)" onclick="clickMagenta(64)"></td><td style="background-color:rgb(255, 89, 255);" class="colorSample" onmousemove="tooltip(1, 65)" onclick="clickMagenta(65)"></td><td style="background-color:rgb(255, 87, 255);" class="colorSample" onmousemove="tooltip(1, 66)" onclick="clickMagenta(66)"></td><td style="background-color:rgb(255, 84, 255);" class="colorSample" onmousemove="tooltip(1, 67)" onclick="clickMagenta(67)"></td><td style="background-color:rgb(255, 82, 255);" class="colorSample" onmousemove="tooltip(1, 68)" onclick="clickMagenta(68)"></td><td style="background-color:rgb(255, 79, 255);" class="colorSample" onmousemove="tooltip(1, 69)" onclick="clickMagenta(69)"></td><td style="background-color:rgb(255, 77, 255);" class="colorSample" onmousemove="tooltip(1, 70)" onclick="clickMagenta(70)"></td><td style="background-color:rgb(255, 74, 255);" class="colorSample" onmousemove="tooltip(1, 71)" onclick="clickMagenta(71)"></td><td style="background-color:rgb(255, 71, 255);" class="colorSample" onmousemove="tooltip(1, 72)" onclick="clickMagenta(72)"></td><td style="background-color:rgb(255, 69, 255);" class="colorSample" onmousemove="tooltip(1, 73)" onclick="clickMagenta(73)"></td><td style="background-color:rgb(255, 66, 255);" class="colorSample" onmousemove="tooltip(1, 74)" onclick="clickMagenta(74)"></td><td style="background-color:rgb(255, 64, 255);" class="colorSample" onmousemove="tooltip(1, 75)" onclick="clickMagenta(75)"></td><td style="background-color:rgb(255, 61, 255);" class="colorSample" onmousemove="tooltip(1, 76)" onclick="clickMagenta(76)"></td><td style="background-color:rgb(255, 59, 255);" class="colorSample" onmousemove="tooltip(1, 77)" onclick="clickMagenta(77)"></td><td style="background-color:rgb(255, 56, 255);" class="colorSample" onmousemove="tooltip(1, 78)" onclick="clickMagenta(78)"></td><td style="background-color:rgb(255, 54, 255);" class="colorSample" onmousemove="tooltip(1, 79)" onclick="clickMagenta(79)"></td><td style="background-color:rgb(255, 51, 255);" class="colorSample" onmousemove="tooltip(1, 80)" onclick="clickMagenta(80)"></td><td style="background-color:rgb(255, 48, 255);" class="colorSample" onmousemove="tooltip(1, 81)" onclick="clickMagenta(81)"></td><td style="background-color:rgb(255, 46, 255);" class="colorSample" onmousemove="tooltip(1, 82)" onclick="clickMagenta(82)"></td><td style="background-color:rgb(255, 43, 255);" class="colorSample" onmousemove="tooltip(1, 83)" onclick="clickMagenta(83)"></td><td style="background-color:rgb(255, 41, 255);" class="colorSample" onmousemove="tooltip(1, 84)" onclick="clickMagenta(84)"></td><td style="background-color:rgb(255, 38, 255);" class="colorSample" onmousemove="tooltip(1, 85)" onclick="clickMagenta(85)"></td><td style="background-color:rgb(255, 36, 255);" class="colorSample" onmousemove="tooltip(1, 86)" onclick="clickMagenta(86)"></td><td style="background-color:rgb(255, 33, 255);" class="colorSample" onmousemove="tooltip(1, 87)" onclick="clickMagenta(87)"></td><td style="background-color:rgb(255, 31, 255);" class="colorSample" onmousemove="tooltip(1, 88)" onclick="clickMagenta(88)"></td><td style="background-color:rgb(255, 28, 255);" class="colorSample" onmousemove="tooltip(1, 89)" onclick="clickMagenta(89)"></td><td style="background-color:rgb(255, 26, 255);" class="colorSample" onmousemove="tooltip(1, 90)" onclick="clickMagenta(90)"></td><td style="background-color:rgb(255, 23, 255);" class="colorSample" onmousemove="tooltip(1, 91)" onclick="clickMagenta(91)"></td><td style="background-color:rgb(255, 20, 255);" class="colorSample" onmousemove="tooltip(1, 92)" onclick="clickMagenta(92)"></td><td style="background-color:rgb(255, 18, 255);" class="colorSample" onmousemove="tooltip(1, 93)" onclick="clickMagenta(93)"></td><td style="background-color:rgb(255, 15, 255);" class="colorSample" onmousemove="tooltip(1, 94)" onclick="clickMagenta(94)"></td><td style="background-color:rgb(255, 13, 255);" class="colorSample" onmousemove="tooltip(1, 95)" onclick="clickMagenta(95)"></td><td style="background-color:rgb(255, 10, 255);" class="colorSample" onmousemove="tooltip(1, 96)" onclick="clickMagenta(96)"></td><td style="background-color:rgb(255, 8, 255);" class="colorSample" onmousemove="tooltip(1, 97)" onclick="clickMagenta(97)"></td><td style="background-color:rgb(255, 5, 255);" class="colorSample" onmousemove="tooltip(1, 98)" onclick="clickMagenta(98)"></td><td style="background-color:rgb(255, 3, 255);" class="colorSample" onmousemove="tooltip(1, 99)" onclick="clickMagenta(99)"></td><td style="background-color:rgb(255, 0, 255);" class="colorSample" onmousemove="tooltip(1, 100)" onclick="clickMagenta(100)"></td></tr></tbody></table></div>
                      </div>
                    </div>
                    <div class="w3-row">
                      <div class="w3-col colorinput">
                        <div class="cmjnLetter">J</div>
                        <input class="cInput" id="y01" oninput="setColor(this)" value="0" type="number">
                      </div>
                      <div class="w3-rest colorslider">
                        <div id="yellowtable"><table class="tableslider"><tbody><tr><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer0" style="display: none;"><div>0</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer1" style="display: none;"><div>1</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer2" style="display: none;"><div>2</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer3" style="display: none;"><div>3</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer4" style="display: none;"><div>4</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer5" style="display: none;"><div>5</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer6" style="display: none;"><div>6</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer7" style="display: none;"><div>7</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer8" style="display: none;"><div>8</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer9" style="display: none;"><div>9</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer10" style="display: none;"><div>10</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer11" style="display: none;"><div>11</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer12" style="display: none;"><div>12</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer13" style="display: none;"><div>13</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer14" style="display: none;"><div>14</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer15" style="display: none;"><div>15</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer16" style="display: none;"><div>16</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer17" style="display: none;"><div>17</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer18" style="display: none;"><div>18</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer19" style="display: none;"><div>19</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer20" style="display: none;"><div>20</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer21" style="display: none;"><div>21</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer22" style="display: none;"><div>22</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer23" style="display: none;"><div>23</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer24" style="display: none;"><div>24</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer25" style="display: none;"><div>25</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer26" style="display: none;"><div>26</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer27" style="display: none;"><div>27</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer28" style="display: none;"><div>28</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer29" style="display: none;"><div>29</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer30" style="display: none;"><div>30</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer31" style="display: none;"><div>31</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer32" style="display: none;"><div>32</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer33" style="display: none;"><div>33</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer34" style="display: none;"><div>34</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer35" style="display: none;"><div>35</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer36" style="display: none;"><div>36</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer37" style="display: none;"><div>37</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer38" style="display: none;"><div>38</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer39" style="display: none;"><div>39</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer40" style="display: none;"><div>40</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer41" style="display: none;"><div>41</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer42" style="display: none;"><div>42</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer43" style="display: none;"><div>43</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer44" style="display: none;"><div>44</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer45" style="display: none;"><div>45</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer46" style="display: none;"><div>46</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer47" style="display: none;"><div>47</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer48" style="display: none;"><div>48</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer49" style="display: none;"><div>49</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer50" style="display: none;"><div>50</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer51" style="display: none;"><div>51</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer52" style="display: none;"><div>52</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer53" style="display: none;"><div>53</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer54" style="display: none;"><div>54</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer55" style="display: none;"><div>55</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer56" style="display: none;"><div>56</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer57" style="display: none;"><div>57</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer58" style="display: none;"><div>58</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer59" style="display: none;"><div>59</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer60" style="display: none;"><div>60</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer61" style="display: none;"><div>61</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer62" style="display: none;"><div>62</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer63" style="display: none;"><div>63</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer64" style="display: none;"><div>64</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer65" style="display: none;"><div>65</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer66" style="display: none;"><div>66</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer67" style="display: none;"><div>67</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer68" style="display: none;"><div>68</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer69" style="display: none;"><div>69</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer70" style="display: none;"><div>70</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer71" style="display: none;"><div>71</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer72" style="display: none;"><div>72</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer73" style="display: none;"><div>73</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer74" style="display: none;"><div>74</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer75" style="display: none;"><div>75</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer76" style="display: none;"><div>76</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer77" style="display: none;"><div>77</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer78" style="display: none;"><div>78</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer79" style="display: none;"><div>79</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer80" style="display: inline;"><div>80</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer81" style="display: none;"><div>81</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer82" style="display: none;"><div>82</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer83" style="display: none;"><div>83</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer84" style="display: none;"><div>84</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer85" style="display: none;"><div>85</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer86" style="display: none;"><div>86</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer87" style="display: none;"><div>87</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer88" style="display: none;"><div>88</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer89" style="display: none;"><div>89</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer90" style="display: none;"><div>90</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer91" style="display: none;"><div>91</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer92" style="display: none;"><div>92</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer93" style="display: none;"><div>93</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer94" style="display: none;"><div>94</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer95" style="display: none;"><div>95</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer96" style="display: none;"><div>96</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer97" style="display: none;"><div>97</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer98" style="display: none;"><div>98</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer99" style="display: none;"><div>99</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="yellowpointer100" style="display: none;"><div>100</div><i class="fa fa-caret-down"></i></div></td></tr><tr><td style="background-color:rgb(255, 255, 255);" class="colorSample" onmousemove="tooltip(2, 0)" onclick="clickYellow(0)"></td><td style="background-color:rgb(255, 255, 252);" class="colorSample" onmousemove="tooltip(2, 1)" onclick="clickYellow(1)"></td><td style="background-color:rgb(255, 255, 250);" class="colorSample" onmousemove="tooltip(2, 2)" onclick="clickYellow(2)"></td><td style="background-color:rgb(255, 255, 247);" class="colorSample" onmousemove="tooltip(2, 3)" onclick="clickYellow(3)"></td><td style="background-color:rgb(255, 255, 245);" class="colorSample" onmousemove="tooltip(2, 4)" onclick="clickYellow(4)"></td><td style="background-color:rgb(255, 255, 242);" class="colorSample" onmousemove="tooltip(2, 5)" onclick="clickYellow(5)"></td><td style="background-color:rgb(255, 255, 240);" class="colorSample" onmousemove="tooltip(2, 6)" onclick="clickYellow(6)"></td><td style="background-color:rgb(255, 255, 237);" class="colorSample" onmousemove="tooltip(2, 7)" onclick="clickYellow(7)"></td><td style="background-color:rgb(255, 255, 235);" class="colorSample" onmousemove="tooltip(2, 8)" onclick="clickYellow(8)"></td><td style="background-color:rgb(255, 255, 232);" class="colorSample" onmousemove="tooltip(2, 9)" onclick="clickYellow(9)"></td><td style="background-color:rgb(255, 255, 230);" class="colorSample" onmousemove="tooltip(2, 10)" onclick="clickYellow(10)"></td><td style="background-color:rgb(255, 255, 227);" class="colorSample" onmousemove="tooltip(2, 11)" onclick="clickYellow(11)"></td><td style="background-color:rgb(255, 255, 224);" class="colorSample" onmousemove="tooltip(2, 12)" onclick="clickYellow(12)"></td><td style="background-color:rgb(255, 255, 222);" class="colorSample" onmousemove="tooltip(2, 13)" onclick="clickYellow(13)"></td><td style="background-color:rgb(255, 255, 219);" class="colorSample" onmousemove="tooltip(2, 14)" onclick="clickYellow(14)"></td><td style="background-color:rgb(255, 255, 217);" class="colorSample" onmousemove="tooltip(2, 15)" onclick="clickYellow(15)"></td><td style="background-color:rgb(255, 255, 214);" class="colorSample" onmousemove="tooltip(2, 16)" onclick="clickYellow(16)"></td><td style="background-color:rgb(255, 255, 212);" class="colorSample" onmousemove="tooltip(2, 17)" onclick="clickYellow(17)"></td><td style="background-color:rgb(255, 255, 209);" class="colorSample" onmousemove="tooltip(2, 18)" onclick="clickYellow(18)"></td><td style="background-color:rgb(255, 255, 207);" class="colorSample" onmousemove="tooltip(2, 19)" onclick="clickYellow(19)"></td><td style="background-color:rgb(255, 255, 204);" class="colorSample" onmousemove="tooltip(2, 20)" onclick="clickYellow(20)"></td><td style="background-color:rgb(255, 255, 201);" class="colorSample" onmousemove="tooltip(2, 21)" onclick="clickYellow(21)"></td><td style="background-color:rgb(255, 255, 199);" class="colorSample" onmousemove="tooltip(2, 22)" onclick="clickYellow(22)"></td><td style="background-color:rgb(255, 255, 196);" class="colorSample" onmousemove="tooltip(2, 23)" onclick="clickYellow(23)"></td><td style="background-color:rgb(255, 255, 194);" class="colorSample" onmousemove="tooltip(2, 24)" onclick="clickYellow(24)"></td><td style="background-color:rgb(255, 255, 191);" class="colorSample" onmousemove="tooltip(2, 25)" onclick="clickYellow(25)"></td><td style="background-color:rgb(255, 255, 189);" class="colorSample" onmousemove="tooltip(2, 26)" onclick="clickYellow(26)"></td><td style="background-color:rgb(255, 255, 186);" class="colorSample" onmousemove="tooltip(2, 27)" onclick="clickYellow(27)"></td><td style="background-color:rgb(255, 255, 184);" class="colorSample" onmousemove="tooltip(2, 28)" onclick="clickYellow(28)"></td><td style="background-color:rgb(255, 255, 181);" class="colorSample" onmousemove="tooltip(2, 29)" onclick="clickYellow(29)"></td><td style="background-color:rgb(255, 255, 179);" class="colorSample" onmousemove="tooltip(2, 30)" onclick="clickYellow(30)"></td><td style="background-color:rgb(255, 255, 176);" class="colorSample" onmousemove="tooltip(2, 31)" onclick="clickYellow(31)"></td><td style="background-color:rgb(255, 255, 173);" class="colorSample" onmousemove="tooltip(2, 32)" onclick="clickYellow(32)"></td><td style="background-color:rgb(255, 255, 171);" class="colorSample" onmousemove="tooltip(2, 33)" onclick="clickYellow(33)"></td><td style="background-color:rgb(255, 255, 168);" class="colorSample" onmousemove="tooltip(2, 34)" onclick="clickYellow(34)"></td><td style="background-color:rgb(255, 255, 166);" class="colorSample" onmousemove="tooltip(2, 35)" onclick="clickYellow(35)"></td><td style="background-color:rgb(255, 255, 163);" class="colorSample" onmousemove="tooltip(2, 36)" onclick="clickYellow(36)"></td><td style="background-color:rgb(255, 255, 161);" class="colorSample" onmousemove="tooltip(2, 37)" onclick="clickYellow(37)"></td><td style="background-color:rgb(255, 255, 158);" class="colorSample" onmousemove="tooltip(2, 38)" onclick="clickYellow(38)"></td><td style="background-color:rgb(255, 255, 156);" class="colorSample" onmousemove="tooltip(2, 39)" onclick="clickYellow(39)"></td><td style="background-color:rgb(255, 255, 153);" class="colorSample" onmousemove="tooltip(2, 40)" onclick="clickYellow(40)"></td><td style="background-color:rgb(255, 255, 150);" class="colorSample" onmousemove="tooltip(2, 41)" onclick="clickYellow(41)"></td><td style="background-color:rgb(255, 255, 148);" class="colorSample" onmousemove="tooltip(2, 42)" onclick="clickYellow(42)"></td><td style="background-color:rgb(255, 255, 145);" class="colorSample" onmousemove="tooltip(2, 43)" onclick="clickYellow(43)"></td><td style="background-color:rgb(255, 255, 143);" class="colorSample" onmousemove="tooltip(2, 44)" onclick="clickYellow(44)"></td><td style="background-color:rgb(255, 255, 140);" class="colorSample" onmousemove="tooltip(2, 45)" onclick="clickYellow(45)"></td><td style="background-color:rgb(255, 255, 138);" class="colorSample" onmousemove="tooltip(2, 46)" onclick="clickYellow(46)"></td><td style="background-color:rgb(255, 255, 135);" class="colorSample" onmousemove="tooltip(2, 47)" onclick="clickYellow(47)"></td><td style="background-color:rgb(255, 255, 133);" class="colorSample" onmousemove="tooltip(2, 48)" onclick="clickYellow(48)"></td><td style="background-color:rgb(255, 255, 130);" class="colorSample" onmousemove="tooltip(2, 49)" onclick="clickYellow(49)"></td><td style="background-color:rgb(255, 255, 128);" class="colorSample" onmousemove="tooltip(2, 50)" onclick="clickYellow(50)"></td><td style="background-color:rgb(255, 255, 125);" class="colorSample" onmousemove="tooltip(2, 51)" onclick="clickYellow(51)"></td><td style="background-color:rgb(255, 255, 122);" class="colorSample" onmousemove="tooltip(2, 52)" onclick="clickYellow(52)"></td><td style="background-color:rgb(255, 255, 120);" class="colorSample" onmousemove="tooltip(2, 53)" onclick="clickYellow(53)"></td><td style="background-color:rgb(255, 255, 117);" class="colorSample" onmousemove="tooltip(2, 54)" onclick="clickYellow(54)"></td><td style="background-color:rgb(255, 255, 115);" class="colorSample" onmousemove="tooltip(2, 55)" onclick="clickYellow(55)"></td><td style="background-color:rgb(255, 255, 112);" class="colorSample" onmousemove="tooltip(2, 56)" onclick="clickYellow(56)"></td><td style="background-color:rgb(255, 255, 110);" class="colorSample" onmousemove="tooltip(2, 57)" onclick="clickYellow(57)"></td><td style="background-color:rgb(255, 255, 107);" class="colorSample" onmousemove="tooltip(2, 58)" onclick="clickYellow(58)"></td><td style="background-color:rgb(255, 255, 105);" class="colorSample" onmousemove="tooltip(2, 59)" onclick="clickYellow(59)"></td><td style="background-color:rgb(255, 255, 102);" class="colorSample" onmousemove="tooltip(2, 60)" onclick="clickYellow(60)"></td><td style="background-color:rgb(255, 255, 99);" class="colorSample" onmousemove="tooltip(2, 61)" onclick="clickYellow(61)"></td><td style="background-color:rgb(255, 255, 97);" class="colorSample" onmousemove="tooltip(2, 62)" onclick="clickYellow(62)"></td><td style="background-color:rgb(255, 255, 94);" class="colorSample" onmousemove="tooltip(2, 63)" onclick="clickYellow(63)"></td><td style="background-color:rgb(255, 255, 92);" class="colorSample" onmousemove="tooltip(2, 64)" onclick="clickYellow(64)"></td><td style="background-color:rgb(255, 255, 89);" class="colorSample" onmousemove="tooltip(2, 65)" onclick="clickYellow(65)"></td><td style="background-color:rgb(255, 255, 87);" class="colorSample" onmousemove="tooltip(2, 66)" onclick="clickYellow(66)"></td><td style="background-color:rgb(255, 255, 84);" class="colorSample" onmousemove="tooltip(2, 67)" onclick="clickYellow(67)"></td><td style="background-color:rgb(255, 255, 82);" class="colorSample" onmousemove="tooltip(2, 68)" onclick="clickYellow(68)"></td><td style="background-color:rgb(255, 255, 79);" class="colorSample" onmousemove="tooltip(2, 69)" onclick="clickYellow(69)"></td><td style="background-color:rgb(255, 255, 77);" class="colorSample" onmousemove="tooltip(2, 70)" onclick="clickYellow(70)"></td><td style="background-color:rgb(255, 255, 74);" class="colorSample" onmousemove="tooltip(2, 71)" onclick="clickYellow(71)"></td><td style="background-color:rgb(255, 255, 71);" class="colorSample" onmousemove="tooltip(2, 72)" onclick="clickYellow(72)"></td><td style="background-color:rgb(255, 255, 69);" class="colorSample" onmousemove="tooltip(2, 73)" onclick="clickYellow(73)"></td><td style="background-color:rgb(255, 255, 66);" class="colorSample" onmousemove="tooltip(2, 74)" onclick="clickYellow(74)"></td><td style="background-color:rgb(255, 255, 64);" class="colorSample" onmousemove="tooltip(2, 75)" onclick="clickYellow(75)"></td><td style="background-color:rgb(255, 255, 61);" class="colorSample" onmousemove="tooltip(2, 76)" onclick="clickYellow(76)"></td><td style="background-color:rgb(255, 255, 59);" class="colorSample" onmousemove="tooltip(2, 77)" onclick="clickYellow(77)"></td><td style="background-color:rgb(255, 255, 56);" class="colorSample" onmousemove="tooltip(2, 78)" onclick="clickYellow(78)"></td><td style="background-color:rgb(255, 255, 54);" class="colorSample" onmousemove="tooltip(2, 79)" onclick="clickYellow(79)"></td><td style="background-color:rgb(255, 255, 51);" class="colorSample" onmousemove="tooltip(2, 80)" onclick="clickYellow(80)"></td><td style="background-color:rgb(255, 255, 48);" class="colorSample" onmousemove="tooltip(2, 81)" onclick="clickYellow(81)"></td><td style="background-color:rgb(255, 255, 46);" class="colorSample" onmousemove="tooltip(2, 82)" onclick="clickYellow(82)"></td><td style="background-color:rgb(255, 255, 43);" class="colorSample" onmousemove="tooltip(2, 83)" onclick="clickYellow(83)"></td><td style="background-color:rgb(255, 255, 41);" class="colorSample" onmousemove="tooltip(2, 84)" onclick="clickYellow(84)"></td><td style="background-color:rgb(255, 255, 38);" class="colorSample" onmousemove="tooltip(2, 85)" onclick="clickYellow(85)"></td><td style="background-color:rgb(255, 255, 36);" class="colorSample" onmousemove="tooltip(2, 86)" onclick="clickYellow(86)"></td><td style="background-color:rgb(255, 255, 33);" class="colorSample" onmousemove="tooltip(2, 87)" onclick="clickYellow(87)"></td><td style="background-color:rgb(255, 255, 31);" class="colorSample" onmousemove="tooltip(2, 88)" onclick="clickYellow(88)"></td><td style="background-color:rgb(255, 255, 28);" class="colorSample" onmousemove="tooltip(2, 89)" onclick="clickYellow(89)"></td><td style="background-color:rgb(255, 255, 26);" class="colorSample" onmousemove="tooltip(2, 90)" onclick="clickYellow(90)"></td><td style="background-color:rgb(255, 255, 23);" class="colorSample" onmousemove="tooltip(2, 91)" onclick="clickYellow(91)"></td><td style="background-color:rgb(255, 255, 20);" class="colorSample" onmousemove="tooltip(2, 92)" onclick="clickYellow(92)"></td><td style="background-color:rgb(255, 255, 18);" class="colorSample" onmousemove="tooltip(2, 93)" onclick="clickYellow(93)"></td><td style="background-color:rgb(255, 255, 15);" class="colorSample" onmousemove="tooltip(2, 94)" onclick="clickYellow(94)"></td><td style="background-color:rgb(255, 255, 13);" class="colorSample" onmousemove="tooltip(2, 95)" onclick="clickYellow(95)"></td><td style="background-color:rgb(255, 255, 10);" class="colorSample" onmousemove="tooltip(2, 96)" onclick="clickYellow(96)"></td><td style="background-color:rgb(255, 255, 8);" class="colorSample" onmousemove="tooltip(2, 97)" onclick="clickYellow(97)"></td><td style="background-color:rgb(255, 255, 5);" class="colorSample" onmousemove="tooltip(2, 98)" onclick="clickYellow(98)"></td><td style="background-color:rgb(255, 255, 3);" class="colorSample" onmousemove="tooltip(2, 99)" onclick="clickYellow(99)"></td><td style="background-color:rgb(255, 255, 0);" class="colorSample" onmousemove="tooltip(2, 100)" onclick="clickYellow(100)"></td></tr></tbody></table></div>
                      </div>
                    </div>
                    <div class="w3-row">
                      <div class="w3-col colorinput">
                        <div class="cmjnLetter">N</div>
                        <input class="cInput" id="k01" oninput="setColor(this)" value="0" type="number">
                      </div>
                      <div class="w3-rest colorslider">
                        <div id="blacktable"><table class="tableslider"><tbody><tr><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer0" style="display: none;"><div>0</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer1" style="display: none;"><div>1</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer2" style="display: none;"><div>2</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer3" style="display: none;"><div>3</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer4" style="display: none;"><div>4</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer5" style="display: none;"><div>5</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer6" style="display: none;"><div>6</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer7" style="display: none;"><div>7</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer8" style="display: none;"><div>8</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer9" style="display: none;"><div>9</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer10" style="display: none;"><div>10</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer11" style="display: none;"><div>11</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer12" style="display: none;"><div>12</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer13" style="display: none;"><div>13</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer14" style="display: none;"><div>14</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer15" style="display: none;"><div>15</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer16" style="display: none;"><div>16</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer17" style="display: none;"><div>17</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer18" style="display: none;"><div>18</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer19" style="display: none;"><div>19</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer20" style="display: none;"><div>20</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer21" style="display: none;"><div>21</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer22" style="display: none;"><div>22</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer23" style="display: none;"><div>23</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer24" style="display: none;"><div>24</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer25" style="display: none;"><div>25</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer26" style="display: none;"><div>26</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer27" style="display: none;"><div>27</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer28" style="display: none;"><div>28</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer29" style="display: none;"><div>29</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer30" style="display: none;"><div>30</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer31" style="display: none;"><div>31</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer32" style="display: none;"><div>32</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer33" style="display: none;"><div>33</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer34" style="display: none;"><div>34</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer35" style="display: none;"><div>35</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer36" style="display: none;"><div>36</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer37" style="display: none;"><div>37</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer38" style="display: none;"><div>38</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer39" style="display: none;"><div>39</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer40" style="display: none;"><div>40</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer41" style="display: none;"><div>41</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer42" style="display: none;"><div>42</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer43" style="display: none;"><div>43</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer44" style="display: none;"><div>44</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer45" style="display: none;"><div>45</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer46" style="display: inline;"><div>46</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer47" style="display: none;"><div>47</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer48" style="display: none;"><div>48</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer49" style="display: none;"><div>49</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer50" style="display: none;"><div>50</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer51" style="display: none;"><div>51</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer52" style="display: none;"><div>52</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer53" style="display: none;"><div>53</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer54" style="display: none;"><div>54</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer55" style="display: none;"><div>55</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer56" style="display: none;"><div>56</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer57" style="display: none;"><div>57</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer58" style="display: none;"><div>58</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer59" style="display: none;"><div>59</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer60" style="display: none;"><div>60</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer61" style="display: none;"><div>61</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer62" style="display: none;"><div>62</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer63" style="display: none;"><div>63</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer64" style="display: none;"><div>64</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer65" style="display: none;"><div>65</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer66" style="display: none;"><div>66</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer67" style="display: none;"><div>67</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer68" style="display: none;"><div>68</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer69" style="display: none;"><div>69</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer70" style="display: none;"><div>70</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer71" style="display: none;"><div>71</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer72" style="display: none;"><div>72</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer73" style="display: none;"><div>73</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer74" style="display: none;"><div>74</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer75" style="display: none;"><div>75</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer76" style="display: none;"><div>76</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer77" style="display: none;"><div>77</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer78" style="display: none;"><div>78</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer79" style="display: none;"><div>79</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer80" style="display: none;"><div>80</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer81" style="display: none;"><div>81</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer82" style="display: none;"><div>82</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer83" style="display: none;"><div>83</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer84" style="display: none;"><div>84</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer85" style="display: none;"><div>85</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer86" style="display: none;"><div>86</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer87" style="display: none;"><div>87</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer88" style="display: none;"><div>88</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer89" style="display: none;"><div>89</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer90" style="display: none;"><div>90</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer91" style="display: none;"><div>91</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer92" style="display: none;"><div>92</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer93" style="display: none;"><div>93</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer94" style="display: none;"><div>94</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer95" style="display: none;"><div>95</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer96" style="display: none;"><div>96</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer97" style="display: none;"><div>97</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer98" style="display: none;"><div>98</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer99" style="display: none;"><div>99</div><i class="fa fa-caret-down"></i></div></td><td style="position:relative;padding:0;"><div class="pointer" id="blackpointer100" style="display: none;"><div>100</div><i class="fa fa-caret-down"></i></div></td></tr><tr><td style="background-color:rgb(255, 255, 255);" class="colorSample" onmousemove="tooltip(3, 0)" onclick="clickBlack(0)"></td><td style="background-color:rgb(252, 252, 252);" class="colorSample" onmousemove="tooltip(3, 1)" onclick="clickBlack(1)"></td><td style="background-color:rgb(250, 250, 250);" class="colorSample" onmousemove="tooltip(3, 2)" onclick="clickBlack(2)"></td><td style="background-color:rgb(247, 247, 247);" class="colorSample" onmousemove="tooltip(3, 3)" onclick="clickBlack(3)"></td><td style="background-color:rgb(245, 245, 245);" class="colorSample" onmousemove="tooltip(3, 4)" onclick="clickBlack(4)"></td><td style="background-color:rgb(242, 242, 242);" class="colorSample" onmousemove="tooltip(3, 5)" onclick="clickBlack(5)"></td><td style="background-color:rgb(240, 240, 240);" class="colorSample" onmousemove="tooltip(3, 6)" onclick="clickBlack(6)"></td><td style="background-color:rgb(237, 237, 237);" class="colorSample" onmousemove="tooltip(3, 7)" onclick="clickBlack(7)"></td><td style="background-color:rgb(235, 235, 235);" class="colorSample" onmousemove="tooltip(3, 8)" onclick="clickBlack(8)"></td><td style="background-color:rgb(232, 232, 232);" class="colorSample" onmousemove="tooltip(3, 9)" onclick="clickBlack(9)"></td><td style="background-color:rgb(230, 230, 230);" class="colorSample" onmousemove="tooltip(3, 10)" onclick="clickBlack(10)"></td><td style="background-color:rgb(227, 227, 227);" class="colorSample" onmousemove="tooltip(3, 11)" onclick="clickBlack(11)"></td><td style="background-color:rgb(224, 224, 224);" class="colorSample" onmousemove="tooltip(3, 12)" onclick="clickBlack(12)"></td><td style="background-color:rgb(222, 222, 222);" class="colorSample" onmousemove="tooltip(3, 13)" onclick="clickBlack(13)"></td><td style="background-color:rgb(219, 219, 219);" class="colorSample" onmousemove="tooltip(3, 14)" onclick="clickBlack(14)"></td><td style="background-color:rgb(217, 217, 217);" class="colorSample" onmousemove="tooltip(3, 15)" onclick="clickBlack(15)"></td><td style="background-color:rgb(214, 214, 214);" class="colorSample" onmousemove="tooltip(3, 16)" onclick="clickBlack(16)"></td><td style="background-color:rgb(212, 212, 212);" class="colorSample" onmousemove="tooltip(3, 17)" onclick="clickBlack(17)"></td><td style="background-color:rgb(209, 209, 209);" class="colorSample" onmousemove="tooltip(3, 18)" onclick="clickBlack(18)"></td><td style="background-color:rgb(207, 207, 207);" class="colorSample" onmousemove="tooltip(3, 19)" onclick="clickBlack(19)"></td><td style="background-color:rgb(204, 204, 204);" class="colorSample" onmousemove="tooltip(3, 20)" onclick="clickBlack(20)"></td><td style="background-color:rgb(201, 201, 201);" class="colorSample" onmousemove="tooltip(3, 21)" onclick="clickBlack(21)"></td><td style="background-color:rgb(199, 199, 199);" class="colorSample" onmousemove="tooltip(3, 22)" onclick="clickBlack(22)"></td><td style="background-color:rgb(196, 196, 196);" class="colorSample" onmousemove="tooltip(3, 23)" onclick="clickBlack(23)"></td><td style="background-color:rgb(194, 194, 194);" class="colorSample" onmousemove="tooltip(3, 24)" onclick="clickBlack(24)"></td><td style="background-color:rgb(191, 191, 191);" class="colorSample" onmousemove="tooltip(3, 25)" onclick="clickBlack(25)"></td><td style="background-color:rgb(189, 189, 189);" class="colorSample" onmousemove="tooltip(3, 26)" onclick="clickBlack(26)"></td><td style="background-color:rgb(186, 186, 186);" class="colorSample" onmousemove="tooltip(3, 27)" onclick="clickBlack(27)"></td><td style="background-color:rgb(184, 184, 184);" class="colorSample" onmousemove="tooltip(3, 28)" onclick="clickBlack(28)"></td><td style="background-color:rgb(181, 181, 181);" class="colorSample" onmousemove="tooltip(3, 29)" onclick="clickBlack(29)"></td><td style="background-color:rgb(179, 179, 179);" class="colorSample" onmousemove="tooltip(3, 30)" onclick="clickBlack(30)"></td><td style="background-color:rgb(176, 176, 176);" class="colorSample" onmousemove="tooltip(3, 31)" onclick="clickBlack(31)"></td><td style="background-color:rgb(173, 173, 173);" class="colorSample" onmousemove="tooltip(3, 32)" onclick="clickBlack(32)"></td><td style="background-color:rgb(171, 171, 171);" class="colorSample" onmousemove="tooltip(3, 33)" onclick="clickBlack(33)"></td><td style="background-color:rgb(168, 168, 168);" class="colorSample" onmousemove="tooltip(3, 34)" onclick="clickBlack(34)"></td><td style="background-color:rgb(166, 166, 166);" class="colorSample" onmousemove="tooltip(3, 35)" onclick="clickBlack(35)"></td><td style="background-color:rgb(163, 163, 163);" class="colorSample" onmousemove="tooltip(3, 36)" onclick="clickBlack(36)"></td><td style="background-color:rgb(161, 161, 161);" class="colorSample" onmousemove="tooltip(3, 37)" onclick="clickBlack(37)"></td><td style="background-color:rgb(158, 158, 158);" class="colorSample" onmousemove="tooltip(3, 38)" onclick="clickBlack(38)"></td><td style="background-color:rgb(156, 156, 156);" class="colorSample" onmousemove="tooltip(3, 39)" onclick="clickBlack(39)"></td><td style="background-color:rgb(153, 153, 153);" class="colorSample" onmousemove="tooltip(3, 40)" onclick="clickBlack(40)"></td><td style="background-color:rgb(150, 150, 150);" class="colorSample" onmousemove="tooltip(3, 41)" onclick="clickBlack(41)"></td><td style="background-color:rgb(148, 148, 148);" class="colorSample" onmousemove="tooltip(3, 42)" onclick="clickBlack(42)"></td><td style="background-color:rgb(145, 145, 145);" class="colorSample" onmousemove="tooltip(3, 43)" onclick="clickBlack(43)"></td><td style="background-color:rgb(143, 143, 143);" class="colorSample" onmousemove="tooltip(3, 44)" onclick="clickBlack(44)"></td><td style="background-color:rgb(140, 140, 140);" class="colorSample" onmousemove="tooltip(3, 45)" onclick="clickBlack(45)"></td><td style="background-color:rgb(138, 138, 138);" class="colorSample" onmousemove="tooltip(3, 46)" onclick="clickBlack(46)"></td><td style="background-color:rgb(135, 135, 135);" class="colorSample" onmousemove="tooltip(3, 47)" onclick="clickBlack(47)"></td><td style="background-color:rgb(133, 133, 133);" class="colorSample" onmousemove="tooltip(3, 48)" onclick="clickBlack(48)"></td><td style="background-color:rgb(130, 130, 130);" class="colorSample" onmousemove="tooltip(3, 49)" onclick="clickBlack(49)"></td><td style="background-color:rgb(128, 128, 128);" class="colorSample" onmousemove="tooltip(3, 50)" onclick="clickBlack(50)"></td><td style="background-color:rgb(125, 125, 125);" class="colorSample" onmousemove="tooltip(3, 51)" onclick="clickBlack(51)"></td><td style="background-color:rgb(122, 122, 122);" class="colorSample" onmousemove="tooltip(3, 52)" onclick="clickBlack(52)"></td><td style="background-color:rgb(120, 120, 120);" class="colorSample" onmousemove="tooltip(3, 53)" onclick="clickBlack(53)"></td><td style="background-color:rgb(117, 117, 117);" class="colorSample" onmousemove="tooltip(3, 54)" onclick="clickBlack(54)"></td><td style="background-color:rgb(115, 115, 115);" class="colorSample" onmousemove="tooltip(3, 55)" onclick="clickBlack(55)"></td><td style="background-color:rgb(112, 112, 112);" class="colorSample" onmousemove="tooltip(3, 56)" onclick="clickBlack(56)"></td><td style="background-color:rgb(110, 110, 110);" class="colorSample" onmousemove="tooltip(3, 57)" onclick="clickBlack(57)"></td><td style="background-color:rgb(107, 107, 107);" class="colorSample" onmousemove="tooltip(3, 58)" onclick="clickBlack(58)"></td><td style="background-color:rgb(105, 105, 105);" class="colorSample" onmousemove="tooltip(3, 59)" onclick="clickBlack(59)"></td><td style="background-color:rgb(102, 102, 102);" class="colorSample" onmousemove="tooltip(3, 60)" onclick="clickBlack(60)"></td><td style="background-color:rgb(99, 99, 99);" class="colorSample" onmousemove="tooltip(3, 61)" onclick="clickBlack(61)"></td><td style="background-color:rgb(97, 97, 97);" class="colorSample" onmousemove="tooltip(3, 62)" onclick="clickBlack(62)"></td><td style="background-color:rgb(94, 94, 94);" class="colorSample" onmousemove="tooltip(3, 63)" onclick="clickBlack(63)"></td><td style="background-color:rgb(92, 92, 92);" class="colorSample" onmousemove="tooltip(3, 64)" onclick="clickBlack(64)"></td><td style="background-color:rgb(89, 89, 89);" class="colorSample" onmousemove="tooltip(3, 65)" onclick="clickBlack(65)"></td><td style="background-color:rgb(87, 87, 87);" class="colorSample" onmousemove="tooltip(3, 66)" onclick="clickBlack(66)"></td><td style="background-color:rgb(84, 84, 84);" class="colorSample" onmousemove="tooltip(3, 67)" onclick="clickBlack(67)"></td><td style="background-color:rgb(82, 82, 82);" class="colorSample" onmousemove="tooltip(3, 68)" onclick="clickBlack(68)"></td><td style="background-color:rgb(79, 79, 79);" class="colorSample" onmousemove="tooltip(3, 69)" onclick="clickBlack(69)"></td><td style="background-color:rgb(77, 77, 77);" class="colorSample" onmousemove="tooltip(3, 70)" onclick="clickBlack(70)"></td><td style="background-color:rgb(74, 74, 74);" class="colorSample" onmousemove="tooltip(3, 71)" onclick="clickBlack(71)"></td><td style="background-color:rgb(71, 71, 71);" class="colorSample" onmousemove="tooltip(3, 72)" onclick="clickBlack(72)"></td><td style="background-color:rgb(69, 69, 69);" class="colorSample" onmousemove="tooltip(3, 73)" onclick="clickBlack(73)"></td><td style="background-color:rgb(66, 66, 66);" class="colorSample" onmousemove="tooltip(3, 74)" onclick="clickBlack(74)"></td><td style="background-color:rgb(64, 64, 64);" class="colorSample" onmousemove="tooltip(3, 75)" onclick="clickBlack(75)"></td><td style="background-color:rgb(61, 61, 61);" class="colorSample" onmousemove="tooltip(3, 76)" onclick="clickBlack(76)"></td><td style="background-color:rgb(59, 59, 59);" class="colorSample" onmousemove="tooltip(3, 77)" onclick="clickBlack(77)"></td><td style="background-color:rgb(56, 56, 56);" class="colorSample" onmousemove="tooltip(3, 78)" onclick="clickBlack(78)"></td><td style="background-color:rgb(54, 54, 54);" class="colorSample" onmousemove="tooltip(3, 79)" onclick="clickBlack(79)"></td><td style="background-color:rgb(51, 51, 51);" class="colorSample" onmousemove="tooltip(3, 80)" onclick="clickBlack(80)"></td><td style="background-color:rgb(48, 48, 48);" class="colorSample" onmousemove="tooltip(3, 81)" onclick="clickBlack(81)"></td><td style="background-color:rgb(46, 46, 46);" class="colorSample" onmousemove="tooltip(3, 82)" onclick="clickBlack(82)"></td><td style="background-color:rgb(43, 43, 43);" class="colorSample" onmousemove="tooltip(3, 83)" onclick="clickBlack(83)"></td><td style="background-color:rgb(41, 41, 41);" class="colorSample" onmousemove="tooltip(3, 84)" onclick="clickBlack(84)"></td><td style="background-color:rgb(38, 38, 38);" class="colorSample" onmousemove="tooltip(3, 85)" onclick="clickBlack(85)"></td><td style="background-color:rgb(36, 36, 36);" class="colorSample" onmousemove="tooltip(3, 86)" onclick="clickBlack(86)"></td><td style="background-color:rgb(33, 33, 33);" class="colorSample" onmousemove="tooltip(3, 87)" onclick="clickBlack(87)"></td><td style="background-color:rgb(31, 31, 31);" class="colorSample" onmousemove="tooltip(3, 88)" onclick="clickBlack(88)"></td><td style="background-color:rgb(28, 28, 28);" class="colorSample" onmousemove="tooltip(3, 89)" onclick="clickBlack(89)"></td><td style="background-color:rgb(26, 26, 26);" class="colorSample" onmousemove="tooltip(3, 90)" onclick="clickBlack(90)"></td><td style="background-color:rgb(23, 23, 23);" class="colorSample" onmousemove="tooltip(3, 91)" onclick="clickBlack(91)"></td><td style="background-color:rgb(20, 20, 20);" class="colorSample" onmousemove="tooltip(3, 92)" onclick="clickBlack(92)"></td><td style="background-color:rgb(18, 18, 18);" class="colorSample" onmousemove="tooltip(3, 93)" onclick="clickBlack(93)"></td><td style="background-color:rgb(15, 15, 15);" class="colorSample" onmousemove="tooltip(3, 94)" onclick="clickBlack(94)"></td><td style="background-color:rgb(13, 13, 13);" class="colorSample" onmousemove="tooltip(3, 95)" onclick="clickBlack(95)"></td><td style="background-color:rgb(10, 10, 10);" class="colorSample" onmousemove="tooltip(3, 96)" onclick="clickBlack(96)"></td><td style="background-color:rgb(8, 8, 8);" class="colorSample" onmousemove="tooltip(3, 97)" onclick="clickBlack(97)"></td><td style="background-color:rgb(5, 5, 5);" class="colorSample" onmousemove="tooltip(3, 98)" onclick="clickBlack(98)"></td><td style="background-color:rgb(3, 3, 3);" class="colorSample" onmousemove="tooltip(3, 99)" onclick="clickBlack(99)"></td><td style="background-color:rgb(0, 0, 0);" class="colorSample" onmousemove="tooltip(3, 100)" onclick="clickBlack(100)"></td></tr></tbody></table></div>
                      </div>
                    </div>
                    </div>
                    </div>
                    <!-- fin sélecteur -->


                    <div class="row form-group transparency" ng-show="fabric.selectedObject.type != 'curvedText'">
                        <md-input-container flex>
                            <label for="Transparency">Transparence:</label>
                            <input class='col-sm-12' title="Transparency" type='range' min="0" max="1" step=".01" ng-model="fabric.selectedObject.opacity" ng-change="opacity(fabric.selectedObject.opacity);"/>
                        </md-input-container>
                    </div>

                    <div class="col-sm-12 input-group cloud-options" ng-show="fabric.selectedObject.type == 'image'">
                        <label class="custom-label">Filtres:</label>
                        <br>
                        <md-checkbox ng-model="fabric.selectedObject.isGrayscale" aria-label="Grayscale" ng-click="setImageFilter(fabric.selectedObject.isGrayscale, 0);">Noir et Blanc</md-checkbox>
                        <md-checkbox ng-model="fabric.selectedObject.isSepia" aria-label="Sepia" ng-click="setImageFilter(fabric.selectedObject.isSepia, 1);">Sepia</md-checkbox>
                        <md-checkbox ng-model="fabric.selectedObject.isInvert" aria-label="Invert" ng-click="setImageFilter(fabric.selectedObject.isInvert, 2);">Inverser</md-checkbox>
                        <md-checkbox ng-model="fabric.selectedObject.isEmboss" aria-label="Emboss" ng-click="setImageFilter(fabric.selectedObject.isEmboss, 3);">Embosser</md-checkbox>
                        <md-checkbox ng-model="fabric.selectedObject.isSharpen" aria-label="Sharpen" ng-click="setImageFilter(fabric.selectedObject.isSharpen, 4);">Sharpen</md-checkbox>
                    </div>
                </div>

            </div>

            <!---->
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 canvas_section pull-right">
            <div class="row">
                <div class="canvas_options">
                    <ul class="clearfix">
                        <!--<li ng-click="layers()" href="#Layers" data-toggle="tab"><i class="fa fa-object-ungroup"></i><span>Calques</span></li>-->

                        <li ng-click="copyItem()" title="copier le calque sélectionné"><i class="fa fa-copy"></i><span>Copier</span>
                        </li>
                        <li ng-click="pasteItem()" title="coller le calque sélectionné"><i class="fa fa-paste"></i><span>Coller</span></li>
                        <li ng-click="globalAlign();" title="centrer le calque sélectionné"><i class="fa fa-bullseye"></i><span>Centrer</span></li>
                        <li ng-click="horizontalAlign()" title="centrer horizontalement"><i class="fa fa-arrows-h"></i><span>Centrer H</span></li>
                        <li ng-click="verticalAlign()" title="centrer verticalement"><i class="fa fa-arrows-v"></i><span>Centrer V</span></li>
                        <li ng-click="{ active: flipObject() }" title="symétrie"><i class="fa fa-exchange fa-2"></i><span>Mirroir</span></li>
                        <li ng-click="removeSelectedObject()" title="supprimer le calque sélectionné"><i class="fa fa-trash"></i><span>Supprimer</span></li>
                        <!--<li ng-click="undo()">
                            <a class="fa fa-undo ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                            <span class="nope">Annuler</span>
                        </li>
                        <li ng-click="redo()">
                            <a class="fa fa-repeat ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                            <span class="nope">Rétablir</span>
                        </li>-->
                        <li ng-click="retour()" title="rétablir la dernière sauvegarde"><i class="fa fa-undo"></i><span>Rétablir</span></li>
                        <li ng-click="reinitialize()" id="reset" title="rétablir gabarit vierge" class="pink"><i class="fa fa-eraser"></i><span>Réinitialiser</span></li>

                        <span class="unredo disno">
                          <li ng-click="selectA()">
                              <a class="fa fa-object-group ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                              <span class="nope">Tout sélectionner</span>
                          </li>


                        </span>


                        <!--<li ng-click="clearAll()"><i class="fa fa-trash"></i><span>Tout effacer</span></li>-->

                    </ul>

                    <div class="btnTopright">

                            <ul>
                              <!--<li>

                                  <a ng-click="downloadObjectAsPdf()" href="#" class="ng-scope">Download as PDF</a>
                              </li>-->
                                <li class="retourCom" title="retour à votre commande">
                                  <a ng-click="quicksaveJSON()" href="/vos-devis/?detail=<?php echo $nbcom; ?>" class="ng-scope tooltip-wide" data-toggle="tooltip" data-placement="bottom" title="Revenir au détail de votre commande"><i class="fa fa-shopping-cart"></i><span>Retour commande</span></a>
                                </li>

                                <li class="saveModif" ng-click="saveObjectAsJSON()" title="sauvegarder mes modifications">
                                  <a href="#" class="ng-scope tooltip-wide" data-toggle="tooltip" data-placement="bottom" title="Vous permet de retrouver vos modifications et de retravailler votre maquette une prochaine fois."><i class="fa fa-save"></i><span>Sauvegarder<br /> </span></a>
                                </li>

                                <li class="saveObject">
                                      <a ng-hide="loader" ng-click="saveObjectAsJpg();" href="#" class="ng-scope tooltip-wide" data-toggle="tooltip" data-placement="bottom" title="Envoyer votre maquette pour validation à notre service infographie. Veuillez patienter jusqu'au message de confirmation indiquant que nous avons bien reçu votre maquette."><i class="fa fa-send" ></i><br /><span>Terminé ? Envoyer</span></a>

                                      <a ng-show="loader" href="#" class="ng-scope">
                                          <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                          <br /><span>Veuillez patienter</span>
                                      </a>

                                  <ul class="ulChildMenu">

                                      <!--  <li class="childLi">
                                            <a ng-click="saveObjectAsJpg();" href="#" class="ng-scope tooltip-wide" data-toggle="tooltip" data-placement="left" title="Envoyer votre maquette pour validation à notre service infographie. Veuillez patienter jusqu'au message de confirmation indiquant que nous avons bien reçu votre maquette."><i class="fa fa-send" ></i><br />Terminé ? Envoyer</a>
                                        </li>
                                        <li class="childLi">
                                            <a ng-click="saveObjectAsJSON()" href="#" class="ng-binding ng-scope tooltip-wide" data-toggle="tooltip" data-placement="left" title="Sauvegarder votre mise en page, formes, couleurs, images et textes."><i class="fa fa-save" ></i><br />Terminer plus tard</a>
                                        </li>
                                        <li class="childLi">
                                            <a ng-click="saveObjectAsPng()" href="#" class="ng-scope">Save as PNG</a>
                                        </li>-->
                                        <!--<li class="childLi">
                                            <a ng-click="downloadObjectAsPdf()" href="#" class="ng-scope">Download as PDF</a>
                                        </li>-->
                                    </ul>
                                </li>

                                <!--<li>
                                    <a ng-click="printObject()" href="#" class="ng-scope"><span class="fa fa-print"></span></a>
                                    <md-tooltip md-visible="print.showTooltip" md-direction="left">Print</md-tooltip>
                                </li>-->

                                <!--<li>
                                    <a ng-click="downloadObject()" href="#" class="ng-scope"><span class="fa fa-cloud-download"></span></a>
                                    <md-tooltip md-visible="download.showTooltip" md-direction="left">Download as PNG</md-tooltip>
                                </li>-->

                            </ul>


                        <!--<div class="social-share">
                            <a href="javascript:void(0);" id="f_share_button" class="fa fa-facebook" ng-click="shareOnFacebook($event);"></a> <a href="javascript:void(0)" class="fa fa-twitter" ng-click="shareOnTwitter($event);"></a>
                        </div>-->
                    </div>
                </div>
                <div class="canvas_image image-builder ng-isolate-scope">
                  <ul class="zoomButtons pull-right">
                    <li ng-click="zoomObject('zoomin')">
                        <a class="fa fa-search-plus ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                        <md-tooltip md-visible="zoomin.showTooltip" md-direction="left">Zoom +</md-tooltip>
                    </li>
                    <li ng-click="zoomObject('zoomout')">
                        <a class="fa fa-search-minus ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                        <md-tooltip md-visible="zoomout.showTooltip" md-direction="left">Zoom -</md-tooltip>
                    </li>
                    <li ng-click="zoomObject('zoomreset')">
                        <a class="fa fa-undo ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                        <md-tooltip md-visible="zoomreset.showTooltip" md-direction="left">Taille initiale</md-tooltip>
                    </li>
                  </ul>

                    <div class='fabric-container'>

                        <div class="canvas-container-outer">
                            <canvas fabric='fabric'></canvas>
                        </div>

                    </div>

                </div>
                <div class="canvas_sub_image">
                    <!--<ul>
                        <li ng-repeat="prodImg in productImages">
                            <img ng-click='loadProduct(defaultProductTitle, prodImg, defaultProductId, defaultPrice, defaultCurrency, $index)' data-ng-src="{{prodImg}}" alt="" width="120px;">
                        </li>
                    </ul>-->
                </div>

                </div>

            </div>

        </div>

    <!--<section class="customizer" id="customizer">

        <div class="selector">
              <h2>Configurer l'espace de travail</h2>
              <div class="color_section color_block">

                    <span class="customizer_headings">Couleurs</span>

                  <div class="col-lg-12 color-mixer">
                      <div class="col-lg-12">
                          <label class="customizer-label">Primaire</label>
                          <div class="input-group colorPicker2 colorpicker-element">
                                  <input ng-model="primaryColor" colorpicker type="text" value="" class="form-control"/>
                                  <span class="input-group-addon"><i style="background: {{primaryColor}};"></i></span>
                          </div>
                      </div>
                      <div class="col-lg-12">
                          <label class="customizer-label">Secondaire</label>
                          <div class="input-group colorPicker2 colorpicker-element">
                              <input ng-model="secondaryColor" colorpicker type="text" value="" class="form-control"/>
                              <span class="input-group-addon"><i style="background: {{secondaryColor}};"></i></span>
                          </div>
                      </div>
                      <hr /><br /><br />
                      <div class="col-lg-12">
                      <center><input ng-model="colorResult" type="button" value="Appliquer" class="btn btn-info" ng-click="changeColorScheme()"/></center>
                      </div>

                  </div>

                    <span class="customizer_headings">Arrière plan</span>
                    <ul id="canvas_color_selector" class="color_selector canvas_selector">
                          <li data-attr="images/site_bg_01.jpg" class="canvas_1"></li>
                          <li data-attr="images/site_bg_02.jpg" class="canvas_2"></li>
                          <li data-attr="images/site_bg_03.jpg" class="canvas_3"></li>
                          <li data-attr="images/site_bg_04.jpg" class="canvas_4"></li>
                    </ul>

              </div>
        </div>
        <i class="fa fa-cog" id="selector_icon"></i>
    </section>-->
    <footer class="footer">
      <div class="logofb"><span></span></div>
      <div class="txta">
        <div class="bienv">Bienvenue sur notre module de création de maquette en ligne !</div>
        <div class="advToggle">
          <label class="switch">
            <input type="checkbox" class="checkbox">
            <span class="slider round"></span>
          </label>
          <div class="advanced">
            utilisateur avancé <span class="onoff">OFF</span> <a href="#" data-toggle="modal" data-target="#avance"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
          </div>


        </div>
      </div>
      <a class="btret" href="" data-toggle="modal" data-target="#faq">
        <i class="fa fa-question-circle"></i> astuces / FAQ
        <!--<span class="waiting" ng-show="saving" href="#" class="ng-scope">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Votre maquette est en cours de sauvegarde...
        </span>
        <span class="waiting" ng-show="sending" href="#" class="ng-scope">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Votre maquette est en cours d'envoi...
        </span>
        <span class="waiting" ng-show="imging" href="#" class="ng-scope">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Votre image est en cours d'importation...
        </span>-->
      </a>

    </footer>
  </div>
</div>

<script src="assets/angular.js"></script>

<script src="assets/angular-animate.js"></script>
<script src="assets/angular-aria.js"></script>

<script src="assets/angular-material.js"></script>

<script src="assets/ng-file-upload/angular-file-upload.js"></script>
<script src="assets/ng-file-upload/angular-file-upload-shim.js"></script>

<!--<script type="text/javascript" src="assets/qr-code/raphael-2.1.0-min.js"></script>
<script type="text/javascript" src="assets/qr-code/qrcodesvg.js"></script>-->

<script src='assets/word-cloud/d3.v3.min.js'></script>
<script src='assets/word-cloud/d3.layout.cloud.js'></script>

<script src="assets/angular-sanitize.min.js"></script>
<script src="assets/ng-scrollbar.min.js"></script>

<script src="js/w3color.js"></script>

<script>
window.paceOptions = {
  ajax: {
      trackMethods: ["GET", "POST"],
      trackWebSockets: false
  },
  document: false,
  restartOnPushState: false
};
</script>
<script src="js/pace.min.js"></script>
<script src="assets/fabric/fabric.min.js"></script>
<!--<script src="assets/fabric/fabricExtensions.js"></script>-->
<script src="assets/fabric/fabric.js"></script>
<script src="assets/fabric/fabricCanvas.js"></script>
<script src="assets/fabric/fabricConstants.js"></script>
<script src="assets/fabric/fabricDirective.js"></script>
<script src="assets/fabric/fabricDirtyStatus.js"></script>
<script src="assets/fabric/fabricUtilities.js"></script>
<script src="assets/fabric/fabricWindow.js"></script>
<script src="assets/fabric/fabric.curvedText.js"></script>
<script src="assets/fabric/fabric.customiseControls.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>-->

<!--<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.js"></script>
<script src="js/ngprogress-lite.js"></script>

<script src="assets/colorpicker/bootstrap-colorpicker-module.js"></script>
<script src="js/application.js"></script>

<script src="assets/file/fileSaver.js"></script>
<script src="assets/pdf/jspdf.debug.js"></script>


<script>
  $(document).ready(function() {

    // activer les tooltips bootstrap
    $('[data-toggle="tooltip"]').tooltip();

    // charger la modal faq au démarrage
    /*$(window).on('load',function(){
      $('#faq').modal('show');
    });*/

    // cacher les boutons sauvegarder au clic
    /*$('.childLi').on(click, function(){
      $('.childLi').hide();
    });
    */

  });
  //------------------------------------------------------------------------CMJN
  function setColor(elmnt) {
    var ele, col, c, m, y, k, rgb;
    c = document.getElementById("c01");
    m = document.getElementById("m01");
    y = document.getElementById("y01");
    k = document.getElementById("k01");
    elmnt.value = Number(elmnt.value);
    if (parseInt(elmnt.value) < 0) {elmnt.value = "0";}
    if (parseInt(elmnt.value) > 100) {elmnt.value = "100";}
    rgb = w3color("cmyk(" + c.value + "%, " + m.value + "%, " + y.value + "%, " + k.value + "%)");
    //document.getElementById("result01").style.backgroundColor = rgb.toHexString();
    //document.getElementById("cmyk01").value = rgb.toHexString();
    document.getElementById("result01").value = rgb.toHexString();
    document.getElementById('result01').dispatchEvent(new Event('change'));
    document.getElementById("rgb01").innerHTML = rgb.toRgbString();
    document.getElementById("hsl01").innerHTML = rgb.toHslString();
    document.getElementById("hex01").innerHTML = rgb.toCmykString();
    for (i = 0; i <= 100; i++) {
      document.getElementById("cyanpointer" + i).style.display = "none";
      document.getElementById("magentapointer" + i).style.display = "none";
      document.getElementById("yellowpointer" + i).style.display = "none";
      document.getElementById("blackpointer" + i).style.display = "none";
    }
    document.getElementById("cyanpointer" + c.value).style.display = "inline";
    document.getElementById("magentapointer" + m.value).style.display = "inline";
    document.getElementById("yellowpointer" + y.value).style.display = "inline";
    document.getElementById("blackpointer" + k.value).style.display = "inline";
    //document.getElementById("linktocp").innerHTML = "<hr style='border-color:#dfdfdf'><p><a href='colors_picker.asp?colorhex=" + rgb.toHexString().substr(1) + "'>Use this color in our Color Picker</a></p>";

  }

  function setFullColor() {
    var color = w3color(document.getElementById("cmyk01").value);
    var cmyk = color.toCmyk();
    document.getElementById("c01").value = (cmyk.c * 100).toFixed(0);
    document.getElementById("m01").value = (cmyk.m * 100).toFixed(0);
    document.getElementById("y01").value = (cmyk.y * 100).toFixed(0);
    document.getElementById("k01").value = (cmyk.k * 100).toFixed(0);
    setColor(document.getElementById("c01"));
  }
  color = w3color(document.getElementById("cmyk01").value);
  document.getElementById("cmyk01").value = color.toCmykString();
  setFullColor();

  /*document.getElementsByClassName("swatch").onclick = function(){
    setFullColor();
  }*/

</script>

<div id="qrcode"></div>
<div id="wordcloud"></div>
<div class="css_gen"></div>
<div class="svgElements"></div>
</body>
</html>

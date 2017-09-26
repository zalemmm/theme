<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Créez votre maquette en ligne - France-Banderole.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300|Source+Sans+Pro:400,700,700i,900|Architects+Daughter|Roboto|Oswald|Montserrat|Lora|PT+Sans|Ubuntu|Roboto+Slab|Fjalla+One|Indie+Flower|Playfair+Display|Poiret+One|Dosis|Oxygen|Lobster|Play|Shadows+Into+Light|Pacifico|Dancing+Script|Kaushan+Script|Gloria+Hallelujah|Black+Ops+One|Lobster+Two|Satisfy|Pontano+Sans|Domine|Russo+One|Handlee|Courgette|Special+Elite|Amaranth|Vidaloka' rel='stylesheet' type='text/css'>

  <meta name="msapplication-TileColor">
  <meta name="theme-color">

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

  <!-- CSS End -->

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body id="body">

<?php
  session_start();
  $path = $_SERVER['DOCUMENT_ROOT'];
  $nbcom = $_GET['number'];
  $nbname = $_GET['name'];
  $nbdesc = $_GET['desc'];
  $nbh = $_GET['hauteur'];
  $nbl = $_GET['largeur'];
  $_SESSION['nbcom'] = $nbcom;
  $_SESSION['nbname'] = $nbname;
  $_SESSION['nbdesc'] = $nbdesc;
  $_SESSION['nbh'] = $nbh;
  $_SESSION['nbl'] = $nbl;

  $find = '/recto-verso/';
  $rectoVerso = preg_match_all($find, $nbdesc, $resultat);
  $rectoVerso = count($resultat[0]);

  $find2 = '/minia3/';
  $minia3 = preg_match_all($find2, $nbdesc, $resultat2);
  $minia3 = count($resultat2[0]);

  $find3 = '/minia4/';
  $minia4 = preg_match_all($find3, $nbdesc, $resultat3);
  $minia4 = count($resultat3[0]);
?>

<div class="container ng-scope" ng-controller="ProductCtrl" ng-app="productApp" id="productApp">
    <div ng-show="loading" class="loading">
        <h1 class="lodingMessage">Initialisation<img src="images/ajax-loader.gif" alt="loading" /></h1>
    </div>
    <div class="row clearfix" ng-cloak>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 editor_section">
            <div id="content" class="tabing">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active"><a ng-click="deactivateAll()" href="#Products" class="products" data-toggle="tab"><i class="fa fa-shopping-cart"></i>Produit</a></li>
                    <li><a ng-click="deactivateAll()" href="#Graphics" class="graphics" data-toggle="tab"><i class="fa fa-picture-o" aria-hidden="true"></i>Image</a></li>
                    <li><a ng-click="addTextByAction()" href="#Text" class="text" data-toggle="tab"><i class="fa fa-font" aria-hidden="true"></i>Texte</a></li>
                </ul>
                <div id="my-tab-content" class="tab-content action_tabs">
                    <div class="tab-pane active clearfix" id="Products">
                      <h5>commande n° <span id="number"><?php echo $nbcom;?></span></h5>

                      <div class="encart">
                        <h2 id="produit"><?php echo $nbname; ?></h2>
                        <p>Gabarit <?php
                          if ($minia3 >= 1){echo 'A3';}
                          if ($minia4 >= 1){echo 'A4';} ?>
                          <span id="hauteur"><?php echo $nbh; ?></span> x <span id="largeur"><?php echo $nbl; ?></span> cm <?php if ($rectoVerso >= 1){echo 'recto/verso';}?> </p>
                      </div>

                        <h4>Créez votre maquette en quelques clics:</h4>
                        <span id="desc" style="display:none;"><?php echo $nbdesc; ?></span>
                        <div class="aide">

                          <div class="intro">
                            <p><span>1</span> Vous pouvez commencer par cliquer sur votre gabarit pour changer sa couleur de fond </p>
                            <p><span>2</span> Importez vos images et entrez du texte à l'aide des boutons ci-dessus '<i class="fa fa-picture-o" aria-hidden="true"></i> / <i class="fa fa-font" aria-hidden="true"></i>'</p>
                            <p><span>3</span> Agencez vos calques : un simple clic dessus pour les déplacer, changer la taile... <br />
                              Dans '<i class="fa fa-object-ungroup"></i> calques' vous pouvez gérer l'ordre de superposition de vos éléments</p>
                            <p><span>4</span> Lorsque vous êtes satisfait de votre création, vérifiez bien qu'il n'y ait pas d'erreurs et cliquez sur '<i class="fa fa-save"></i> enregistrer' pour nous la transmettre</p>
                            <p class="dashed">Vos éléments (excepté image de fond) ne doivent pas dépasser la marge technique en pointillés gris</p>

                            <!-- modal astuces -->
                            <div id="faq" class="modal" tabindex="-1" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title">Astuces / FAQ</h4>
                                                    <p class="alert alert-info alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        Pour déplacer ensemble vos calques dans l'espace de travail, pensez à d'abord appuyer sur le bouton '<i class="fa fa-object-group"></i> Tout sélectionner' (vous pouvez aussi les sélectionner avec la souris).
                                                    </p>
                                                    <p class="alert alert-danger alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        Si vous supprimez des calques, veillez à ne pas supprimer le calque initial (gabarit).
                                                    </p>
                                                    <p class="alert alert-info alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        Si par erreur votre gabarit disparait, fermer la popup et relancer l'application avec le bouton "créer la maquette" pour retrouver un gabarit vierge.
                                                    </p>
                                                    <p  class="alert alert-danger alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        Attention votre maquette n'est pas sauvegardée automatiquement: il n'est pas possible de fermer cette fenêtre et de la réouvrir plus tard pour terminer votre travail. Vous devez terminer votre maquette et l'enregistrer dans la même session.
                                                    </p>
                                                    <p  class="alert alert-info alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        '<i class="fa fa-save" ></i> Enregistrer' envoie votre maquette à notre service infographie. Suivant la taille des fichiers que vous avez uploadé, l'enregistrement peut prendre quelques minutes, veillez à garder l'application ouverte jusqu'à voir un message de confirmation.
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- fin modal astuces -->

                            <button class="astuces" data-toggle="modal" data-target="#faq">Plus d'astuces / FAQ</button>
                          </div><!-- fin div intro -->

                        </div><!-- fin modal aide -->


                    </div><!-- fin modal astuces -->

                    <div class="tab-pane clearfix" id="Graphics">

                    <div class="graphic_options clearfix">
                        <ul>

                            <li class="butLoad col-lg-4 col-md-4 col-sm-4 col-xs-6 active">
                                <div>
                                    <a class="" href="#clip_arts" aria-controls="clip_arts" role="tab" data-toggle="tab" ng-click="exitDrawing()">
                                        <i class="fa fa-camera-retro"></i>
                                        <span>Formes</span>
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
                                    <a class="" href="#hand_draw" aria-controls="hand_draw" role="tab" data-toggle="tab" ng-click="enterDrawing();">
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
                                    <!--<div class="filter_by_cat">
                                        <md-input-container style="">
                                            <label>Classer par catégorie</label>
                                            <md-select ng-model="graphicsCategory" ng-change="loadByGraphicsCategory();">
                                                <md-option ng-repeat="graphicsCategory in graphicsCategories" value="{{graphicsCategory}}">{{graphicsCategory}}</md-option>
                                            </md-select>
                                        </md-input-container>
                                    </div>-->
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
                                                <span>Sélectionner une image</span>
                                                <input type="file" ngf-select="onFileSelect(picFile);" ng-model="picFile" name="file" accept="image/*" ngf-max-size="10MB" class="upload">
                                            </div>
                                            <input id="uploadFile" placeholdFile NameName disabled="disabled" />
                                            <span class="has-error" ng-show="myForm.file.$error.maxSize">File too large {{picFile.size / 1000000|number:1}}MB: max 2M</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="myForm.file.$error.maxWidth">File width too large : Max Width 3000px</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="myForm.file.$error.maxHeight">File height too large : Max Height 3000px</span>
                                            <div class="clearfix"></div>
                                            <span class="has-error" ng-show="uploadErrorMsg">{{uploadErrorMsg}}</span>
                                        </form>
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
                                                <label>Entrer le texte ci-dessous</label>
                                                <textarea  columns="1" id="textarea-text" style="text-align: {{ fabric.selectedObject.textAlign }}" ng-model="fabric.selectedObject.text"></textarea>
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
                        <h1>Calques</h1>
                        <div class="layer_listing scrollme" rebuild-on="rebuild:layer" ng-scrollbar is-bar-shown="barShown">

                        <ul class="ul_layer_canvas row">

                                <li ng-repeat="layer in objectLayers" class="ng-scope">
                                    <span>{{layer.id}}</span>
                                    <img ng-src="{{layer.src}}" alt=""/>

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

                    <div class="row form-group" ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'">
                        <md-input-container flex>
                            <label>Entrer le texte ci-dessous</label>
                            <textarea  columns="1" id="textarea-text" style="text-align: {{ fabric.selectedObject.textAlign }}" ng-model="fabric.selectedObject.text"></textarea>
                        </md-input-container>
                    </div>

                    <div class="row form-group" ng-show="fabric.selectedObject.type == 'text' || fabric.selectedObject.type == 'curvedText'" style="position: relative;">
                        <md-button class="md-raised md-cornered dropdown-toggle" data-toggle="dropdown" aria-label="Font Family"><span class='object-font-family-preview' style='font-family: "{{ fabric.selectedObject.fontFamily }}";'> {{ fabric.selectedObject.fontFamily }} </span> <span class="caret"></span></md-button>

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

                    <div class="row form-group input-group colorPicker2" ng-show="fabric.selectedObject.type != 'image' && fabric.selectedObject.type != 'path'">
                            <md-input-container flex>
                                <label for="Color">Couleur:</label>
                                <input type="text" value="" class="" colorpicker ng-model="fabric.selectedObject.fill" ng-change="fillColor(fabric.selectedObject.fill);" />
                            </md-input-container>
                            <span class="input-group-addon" colorpicker ng-model="fabric.selectedObject.fill" ng-change="fillColor(fabric.selectedObject.fill);" style="border: 2px solid #ccc; background-color: {{fabric.selectedObject.fill}}"><i></i></span>
                    </div>

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
                        <li ng-click="layers()" href="#Layers" data-toggle="tab"><i class="fa fa-object-ungroup"></i><span>Calques</span></li>
                        <li ng-click="copyItem()"><i class="fa fa-copy"></i><span>Copier</span></li>
                        <li ng-click="pasteItem()"><i class="fa fa-paste"></i><span>Coller</span></li>
                        <li ng-click="horizontalAlign()"><i class="fa fa-arrows-h"></i><span>Centrer</span></li>
                        <li ng-click="verticalAlign()"><i class="fa fa-arrows-v"></i><span>Centrer</span></li>
                        <li ng-click="{ active: flipObject() }"><i class="fa fa-exchange fa-2"></i><span>Mirroir</span></li>
                        <li ng-click="removeSelectedObject()"><i class="fa fa-eraser"></i><span>Supprimer</span></li>
                        <li ng-click="selectA()">
                            <a class="fa fa-object-group ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                            <md-tooltip md-visible="redo.showTooltip" md-direction="left">Tout sélectionner</md-tooltip>
                            <span class="nope">Tout sélectionner</span>
                        </li>
                        <li ng-click="undo()">
                            <a class="fa fa-undo ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                            <md-tooltip md-visible="undo.showTooltip" md-direction="left">Annuler</md-tooltip>
                            <span class="nope">Annuler</span>
                        </li>
                        <li ng-click="redo()">
                            <a class="fa fa-repeat ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
                            <md-tooltip md-visible="redo.showTooltip" md-direction="left">Rétablir</md-tooltip>
                            <span class="nope">Rétablir</span>
                        </li>

                        <!--<li ng-click="clearAll()"><i class="fa fa-trash"></i><span>Tout effacer</span></li>-->

                    </ul>

                    <div class="btn-group-vertical">
                        <div class="icon-vertical m-b-sm pull-right">
                            <ul>
                                <li class="saveObject">

                                      <a ng-hide="loader" ng-click="saveObjectAsSvg()" href="#" class="ng-scope">
                                          <i class="fa fa-save" ></i>
                                          <br />Enregistrer
                                      </a>
                                      <a ng-show="loader" href="#" class="ng-scope">
                                          <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                          <br />Veuillez patienter
                                      </a>

                                  <!--<ul class="ulChildMenu">
                                        <li class="childLi">
                                            <a ng-click="saveObjectAsSvg()" href="#" class="ng-scope">Save as SVG</a>
                                        </li>
                                        <li class="childLi">
                                            <a ng-click="saveObjectAsPng()" href="#" class="ng-scope">Save as PNG</a>
                                        </li>
                                        <li class="childLi">
                                            <a ng-click="saveObjectAsJpg()" href="#" class="ng-scope">Save as JPG</a>
                                        </li>
                                        <li class="childLi">
                                            <a ng-click="downloadObjectAsPdf()" href="#" class="ng-scope">Download as PDF</a>
                                        </li>
                                      </ul>-->
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

                        </div>
                        <!--<div class="social-share">
                            <a href="javascript:void(0);" id="f_share_button" class="fa fa-facebook" ng-click="shareOnFacebook($event);"></a> <a href="javascript:void(0)" class="fa fa-twitter" ng-click="shareOnTwitter($event);"></a>
                        </div>-->
                    </div>
                </div>
                <div class="canvas_image image-builder ng-isolate-scope">
                  <ul class="zoomButtons pull-right">
                    <li ng-click="zoomObject('zoomin')">
                        <a class="fa fa-search-plus fa-flip-horizontal ng-scope ng-isolate-scope" translate="" href="#"><span class="ng-binding ng-scope"></span></a>
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
<script src="js/ngprogress-lite.min.js"></script>

<script src="assets/colorpicker/bootstrap-colorpicker-module.js"></script>
<script src="js/application.js"></script>

<script src="assets/file/fileSaver.js"></script>
<script src="assets/pdf/jspdf.debug.js"></script>

<script>
jQuery(document).ready(function() {
/*  $(document).on('click','.saveObject', function() {
    NProgress.start();
  });*/
});
</script>

<div id="qrcode"></div>
<div id="wordcloud"></div>
<div class="css_gen"></div>
<div class="svgElements"></div>
</body>
</html>

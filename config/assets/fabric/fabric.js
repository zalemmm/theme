'use strict';
angular.module('common.fabric', [
	'common.fabric.window',
	'common.fabric.directive',
	'common.fabric.canvas',
	'common.fabric.dirtyStatus'
])

.factory('Fabric', [
	'FabricWindow', '$timeout', '$window', 'FabricCanvas', 'FabricDirtyStatus',
	function(FabricWindow, $timeout, $window, FabricCanvas, FabricDirtyStatus) {

	return function(options) {

		var canvas;
		var JSONObject;
		var self = angular.extend({
			canvasBackgroundColor: '#ffffff',
			canvasWidth: 840,
			canvasHeight: 580,
			canvasOriginalHeight: 580,
			canvasOriginalWidth: 840,
			maxContinuousRenderLoops: 25,
			continuousRenderTimeDelay: 500,
			editable: true,
			JSONExportProperties: [],
			loading: false,
			dirty: false,
			initialized: false,
			userHasClickedCanvas: false,
			downloadMultipler: 2,
			imageDefaults: {},
			textDefaults: {},
      curvedTextDefaults: {},
			shapeDefaults: {
				globalCompositeOperation : 'source-atop'
			},
			windowDefaults: {
                rotatingPointOffset: 20,
                padding: 10,
                borderColor: 'EEF6FC',
                cornerColor: '#FFC23F',
                cornerSize: 10,
                transparentCorners: false,
                hasRotatingPoint: true,
                centerTransform: true
			},
			canvasDefaults: {
				selection: true
			}
		}, options);

		var winWidth = $(window).width();
		var winHeight = $(window).height();
		var xsmall = winWidth < 1366 && winHeight < 768;
		var small = winWidth < 1440 && winHeight < 900;
		var medium = winWidth >= 1440  && winHeight >= 900;
		var large = winWidth >= 1600 && winHeight >= 900;

		function capitalize(string) {
			if (typeof string !== 'string') {
				return '';
			}

			return string.charAt(0).toUpperCase() + string.slice(1);
		}

		function getActiveStyle(styleName, object) {
			object = object || canvas.getActiveObject();

			if (typeof object !== 'object' || object === null) {
				return '';
			}

			return (object.getSelectionStyles && object.isEditing) ? (object.getSelectionStyles()[styleName] || '') : (object[styleName] || '');
		}

		function setActiveStyle(styleName, value, object) {
			object = object || canvas.getActiveObject();
            if(object != null) {
                if (object.setSelectionStyles && object.isEditing) {
                    var style = {};
                    style[styleName] = value;
                    object.setSelectionStyles(style);
                } else {
                    object[styleName] = value;
                }

                self.render();
            }
		}

		function getActiveProp(name) {
			var object = canvas.getActiveObject();

			return typeof object === 'object' && object !== null ? object[name] : '';
		}

		function setActiveProp(name, value) {
			var object = canvas.getActiveObject();
            if(object != null) {
                object.set(name, value);
                self.render();
            }
		}

		function b64toBlob(b64Data, contentType, sliceSize) {
			contentType = contentType || '';
			sliceSize = sliceSize || 512;

			var byteCharacters = atob(b64Data);
			var byteArrays = [];

			for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
				var slice = byteCharacters.slice(offset, offset + sliceSize);

				var byteNumbers = new Array(slice.length);
				for (var i = 0; i < slice.length; i++) {
					byteNumbers[i] = slice.charCodeAt(i);
				}

				var byteArray = new Uint8Array(byteNumbers);

				byteArrays.push(byteArray);
			}

			var blob = new Blob(byteArrays, {type: contentType});
			return blob;
		}

		function isHex(str) {
			return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/gi.test(str);
		}

		//
		// Canvas
		// ==============================================================
		self.renderCount = 0;
        var isRedoing = false;
        var h = [];
        var copiedObject;
        var copiedObjects = new Array();
        self.designedObjects = {};
        self.designedSVGObjects = {};
        self.designedPNGObjects = {};
        self.designedJPGObjects = {};

        /***************** for corner icons  ****************/

        fabric.Object.prototype.setControlsVisibility( {
/*          ml: false,
            mr: false,
            mb: false,
            mt: false*/
						mtr: false
        } );

        fabric.Canvas.prototype.customiseControls( {
            tl: {
                action: 'rotate',
                cursor: 'grab'
            },
            tr: {
                action: 'scale'
            },
            bl: {
                action: 'remove',
                cursor: 'pointer'
            },
            br: {
                action: 'scale',
                cursor: 'nwse-resize'
            },
            mb: {
                action: 'scaleY',
                cursor: 'ns-resize'
            },
            mt: {
                action: 'scaleY',
                cursor: 'ns-resize'
            },
            ml: {
                action: 'scaleX',
                cursor: 'ew-resize'
            },
            mr: {
                action: 'scaleX',
                cursor: 'ew-resize'
            }
        } );

        // basic settings
        fabric.Object.prototype.customiseCornerIcons( {
            settings: {
                borderColor: 'red',
                cornerSize: 24,
                cornerBackgroundColor: 'white',
                cornerShape: 'circle',
                cornerPadding: 8
            },
            tl: {
                icon: 'images/icons/rotate.jpg'
            },
            tr: {
                icon: 'images/icons/resize.png'
            },
            bl: {
                icon: 'images/icons/delete.png'
            },
            br: {
                icon: 'images/icons/resize2.png'
            },
            mb: {
                icon: 'images/icons/moveY.png'
            },
            mt: {
                icon: 'images/icons/moveY.png'
            },
            ml: {
                icon: 'images/icons/moveX.png'
            },
            mr: {
                icon: 'images/icons/moveX.png'
            }
        } );

       /***************** for corner icons  ****************/

        var filters = [
            new fabric.Image.filters.Grayscale(),       // grayscale    0
            new fabric.Image.filters.Sepia2(),          // sepia        1 // v2 mod
            new fabric.Image.filters.Invert(),          // invert       2
            new fabric.Image.filters.Convolute({        // emboss       3
                matrix: [ 1, 1, 1,
                    1, 0.7, -1,
                    -1, -1, -1 ]
            }),
            new fabric.Image.filters.Convolute({        // sharpen      4
                matrix: [  0, -1, 0,
                    -1, 5, -1,
                    0, -1, 0 ]
            })
        ];

        /*self.addQRCode = function(text){

        };*/

        self.applyImageFilter = function (isChecked, filter){
            var obj = canvas.getActiveObject();
            obj.filters[filter] = isChecked ? filters[filter] : null;
            obj.applyFilters(function () {
                canvas.renderAll();
            });
        };

		self.render = function() {
			var objects = canvas.getObjects();
			for (var i in objects) {
				objects[i].setCoords();
			}

			canvas.calcOffset();
			canvas.renderAll();
			self.renderCount++;
		};

		self.setCanvas = function(newCanvas) {
			canvas = newCanvas;
			canvas.selection = self.canvasDefaults.selection;
		};

		self.setTextDefaults = function(textDefaults) {
			self.textDefaults = textDefaults;
		};

		self.setJSONExportProperties = function(JSONExportProperties) {
			self.JSONExportProperties = JSONExportProperties;
		};

		self.setCanvasBackgroundColor = function(color) {
			self.canvasBackgroundColor = color;
			canvas.setBackgroundColor(color);
			self.render();
		};

		self.setCanvasWidth = function(width) {
			self.canvasWidth = width;
			canvas.setWidth(width);
			self.render();
		};

		self.setCanvasHeight = function(height) {
			self.canvasHeight = height;
			canvas.setHeight(height);
			self.render();
		};

		self.setCanvasSize = function(width, height) {
			self.stopContinuousRendering();
			var initialCanvasScale = self.canvasScale;
			self.resetZoom();

			self.canvasWidth = width;
			self.canvasOriginalWidth = width;
			canvas.originalWidth = width;
			canvas.setWidth(width);

			self.canvasHeight = height;
			self.canvasOriginalHeight = height;
			canvas.originalHeight = height;
			canvas.setHeight(height);

			self.canvasScale = initialCanvasScale;
			self.render();
			self.setZoom();
			self.render();
			self.setZoom();
		};

		self.isLoading = function() {
			return self.isLoading;
		};

		self.deactivateAll = function() {
			canvas.deactivateAll();
			self.deselectActiveObject();
			self.render();
		};

		self.clearCanvas = function() {
			canvas.clear();
			self.render();
		};

		//---------------------------------------- rechercher un objet par propriété

		self.findObject = function(canvas, propertyName, propertyValue) {
			var condition = {};
			condition[propertyName] = propertyValue;
			return _(canvas.getObjects()).filter( condition ).first()
		}



		//--------------------------------------------------------mode avancé toggle

		self.switch = function() {
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');
			var rolltop = self.findObject(canvas, 'id', 'rolltop');
			var rollbot = self.findObject(canvas, 'id', 'rollbot');
			var rollfoot1 = self.findObject(canvas, 'id', 'rollfoot1');
			var rollfoot2 = self.findObject(canvas, 'id', 'rollfoot2');

			// lier les mouvements des calques gabarit : récup des coordonnées au déplacement
			function rectMouseMove(option){
				gabarit.left = recbg.gabaritLeft+ recbg.left - recbg.mousesDownLeft ;
				gabarit.top = recbg.gabaritTop+ recbg.top- recbg.mousesDownTop;

				if(rolltop)  {
					rolltop.left = recbg.rolltopLeft+ recbg.left - recbg.mousesDownLeft ;
					rolltop.top = recbg.rolltopTop+ recbg.top- recbg.mousesDownTop;
					rollbot.left = recbg.rollbotLeft+ recbg.left - recbg.mousesDownLeft ;
					rollbot.top = recbg.rollbotTop+ recbg.top- recbg.mousesDownTop;
					rollfoot1.left = recbg.rollfoot1Left+ recbg.left - recbg.mousesDownLeft ;
					rollfoot1.top = recbg.rollfoot1Top+ recbg.top- recbg.mousesDownTop;
					rollfoot2.left = recbg.rollfoot2Left+ recbg.left - recbg.mousesDownLeft ;
					rollfoot2.top = recbg.rollfoot2Top+ recbg.top- recbg.mousesDownTop;

					rolltop.setCoords();
					rollbot.setCoords();
					rollfoot1.setCoords();
					rollfoot2.setCoords();
				}
				gabarit.setCoords();
			}

			// lier les mouvements des calques gabarit : application des coordonnées au relachement clic
			function rectMouseDown(option){
				recbg.mousesDownLeft = recbg.left;
				recbg.mousesDownTop = recbg.top;
				recbg.gabaritLeft = gabarit.left;
				recbg.gabaritTop = gabarit.top;

				if(rolltop)  {
					recbg.rollbotLeft = rollbot.left;
					recbg.rollbotTop = rollbot.top;
					recbg.rolltopLeft = rolltop.left;
					recbg.rolltopTop = rolltop.top;

					recbg.rollfoot1Left = rollfoot1.left;
					recbg.rollfoot1Top = rollfoot1.top;
					recbg.rollfoot2Left = rollfoot2.left;
					recbg.rollfoot2Top = rollfoot2.top;
				}
			}

/*			// au chargement les calques gabarit sont bloqués
			recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
			gabarit.set({evented: false, hasControls: false});

			rolltop.set({evented: false, hasControls: false});
			rollbot.set({evented: false, hasControls: false});
			rollfoot1.set({evented: false, hasControls: false});
			rollfoot2.set({evented: false, hasControls: false});*/


			// display et action du bouton utilisateur avancé
			$('.advToggle').css('display','inline-block');

			$(".checkbox").change(function() {
				if(this.checked) {
					$(".zoomButtons, .unredo").removeClass('disno');
					$('.onoff').text('on').css('color', '#26a7d9');
					recbg.set({lockMovementY:false, lockMovementX: false, hasControls: false});
					// action au déplacement des calques

				}else{
					$(".zoomButtons, .unredo").addClass('disno');
					$('.onoff').text('off').css('color', '#ea2a6a');
					recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
				}
			});

			recbg.on('moving',rectMouseMove);
			recbg.on('mousedown',rectMouseDown);

		}


		//
		// Creating Objects
		// ==============================================================
		self.addObjectToCanvas = function(object) {

			object.originalScaleX = object.scaleX;
			object.originalScaleY = object.scaleY;
			object.originalLeft = object.left;
			object.originalTop = object.top;

			canvas.add(object);
			self.setObjectZoom(object);
			canvas.setActiveObject(object.set({
		        left: canvas.width/2,
		        top: canvas.height/2,
						originX: 'center',
						originY: 'center'
		    })
			);
			object.bringForward();

			var gaba = self.findObject(canvas, 'id', 'gabarit');
			canvas.bringToFront(gaba);
			gaba.set({hasControls: false, evented: false});

			self.render();
		};

		// Séparation lignes multiples à l'imput text
		// ==============================================================
		self.addMultilineText = function(object, lines) {

			object.originalScaleX = object.scaleX;
			object.originalScaleY = object.scaleY;
			object.originalLeft = object.left;
			object.originalTop = object.top;

			canvas.add(object);

			if (lines == 1) {
				var topp = 0;
			}else{
				var topp = object.getHeight()*(lines-1);
			}

			self.setObjectZoom(object);
			canvas.setActiveObject(object.set({
		        left: canvas.width/2,
		        top: canvas.height/2.5+topp,
						originX: 'center',
						originY: 'center'
		    })
			);
			object.bringForward();

			var gaba = self.findObject(canvas, 'id', 'gabarit');
			canvas.bringToFront(gaba);
			gaba.set({hasControls: false, evented: false});

			self.render();
		};
    // =========================================================================
		//														Générer les gabarits
    // =========================================================================

		// Canvas Background
		// =========================================================================
		self.addCanvasBackground = function(src) {

				var gabarit = self.gabaritResize();
				var ctx = canvas.getContext("2d");
				ctx.clearRect(0, 0, canvas.width, canvas.height);

				var center = canvas.getCenter();

				canvas.setBackgroundImage(src, canvas.renderAll.bind(canvas), {
					scaleX:1,
					scaleY:1,
					top: 25,
					left: center.left,
					originX: 'center',
					originY: 'top',
					width: gabarit.width,
					height: gabarit.height,
					backgroundImageStretch: false
				});
		};

		// Resize Canvas
		// =========================================================================
		self.resizeCanvas = function() {

		};

		// Resize Canvas Background
		// =========================================================================

    self.gabaritResize = function() {
			 // variables taille et positionnement -----------------------------------
        var MAX_HEIGHT = canvas.height-50;
				var MAX_WIDTH = canvas.width-50;
        var w;
        var h;
				var center = canvas.getCenter();
				var ratio;

				//var image = new Image();
				//image.src = src;
				var recbg     = self.findObject(canvas, 'id', 'recbg');
				var gabarit   = self.findObject(canvas, 'id', 'gabarit');
				var rolltop   = self.findObject(canvas, 'id', 'rolltop');
				var rollbot   = self.findObject(canvas, 'id', 'rollbot');
				var rollfoot1 = self.findObject(canvas, 'id', 'rollfoot1');
				var rollfoot2 = self.findObject(canvas, 'id', 'rollfoot2');
				var line      = self.findObject(canvas, 'id', 'line');
				var line1     = self.findObject(canvas, 'id', 'line1');
				var line2     = self.findObject(canvas, 'id', 'line2');

				// récupération des données produits -----------------------------------
				var produit    = $('#produit').text();
				var hauteur    = parseInt($('#hauteur').text(), 10);
				var largeur    = parseInt($('#largeur').text(), 10);
				var realhaut   = parseInt($('#hauteur').text(), 10);
				var reallarg   = parseInt($('#largeur').text(), 10);
				var rectoVerso = $('#desc').text().indexOf('recto-verso') > -1;

				console.log(produit+' - '+hauteur+' x '+largeur);

				// variables stand tissu -----------------------------------------------
				var standTissu = $('#desc').text().indexOf('Tissu') > -1;
				/*var trois1     = $('#desc').text().indexOf(' 3x1 ') > -1;
				var trois2     = $('#desc').text().indexOf(' 3x2 ') > -1;
				var trois3     = $('#desc').text().indexOf(' 3x3 ') > -1;
				var trois4     = $('#desc').text().indexOf(' 3x4 ') > -1;
				var trois5     = $('#desc').text().indexOf(' 3x5 ') > -1;
				var trois6     = $('#desc').text().indexOf(' 3x6 ') > -1;
				var trois7     = $('#desc').text().indexOf(' 3x7 ') > -1;
				var trois8     = $('#desc').text().indexOf(' 3x8 ') > -1;*/
				var comptoir   = $('#desc').text().indexOf('Comptoir') > -1;
				var valise     = $('#desc').text().indexOf('Valise') > -1;
				var totem      = $('#desc').text().indexOf('Totem Tissu') > -1;
				var rond       = $('#desc').text().indexOf('ronde') > -1;

				// variables rollup ----------------------------------------------------
				var firstline = $('#desc').text().indexOf('firstline') > -1;
				var bestline  = $('#desc').text().indexOf('bestline') > -1;
				var luxline   = $('#desc').text().indexOf('luxline') > -1;
				var double    = $('#desc').text().indexOf('double') > -1;
				var mistral   = $('#desc').text().indexOf('mistral') > -1;
				var mini      = $('#desc').text().indexOf('mini') > -1;
				var visuel    = $('#desc').text().indexOf('visuel') > -1;

				// variables orfilammes ------------------------------------------------
				var aile1   = $('#desc').text().indexOf('aile d’avion 54x240') > -1;
				var aile2   = $('#desc').text().indexOf('aile d’avion 85x308') > -1;
				var aile3   = $('#desc').text().indexOf('aile d’avion 85x351') > -1;
				var aile4   = $('#desc').text().indexOf('aile d’avion 85x465') > -1;
				var goutte1 = $('#desc').text().indexOf('goutte d’eau 72x203') > -1;
				var goutte2 = $('#desc').text().indexOf('goutte d’eau 75x254') > -1;
				var goutte3 = $('#desc').text().indexOf('goutte d’eau 106x323') > -1;
				var goutte4 = $('#desc').text().indexOf('goutte d’eau 125x460') > -1;
				var verso   = $('#rectvers').text();

				// banderoles fourreaux-------------------------------------------------
				var fourgd  = $('#desc').text().indexOf('fourreaux gauche/droite') > -1;
				var fourhb  = $('#desc').text().indexOf('fourreaux haut/bas') > -1;

				// dépliants------------------------------------------------------------
				var depliant = produit.indexOf('Depliants') > -1;
				var volets   = $('#desc').text().indexOf('3 volets') > -1;

				// nappes---------------------------------------------------------------

				var ret20  = $('#desc').text().indexOf('20 cm de retombée') > -1;
				var ret30  = $('#desc').text().indexOf('30 cm de retombée') > -1;
				var ret50  = $('#desc').text().indexOf('50 cm de retombée') > -1;
				var ret60  = $('#desc').text().indexOf('60 cm de retombée') > -1;
				var ret70  = $('#desc').text().indexOf('70 cm de retombée') > -1;
				var ret40  = $('#desc').text().indexOf('40 cm de retombée') > -1;
				var ret80  = $('#desc').text().indexOf('80 cm de retombée') > -1;

				var retomb = 0;
				if (ret20) retomb = 20;
				if (ret30) retomb = 30;
				if (ret40) retomb = 40;
				if (ret50) retomb = 50;
				if (ret60) retomb = 60;
				if (ret70) retomb = 70;
				if (ret80) retomb = 80;

				//-------------------- s'il existe une sauvegarde, récupérer les données
				var sauvegarde = $('#saved').text();
				var reset      = $('#rset').text();
				var jsondata   = $('#json').text();

				jsondata = jsondata.replace(/ \| /g, '\\n');
				jsondata = jsondata.replace(/apquote/g, '\'');

				if (sauvegarde == 'oui' && reset == 'non'){

					canvas.loadFromJSON(jsondata, canvas.renderAll.bind(canvas), function(o, object) {
						console.log(o, object);
					});

					self.render();

					canvas.deactivateAll();
					var objs = canvas.getObjects().map(function(o) {
						return o.set('active', true);
					});
					center = canvas.getCenter();
					var group = new fabric.Group(objs, {
						top: center.top,
						left: center.left,
						originX: 'center',
						originY: 'center'
					});
					canvas.setActiveGroup(group.setCoords()).deactivateAll().renderAll();

					var gaba = self.findObject(canvas, 'id', 'gabarit');
					canvas.sendToBack(gaba);
				}

				//------------------------------- ratio gabarit/canvas suivant le format

				// portrait ------------------------------------------------------------
				if(hauteur > largeur) {
					ratio = hauteur/largeur;
					hauteur = MAX_HEIGHT;
					largeur = MAX_HEIGHT/ratio;
					w = largeur;
					h = hauteur;

				// paysage -------------------------------------------------------------
				}else if(largeur > hauteur) {
					ratio = largeur/hauteur;
					largeur = MAX_WIDTH;
					hauteur = MAX_WIDTH/ratio;
					w = largeur;
					h = hauteur;
					// cas particulier où la hauteur = presque la largeur et dépasse MAX_HEIGHT
					if (h >= canvas.height) {
						largeur = MAX_HEIGHT;
						hauteur = MAX_HEIGHT/ratio;
					}

				// carré ---------------------------------------------------------------
				}else if(largeur == hauteur) {
					largeur = MAX_HEIGHT;
					hauteur = MAX_HEIGHT;
					w = largeur;
					h = hauteur;
				}

				// ratio retours stands ------------------------------------------------
				var sratio  = reallarg/35;
				var retour  = largeur/sratio;

				// ratio retour nappes rect --------------------------------------------
				var nratiol = reallarg/retomb;
				var nratioh = realhaut/retomb;

				var retgd = largeur/nratiol;
				var rethb = hauteur/nratioh;

				// ratio fourreaux -----------------------------------------------------
				var fratiol = reallarg/10;
				var fratioh = realhaut/10;

				var fgd = largeur/fratiol;
				var fhb = hauteur/fratioh;

				//------------------------------------- tous les gabarits rectangulaires
				if (!aile1 && !aile2 && !aile3 && !aile4 && !goutte1 && !goutte2 && !goutte3 && !goutte4 && !rond){

					//------------------------------------------------------- FOURREAUX GD
					if (fourgd) {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-fgd*2,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

					//--------------------------------------------------------FOURREAUX HB
					}	else if (fourhb) {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-12,
							height: hauteur-fhb*2,
							hasControls: false,
							evented:false
						});

					//------------------------------------------------------------- STANDS
			  	}else if (produit == 'Stand Tissu' || produit == 'Comptoir') {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-retour*2,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

					//--------------------------------------------------------------------
					}else if (produit == 'Valise') {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: 36*largeur/100,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});
					//--------------------------------------------------------------------
					}else if (totem) {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-12,
							height: hauteur-12,
							hasControls: false,
							ry: 30,
							rx: 30,
							evented:false
						});

					//--------------------------------------------------------------------
		  		}else if (produit == 'Nappe' && retomb !== 0) {
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-retgd*2,
							height: hauteur-rethb*2,
							hasControls: false,
							evented:false
						});

			  	}else{
						// ----------------------------------------------calques sup Roll-up
						if(produit == 'Roll-up' || produit == 'Rollup') {

							if(luxline) {
								rollbot= new fabric.Rect({
									id: 'rollbot',
									originX: 'center',
									originY: 'top',
									top: canvas.height-55,
									left: center.left,
									fill: '#aab2b7',
									shadow: 'rgba(0,0,0,0.4) 0px 0px 2px',
									width: largeur+14,
									height: 45,
									lockMovementX: true,
									lockMovementY: true,
									hasControls: false,
									evented:false
								});

							}else if(double){
								rollbot= new fabric.Rect({
									id: 'rollbot',
									originX: 'center',
									originY: 'top',
									top: canvas.height-45,
									left: center.left,
									fill: '#aab2b7',
									shadow: 'rgba(0,0,0,0.4) 0px 0px 2px',
									width: largeur+14,
									height: 35,
									lockMovementX: true,
									lockMovementY: true,
									hasControls: false,
									evented:false
								});

								fabric.loadSVGFromURL('svg/rollfoot.svg', function(objects, options) {
									rollfoot1 = fabric.util.groupSVGElements(objects, options);
									rollfoot1.set({
										id: 'rollfoot1',
										originX: 'center',
										originY: 'center',
										top: canvas.height-5,
										left: center.left,
										fill: '#aab2b7',
										width: 22,
										height: 12,
										lockMovementX: true,
										lockMovementY: true,
										hasControls: false,
										evented:false
									});

									if (sauvegarde == 'non' || reset == 'oui'){
										canvas.add(rollfoot1);
										canvas.sendToBack(rollfoot1);
									}
								});

							}else if(mistral || mini){
								rollbot= new fabric.Rect({
									id: 'rollbot',
									originX: 'center',
									originY: 'top',
									top: canvas.height-45,
									left: center.left,
									fill: '#aab2b7',
									shadow: 'rgba(0,0,0,0.4) 0px 0px 2px',
									width: largeur+14,
									height: 35,
									lockMovementX: true,
									lockMovementY: true,
									hasControls: false,
									evented:false
								});

							}else if(bestline || firstline || visuel) {
								rollbot= new fabric.Rect({
									id: 'rollbot',
									originX: 'center',
									originY: 'top',
									top: canvas.height-40,
									left: center.left,
									fill: '#aab2b7',
									shadow: 'rgba(0,0,0,0.4) 0px 0px 2px',
									width: largeur+14,
									height: 28,
									lockMovementX: true,
									lockMovementY: true,
									hasControls: false,
									evented:false
								});

								fabric.loadSVGFromURL('svg/rollfoot.svg', function(objects, options) {
									rollfoot1 = fabric.util.groupSVGElements(objects, options);
									rollfoot1.set({
										id: 'rollfoot1',
										originX: 'center',
										originY: 'center',
										top: canvas.height-7,
										left: (center.left)-largeur/2+45,
										fill: '#aab2b7',
										width: 22,
										height: 12,
										lockMovementX: true,
										lockMovementY: true,
										hasControls: false,
										evented:false
									});

									rollfoot2 = fabric.util.groupSVGElements(objects, options);
									rollfoot2.set({
										id: 'rollfoot2',
										originX: 'center',
										originY: 'center',
										top: canvas.height-7,
										left: (center.left)+largeur/2-45,
										fill: '#aab2b7',
										width: 22,
										height: 12,
										lockMovementX: true,
										lockMovementY: true,
										hasControls: false,
										evented:false
									});

									if (sauvegarde == 'non' || reset == 'oui'){
										canvas.add(rollfoot1);
										canvas.add(rollfoot2);
									}

								});
							}

							rolltop = new fabric.Rect({
								id: 'rolltop',
								originX: 'center',
								originY: 'top',
								top: 18,
								left: center.left,
								fill: '#ccc',
								shadow: 'rgba(0,0,0,0.4) 0px 0px 2px',
								width: largeur+4,
								height: 7,
								lockMovementX: true,
								lockMovementY: true,
								hasControls: false,
								evented:false
							});

							rollbot.setGradient('fill', {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: rollbot.height,
								colorStops: {
									0: '#444',
									0.9: "#ccc",
									1: '#111'
								}
							});

							if (sauvegarde == 'non' || reset == 'oui'){
								canvas.add(rolltop);
								canvas.add(rollbot);

							}else{
								rolltop = self.findObject(canvas, 'id', 'rolltop');
								rollbot = self.findObject(canvas, 'id', 'rollbot');
								rollfoot1 = self.findObject(canvas, 'id', 'rollfoot1');
								rollfoot2 = self.findObject(canvas, 'id', 'rollfoot2');
								rolltop.set({evented: false, hasControls: false});
								rollbot.set({evented: false, hasControls: false});
								rollfoot1.set({evented: false, hasControls: false});
								rollfoot2.set({evented: false, hasControls: false});
							}

						} // fin calques rollup

						//------------------------------------------- calques plis depliants
						line = new fabric.Rect({
							id: 'line',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#ccc',
							width: 1,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

						line1 = new fabric.Rect({
							id: 'line1',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: (center.left)-(largeur/3)/2,
							fill: '#ccc',
							width: 1,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

						line2 = new fabric.Rect({
							id: 'line2',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: (center.left)+(largeur/3)/2,
							fill: '#ccc',
							width: 1,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

						//---------------------------- RECTANGLE POINTILLES GABARITS NORMAUX
						gabarit = new fabric.Rect({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: 'rgba(0,0,0,0)',
							stroke: '#ccc',
							strokeWidth: 1,
							strokeDashArray: [10, 5],
							width: largeur-12,
							height: hauteur-12,
							hasControls: false,
							evented:false
						});

					} // fin gabarits rectangulaires normaux

					//---------------------------------------------------- RECTANGLE BLANC
					recbg = new fabric.Rect({
						id: 'recbg',
						originX: 'center',
						originY: 'center',
						top: center.top,
						left: center.left,
						fill: '#fff',
						shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
						width: largeur,
						height: hauteur,
						lockMovementX: true,
						lockMovementY: true,
						hasControls: false
					});

					//--------------------------------------------------------------------
					if (sauvegarde == 'non' || reset == 'oui'){
						canvas.add(recbg);
						canvas.add(gabarit);

						if(depliant) {
							if(volets) {
								canvas.add(line1);
								canvas.add(line2);
							}else {
								canvas.add(line);
							}
						}

					}else{

						recbg = self.findObject(canvas, 'id', 'recbg');
						gabarit = self.findObject(canvas, 'id', 'gabarit');
						recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						gabarit.set({evented: false, hasControls: false});
						self.switch();

						if(depliant) {
							line  = self.findObject(canvas, 'id', 'line');
							line1 = self.findObject(canvas, 'id', 'line1');
							line2 = self.findObject(canvas, 'id', 'line2');
							line.set({evented: false, hasControls: false});
							line1.set({evented: false, hasControls: false});
							line2.set({evented: false, hasControls: false});
						}

					}



			//----------------------------------------------------------- GABARIT ROND
	  	}else if(rond){

				var rayontotal   = realhaut/2;                        // vrai rayon total
				var rayonplateau = realhaut/2-retomb;                 // vrai rayon moins retombée
				var pourcentage  = rayontotal/100*rayonplateau;       // calcul % rayon sans retombée
				var rayontotalecran  = canvas.height/2-20;  // rayon total à l'écran
				var rayonplateautecran;

				if (retomb !== 0) rayonplateautecran  = rayontotalecran-(rayontotalecran*pourcentage/100);
				else rayonplateautecran  = rayontotalecran-12;

				/*console.log(rayontotal);
				console.log(rayonplateau);
				console.log(pourcentage);*/


				//------------------------------------------------------ ROND POINTILLES
				gabarit = new fabric.Circle({
					id: 'gabarit',
					originX: 'center',
					originY: 'center',
					top: center.top,
					left: center.left,
					fill: 'rgba(0,0,0,0)',
					stroke: '#ccc',
					strokeWidth: 1,
					strokeDashArray: [10, 5],
					radius: rayonplateautecran,
					hasControls: false,
					evented:false
				});

				//------------------------------------------------------------ROND BLANC
				recbg = new fabric.Circle({
					id: 'recbg',
					originX: 'center',
					originY: 'center',
					top: center.top,
					left: center.left,
					fill: '#fff',
					shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
					radius: rayontotalecran,
					lockMovementX: true,
					lockMovementY: true,
					hasControls: false
				});

				if (sauvegarde == 'non' || reset == 'oui'){

					canvas.add(recbg);
					canvas.add(gabarit);

				}else{

					recbg = self.findObject(canvas, 'id', 'recbg');
					gabarit = self.findObject(canvas, 'id', 'gabarit');
					recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
					gabarit.set({evented: false, hasControls: false});

					self.switch();
				}


			//------------------------------------------------------------- ORIFLAMMES
			}else{
				//-------------------------------------------------------- ailes d'avion

				if ((aile1) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/aile54x240cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile54x240cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});

				}
				//--------------------------------------------------------------------
				if ((aile1) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/aile54x240cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile54x240cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile2) && (verso != 'Verso')){
					fabric.loadSVGFromURL('svg/aile85x308cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x308cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile2) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/aile85x308cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x308cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile3) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/aile85x351cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x351cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile3) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/aile85x351cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x351cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile4) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/aile85x465cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x465cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((aile4) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/aile85x465cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/aile85x465cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						};
					});
				}

				//-------------------------------------------------------- gouttes d'eau

				if ((goutte1) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte72x203cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte72x203cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte1) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte72x203cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte72x203cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte2) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte75x254cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});
						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte75x254cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false,
							evented:false
						});
						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte2) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte75x254cmVerso.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte75x254cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte3) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte106x323cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte106x323cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte3) && (verso == 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte106x323cmVerso.svg', function(objects, options) {
					  recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte106x323cmVersoD.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});

						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}

				//--------------------------------------------------------------------
				if ((goutte4) && (verso != 'Verso')) {
					fabric.loadSVGFromURL('svg/goutte125x460cm.svg', function(objects, options) {
						recbg = fabric.util.groupSVGElements(objects, options);
						recbg.set({
							id: 'recbg',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							fill: '#fff',
							shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
							lockMovementX: true,
							lockMovementY: true,
							hasControls: false
						});
						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(recbg);
							recbg.scaleToHeight(canvas.height);
							//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
						}
					});

					fabric.loadSVGFromURL('svg/goutte125x460cmDashed.svg', function(objects, options) {
						gabarit = fabric.util.groupSVGElements(objects, options);
						gabarit.set({
							id: 'gabarit',
							originX: 'center',
							originY: 'center',
							top: center.top,
							left: center.left,
							hasControls: false,
							lockMovementX: true,
							lockMovementY: true,
							evented:false
						});
						if (sauvegarde == 'non' || reset == 'oui'){
							canvas.add(gabarit);
							gabarit.scaleToHeight(canvas.height);
							gabarit.bringToFront();
						}
					});
				}
				//--------------------------------------------------------------------
				if ((goutte4) && (verso == 'Verso')) {
						fabric.loadSVGFromURL('svg/goutte125x460cmVerso.svg', function(objects, options) {
							recbg = fabric.util.groupSVGElements(objects, options);
							recbg.set({
									id: 'recbg',
									originX: 'center',
									originY: 'center',
									top: center.top,
									left: center.left,
									fill: '#fff',
									shadow: 'rgba(0,0,0,0.4) 0px 0px 5px',
									lockMovementX: true,
									lockMovementY: true,
									hasControls: false
								});
								if (sauvegarde == 'non' || reset == 'oui'){
									canvas.add(recbg);
									recbg.scaleToHeight(canvas.height);
									//recbg.set({lockMovementY:true, lockMovementX: true, hasControls: false});
								}
						});

						fabric.loadSVGFromURL('svg/goutte125x460cmVersoD.svg', function(objects, options) {
							gabarit = fabric.util.groupSVGElements(objects, options);
							gabarit.set({
									id: 'gabarit',
									originX: 'center',
									originY: 'center',
									top: center.top,
									left: center.left,
									hasControls: false,
									lockMovementX: true,
									lockMovementY: true,
									evented:false
								});

								if (sauvegarde == 'non' || reset == 'oui'){
									canvas.add(gabarit);
									gabarit.scaleToHeight(canvas.height);
									gabarit.bringToFront();
								}
						});
					}

					//self.bgMove();
					//self.switch();

				} // fin oriflammes
			//------------------------------------------------------------------------
      return {width:w,height:h};
    };

    //========================================================================== IMG META
    self.getImageMeta = function (url){
        var w; var h;
        var img = new Image();

        img.src = url;
        h = img.height;
        w = img.width;

        return {width:w,height:h};
    };

    // ========================================================================= CHECK BG

    self.checkBackgroundImage = function () {
        return canvas.backgroundImage;
    };

    // ========================================================================= CONTROLES GROUPE
		fabric.Group.prototype.hasControls = false;
		fabric.Group.prototype.hasBorders = false;

		self.getSelection = function(){
		  return canvas.getActiveObject() == null ? canvas.getActiveGroup() : canvas.getActiveObject()
		}

    // ========================================================================= TOUT SELECTIONNER

		self.selectA = function (){
				canvas.deactivateAll();

				var objs = canvas.getObjects().map(function(o) {
					return o.set('active', true);
				});
				var center = canvas.getCenter();
				var group = new fabric.Group(objs, {
					originX: 'center',
					originY: 'center',
				});

				//canvas._activeObject = null;
				canvas.setActiveGroup(group.setCoords()).renderAll();
		}

		self.relock = function () {
			self.findObject(canvas, 'id', 'recbg').set({lockMovementY:true, lockMovementX: true});
		}

    // ========================================================================= CALQUES

    self.canvasLayers = function (){
      var layers = [];

      $.each(canvas.getObjects(), function (index,value) {
					layers.push({
						"id": "calque "+(index+1),
						"src":self.convertToSVG(value),
						"object":value
					});
      });

      return layers.reverse();

    };

    self.convertToSVG = function (value){
      return value.toDataURL({
				format: 'jpg',
				multiplier: .5
			});
    };


    // =========================================================================
    self.isTainted = function (){
        var ctx = canvas.getContext("2d");
        try {
            var pixel = ctx.getImageData(0, 0, 1, 1);
            return false;
        } catch(err) {
            return (err.code === 18);
        }
    };



		// ========================================================================= GET BASE 64
		self.getBase64 = function(img) {
			var reader = new FileReader();
			reader.readAsDataURL(img);
			reader.onload = function () {
				console.log(reader.result);
			};
			reader.onerror = function (error) {
				console.log('Error: ', error);
			};
		}


		// ========================================================================= LOAD BASE 64
		self.adb64 = function(b64object, w, h) {
			fabric.Image.fromURL(b64object, function(object) {
				object.globalCompositeOperation = 'source-atop';
				self.addObjectToCanvas(object);
				canvas.setActiveObject(object.set({
							width: w,
							height: h
					})
				);
				object.bringForward();

				var gaba = self.findObject(canvas, 'id', 'gabarit');
				canvas.bringToFront(gaba);
				gaba.set({evented: false});
				self.render();
			});
		}

		// ========================================================================= LOAD IMG
		self.addImage = function(imageURL) {
		  fabric.Image.fromURL(imageURL, function(object) {
				object.id = self.createId();

				for (var p in self.imageOptions) {
					object[p] = self.imageOptions[p];
				}

				// Add a filter that can be used to turn the image
				// into a solid colored shape.
				var filter = new fabric.Image.filters.Tint({
					color: '#ffffff',
					opacity: 0
				});
				object.filters.push(filter);
				object.applyFilters(canvas.renderAll.bind(canvas));
				object.globalCompositeOperation = 'source-atop';

				var produit = $('#produit').text();
				var desc = $('#desc').text();
				var min = desc.indexOf('mini') > -1;
				var fly = produit.indexOf('Flyers') > -1;
				var dep = produit.indexOf('Depliants') > -1;
				var cat = produit.indexOf('Cartes') > -1;
				var sti = produit.indexOf('Sticker') > -1;

				//---------------------------------------------------------------------- grand formats
				if (!min && !fly && !dep && !cat && !sti) {
					// si la largeur est inférieure à 1.5 x hauteur, on cale l'img sur la hauteur du canvas
					if (object.width <= object.height*1.5){

						object.scaleToHeight(canvas.height-50);

						//------------------------------------------------------scale vertical
						if (object.height <= 3500) {
							object.scaleToHeight(canvas.height/1.2);
						}
						if (object.height <= 3000) {
							object.scaleToHeight(canvas.height/1.4);
						}
						if (object.height <= 2500) {
							object.scaleToHeight(canvas.height/1.8);					}

						if (object.height <= 2400) {
							object.scaleToHeight(canvas.height/2);
						}
						if (object.height <= 1600) {
							object.scaleToHeight(canvas.height/3);
						}
						if (object.height <= 800) {
							object.scaleToHeight(canvas.height/6);
						}
						if (object.height <= 400) {
							object.scaleToHeight(canvas.height/15);
						}
						if (object.height <= 200) {
							object.scaleToHeight(canvas.height/20);
						}
						if (object.height <= 100) {
							object.scaleToHeight(canvas.height/30);
						}
						if (object.height <= 50) {
							object.scaleToHeight(canvas.height/50);
						}
						if (object.height <= 25) {
							object.scaleToHeight(canvas.height/100);
						}

					}else { // si largeur + gde, img calée sur la largeur du canvas
						object.scaleToWidth(canvas.width-50);

						//----------------------------------------------------scale horizontal
						if (object.width <= 3500) {
							object.scaleToWidth(canvas.width/1.2);
						}
						if (object.width <= 3000) {
							object.scaleToWidth(canvas.width/1.4);
						}
						if (object.width <= 2500) {
							object.scaleToWidth(canvas.width/1.8);
						}
						if (object.width <= 2000) {
							object.scaleToWidth(canvas.width/2);
						}
						if (object.width <= 1600) {
							object.scaleToWidth(canvas.width/3);
						}
						if (object.width <= 800) {
							object.scaleToWidth(canvas.width/6);
						}
						if (object.width <= 400) {
							object.scaleToWidth(canvas.width/15);
						}
						if (object.width <= 200) {
							object.scaleToWidth(canvas.width/20);
						}
						if (object.width <= 100) {
							object.scaleToWidth(canvas.width/30);
						}
						if (object.width <= 50) {
							object.scaleToWidth(canvas.width/50);
						}
						if (object.width <= 25) {
							object.scaleToWidth(canvas.width/100);
						}
					}

					//--------------------------- si résolution trop petite, avertissement
					if((object.width <= 800) || (object.height <= 800)){
							if (!confirm('l\'image que vous avez sélectionné semble être de trop petite pour une impression grand format. Etes-vous sur de vouloir continuer ?')) {
	              return;
	            }
							else  {
							  self.addObjectToCanvas(object);
							}
					}else{
						self.addObjectToCanvas(object);
					}

				//---------------------------------------------------------------------- Petits formats
				}else{
					// si la largeur est inférieure à 1.5 x hauteur, on cale l'img sur la hauteur du canvas
					if (object.width <= object.height*1.5){
						object.scaleToHeight(canvas.height-50);

						//------------------------------------------------------scale vertical
						if (object.height <= 1600) {
							object.scaleToHeight(canvas.height/1.5);
						}
						if (object.height <= 800) {
							object.scaleToHeight(canvas.height/2);
						}
						if (object.height <= 400) {
							object.scaleToHeight(canvas.height/4);
						}
						if (object.height <= 200) {
							object.scaleToHeight(canvas.height/8);
						}
						if (object.height <= 100) {
							object.scaleToHeight(canvas.height/16);
						}
						if (object.height <= 50) {
							object.scaleToHeight(canvas.height/32);
						}
						if (object.height <= 25) {
							object.scaleToHeight(canvas.height/64);
						}
					}else { // si largeur + gde, img calée sur la largeur du canvas
						object.scaleToWidth(canvas.width-50);

						//----------------------------------------------------scale horizontal
						if (object.width <= 1600) {
							object.scaleToWidth(canvas.width/1.5);
						}
						if (object.width <= 800) {
							object.scaleToWidth(canvas.width/2);
						}
						if (object.width <= 400) {
							object.scaleToWidth(canvas.width/4);
						}
						if (object.width <= 200) {
							object.scaleToWidth(canvas.width/8);
						}
						if (object.width <= 100) {
							object.scaleToWidth(canvas.width/16);
						}
						if (object.width <= 50) {
							object.scaleToWidth(canvas.width/32);
						}
						if (object.width <= 25) {
							object.scaleToWidth(canvas.width/64);
						}
					}

					self.addObjectToCanvas(object);
				}
				//canvas.deactivateAll().renderAll();


				var br = object.getBoundingRect();
				var mult = 10;

				if (xsmall) {
					mult = 12;
				}
				if (small) {
					mult = 11;
				}
				if (medium) {
					mult = 10;
				}
				if (large) {
					mult = 8;
				}

				var newimg = canvas.getActiveObject().toDataURL({
					format: 'jpeg',
					quality: '1.0',
					left: 11,
					top: 11,
					width: br.width-22,
					height: br.height-22,
					multiplier: mult
				});

				canvas.remove(object);
				self.adb64(newimg, br.width-22, br.height-22);

			}, self.imageDefaults);

		};

		// ========================================================================= LOAD PNG
		self.addPNG = function(imageURL) {
        fabric.Image.fromURL(imageURL, function (object) {
					object.id = self.createId();

					for (var p in self.imageOptions) {
						object[p] = self.imageOptions[p];
					}

					// Add a filter that can be used to turn the image
					// into a solid colored shape.
					var filter = new fabric.Image.filters.Tint({
						color: '#ffffff',
						opacity: 0
					});
					object.filters.push(filter);
					object.applyFilters(canvas.renderAll.bind(canvas));
					object.globalCompositeOperation = 'source-atop';

          self.addObjectToCanvas(object);
        });
		};


		// ========================================================================= LOAD SHAPES
		self.addShape = function(svgURL) {

			fabric.loadSVGFromURL(svgURL, function (objects, options) {
				var newOptions = self.merge_options(options,self.shapeDefaults);
				var object = fabric.util.groupSVGElements(objects, newOptions);

				object.id = self.createId();


				for (var p in self.shapeDefaults) {
					object[p] = self.shapeDefaults[p];
				}
				object.scaleToHeight(canvas.height/3.5);
				/*if (object.isSameColor && object.isSameColor() || !object.paths) {
					object.setFill('#000000');
				} else if (object.paths) {
					for (var i = 0; i < object.paths.length; i++) {
						object.paths[i].setFill(object.paths[i].fill);
					}
				}*/
				self.addObjectToCanvas(object);

			});

		};

    // ========================================================================= Shape String
    self.addShapeString = function(svg) {

        fabric.loadSVGFromString(svg, function (objects, options) {
            var newOptions = self.merge_options(options,self.shapeDefaults);
            var object = fabric.util.groupSVGElements(objects, newOptions);
            object.id = self.createId();

            for (var p in self.shapeDefaults) {
                object[p] = self.shapeDefaults[p];
            }
            if (object.isSameColor && object.isSameColor() || !object.paths) {
                object.setFill('#000000');
            } else if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setFill(object.paths[i].fill);
                }
            }
						object.globalCompositeOperation = 'source-atop';
            self.addObjectToCanvas(object);

        });
    };

    // ========================================================================= COPIER COLLER

    // Copy

    self.copyItem = function() {
        if(canvas.getActiveGroup()){
            for(var i in canvas.getActiveGroup().objects){
                var object = fabric.util.object.clone(canvas.getActiveGroup().objects[i]);
                object.set("top", object.top+5);
                object.set("left", object.left+5);
                copiedObjects[i] = object;
            }
            return 'DONE';
        }
        else if(canvas.getActiveObject()){
            var object = fabric.util.object.clone(canvas.getActiveObject());
            object.set("top", object.top+5);
            object.set("left", object.left+5);
            copiedObject = object;
            return 'DONE';
        }else{
            return 'ERROR';
        }
    };


    // Paste

    self.pasteItem = function() {
        if(copiedObjects.length > 0){
            for(var i in copiedObjects){
                canvas.add(copiedObjects[i]);
            }
            canvas.renderAll();
            copiedObject = null;
            return 'DONE';
        }
        else if(copiedObject){
            canvas.add(copiedObject);
            canvas.renderAll();
            copiedObject = null;
            return 'DONE';
        }else{
            return 'ERROR';
        }

    };

		// ========================================================================= UNDO REDO

    //Undo

    self.undo = function() {
			// lenght>1 pour ne pas effacer le 1er object soit le gabarit en revenant en arrière
        if(canvas._objects.length>1){
            h.push(canvas._objects.pop());
            canvas.renderAll();
        }
    };

    //Redo

    self.redo = function() {
        if(h.length>0){
            isRedoing = true;
            canvas.add(h.pop());
        }
    };

		//
		// Text
		// ========================================================================= TEXT
		self.addText = function(str) {
			str = str || 'Votre Texte...';
			str = str.replace(/^"/g, "«").replace(/"$/g, "»");
			str = str.replace(/ "/g, " «").replace(/" /g, "» ");
			var object = new FabricWindow.Text(str, self.textDefaults);
      object.id = self.createId();
			object.globalCompositeOperation = 'source-atop';
      self.addObjectToCanvas(object);

			/*let strArr = str.split('\n');
			var n = 0;
				strArr.forEach(s => {
						n++;
				    let object = new FabricWindow.Text(s, self.textDefaults);
				    object.id = self.createId(); //you should probably start using es6 arrow syntax to avoid having to use self
						object.globalCompositeOperation = 'source-atop';
				    self.addObjectToCanvas(object, n);
			})*/

		};

    // ========================================================================= Curved Text
    self.addCurvedText = function(str) {
      str = str || 'Texte incurvé';
			str = str.replace(/^"/, "«").replace(/"$/, "»");
			str = str.replace(/ "/g, " «").replace(/" /g, "» ");
			str = str.replace(/\n"/g, '\n«').replace(/"\n/g, "»\n");
      var CurvedText = new FabricWindow.CurvedText(str, self.textDefaults);
      CurvedText.id = self.createId();
			CurvedText.globalCompositeOperation = 'source-atop';
      self.addObjectToCanvas(CurvedText);
    };

		self.getText = function() {
        return getActiveProp('text');
    };

		self.setText = function(value) {
			value = value.replace(/^"/, "«").replace(/"$/, "»");
			value = value.replace(/ "/g, " «").replace(/" /g, "» ");
			value = value.replace(/\n"/g, '\n«').replace(/"\n/g, "»\n");
      var obj = canvas.getActiveObject();
      if(obj != null) {
          if (/text/.test(obj.type)) {
              setActiveProp('text', value);
          } else {
              obj.setText(value);
              canvas.renderAll();
          }
      }
		};

    self.merge_options = function (obj1,obj2){
        for (var p in obj2) {
            try {
                // Property in destination object set; update its value.
                if ( obj2[p].constructor==Object ) {
                    obj1[p] = MergeRecursive(obj1[p], obj2[p]);

                } else {
                    obj1[p] = obj2[p];

                }

            } catch(e) {
                // Property in destination object not set; create it and set its value.
                obj1[p] = obj2[p];

            }
        }

        return obj1;
    };

    self.toggleText = function(){
        var props = {};
        var obj = canvas.getActiveObject();
        if(obj){
            if(/curvedText/.test(obj.type)) {
                var default_text = obj.getText();
                props = obj.toObject();
                delete props['type'];
                var newProp = self.merge_options(props,self.textDefaults);
                var textSample = new fabric.Text(default_text, newProp);
            }else if(/text/.test(obj.type)) {
                var default_text = obj.getText();
                props = obj.toObject();
                delete props['type'];
                var newProp = self.merge_options(props,self.curvedTextDefaults);
                var textSample = new fabric.CurvedText(default_text, newProp);
            }
            canvas.remove(obj);
            canvas.add(textSample).renderAll();
            canvas.setActiveObject(canvas.item(canvas.getObjects().length-1));
        }
    };

    self.toggleReverse = function (value) {

        var obj = canvas.getActiveObject();
        if(obj) {
            if (typeof value !== "undefined") {
                if (value == true) {
                    obj.set('reverse',false);
                    canvas.renderAll();
                } else {
                    obj.set('reverse',true);
                    canvas.renderAll();
                }
            } else {
                obj.set('reverse',true);
                canvas.renderAll();
            }
        }
    };

    self.renderBridgeText = function () {

        var curve = parseInt(iCurve.value, 10);
        var offsetY = parseInt(iOffset.value, 10);
        var textHeight = parseInt(iHeight.value, 10);
        var bottom = parseInt(iBottom.value, 10);
        var isTri = iTriangle.checked;

        vCurve.innerHTML = curve;
        vOffset.innerHTML = offsetY;
        vHeight.innerHTML = textHeight;
        vBottom.innerHTML = bottom;

        octx.clearRect(0, 0, w, h);
        ctx.clearRect(0, 0, w, h);

        octx.fillText(iText.value.toUpperCase(), w * 0.5, 0);

        /// slide and dice
        var i = w;
        var dltY = curve / textHeight;
        var y = 0;
        while (i--) {
            if (isTri) {
                y += dltY;
                if (i === (w * 0.5)|0) dltY = -dltY;
            } else {
                y = bottom - curve * Math.sin(i * angleSteps * Math.PI / 180);
            }
            ctx.drawImage(os, i, 0, 1, textHeight,
                i, h * 0.5 - offsetY / textHeight * y, 1, y);
        }
    };

    self.radius = function (value) {
        var obj = canvas.getActiveObject();
        if(obj){
            obj.set('radius',value);
        }
        canvas.renderAll();
    };

    self.spacing = function (value) {
        var obj = canvas.getActiveObject();
        if(obj){
            obj.set('spacing',value);
        }
        canvas.renderAll();
    };

		// ========================================================================= Font Size
		self.getFontSize = function() {
			return getActiveStyle('fontSize');
		};

		self.setFontSize = function(value) {
            var obj = canvas.getActiveObject();
            if(obj){
                if(/curvedText/.test(obj.type)) {
                    obj.set('fontSize', parseInt(value, 10));
                    canvas.renderAll();
                }else if(/text/.test(obj.type)) {
                    setActiveStyle('fontSize', parseInt(value, 10));
                    self.render();
                }
            }
		};


		// ========================================================================= Text Align
		self.getTextAlign = function() {
			return capitalize(getActiveProp('textAlign'));
		};

		self.setTextAlign = function(value) {
			setActiveProp('textAlign', value.toLowerCase());
		};

		// ========================================================================= Font Family
		self.getFontFamily = function() {
			var fontFamily = getActiveProp('fontFamily');
			return fontFamily ? fontFamily.toLowerCase() : '';
		};

		self.setFontFamily = function(value) {
			setActiveProp('fontFamily', value.toLowerCase());
		};

		// ========================================================================= Lineheight
		self.getLineHeight = function() {
			return getActiveStyle('lineHeight');
		};

		self.setLineHeight = function(value) {
			setActiveStyle('lineHeight', parseFloat(value, 10));
			self.render();
		};

		// ========================================================================= Bold
		self.isBold = function() {
			return getActiveStyle('fontWeight') === 'bold';
		};

		self.toggleBold = function() {

            var obj = canvas.getActiveObject();
            if(obj){
                if(/curvedText/.test(obj.type)) {
                    obj.set('fontWeight', getActiveStyle('fontWeight') === 'bold' ? '' : 'bold');
                    canvas.renderAll();
                }else if(/text/.test(obj.type)) {
                    setActiveStyle('fontWeight', getActiveStyle('fontWeight') === 'bold' ? '' : 'bold');
                    self.render();
                }
            }
		};

		// ========================================================================= Italic
		self.isItalic = function() {
			return getActiveStyle('fontStyle') === 'italic';
		};

		self.toggleItalic = function() {

            var obj = canvas.getActiveObject();
            if(obj){
                if(/curvedText/.test(obj.type)) {
                    obj.set('fontStyle', getActiveStyle('fontStyle') === 'italic' ? '' : 'italic');
                    canvas.renderAll();
                }else if(/text/.test(obj.type)) {
                    setActiveStyle('fontStyle', getActiveStyle('fontStyle') === 'italic' ? '' : 'italic');
                    self.render();
                }

            }
		};

		// ========================================================================= Underline
		self.isUnderline = function() {
			return getActiveStyle('textDecoration').indexOf('underline') > -1;
		};

		self.toggleUnderline = function() {

            var obj = canvas.getActiveObject();
            if(obj){
                if(/curvedText/.test(obj.type)) {
                    var value = self.isUnderline() ? getActiveStyle('textDecoration').replace('underline', '') : (getActiveStyle('textDecoration') + ' underline');
                    obj.set('textDecoration', value);
                    canvas.renderAll();
                }else if(/text/.test(obj.type)) {
                    var value = self.isUnderline() ? getActiveStyle('textDecoration').replace('underline', '') : (getActiveStyle('textDecoration') + ' underline');
                    setActiveStyle('textDecoration', value);
                    self.render();
                }
            }
		};

		// ========================================================================= Linethrough
		self.isLinethrough = function() {
			return getActiveStyle('textDecoration').indexOf('line-through') > -1;
		};

		self.toggleLinethrough = function() {

            var obj = canvas.getActiveObject();
            if(obj){
                if(/curvedText/.test(obj.type)) {
                    var value = self.isLinethrough() ? getActiveStyle('textDecoration').replace('line-through', '') : (getActiveStyle('textDecoration') + ' line-through');
                    obj.set('textDecoration', value);
                    canvas.renderAll();
                }else if(/text/.test(obj.type)) {
                    var value = self.isLinethrough() ? getActiveStyle('textDecoration').replace('line-through', '') : (getActiveStyle('textDecoration') + ' line-through');

                    setActiveStyle('textDecoration', value);
                    self.render();
                }
            }
		};

		// ========================================================================= Text Align
		self.getTextAlign = function() {
			return getActiveProp('textAlign');
		};

		self.setTextAlign = function(value) {
			setActiveProp('textAlign', value);
		};

		// ========================================================================= Opacity
		self.getOpacity = function() {
			return getActiveStyle('opacity');
		};

		self.setOpacity = function(value) {
			setActiveStyle('opacity', value);
		};

		// ========================================================================= FlipX
		self.getFlipX = function() {
			return getActiveProp('flipX');
		};

		self.setFlipX = function(value) {
			setActiveProp('flipX', value);
		};

		self.toggleFlipX = function() {
			var value = self.getFlipX() ? false : true;
			self.setFlipX(value);
			self.render();
		};

		// ========================================================================= Align Active Object
		self.center = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');
			if (activeObject) {
				if (activeObject == recbg) {	// si l'objet sélectionnné est le gabarit, centrer avec le calque en pointillés
					gabarit.center();
				}
				activeObject.center();
				self.updateActiveObjectOriginals();
				self.render();
			}
		};

		self.centerH = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');
			if (activeObject) {
				if (activeObject == recbg) {	// si l'objet sélectionnné est le gabarit, centrer avec le calque en pointillé
					gabarit.centerH();
				}
				activeObject.centerH();
				self.updateActiveObjectOriginals();
				self.render();
			}
		};

		self.centerV = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');
			if (activeObject) {
				if (activeObject == recbg) {	// si l'objet sélectionnné est le gabarit, centrer avec le calque en pointillé
					gabarit.centerV();
				}
				activeObject.centerV();
				self.updateActiveObjectOriginals();
				self.render();
			}
		};

		// =========================================================================  Active Object Layer Position
		self.sendBackwards = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObject != recbg) {
				canvas.sendBackwards(activeObject);
				self.render();
			}
		};

    // ========================================================================= Object Layer Position
    self.objectSendBackwards = function(activeObj) {
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObj != recbg) {
            canvas.sendBackwards(activeObj);
            self.render();
        }
    };

		self.objectBringForward = function(activeObj) {
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObj != recbg) {
            canvas.bringForward(activeObj);
            self.render();
        }
    };

		self.sendToBack = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObject != recbg) {
				canvas.bringForward(activeObject);
				canvas.sendToBack(activeObject);
				self.render();
			}
		};

		self.bringForward = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObject != recbg) {
				canvas.bringForward(activeObject);
				self.render();
			}
		};

		self.bringToFront = function() {
			var activeObject = canvas.getActiveObject();
			var recbg = self.findObject(canvas, 'id', 'recbg');

			if (activeObject != recbg) {
				canvas.bringToFront(activeObject);
				self.render();
			}
		};

		// ========================================================================= TINT COLOR
		self.isTinted = function() {
			return getActiveProp('isTinted');
		};

		self.toggleTint = function() {
			var activeObject = canvas.getActiveObject();
            if(activeObject !==undefined && activeObject !==null) {
                if (activeObject.filters[0] !== undefined && activeObject.filters[0] !== null) {
                    activeObject.isTinted = !activeObject.isTinted;
                    activeObject.filters[0].opacity = activeObject.isTinted ? 1 : 0;
                    activeObject.applyFilters(canvas.renderAll.bind(canvas));
                }
            }
		};

    self.applyTint = function() {
        var activeObject = canvas.getActiveObject();
        if(activeObject !==undefined && activeObject !==null) {
            if (activeObject.filters[0] !== undefined && activeObject.filters[0] !== null) {
                activeObject.filters[0].opacity = 1;
                activeObject.applyFilters(canvas.renderAll.bind(canvas));
            }
        }
    };

    self.resetTint = function() {
        var activeObject = canvas.getActiveObject();
        if(activeObject !==undefined && activeObject !==null) {
            if (activeObject.filters[0] !== undefined && activeObject.filters[0] !== null) {
                activeObject.filters[0].opacity = 0;
                activeObject.applyFilters(canvas.renderAll.bind(canvas));
            }
        }
    };


		self.getTint = function() {
			var object = canvas.getActiveObject();

			if (typeof object !== 'object' || object === null) {
				return '';
			}

			if (object.filters !== undefined && object.filters !== null) {
				if (object.filters[0] !== undefined && object.filters[0] !== null) {
					return object.filters[0].color;
				}
			}
		};

		self.setTint = function(tint) {
			if (! isHex(tint)) {
				return;
			}

			var activeObject = canvas.getActiveObject();
			if (activeObject.filters !== undefined && activeObject.filters !== null) {
				if (activeObject.filters[0] !== undefined && activeObject.filters[0] !== null) {
					activeObject.filters[0].color = tint;
					activeObject.applyFilters(canvas.renderAll.bind(canvas));
				}
			}
		};

		// ========================================================================= FILL COLOR
		self.getFill = function() {
			return getActiveStyle('fill');
		};

		self.setFill = function(value) {
            value = $.trim(value);
            if(typeof value != "undefined" && value.length>0){
                var object = canvas.getActiveObject();
                if (object) {
                    if (object.type === 'text') {
                        setActiveStyle('fill', value);
                    } else {
                        self.setFillPath(object, value);
                    }
                }
            }
		};

		self.setFillPath = function(object, value) {
			if (object.isSameColor && object.isSameColor() || !object.paths) {
				object.setFill(value);
			} else if (object.paths) {
				for (var i = 0; i < object.paths.length; i++) {
					object.paths[i].setFill(value);
				}
			}
		};

    // ========================================================================= 	ZOOM
		var canvasScale = 1;
		var SCALE_FACTOR = 1.1;
    // Zoom In

    self.zoomInObject = function () {
			canvasScale = canvasScale * SCALE_FACTOR;
			canvas.deactivateAll();

			var objs = canvas.getObjects().map(function(o) {
				return o.set('active', true);
			});
			var center = canvas.getCenter();
			var group = new fabric.Group(objs, {
				originX: 'center',
				originY: 'center'
			});

			var x = group.scaleX;
			var y = group.scaleY;

			group.set({
				scaleY: y*SCALE_FACTOR,
				scaleX: x*SCALE_FACTOR
			})
			canvas.setActiveGroup(group.setCoords()).deactivateAll().renderAll();
    };

    // Zoom Out

    self.zoomOutObject = function () {
			canvasScale = canvasScale / SCALE_FACTOR;
			canvas.deactivateAll();

			var objs = canvas.getObjects().map(function(o) {
				return o.set('active', true);
			});
			var center = canvas.getCenter();
			var group = new fabric.Group(objs, {
				originX: 'center',
				originY: 'center'
			});
			var x = group.scaleX;
			var y = group.scaleY;

			group.set({
				scaleY: y/SCALE_FACTOR,
				scaleX: x/SCALE_FACTOR
			})
			canvas.setActiveGroup(group.setCoords()).deactivateAll().renderAll();

    };

		// RESET ZOOM ============================================================== !! BUG !!

		// reset zoom orginal

		self.resetZoom = function() {
			self.canvasScale = 1;
			self.setZoom(1.0);
		};

		// reset zoom maison

		self.resetZoooom = function() {

			var objects = canvas.getObjects();
			for (var i in objects) {
				var scaleX = objects[i].scaleX;
				var scaleY = objects[i].scaleY;
				var left = objects[i].left;
				var top = objects[i].top;

				var tempScaleX = scaleX * (1 / canvasScale);
				var tempScaleY = scaleY * (1 / canvasScale);
				var tempLeft = left * (1 / canvasScale);
				var tempTop = top * (1 / canvasScale);

				objects[i].scaleX = tempScaleX;
				objects[i].scaleY = tempScaleY;
				objects[i].left = tempLeft;
				objects[i].top = tempTop;

				objects[i].setCoords();
			}
			canvas.renderAll();
			canvasScale = 1;

			canvas.deactivateAll();
			var objs = canvas.getObjects().map(function(o) {
				return o.set('active', true);
			});
			var center = canvas.getCenter();
			var group = new fabric.Group(objs, {
				top: center.top,
				left: center.left,
				originX: 'center',
				originY: 'center'
			});
			canvas.setActiveGroup(group.setCoords()).deactivateAll().renderAll();
		};

		// Zoom global -------------------------------------------------------------

		self.glzoomIn = function() {
			if (canvas.getWidth() < 1024) {
				canvas.setHeight(canvas.getHeight() * 1.1);
				canvas.setWidth(canvas.getWidth() * 1.1);

			}

			canvas.renderAll();
		}
		self.glzoomOut = function() {
			canvas.setHeight(canvas.getHeight() * 0.9);
			canvas.setWidth(canvas.getWidth() * 0.9);

			canvas.renderAll();
		}
		self.glresetZoom = function() {
			self.canvasScale = 1;
			self.setZoom(1.0);
			canvas.renderAll();
		}


		// Canvas Zoom
		// =========================================================================
		self.setZoom = function() {
			var objects = canvas.getObjects();
			for (var i in objects) {
				objects[i].originalScaleX = objects[i].originalScaleX ? objects[i].originalScaleX : objects[i].scaleX;
				objects[i].originalScaleY = objects[i].originalScaleY ? objects[i].originalScaleY : objects[i].scaleY;
				objects[i].originalLeft = objects[i].originalLeft ? objects[i].originalLeft : objects[i].left;
				objects[i].originalTop = objects[i].originalTop ? objects[i].originalTop : objects[i].top;
				self.setObjectZoom(objects[i]);
			}

			self.setCanvasZoom();
			self.render();
		};

		self.setObjectZoom = function(object) {
			var scaleX = object.originalScaleX;
			var scaleY = object.originalScaleY;
			var left = object.originalLeft;
			var top = object.originalTop;

			var tempScaleX = scaleX * self.canvasScale;
			var tempScaleY = scaleY * self.canvasScale;
			var tempLeft = left * self.canvasScale;
			var tempTop = top * self.canvasScale;

			object.scaleX = tempScaleX;
			object.scaleY = tempScaleY;
			object.left = tempLeft;
			object.top = tempTop;

			object.setCoords();
		};

		self.setCanvasZoom = function() {
			var width = self.canvasOriginalWidth;
			var height = self.canvasOriginalHeight;

			var tempWidth = width * self.canvasScale;
			var tempHeight = height * self.canvasScale;

			canvas.setWidth(tempWidth);
			canvas.setHeight(tempHeight);
		};

		self.updateActiveObjectOriginals = function() {
			var object = canvas.getActiveObject();
			if (object) {
				object.originalScaleX = object.scaleX / self.canvasScale;
				object.originalScaleY = object.scaleY / self.canvasScale;
				object.originalLeft = object.left / self.canvasScale;
				object.originalTop = object.top / self.canvasScale;
			}
		};

		//
		// Active Object Lock
		// ==============================================================
		self.toggleLockActiveObject = function() {
			var activeObject = canvas.getActiveObject();
			if (activeObject) {
				activeObject.lockMovementX = !activeObject.lockMovementX;
				activeObject.lockMovementY = !activeObject.lockMovementY;
				activeObject.lockScalingX = !activeObject.lockScalingX;
				activeObject.lockScalingY = !activeObject.lockScalingY;
				activeObject.lockUniScaling = !activeObject.lockUniScaling;
				activeObject.lockRotation = !activeObject.lockRotation;
				activeObject.lockObject = !activeObject.lockObject;
				self.render();
			}
		};

    //
    // Object Lock
    // ==============================================================
    self.toggleLockObject = function(activeObj) {

        if (activeObj) {
            activeObj.lockMovementX = !activeObj.lockMovementX;
            activeObj.lockMovementY = !activeObj.lockMovementY;
            activeObj.lockScalingX = !activeObj.lockScalingX;
            activeObj.lockScalingY = !activeObj.lockScalingY;
            activeObj.lockUniScaling = !activeObj.lockUniScaling;
            activeObj.lockRotation = !activeObj.lockRotation;
            activeObj.lockObject = !activeObj.lockObject;
            self.render();
        }
    };

    //
    // Lock Status
    // ==============================================================

    self.isLocked = function() {
        var activeObject = canvas.getActiveObject();
        if (null != activeObject) {
            if (activeObject.lockObject) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    };

    //
    // Object Lock Status
    // ==============================================================

    self.isObjectLocked = function(activeObj) {
        if (null != activeObj) {
            if (activeObj.lockObject) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    };

		//
		// Active Object
		// ==============================================================
		self.selectActiveObject = function() {
			var activeObject = canvas.getActiveObject();
			if (! activeObject) {
				return;
			}

			self.selectedObject = activeObject;
			self.selectedObject.text = self.getText();
      self.selectedObject.textWordCloud = "";
      self.selectedObject.isCurved = self.getIsCurved();
      self.selectedObject.isReversed = self.getIsReversed();
			self.selectedObject.fontSize = self.getFontSize();
			self.selectedObject.lineHeight = self.getLineHeight();
			self.selectedObject.textAlign = self.getTextAlign();
			self.selectedObject.opacity = self.getOpacity();
			self.selectedObject.fontFamily = self.getFontFamily();
			self.selectedObject.fill = self.getFill();
			self.selectedObject.tint = self.getTint();

		};


		self.getRandomArbitrary = function (){
		    var min = 13;
		    var max = 40;
		    var result =  Math.floor(Math.random() * (max - min));
		    return result;
		};



		self.getIsCurved = function (){
		    var obj = canvas.getActiveObject();
		    if(obj){
		        if(/curvedText/.test(obj.type)) {
		            return true;
		        }else if(/text/.test(obj.type)) {
		            return false;
		        }
		    }
		};

		self.getIsReversed = function () {
		    var obj = canvas.getActiveObject();
		    if(obj){
		        if(/curvedText/.test(obj.type)) {
		            return getActiveStyle('reverse');
		        }
		    }
		};

		//
		// deselect Active object
		// ============================================================

		self.deselectActiveObject = function() {
			self.selectedObject = false;
		};

		//
		// delete Active object
		// ============================================================

		self.deleteActiveObject = function() {
			var activeObject = canvas.getActiveObject();
			// permettre de supprimer l'objet si l'objet n'est pas le gabarit :
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');

			if (activeObject !== recbg && activeObject !== gabarit) {
				canvas.remove(activeObject);
			}
			self.render();
		};

		//
		// delete object
		// ============================================================

		self.deleteObject = function(activeObj) {
			var recbg = self.findObject(canvas, 'id', 'recbg');
			var gabarit = self.findObject(canvas, 'id', 'gabarit');

			if (activeObj !== recbg && activeObj !== gabarit) {
				canvas.remove(activeObj);
			}
		    self.render();
		};

		//
		// State Managers
		// ==============================================================
		self.isLoading = function() {
			return self.loading;
		};

		self.setLoading = function(value) {
			self.loading = value;
		};

		self.setDirty = function(value) {
			FabricDirtyStatus.setDirty(value);
		};

		self.isDirty = function() {
			return FabricDirtyStatus.isDirty();
		};

		self.setInitalized = function(value) {
			self.initialized = value;
		};

		self.isInitalized = function() {
			return self.initialized;
		};



		//==========================================================================                                                            //          										  EXPORT
		//==========================================================================
		self.prepSave = function() {
			canvas.deactivateAll().renderAll();
			// ==================================== enlever les elements gabarit inutiles au print

			var gabarit   = self.findObject(canvas, 'id', 'gabarit');
			var rolltop   = self.findObject(canvas, 'id', 'rolltop');
			var rollbot   = self.findObject(canvas, 'id', 'rollbot');
			var rollfoot1 = self.findObject(canvas, 'id', 'rollfoot1');
			var rollfoot2 = self.findObject(canvas, 'id', 'rollfoot2');
			var line      = self.findObject(canvas, 'id', 'line');
			var line1     = self.findObject(canvas, 'id', 'line1');
			var line2     = self.findObject(canvas, 'id', 'line2');

			canvas.remove(gabarit);
			canvas.remove(rolltop);
			canvas.remove(rollbot);
			canvas.remove(rollfoot1);
			canvas.remove(rollfoot2);
			canvas.remove(line);
			canvas.remove(line1);
			canvas.remove(line2);

			// ====================================== récupérer la taille de l'objet

			var obj = self.findObject(canvas, 'id', 'recbg');
			var hauteur = obj.height;
			var largeur = obj.width;
			var br = obj.getBoundingRect();

			/*if( br.width > canvas.width || br.height > canvas.height || br.height < canvas.height - 50)  {
				self.resetZoooom();
			}*/

			/*if(br.top - obj.cornerSize  <  0 || br.left - obj.cornerSize  < 0 || br.top+br.height + obj.cornerSize > obj.canvas.height || br.left+br.width + obj.cornerSize > obj.canvas.width) {
				self.resetZoooom();
			}*/

			//canvas.deactivateAll().renderAll();
		}


		// ========================================================================= JSON
		self.sauvegarder = function() {
			var obj = self.findObject(canvas, 'id', 'recbg');
			var hauteur = obj.height;
			var largeur = obj.width;
			var br = obj.getBoundingRect();

			if( br.width > canvas.width || br.height > canvas.height) {
				self.resetZoooom();
			}

			self.setDirty(false);
			return JSON.stringify(canvas.toJSON(self.JSONExportProperties));
		};

		self.getJSON = function() {
			var initialCanvasScale = self.canvasScale;
			self.canvasScale = 1;
			self.resetZoom();

			var json = JSON.stringify(canvas.toJSON(self.JSONExportProperties));

			self.canvasScale = initialCanvasScale;
			self.setZoom();

			return json;
		};

		self.loadJSON = function(json) {
			self.setLoading(true);
			canvas.loadFromJSON(json, function() {
				$timeout(function() {
					self.setLoading(false);

					if (!self.editable) {
						self.disableEditing();
					}

					self.render();
				});
			});
		};

		self.exportCanvasObjectAsJson = function() {
		    canvas.deactivateAll().renderAll();
		    return canvas.toJSON();
		};


		// ========================================================================= saveCanvasObject
		self.saveCanvasObject = function() {

		    canvas.deactivateAll().renderAll();

				var obj = canvas.item(0);
				//var hauteur = parseInt($('#hauteur').text(), 10);
				//var largeur = parseInt($('#largeur').text(), 10);

				// My SVG file as s string.
				var mySVG = canvas.toSVG();
		    //var currentFontUrl = "http://localhost:8000/wordpress/wp-content/themes/fb/config/css/fonts.css";
				//@import url('+currentFontUrl+');
		    $(document).find('.svgElements').html(mySVG);
		    var fonts = '<defs><style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lato:400,300|Architects+Daughter|Roboto|Oswald|Montserrat|Lora|PT+Sans|Ubuntu|Roboto+Slab|Fjalla+One|Indie+Flower|Playfair+Display|Poiret+One|Dosis|Oxygen|Lobster|Play|Shadows+Into+Light|Pacifico|Dancing+Script|Kaushan+Script|Gloria+Hallelujah|Black+Ops+One|Lobster+Two|Satisfy|Pontano+Sans|Domine|Russo+One|Handlee|Courgette|Special+Elite|Amaranth|Vidaloka");</style></defs>';

		    $( fonts ).insertAfter( $(document).find( ".svgElements > svg > desc" ) );
		    var svgResult = $(document).find('.svgElements').html();

		    // Create a Data URI.
		    var svg = 'data:image/svg+xml;base64,'+window.btoa(svgResult);
		    window.open(svg);
		};

		// ========================================================================= SVG

		self.saveCanvasObjectAsSvg = function() {
				//canvas.width = largeur;
				//canvas.height = hauteur;

				// ====================================================== exorter le SVG

				var mySVG = canvas.toSVG({ width: largeur,
																   height: hauteur,
																	 viewBox: {
																		  x:0,
																		  y:0,
																		  width: largeur,
																		  height: hauteur
																 	}
																});
		    //var mySVG = canvas.toSVG();
		    //var currentFontUrl = "http://localhost:8000/wordpress/wp-content/themes/fb/config/css/fonts.csss";
				//@import url('+currentFontUrl+');
		    $(document).find('.svgElements').html(mySVG);
		    var fonts = '<defs><style type="text/css">@import url("https://fonts.googleapis.com/css?family=Lato:400,300|Architects+Daughter|Roboto|Oswald|Montserrat|Lora|PT+Sans|Ubuntu|Roboto+Slab|Fjalla+One|Indie+Flower|Playfair+Display|Poiret+One|Dosis|Oxygen|Lobster|Play|Shadows+Into+Light|Pacifico|Dancing+Script|Kaushan+Script|Gloria+Hallelujah|Black+Ops+One|Lobster+Two|Satisfy|Pontano+Sans|Domine|Russo+One|Handlee|Courgette|Special+Elite|Amaranth|Vidaloka");</style></defs>';

		    $( fonts ).insertAfter( $(document).find( ".svgElements > svg > desc" ) );
		    var svgResult = $(document).find('.svgElements').html();

		    // Create a Data URI.
		    var svg = 'data:image/svg+xml;base64,'+window.btoa(svgResult);
				//console.log(svg);
		    return svg;
				// ===================================================================== fin svg
		};


		// ========================================================================= PNG
		self.saveCanvasObjectAsPng = function() {

		    canvas.deactivateAll().renderAll();

		    var png = canvas.toDataURL({
		      format: 'png',
		      multiplier: 12
		    });

		    return png;
		};

		// ========================================================================= JPG
		self.saveCanvasObjectAsJpg = function() {
				self.prepSave();
				self.setDirty(false);
				var obj = self.findObject(canvas, 'id', 'recbg');
				var br = obj.getBoundingRect();
				var mult = 14;

				// si le canvas dépasse 840x580 max:13 pour ffx et 14 pour chrome
				if (canvas.height < 580 && canvas.width < 840) {
					mult = 16;
				}
				if (navigator.userAgent.indexOf("Firefox") != -1)  {
					mult = 13;
					// max 10 pour firefox en écran large
					if (canvas.height > 609 && canvas.width > 1129) {
						mult = 10;
					}
				}
				//----------------------------------------------------------------------

		    var jpeg = canvas.toDataURL({
		      format: 'jpeg',
					quality: '1.0',
					left: br.left+11,
					top: br.top+11,
					width: br.width-22,
					height: br.height-22,
					multiplier: mult
		    });

		    return jpeg;
		};

		// =========================================================================
		//                     		DOWNLOAD
		//==========================================================================

		// ========================================================================= PNG
		self.downloadCanvasObject = function() {
		    canvas.deactivateAll().renderAll();

		    var data = canvas.toDataURL({
		      format: 'png',
		      multiplier: 12
		    });

		    var img = document.createElement('img');
		    img.src = data;

		    var a = document.createElement('a');
		    a.setAttribute("download", "export.png");
		    a.setAttribute("href", data);
		    a.appendChild(img);

		    var w = open();
		    w.document.title = 'Export Image';
		    w.document.body.appendChild(a);
		};

		// ======================================================================== PDF
		self.downloadCanvasObjectAsPDF = function () {
		    canvas.deactivateAll().renderAll();
				var hauteur = parseInt($('#hauteur').text(), 10);
				var largeur = parseInt($('#largeur').text(), 10);
		    try {
		        canvas.getContext('2d');
		        var imgData = canvas.toDataURL("image/jpeg", 1.0);
		        var pdf = new jsPDF('p', 'cm', [hauteur+10, largeur+10]);
		        pdf.addImage(imgData, 'JPEG', 5, 5, hauteur, largeur);
		        var namefile = 'export';
		        if(namefile != null) {
		            pdf.save(namefile + ".pdf");
		            return true;
		        }else{
		            return false;
		        }
		    } catch(e) {
		        alert("Error description: " + e.message);
		    }
		};

		// ======================================================================== PRINT
		self.printCanvasObject = function () {
		    canvas.deactivateAll().renderAll();

		    var dataUrl = canvas.toDataURL(); //attempt to save base64 string to server using this var
		    var windowContent = '<!DOCTYPE html>';
		    windowContent += '<html>'
		    windowContent += '<head><title>Print canvas</title></head>';
		    windowContent += '<body>'
		    windowContent += '<img src="' + dataUrl + '">';
		    windowContent += '</body>';
		    windowContent += '</html>';
		    var printWin = window.open('','','width=440,height=360');
		    printWin.document.open();
		    printWin.document.write(windowContent);
		    printWin.document.close();
		    printWin.focus();
		    printWin.print();
		    printWin.close();

		};

		// Download Canvas
		// =========================================================================  DOWNLOAD
		self.getCanvasData = function() {
			var data = canvas.toDataURL({
				width: canvas.getWidth(),
				height: canvas.getHeight(),
				multiplier: self.downloadMultipler
			});

			return data;
		};

		self.getCanvasBlob = function() {
			var base64Data = self.getCanvasData();
			var data = base64Data.replace('data:image/png;base64,', '');
			var blob = b64toBlob(data, 'image/png');
			var blobUrl = URL.createObjectURL(blob);

			return blobUrl;
		};

		self.download = function(name) {
			// Stops active object outline from showing in image
			self.deactivateAll();

			var initialCanvasScale = self.canvasScale;
			self.resetZoom();

			// Click an artifical anchor to 'force' download.
			var link = document.createElement('a');
			var filename = name + '.png';
			link.download = filename;
			link.href = self.getCanvasBlob();
			link.click();

			self.canvasScale = initialCanvasScale;
			self.setZoom();
		};

		//
		// Continuous Rendering
		// =========================================================================
		// Upon initialization re render the canvas
		// to account for fonts loaded from CDN's
		// or other lazy loaded items.

		// Prevent infinite rendering loop
		self.continuousRenderCounter = 0;
		self.continuousRenderHandle;

		self.stopContinuousRendering = function() {
			$timeout.cancel(self.continuousRenderHandle);
			self.continuousRenderCounter = self.maxContinuousRenderLoops;
		};

		self.startContinuousRendering = function() {
			self.continuousRenderCounter = 0;
			self.continuousRender();
		};

		// Prevents the "not fully rendered up upon init for a few seconds" bug.
		self.continuousRender = function() {
			if (self.userHasClickedCanvas || self.continuousRenderCounter > self.maxContinuousRenderLoops) {
				return;
			}

			self.continuousRenderHandle = $timeout(function() {
				self.setZoom();
				self.render();
				self.continuousRenderCounter++;
				self.continuousRender();
			}, self.continuousRenderTimeDelay);
		};

		//
		// Utility
		// ==============================================================
		self.setUserHasClickedCanvas = function(value) {
			self.userHasClickedCanvas = value;
		};

		self.createId = function() {
			return Math.floor(Math.random() * 10000);
		};

		//
		// Toggle Object Selectability
		// ==============================================================
		self.disableEditing = function() {
			canvas.selection = false;
			canvas.forEachObject(function(object) {
				object.selectable = false;
			});
		};

		self.enableEditing = function() {
			canvas.selection = true;
			canvas.forEachObject(function(object) {
				object.selectable = true;
			});
		};

		//
		// Set Global Defaults
		// ==============================================================
		self.setCanvasDefaults = function() {
			canvas.selection = self.canvasDefaults.selection;
		};

		self.setWindowDefaults = function() {
			FabricWindow.Object.prototype.transparentCorners = self.windowDefaults.transparentCorners;
			FabricWindow.Object.prototype.rotatingPointOffset = self.windowDefaults.rotatingPointOffset;
			FabricWindow.Object.prototype.padding = self.windowDefaults.padding;
		};

		//
		// Canvas Listeners
		// ============================================================
		self.startCanvasListeners = function() {

			// surveille qu'un objet ne déborde pas du cadre lors de son déplacement
			/*canvas.on('object:moving', function (e) {
        var obj = e.target;
         // if object is too big ignore
        if(obj.currentHeight > obj.canvas.height || obj.currentWidth > obj.canvas.width){
            return;
        }
        obj.setCoords();
        // top-left  corner
        if(obj.getBoundingRect().top < 0 || obj.getBoundingRect().left < 0){
            obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top);
            obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left);
        }
        // bot-right corner
        if(obj.getBoundingRect().top+obj.getBoundingRect().height  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width  > obj.canvas.width){
            obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top);
            obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left);
        }
			});*/


			// surveille qu'un objet ne déborde pas du cadre lors de son redimentionnement
			/*canvas.on('object:scaling', function (e) {
		    var obj = e.target;
			  if(obj.getHeight() > obj.canvas.height || obj.getWidth() > obj.canvas.width){
			    obj.setScaleY(obj.originalState.scaleY);
			    obj.setScaleX(obj.originalState.scaleX);
			  }
			  obj.setCoords();
			  if(obj.getBoundingRect().top - (obj.cornerSize / 2) < 0 ||
			     obj.getBoundingRect().left -  (obj.cornerSize / 2) < 0) {
			    obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top + (obj.cornerSize / 2));
			    obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left + (obj.cornerSize / 2));
			  }
			  if(obj.getBoundingRect().top+obj.getBoundingRect().height + obj.cornerSize  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width + obj.cornerSize  > obj.canvas.width) {
			    obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top - obj.cornerSize / 2);
			    obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left - obj.cornerSize /2);
			  }
			});*/


			canvas.on('object:selected', function() {
				self.stopContinuousRendering();

				//----------- correction bug gabarit pointillé actif qd il y a une image
				var gaba = self.findObject(canvas, 'id', 'gabarit');
				var recbg = self.findObject(canvas, 'id', 'recbg');
				canvas.bringToFront(gaba);
				gaba.set({hasControls: false, evented: false});
				recbg.set({hasControls: false});
				//----------------------------------------------------------------------

				$timeout(function() {
					self.selectActiveObject();
					self.setDirty(true);
				});
			});

			canvas.on('selection:created', function() {
				self.stopContinuousRendering();

			});

			canvas.on('selection:cleared', function() {
				$timeout(function() {
					self.deselectActiveObject();
				});
			});

			canvas.on('after:render', function() {
				canvas.calcOffset();
			});

			canvas.on('object:modified', function() {
				self.stopContinuousRendering();
				$timeout(function() {
					self.updateActiveObjectOriginals();
					self.setDirty(true);
				});
			});

			canvas.on('object:added', function() {

			});


		};





	// drawing mode //////////////////////////////////////////////////////////////

    self.toggleDrawing = function (){
        canvas.isDrawingMode = !canvas.isDrawingMode;
        if (canvas.isDrawingMode) {
            return 'Cancel';
        }
        else {
            return 'Enter';
        }

    };

    self.enterDrawing = function (){
        canvas.isDrawingMode = true;

    };

    self.exitDrawing = function (){
        canvas.isDrawingMode = false;

    };

    self.changeDrawingMode = function (mode, color, width, shadow){

        if (fabric.PatternBrush) {

            var vLinePatternBrush = new fabric.PatternBrush(canvas);
            vLinePatternBrush.getPatternSrc = function() {
                var patternCanvas = fabric.document.createElement('canvas');
                patternCanvas.width = patternCanvas.height = 10;
                var ctx = patternCanvas.getContext('2d');

                ctx.strokeStyle = this.color;
                ctx.lineWidth = 5;
                ctx.beginPath();
                ctx.moveTo(0, 5);
                ctx.lineTo(10, 5);
                ctx.closePath();
                ctx.stroke();

                return patternCanvas;
            };

            var hLinePatternBrush = new fabric.PatternBrush(canvas);
            hLinePatternBrush.getPatternSrc = function() {

                var patternCanvas = fabric.document.createElement('canvas');
                patternCanvas.width = patternCanvas.height = 10;
                var ctx = patternCanvas.getContext('2d');

                ctx.strokeStyle = this.color;
                ctx.lineWidth = 5;
                ctx.beginPath();
                ctx.moveTo(5, 0);
                ctx.lineTo(5, 10);
                ctx.closePath();
                ctx.stroke();

                return patternCanvas;
            };

            var squarePatternBrush = new fabric.PatternBrush(canvas);
            squarePatternBrush.getPatternSrc = function() {

                var squareWidth = 10, squareDistance = 2;

                var patternCanvas = fabric.document.createElement('canvas');
                patternCanvas.width = patternCanvas.height = squareWidth + squareDistance;
                var ctx = patternCanvas.getContext('2d');

                ctx.fillStyle = this.color;
                ctx.fillRect(0, 0, squareWidth, squareWidth);

                return patternCanvas;
            };

            var diamondPatternBrush = new fabric.PatternBrush(canvas);
            diamondPatternBrush.getPatternSrc = function() {

                var squareWidth = 10, squareDistance = 6;
                var patternCanvas = fabric.document.createElement('canvas');
                var rect = new fabric.Rect({
                    width: squareWidth,
                    height: squareWidth,
                    angle: 45,
                    fill: this.color
                });

                var canvasWidth = rect.getBoundingRectWidth();
                var canvasWidth  = canvasWidth - 28;
                patternCanvas.width = patternCanvas.height = canvasWidth + squareDistance;
                rect.set({ left: canvasWidth / 2, top: canvasWidth / 2 });

                var ctx = patternCanvas.getContext('2d');
                rect.render(ctx);

                return patternCanvas;
            };



        }

        if (mode === 'hline') {
            canvas.freeDrawingBrush = vLinePatternBrush;
        }
        else if (mode === 'vline') {
            canvas.freeDrawingBrush = hLinePatternBrush;
        }
        else if (mode === 'square') {
            canvas.freeDrawingBrush = squarePatternBrush;
        }
        else if (mode === 'diamond') {
            canvas.freeDrawingBrush = diamondPatternBrush;
        }
        else if (mode === 'texture') {
            canvas.freeDrawingBrush = texturePatternBrush;
        }
        else {

            canvas.freeDrawingBrush = new fabric[mode + 'Brush'](canvas);
        }

        canvas.freeDrawingBrush.color = color;
        canvas.freeDrawingBrush.width = parseInt(width, 10) || 1;
        canvas.freeDrawingBrush.shadowBlur = parseInt(shadow, 10) || 0;


    };

    self.resetBrush = function (mode, color, width, shadow){

        canvas.freeDrawingBrush = new fabric[mode + 'Brush'](canvas);
        canvas.freeDrawingBrush.color = color;
        canvas.freeDrawingBrush.width = parseInt(width, 10) || 1;
        canvas.freeDrawingBrush.shadowBlur = parseInt(shadow, 10) || 0;
    };

    self.fillDrawing = function (color){
        canvas.freeDrawingBrush.color = color;
    };

    self.changeDrawingWidth = function (width){
        canvas.freeDrawingBrush.width = parseInt(width, 10) || 1;
    };

    self.changeDrawingShadow = function (shadow){
        canvas.freeDrawingBrush.shadowBlur = parseInt(shadow, 10) || 0;
    };

    self.readyHandTool = function (dBrush, dColor, dWidth, dShadow){

        if (canvas.freeDrawingBrush) {
            canvas.freeDrawingBrush = new fabric[dBrush+'Brush'](canvas);
            canvas.freeDrawingBrush.color = dColor;
            canvas.freeDrawingBrush.width = parseInt(dWidth, 10) || 1;
            canvas.freeDrawingBrush.shadowBlur = parseInt(dShadow, 10) || 0;
        }

    };

		//
		// Constructor
		// ==============================================================
		self.init = function() {
			canvas = FabricCanvas.getCanvas();
      var canvasW = winWidth/1.36;
			var canvasH = winHeight-130;
			console.log('window:' +winWidth+ 'x' +winHeight);
			console.log('canvas:' +canvasW+ 'x' +canvasH);
			//------------------------------------------------------------------------


			//------------------------------------------------------------------------

			self.canvasId = FabricCanvas.getCanvasId();
			canvas.clear();

			if(winWidth < 990){
				var canvasW = winWidth-20;
				var canvasH = 580;
      }

			// For easily accessing the json
			JSONObject = angular.fromJson(self.json);
			self.loadJSON(self.json);

			JSONObject = JSONObject || {};

			self.canvasScale = 1;

			JSONObject.background = JSONObject.background || '';
			self.setCanvasBackgroundColor(JSONObject.background);

			// Set the size of the canvas
			JSONObject.width = JSONObject.width || canvasW;
			self.canvasOriginalWidth = JSONObject.width;

			JSONObject.height = JSONObject.height || canvasH;
			self.canvasOriginalHeight = JSONObject.height;

			self.setCanvasSize(self.canvasOriginalWidth, self.canvasOriginalHeight);

			self.render();
			self.setDirty(false);
			self.setInitalized(true);

			self.setCanvasDefaults();
			self.setWindowDefaults();
			self.startCanvasListeners();
			self.startContinuousRendering();
			FabricDirtyStatus.startListening();
		};
		self.init();
		return self;
	};
}]);

//------------------------------------------------------------------------------
// SAUVEGARDE DOUBLES GABARITS RECTO Verso
//------------------------------------------------------------------------------
	// si recto-verso format portrait ou carré, afficher les 2 gabarits côte à côte
  if (rectoVerso && (hauteur >= largeur) ){

    // pour format carré réduction de la taille pour que les 2 carrés rentrent dans le canvas
    if(largeur == hauteur) {
        largeur = MAX_HEIGHT/1.15-50;
        hauteur = MAX_HEIGHT/1.15-50;
    }

    var gabarit = new fabric.Rect({
      id: 'gabarit1',
      originX: 'left',
      originY: 'center',
      top: center.top,
      left: 15,
      fill: 'rgba(0,0,0,0)',
      stroke: '#ccc',
      strokeWidth: 2,
      strokeDashArray: [10, 5],
      width: largeur-12,
      height: hauteur-12,
      hasControls: false,
      evented:false
    });

    var gabarit2 = new fabric.Rect({
      id: 'gabarit2',
      originX: 'left',
      originY: 'center',
      top: center.top,
      left: largeur+25,
      fill: 'rgba(0,0,0,0)',
      stroke: '#ccc',
      strokeWidth: 2,
      strokeDashArray: [10, 5],
      width: largeur-12,
      height: hauteur-12,
      hasControls: false,
      evented:false
    });

    var rect = new fabric.Rect({
      id: 'recbg1',
      originX: 'left',
      originY: 'center',
      top: center.top,
      left: 10,
      fill: '#fff',
      width: largeur,
      height: hauteur,
      hasControls: false
    });

    var rect2 = new fabric.Rect({
      id: 'recbg2',
      originX: 'left',
      originY: 'center',
      top: center.top,
      left: largeur+20,
      fill: '#fff',
      width: largeur,
      height: hauteur,
      hasControls: false
    });

    canvas.add(rect);
    canvas.add(gabarit);
    canvas.add(rect2);
    canvas.add(gabarit2);

    // lier les calques rect & gabarit -------------------------------
    function rectMouseMove(option){
     gabarit.left = rect.gabaritLeft+ rect.left - rect.mousesDownLeft ;
     gabarit.top = rect.gabaritTop+ rect.top- rect.mousesDownTop;
     gabarit.setCoords();

     gabarit2.left = rect2.gabaritLeft+ rect2.left - rect2.mousesDownLeft ;
     gabarit2.top = rect2.gabaritTop+ rect2.top- rect2.mousesDownTop;
     gabarit2.setCoords();
    }

    function rectMouseDown(option){
     rect.mousesDownLeft = rect.left;
     rect.mousesDownTop = rect.top;
     rect.gabaritLeft = gabarit.left;
     rect.gabaritTop = gabarit.top;

     rect2.mousesDownLeft = rect2.left;
     rect2.mousesDownTop = rect2.top;
     rect2.gabaritLeft = gabarit2.left;
     rect2.gabaritTop = gabarit2.top;
    }

    register();
    function register(){
     rect.on('moving',rectMouseMove);
     rect.on('mousedown',rectMouseDown);
     rect2.on('moving',rectMouseMove);
     rect2.on('mousedown',rectMouseDown);
    }

  // si recto-verso format paysage, afficher les 2 gabarits l'un sur l'autre
  }else if (rectoVerso && (largeur > hauteur)){

    // réduction de la taille si hauteurx2 supérieure à la hauteur du canvas
    if(h >= MAX_HEIGHT/2) {
      hauteur = MAX_HEIGHT/2-10;
      largeur = hauteur*ratio;
    }

    var gabarit = new fabric.Rect({
      id: 'gabarit1',
      originX: 'center',
      originY: 'top',
      top: 15,
      left: center.left,
      fill: 'rgba(0,0,0,0)',
      stroke: '#ccc',
      strokeWidth: 2,
      strokeDashArray: [10, 5],
      width: largeur-12,
      height: hauteur-12,
      hasControls: false,
      evented:false
    });

    var gabarit2 = new fabric.Rect({
      id: 'gabarit2',
      originX: 'center',
      originY: 'top',
      top: hauteur+25,
      left: center.left,
      fill: 'rgba(0,0,0,0)',
      stroke: '#ccc',
      strokeWidth: 2,
      strokeDashArray: [10, 5],
      width: largeur-12,
      height: hauteur-12,
      hasControls: false,
      evented:false
    });

    var rect = new fabric.Rect({
      id: 'recbg1',
      originX: 'center',
      originY: 'top',
      top: 10,
      left: center.left,
      fill: '#fff',
      width: largeur,
      height: hauteur,
      hasControls: false
    });

    var rect2 = new fabric.Rect({
      id: 'recbg2',
      originX: 'center',
      originY: 'top',
      top: hauteur+20,
      left: center.left,
      fill: '#fff',
      width: largeur,
      height: hauteur,
      hasControls: false
    });

    canvas.add(rect);
    canvas.add(gabarit);
    canvas.add(rect2);
    canvas.add(gabarit2);

    // lier les calques rect & gabarit -------------------------------
    function rectMouseMove(option){
     gabarit.left = rect.gabaritLeft+ rect.left - rect.mousesDownLeft ;
     gabarit.top = rect.gabaritTop+ rect.top- rect.mousesDownTop;
     gabarit.setCoords();

     gabarit2.left = rect2.gabaritLeft+ rect2.left - rect2.mousesDownLeft ;
     gabarit2.top = rect2.gabaritTop+ rect2.top- rect2.mousesDownTop;
     gabarit2.setCoords();
    }

    function rectMouseDown(option){
     rect.mousesDownLeft = rect.left;
     rect.mousesDownTop = rect.top;
     rect.gabaritLeft = gabarit.left;
     rect.gabaritTop = gabarit.top;

     rect2.mousesDownLeft = rect2.left;
     rect2.mousesDownTop = rect2.top;
     rect2.gabaritLeft = gabarit2.left;
     rect2.gabaritTop = gabarit2.top;
    }

    register();
    function register(){
     rect.on('moving',rectMouseMove);
     rect.on('mousedown',rectMouseDown);
     rect2.on('moving',rectMouseMove);
     rect2.on('mousedown',rectMouseDown);
    }
  }else{

  }

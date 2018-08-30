//================================================================================================//
//                             FONCTIONS GLOBALES POUR LES PROD PAGES                             //
//================================================================================================//

// fonction globale :                                       calculs jours ouvrés
//==============================================================================
function AddBusinessDays(weekDaysToAdd) {
    var curdate = new Date();
    var realDaysToAdd = 0;
    for(i=0; i<weekDaysToAdd; i++){
      curdate.setDate(curdate.getDate()+1);
      var estdt1 = new Date(curdate);
      var n = curdate.getDay();
      if (n == '6' || n == '0') {
        weekDaysToAdd++;
      }
      realDaysToAdd++;
    }
    return realDaysToAdd;
}

// fonction globale :                            conversion blob to base64 image
//==============================================================================
function saveBlobAsFile(blob, fileName) {
    return new Promise(function (resolve, reject) {
      var reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onload = function () {
        return resolve(reader.result);
      };
      reader.onerror = function (error) {
        return reject(error);
      };
      return Promise.resolve(reader.result);
    });
}

// fonction globale :                   inclure image produit b64 dans le panier
//==============================================================================
function sendData(cartData, base64) {
    cartData.innerHTML += '<input type="hidden" name="image" value="'+base64+'" />';
}

// fonction globale :    retourner des textes tooltip communs à toutes les pages
//==============================================================================
function getString(value){
  // valeurs par défaut tooltips communs à toutes les pages :
  if (value == 'btn') return ('<b>j\'ai mon fichier, je ne souhaite pas de BAT:</b>Après la réception de votre fichier et de votre paiement, la commande sera mise directement en production. Si votre fichier ne respecte pas nos spécifications, il sera automatiquement adapté par notre service infographie. Supprimer le BAT décharge France Banderole de toutes responsabilités en cas de non conformité de votre fichier (couleur, format, pixellisation, fond perdu, faute orthographique, etc).');

  if (value == 'bty') return ('<b>j\'ai mon fichier, je souhaite un BAT numérique: +5,00€</b> Vous envoyez votre propre fichier (une fois votre devis enregistré). Ce dernier sera contrôlé par notre service d\'infographie et un <span class="highlight">BAT à valider</span> vous sera transmis dans votre accès client. Votre production commence après la validation de ce BAT');

  if (value == 'enl') return ('<b>Vous créez votre maquette en ligne: +5,00€</b> Dans le détail de votre commande vous aurez accès à notre outil de personnalisation en ligne. Simple et axé sur les fonctionnalités essentielles, il vous permettra de composer en quelques clics une maquette aux bonnes dimensions avec vos éléments personnels (logos, images...), du texte et un large choix de polices, couleurs, formes. <span class="highlight">Attention</span> cet outil est conçu pour être utilisé sur PC/Mac avec un navigateur récent et une <span class="highlight">résolution d\'écran minimum de 1280x720 pixels.</span>');

  if (value == 'mfb') return ('<b>France banderole crée votre fichier: +19,00€</b> Vous fournissez <span class="highlight">de 1 à 6 éléments séparés</span> et un explicatif sur votre souhait. Notre équipe d\'infographie crée votre maquette et vous envoie un premier BAT. Si vous souhaitez une composition plus complexe, une recherche graphique ou création de logo, contactez notre service commercial.');

  if (value == 'psi') return ('<b>Logo France Banderole</b> Si vous choisissez l\'option "produit signé" un petit logo sera imprimé en bas de votre visuel <br/> <img src="//www.france-banderole.com/wp-content/plugins/fbshop/images/signature.png">');

  if (value == 'pne') return ('<b>Produit neutre: +5€</b> Aucun logo ni référence à France Banderole sur votre produit');

  if (value == 'lad') return ('Pour être livré directement chez vous ou à votre adresse professionnelle. Par défaut votre adresse de facturation sera utilisée, mais vous pourrez spécifier une adresse de livraison dans votre accès client.');

  if (value == 'lat') return ('Retrait de votre commande à l\'atelier de Vitrolles.');

  if (value == 'lre') return ('Vous ne souhaitez pas être livré à une adresse professionnelle ou personnelle. Votre commande sera déposée dans le relais colis le plus proche de l adresse souhaitée. Vous serez informé du nom et de l adresse du point de dépot dans votre accès client la veille de l expedition.');

  if (value == 'crv') return ('Vous permet d’avoir une expédition neutre sans étiquetage France banderole. Vous pouvez également transmettre un bon de livraison personnalisé dans votre accès client');
}

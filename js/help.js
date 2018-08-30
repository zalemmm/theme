jQuery(document).ready(function ($) {
  ///////////////////////////////////////////////////////////////////// helpText
  //------------------------------------------------------------helpTextmaquette
  $('#helpTextmaquette, #helpTextmaquetteBis, #helpTextmaquette41, #helpTextmaquette42, #helpTextmaquette43, #helpTextmaquette44, #helpTextmaquette41depliant, #helpTextmaquette42depliant').html('<div><b>j\'ai mon fichier, je ne souhaite pas de BAT:</b><br/>Après la réception de votre fichier et de votre paiement, la commande sera mise directement en production. Si votre fichier ne respecte pas nos spécifications, il sera automatiquement adapté par notre service infographie. Supprimer le BAT décharge France Banderole de toutes responsabilités en cas de non conformité de votre fichier (couleur, format, pixellisation, fond perdu, faute orthographique, etc).</div><div><b>j\'ai mon fichier, je souhaite un BAT numérique +5,00€:</b><br/>Vous envoyez votre propre fichier (une fois votre devis enregistré). Ce dernier sera contrôlé par notre service d\'infographie et un <span class="highlight"><b>BAT à valider</b></span> vous sera transmis dans votre accès client. Votre production commence après la validation de ce BAT</div><div><b>Vous créez votre maquette en ligne +5,00€ :</b><br/>Dans le détail de votre commande vous aurez accès à notre outil de personnalisation en ligne. Simple et axé sur les fonctionnalités essentielles, il vous permettra de composer en quelques clics une maquette aux bonnes dimensions avec vos éléments personnels (logos, images...), du texte et un large choix de polices, couleurs, formes. <span class="highlight">Attention</span> cet outil est conçu pour être utilisé sur PC/Mac avec un navigateur récent et une <span class="highlight">résolution d\'écran minimum de 1280x720 pixels.</span><b></div><div>France banderole crée votre fichier +19,00€ :</b><br/>Vous fournissez <span class="highlight"><b> de 1 à 6 éléments séparés</b></span> et un explicatif sur votre souhait. Notre équipe d\'infographie crée votre maquette et vous envoie un premier BAT. Si vous souhaitez une composition plus complexe, une recherche graphique ou création de logo, contactez notre service commercial.</div>');

  //-----------------------------------------------------------helpTextsignature
  $('#helpTextsignature, #helpTextsignatureBis').html('<b>Logo France Banderole</b><br/>Si vous choisissez l\'option "produit signé" un petit logo sera imprimé en bas de votre visuel <br/> <img src="//www.france-banderole.com/wp-content/plugins/fbshop/images/signature.png">');

  //-------------------------------------------------------------helpTextAdresse
  $('#helpTextAdresse').html('Pour être livré directement chez vous ou à votre adresse professionnelle. Par défaut votre adresse de facturation sera utilisée, mais vous pourrez spécifier une adresse de livraison dans votre accès client.');

  //-----------------------------------------------------------helpTextetiquette
  $('#helpTextetiquette').html('Retrait de votre commande à l\'atelier de Vitrolles.');

  //--------------------------------------------------------------helpTextrelais
  $('#helpTextrelais').html('Vous ne souhaitez pas être livré à une adresse professionnelle ou personnelle. Votre commande sera déposée dans le relais colis le plus proche de l adresse souhaitée. Vous serez informé du nom et de l adresse du point de dépot dans votre accès client la veille de l expedition.');

  //---------------------------------------------------------------helpTextcolis
  $('#helpTextcolis').html('Vous permet d’avoir une expédition neutre sans étiquetage France banderole. Vous pouvez également transmettre un bon de livraison personnalisé dans votre accès client');
});
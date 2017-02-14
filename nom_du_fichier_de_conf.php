<?php
	
	//* Fonction pour convertir les caractères avec accents et mettre le mot en minuscule
	function mise_en_forme_url($value) {
		$trouver = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ²()' ,/.";
		$remplacerpar = "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn2-------";
		$value=str_replace("&#039;","-",$value);
		$value=str_replace("&nbsp;","-",$value);
		$value=str_replace("%20","-",$value);
		$value=str_replace(utf8_decode("%20"),"-",$value);
		$value=str_replace(utf8_encode(" "),"-",$value);
		$value=html_entity_decode($value);
		$value=strtolower(strtr($value,$trouver,$remplacerpar));
		if(strpos($value,"---")>0){$value=str_replace("---","-",$value);}
		if(strpos($value,"--")>0){$value=str_replace("--","-",$value);}
		return $value;
	}//*/
?>

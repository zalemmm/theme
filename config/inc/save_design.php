<?php
//$site_url = $_SERVER['DOCUMENT_ROOT'];
session_start();
//------------------------------------------------------------------------------
//                       ENREGISTREMENT DES MAQUETTES
// -------------------------------------------------connexion à la bdd wordpress
define( 'SHORTINIT', true );
require( '../../../../../wp-load.php' );
global $wpdb;
$prefix = $wpdb->prefix;
$fb_tablename_maquette = $prefix."fbs_maquette";

//------------------------------------------------------------------------------
$site_url = $_SERVER['HTTP_REFERER'];
$site_ref_url = explode('/', $site_url);
$site_url = $site_ref_url[2];
$type = json_decode($_POST['type'], true);
$post_data = json_decode($_POST['object'], true);

$nbcom = $_SESSION['nbcom'];
$nbname = $_SESSION['nbname'];
$nbh = $_SESSION['nbh'];
$nbl = $_SESSION['nbl'];
$saveref = $_SESSION['saveref'];

//------------------------------------------------------------------- format SVG

if(isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] == 'svg'){

		$result = array();
		$filenames = array();
		foreach ($post_data as $key => $value) {

			if(!empty($value) && $value != null){

				$destination = (__DIR__).'/../../../../../uploaded/'.$nbcom.'/';

				if (!is_dir($destination)) {
				    mkdir($destination, 0777, true);
				}

				$filename = $nbname.'-'.$nbh.'x'.$nbl.'_'.date("Y-m-d_H-i").'.svg';

				$contant = file_get_contents($value);

				file_put_contents($destination.$filename, $contant);
				//chmod($filename, 0664);
				$filenames[] = $site_url.'/uploaded/'.$nbcom.'/'.$filename;



			}
		}
		//-------------------------------------------------------------insertion bdd
		$maquette = $wpdb->get_row("SELECT * FROM `$fb_tablename_maquette` WHERE item = '$saveref'");
		if(!$maquette){
			$wpdb->query("INSERT INTO `$fb_tablename_maquette` VALUES ('','$nbcom','$saveref','$contant')");
		}else{
			$wpdb->query("DELETE FROM `$fb_tablename_maquette` WHERE item='$saveref'");
			$wpdb->query("INSERT INTO `$fb_tablename_maquette` VALUES ('','$nbcom','$saveref','$contant')");
		}
		$result['status'] = true;
		$result['filename'] = $filenames;
		$result['message'] = 'Your designed object has been saved.';

		echo json_encode($result);

		//send_design($destination, $filename);

//------------------------------------------------------------------- format PNG

} else if(isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] == 'png'){

		$result = array();
		$filenames = array();
		foreach ($post_data as $key => $value) {

			if(!empty($value) && $value != null){

				$destination = (__DIR__).'/../../../../../uploaded/'.$nbcom.'/';

				if (!is_dir($destination)) {
						mkdir($destination, 0777, true);
				}

				$filename = $nbname.'-'.$nbh.'x'.$nbl.'_'.date("Y-m-d_H-i").'.png';

				$contant = file_get_contents($value);

				file_put_contents($destination.$filename, $contant);
				//chmod($filename, 0664);
				$filenames[] = $site_url.'/uploaded/'.$nbcom.'/'.$filename;

			}
		}

		$result['status'] = true;
		$result['filename'] = $filenames;
		$result['message'] = 'Your designed object has been saved.';

		echo json_encode($result);

		//send_design($destination, $filename);

//------------------------------------------------------------------- format JPG
} else if(isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] == 'jpg'){

		$result = array();
		$filenames = array();
		foreach ($post_data as $key => $value) {

			if(!empty($value) && $value != null){

				$destination = (__DIR__).'/../../../../../uploaded/'.$nbcom.'/';

				if (!is_dir($destination)) {
						mkdir($destination, 0777, true);
				}

				$filename = $nbname.'-'.$nbh.'x'.$nbl.'_'.date("Y-m-d_H-i").'.jpg';

				$contant = file_get_contents($value);

				file_put_contents($destination.$filename, $contant);
				//chmod($filename, 0664);
				$filenames[] = $site_url.'/uploaded/'.$nbcom.'/'.$filename;

			}
		}

		$result['status'] = true;
		$result['filename'] = $filenames;
		$result['message'] = 'Your designed object has been saved.';

		echo json_encode($result);

		//send_design($destination, $filename);

//------------------------------------------------------------------ format JSON
}  else if(isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] == 'json'){
		$result = array();
		$filenames = array();
		$value = $_POST['object'];
		$value = preg_replace('/\\\r\\\n|\\\r|\\\n\\\r|\\\n/m', ' | ', $value);
		$value = preg_replace('/\'/m', 'apquote', $value);

		//-------------------------------------------------------------insertion bdd
		/*$maquette = $wpdb->get_row("SELECT * FROM `$fb_tablename_maquette` WHERE item = '$saveref'");
		if(!$maquette){
			$wpdb->query("INSERT INTO `$fb_tablename_maquette` VALUES ('','$nbcom','$saveref','$value')");
		}else{
			$wpdb->query("DELETE FROM `$fb_tablename_maquette` WHERE item='$saveref'");
			$wpdb->query("INSERT INTO `$fb_tablename_maquette` VALUES ('','$nbcom','$saveref','$value')");
		}*/

		//-------------------------------------------------------------- create file
		//foreach ($post_data as $key => $value) {
		$json_data = json_encode($value);

		$destination = (__DIR__).'/../../../../../uploaded/'.$nbcom.'/';

		if (!is_dir($destination)) {
				mkdir($destination, 0777, true);
		}

		$filename = $saveref.'.json';

		file_put_contents($destination.$filename, $value);
		$filenames[] = $site_url.'/uploaded/'.$nbcom.'/'.$filename;
		//}

		//--------------------------------------------------------------------------

		$result['status'] = true;
		$result['filename'] = $filenames;
		$result['message'] = 'Your designed object has been saved.';

		echo json_encode($result);

		//send_design($destination, $filename);

} else{

	$result['status'] = false;
	$result['filename'] = array();
	$result['message'] = 'Something went wrong! Please try again.';

	echo json_encode($result);
}


function send_design($filepath = null, $filename = null){

	$my_file = $filename;
	$my_path = $filepath;

	$my_name    = "Design Tailor";
	$my_mail    = "no-reply@xxxxxx.com";
	$my_replyto = "no-reply@xxxxxx.com";

	$to_email   = '';
	$my_subject = "Design Tailor :: Saved design";
	$message     = "New design created using design tailor.";

	if(!empty($to_email)){
		mail_attachment($my_file, $my_path, $to_email, $my_mail, $my_name, $my_replyto, $my_subject, $message);
	}
}

//--------------------------------------------------------------- envoi par mail

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {

	    $file = $path.$filename;
	    $file_size = filesize($file);
	    $handle = fopen($file, "r");
	    $content = fread($handle, $file_size);
	    fclose($handle);
	    $content = chunk_split(base64_encode($content));

	    $uid = md5(uniqid(time()));

	    $header = "From: ".$from_name." <".$from_mail.">\r\n";
	    $header .= "Reply-To: ".$replyto."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
	    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	    $header .= $message."\r\n\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
	    $header .= "Content-Transfer-Encoding: base64\r\n";
	    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
	    $header .= $content."\r\n\r\n";
	    $header .= "--".$uid."--";

	    mail($mailto, $subject, "", $header);

}

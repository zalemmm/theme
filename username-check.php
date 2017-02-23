<?php

$host = "localhost"; // Database Hostname
$port = "3306"; / /MySQL Port : Default : 3306
$user = "bn_wordpress"; // Databse Username Here
$pass = "3b4a4042b1"; // Databse Password Here
$db   = "bitnami_wordpress"; // Database Name
$dbh  = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port,$user,$pass);

$user=strtolower($_POST['user']);
if(isset($_POST) && $user!=''){
 $sql=$dbh->prepare("SELECT login FROM wp_fbs_users WHERE login=?");
 $sql->execute(array($user));
 if($sql->rowCount()==0){
  echo "available";
 }else{
  echo "not-available";
 }
}
?>

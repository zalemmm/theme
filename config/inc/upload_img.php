<?php
  session_start();
  $nbcom = $_SESSION['nbcom'];
  //----------------------------------------------------------------------------
  $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/svg+xml'];

  if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
	    echo "false";
	    return;
	}

  $destination = (__DIR__).'/../../../../../uploaded/'.$nbcom.'/ressources/';

  $name = $_FILES['file']['name'];

  if (!is_dir($destination)) {
      mkdir($destination, 0777, true);
  }

  move_uploaded_file($_FILES['file']['tmp_name'], $destination.$name);

  echo "File uploaded successfully.";
?>

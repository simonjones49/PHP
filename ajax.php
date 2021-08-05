<?php
//$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
  
//if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    //echo "false";
    //return;
//}

$local = 1;
 $ipaddress = 'UNKNOWN';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');

if ($ipaddress == '185.217.112.208' or $local == 1){
}
else {
header("Location: index.php");
die();
}
  
if (!file_exists('files994')) {
    mkdir('files994', 0777);
}
  
$filename = $_FILES['file']['name'];
  
move_uploaded_file($_FILES['file']['tmp_name'], 'files994/'.$filename);


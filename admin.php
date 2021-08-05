<?php
/*
 * admin.php
 *
 * Copyright 2021 Simon Jones <simon_jones49@yahoo.es>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 *
 */
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

// Set dir to use
$filedir = './files994';
$log = 'log.txt';

// scan for file
$filelist = scandir($filedir);

if ($_POST['update'] == 'update') {

foreach($_POST as $key=>$value)
{

	if ($key == '' or $key == 'update'){
	}
	else {
	$pi = pathinfo($key);

	$descfile = $pi['filename'] ;  // filename


	$fp = fopen('./desc/' . $descfile, "w");
	fwrite($fp, $value);
	fclose($fp);
	}

}

header("Location: admin.php");
}
else {
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
 <title>Download Administration</title>
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <meta name="generator" content="Geany 1.37.1" />
</head>

<body>
<form action="" method="post">
';
foreach($filelist as $item):

 if (preg_match('#[a-z]#',$item)){

 $pi = pathinfo($item);

 $descfile = $pi['filename'] . "_txt";  // filename

 //if(file_exists($descfile)) {
 $desc = file_get_contents('./desc/' . $descfile);
// }

  echo '<p>' . $item .
  '<br><textarea cols="40" rows=5" name="' . $descfile . '">' . $desc . '</textarea><p/>';

 }
endforeach;

echo '
<input type="submit" value="update" name="update">
</form>
</body>

</html>
';
}
?>

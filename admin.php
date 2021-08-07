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
include 'config.php' ;

if ($ipaddress == '$adminip' or $local == 1){
}
else {
header("Location: index.php");
die();
}
function makeDirPath($path) {
    return file_exists($path) || mkdir($path, 0777, true);
}
if (!file_exists($filedir)) {
     makeDirPath($filedir, 0777);
}
if (!file_exists($thumbdir)) {
     makeDirPath($thumbdir, 0777);
}
if (!file_exists($descdir)) {
     makeDirPath($descdir, 0777);
}



// scan for file
$filelist = scandir($filedir);

if(isset($_GET['delete'])) {
$delfile = $filedir . $_GET['delete'];
$delthumb = $thumbdir .  $_GET['delete'];
if (file_exists($delfile)) {
unlink ($delfile);

 $pid = pathinfo($_GET['delete']);

 $deldescfile = $pid['filename'] . "_txt";  // filename
 $deldescfile = str_replace(" ","_",$deldescfile);
 $deldescfile = str_replace(".","_",$deldescfile);
 $deldesc =  $descdir . $deldescfile;


//echo $deldesc;
if (file_exists($deldesc)) {
unlink ($deldesc);
}
if (file_exists($delthumb)) {
unlink ($delthumb);
}
}

header("Location: admin.php");
die;
}    
if (isset($_POST['update'])) {
    
if ($_POST['update'] == 'update') {
foreach($_POST as $key=>$value)
{

	if ($key == '' or $key == 'update'){
	}
	else {
	$pi = pathinfo($key);
    
	$descfile = $pi['filename'] ;  // filename


	$fp = fopen($descdir . $descfile, "w");
	fwrite($fp, $value);
	fclose($fp);
	}

}

header("Location: admin.php");
}
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
 <link rel="stylesheet" href="style.css" />
</head>

<body>
<a href="index.php">Front Page</a>
<div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
    <div id="drag_upload_file">
        <p>Drop file here</p>
        <p>or</p>
        <p><input type="button" value="Select File" onclick="file_explorer();" /></p>
        <input type="file" id="selectfile" />
    </div>
</div>


<form action="" method="post">
<input type="submit" value="update" name="update">
';
foreach($filelist as $item):

 if (preg_match('#[a-z]#',$item)){
 $desc = '';   
 $pi = pathinfo($item);

 $descfile = $pi['filename'] . "_txt";  // filename
    $descfile = str_replace(" ","_",$descfile);
 if(file_exists($descdir . $descfile)) {
 $desc = file_get_contents($descdir . $descfile);
 }

  echo '<p>' . $item . ' <a style="color:red;" onclick="if (!confirm(\'Are you sure?\')) return false;" href="admin.php?delete=' . $item . '">Delete</a>' .
  '<br><textarea cols="40" rows=5" name="' . $descfile . '">' . $desc . '</textarea><p/>';

 }
endforeach;

echo '

</form>


 
<script src="custom.js"></script>
</body>

</html>
';
}
?>



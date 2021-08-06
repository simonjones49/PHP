<?php
/*
 * index.php
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

// scan for file
$filelist = scandir($filedir);

// Check if we have input for a file
if(isset($_GET['file'])) {
$filename = $_GET['file'];
}
// Check filename is not empty but it is set
if (isset($filename) && $filename !== ''){

// Set download type
$dl_type="application/octet-stream";

// Set full path with filename
$path = $filedir . $filename;

// Proceed if file exists
if(file_exists($path)) {

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: " . $dl_type);
header("Content-Length: " .(string)(filesize($path)) );
header('Content-Disposition: attachment; filename="'.basename($path).'"');
header("Content-Transfer-Encoding: binary\n");

readfile($path); // outputs the content of the file


  $newlog = $ipaddress . ":" . $path . "\n";
  $fp = fopen($log, "a");
  fwrite($fp, $newlog);
  fclose($fp);

//Terminate from the script
die();
}
else{
// We get here if the filename exists but the file does not
echo "File does not exist.";
}


}
else {
// Front page

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
 <title>Downloads</title>
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <meta name="generator" content="Geany 1.37.1" />
  <link rel="stylesheet" href="style.css" />

</head>

<body>
<h1> Downloads </h1>
<div class="dlcontainer">

';
$link = 1;
foreach($filelist as $item):

 if (preg_match('#[a-z]#',$item)){

 $pi = pathinfo($item);

 $descfile = $pi['filename'] . "_txt";  // filename
 $descfile = str_replace(" ","_",$descfile);
 if(file_exists($descdir . $descfile)) {
 $desc = file_get_contents($descdir . $descfile);
 if (preg_match('#[a-z]|[0-9]#',$desc)){
     $desc = '<hr class="descline">' . $desc;
 }
 else { $desc = ''; }
 }
    echo '<div class="dlbox">';
    if ($link > 2) { $link = 1; }
    if (preg_match('#jpg|png#',$item)) {
        echo '<div class="link link' . $link . '"><img class="thumb" src="' . $thumbdir . '/' . $item . '"><a href="index.php?file=' . $item . '">Download</a><br>' . $item . $desc . '</div>';
    }
    else {
        echo '<div class="link link' . $link . '"><a href="index.php?file=' . $item . '">Download </a><br>' . $item . '<br>' . $desc . '</div>';
    }
    $link += 1;
    echo '</div>';
 }
endforeach;

echo '
</div>
';
if ($ipaddress == $adminip or $local == 1){
    echo '<a href="admin.php">Admin</a>';
}
echo '
</body>

</html>

';
}
?>

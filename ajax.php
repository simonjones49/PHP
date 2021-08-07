<?php
/*
 * ajax.php
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



if ($ipaddress == $adminip or $local == 1){
}
else {
header("Location: index.php");
die();
}
  
if (!file_exists($filedir)) {
    mkdir($filedir, 0777);
}
  
$filename = $_FILES['file']['name'];
  
move_uploaded_file($_FILES['file']['tmp_name'], $filedir . $filename);

    if(preg_match('/[.](jpg|png|jpeg)$/', $filename)) {
    createThumbnail($filename);    
    }
function createThumbnail($filename) {
    include 'config.php' ;

    if(preg_match('/[.](jpg|jpeg)$/', $filename)) {
        $im = imagecreatefromjpeg($filedir . $filename);
    } else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($filedir . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($filedir . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = $final_width_of_image;
    $ny = floor($oy * ($final_width_of_image / $ox));
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    if(!file_exists($thumbdir)) {
      if(!mkdir($thumbdir)) {
           die("There was a problem. Please try again!");
      } 
       }
 
    imagejpeg($nm, $thumbdir . $filename);

}

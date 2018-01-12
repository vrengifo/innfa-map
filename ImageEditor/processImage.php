<?php
/*
processImage.php
Copyright (C) 2004-2006 Peter Frueh (http://www.ajaxprogrammer.com/)

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

// required params: imageName

header("Content-Type: text/plain");

$originalDirectory = getcwd()."/original/";
//$originalDirectory = "../";
$activeDirectory = getcwd()."/active/";
$editDirectory = getcwd()."/edit/";
$imageName = $_REQUEST["imageName"];
$action = $_REQUEST["action"];

if(empty($imageName) ||
	!file_exists($originalDirectory.$imageName) ||
	!file_exists($activeDirectory.$imageName) ||
	!file_exists($editDirectory.$imageName)) { echo "{imageFound:false}"; exit; }

switch($action){

	case "viewOriginal":
		copy($originalDirectory.$imageName, $editDirectory.$imageName);
		break;

	case "viewActive":
		copy($activeDirectory.$imageName, $editDirectory.$imageName);
		break;

	case "save":
		copy($editDirectory.$imageName, $activeDirectory.$imageName);
		break;

	case "resize": // additional required params: w, h
		$out_w = $_REQUEST["w"];
		$out_h = $_REQUEST["h"];
		if (!is_numeric($out_w) || $out_w < 1 || $out_w > 2000 || !is_numeric($out_h) || $out_h < 1 || $out_h > 2000) { exit; }
		list($in_w, $in_h) = getimagesize($editDirectory.$imageName);
		$in = imagecreatefromjpeg($editDirectory.$imageName);
		$out = imagecreatetruecolor($out_w, $out_h);
		imagecopyresampled($out, $in, 0, 0, 0, 0, $out_w, $out_h, $in_w, $in_h);
		imagejpeg($out, $editDirectory.$imageName, 100);
		imagedestroy($in);
		imagedestroy($out);
		break;

	case "rotate": // additional required params: degrees (90, 180 or 270)
		$degrees = $_REQUEST["degrees"];
		if (($degrees != 90 && $degrees != 180 && $degrees != 270)) { exit; }
		$in = imagecreatefromjpeg($editDirectory.$imageName);
		if ($degrees == 180){
			$out = imagerotate($in, $degrees, 180);
		}else{ // 90 or 270
			$x = imagesx($in);
			$y = imagesy ($in);
			$max = max($x, $y);

			$square = imagecreatetruecolor($max, $max);
			imagecopy($square, $in, 0, 0, 0, 0, $x, $y);
			$square = imageRotate($square, $degrees, 0);

			$out = imagecreatetruecolor($y, $x);
			if ($degrees == 90) {
				imagecopy($out, $square, 0, 0, 0, $max - $x, $y, $x);
			} elseif ($degrees == 270) {
				imagecopy($out, $square, 0, 0, $max - $y, 0, $y, $x);
			}
			imagedestroy($square);
		}
		imagejpeg($out, $editDirectory.$imageName, 100);
		imagedestroy($in);
		imagedestroy($out);
		break;

	case "crop": // additional required params: x, y, w, h
		$x = $_REQUEST["x"];
		$y = $_REQUEST["y"];
		$w = $_REQUEST["w"];
		$h = $_REQUEST["h"];
		if (!is_numeric($x) || !is_numeric($y) || !is_numeric($w) || !is_numeric($h)) { exit; }
		$in = imagecreatefromjpeg($editDirectory.$imageName);
		$out = imagecreatetruecolor($w, $h);
		imagecopyresampled($out, $in, 0, 0, $x, $y, $w, $h, $w, $h);
		imagejpeg($out, $editDirectory.$imageName, 100);
		imagedestroy($in);
		imagedestroy($out);
		break;

}

list($w, $h) = getimagesize($editDirectory.$imageName);
echo '{imageFound:true,imageName:"'.$imageName.'",w:'.$w.',h:'.$h.'}';

?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
header ('Content-Type: image/png');
$im = @imagecreatetruecolor(16, 16)
      or die('Cannot Initialize new GD image stream');

$statement = $pdo->prepare("SELECT avatar FROM users WHERE id = :userid");
$statement->execute(array('userid' => $_GET['userid'] ));
$avatar = $statement ->fetch();

$colorsRGB = array();
$statement = $pdo->prepare("SELECT value FROM Avatar_Colors");
$statement->execute();
while($color = $statement->fetch()){
	$colorsRGB[] = hex2RGB($color[0]);
}
//var_dump($colorsRGB);
$avatar_lines = explode ("|" ,$avatar["avatar"]);


//var_dump(colors[explode(";" ,$avatar_lines[0])]);

for($y = 0; $y< 16; $y++){
	$avatar_line_colors = explode(";" ,$avatar_lines[$y]);
	for($x = 0;$x < 16; $x++){
		$color = imagecolorallocate($im,$colorsRGB[$avatar_line_colors[$x]][0],$colorsRGB[$avatar_line_colors[$x]][1],$colorsRGB[$avatar_line_colors[$x]][2]);
		imagesetpixel($im,$x,$y,$color);
	}
}
imagepng($im);
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
?>

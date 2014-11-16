<?
	session_start();
	$image = @imagecreate(85, 30) or die("Could not create image!");
	imagecolorallocate($image,200,200,200);
	$color_black = imagecolorallocate($image,0,0,0);
	imagestring($image, 6, 10, 5, $_SESSION["captcha"], $color_black);
	header("Content-Type: image/png");
	imagepng($image);
	imagedestroy($image);
	exit();
?>
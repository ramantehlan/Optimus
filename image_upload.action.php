<?php
/***********************************************
This is to read a image and find out it's information

Creator:- Raman Tehlan
Date of creation:- 04/02/2017
************************************************/


/*******************************
row 1
y1 = 719
y2 = 823

row 2

y1 = 1770
y2 = 1890

row 3

y1 = 2785
y2 = 2913



*********************************/

/**********************************

column 1

x1 = 0
x2 = 1156

column 2

x1 = 1100
x2 = 2273

column 3

x1 = 2280
x2 = 3700

column 4

x1 = 3700
x2 = 4580

**********************************/

if(isset($_FILES['image'])){

	//Including required library
	include "TesseractOCR.php";
	require "SimpleImage.php";

	$file_location = $_FILES['image']['tmp_name'];


	// Ignore notices
error_reporting(E_ALL & ~E_NOTICE);

try {
  // Create a new SimpleImage object
  $image = new \claviska\SimpleImage();


  // Magic! ✨
  $image
    ->fromFile($_FILES['image']['tmp_name'])                     // load image.jpg
    ->crop(0, 719, 1156, 823)
    ->resize(2000)
    ->darken(20)  
    ->desaturate()
    ->pixelate(1)
    //->darkenColor('Black', 255)
    //->colorize('Black')
    //->sharpen()
    ->autoOrient()                              // adjust orientation based on exif data
    //->resize(320, 200)                          // resize to 320x200 pixels
    //->flip('x')                                 // flip horizontally
    //->colorize('DarkBlue')                      // tint dark blue
    //->border('black', 10)                       // add a 10 pixel black border
    //->overlay('images/8055.png', 'bottom right')  // add a watermark image
    ->toFile('assets/image/new-image.png', 'image/png');      // convert to PNG and save a copy to new-image.png
    //->toScreen();                               // output to the screen

  // And much more! 💪
} catch(Exception $err) {
  // Handle errors
  echo $err->getMessage();
}

//use like to replace
echo (new TesseractOCR('assets/image/new-image.png'))->run();

echo "<BR>";




}else{
	echo "Image no set!";
}


?>
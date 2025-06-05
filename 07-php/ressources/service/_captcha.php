<?php 
if(session_status() === PHP_SESSION_NONE)
session_start();
// List of accepted characters for the captcha
$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789';
/**
 * Generates a random string.
 *
 * @param string $characters
 * @param integer $strength
 * @return string
 */
function generateString(string $characters, int $strength = 10): string {
    $randStr = '';
    // loop a number of times equal to the $strength argument
    for($i = 0; $i < $strength; $i++) 
    {
        // Choose a random character from the list of available characters
        $randStr .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randStr;
}
// Create a new image with (width, height). This is an object of class GdImage
$image = imagecreatetruecolor(200, 50);
// Enable antialiasing functions to improve image quality
imageantialias($image, true);

$colors = [];
// Choose a random color range
$red = rand(125, 175);
$green = rand(125, 175);
$blue = rand(125, 175);

for($i = 0; $i < 5; $i++) {
  /* 
    imagecolorallocate takes a GdImage object as first argument,
    then 3 numeric values representing rgb color levels.
    Returns an INT representing an identifier for the generated color.
  */
  $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
}
/* 
  Fills a given GdImage object (first argument)
  starting at position given by second and third arguments,
  with the color identifier given as the fourth argument.
*/
imagefill($image, 0, 0, $colors[0]);

for($i = 0; $i < 10; $i++) 
{
  // Set a line thickness in pixels
  imagesetthickness($image, rand(2, 10));
  /* 
    Draws a rectangle on the given GdImage object (first argument)
    with start position x, y given by second and third arguments,
    end position given by fourth and fifth arguments,
    and the color given in sixth argument.
  */
  imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $colors[rand(1, 4)]);
}
/* Prepare possible colors for the text, here black and white. */
$textColors = [imagecolorallocate($image, 0, 0, 0), imagecolorallocate($image, 255, 255, 255)];
/* Prepare an array of available font files. */
$fonts = [__DIR__.'/../fonts/Acme-Regular.ttf', __DIR__.'/../fonts/arial.ttf', __DIR__."/../fonts/typewriter.ttf"];

// Choose a size for the captcha and generate our random text.
$strLength = 6;
$captchaStr = generateString($characters, $strLength);
// Save our random text in session.
$_SESSION['captchaStr'] = $captchaStr;
/* 
  Instead of displaying our text all at once, we display the characters one by one with 
  different values for color, angle, etc.
*/
for($i = 0; $i < $strLength; $i++) {
  // Choose spacing between letters and initial position in px.
  $letterSpace = 170/$strLength;
  $initial = 15;
  /* 
    imagettftext writes text into our image using a ttf font.
    First argument is the image object (GdImage),
    second is the font size,
    third is the angle in degrees,
    fourth and fifth are x and y coordinates,
    sixth is the color,
    seventh is the font file,
    eighth is the text to write.
  */
  imagettftext(
    $image, 
    24, 
    rand(-15, 15), 
    (int)($initial + $i*$letterSpace), 
    rand(25, 45), 
    $textColors[rand(0, 1)], 
    $fonts[array_rand($fonts)], 
    $captchaStr[$i]
  );
}
/* 
  Here we set the header to indicate the content type is a PNG image.
*/
header('Content-type: image/png');
/* 
  Then we output our GdImage object as a PNG image.
*/
imagepng($image);
?>

<?php 
if(session_status() === PHP_SESSION_NONE)
session_start();
// CAPTCHAに使う文字セット
$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789';
/**
 * ランダム文字列を生成します。
 *
 * @param string $characters
 * @param integer $strength
 * @return string
 */
function generateString(string $characters, int $strength = 10): string {
    $randStr = '';
    // $strength回ループして文字を選ぶ
    for($i = 0; $i < $strength; $i++) 
    {
        // 文字セットからランダムに一文字選択
        $randStr .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randStr;
}
// 200x50の新規画像を作成（GdImageオブジェクト）
$image = imagecreatetruecolor(200, 50);
// アンチエイリアスを有効化し画質を向上
imageantialias($image, true);

$colors = [];
// ランダムに淡い色を生成
$red = rand(125, 175);
$green = rand(125, 175);
$blue = rand(125, 175);

for($i = 0; $i < 5; $i++) {
  /* 
    imagecolorallocateは画像とRGB値を渡すと、
    色のID（整数）を返します。
  */
  $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
}
/* 
  画像の背景を一番明るい色で塗りつぶす
*/
imagefill($image, 0, 0, $colors[0]);

for($i = 0; $i < 10; $i++) 
{
  // ランダムに線の太さを設定
  imagesetthickness($image, rand(2, 10));
  /* 
    画像にランダムな位置で矩形を描画（線の色もランダム）
  */
  imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $colors[rand(1, 4)]);
}
/* テキスト色を黒と白で用意 */
$textColors = [imagecolorallocate($image, 0, 0, 0), imagecolorallocate($image, 255, 255, 255)];
/* フォントのパス配列 */
$fonts = [__DIR__.'/../fonts/Acme-Regular.ttf', __DIR__.'/../fonts/arial.ttf', __DIR__."/../fonts/typewriter.ttf"];

// CAPTCHA文字列の長さと生成
$strLength = 6;
$captchaStr = generateString($characters, $strLength);
// セッションに保存
$_SESSION['captchaStr'] = $captchaStr;
/* 
  文字列を一文字ずつ画像に描画。色や角度をランダムに変える。
*/
for($i = 0; $i < $strLength; $i++) {
  $letterSpace = 170/$strLength;
  $initial = 15;
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
  Content-Typeを画像/pngに指定し、
  画像をブラウザに送信
*/
header('Content-type: image/png');
imagepng($image);
?>

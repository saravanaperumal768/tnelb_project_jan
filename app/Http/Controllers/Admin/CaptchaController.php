<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class CaptchaController extends Controller
{
   public function generateCaptcha()
    {

        
            $code = '';
            $chars = 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789';
            for ($i = 0; $i < 5; $i++) {
                $code .= $chars[rand(0, strlen($chars) - 1)];
            }

            Session::put('custom_captcha', $code);

            $width = 150;
            $height = 50;
            $image = imagecreate($width, $height);

            // Background color
            $bgColor = imagecolorallocate($image, 255, 255, 255);

            // Some random colors
            $textColors = [
                imagecolorallocate($image, 0, 0, 0),
                imagecolorallocate($image, 50, 50, 200),
                imagecolorallocate($image, 200, 20, 20),
                imagecolorallocate($image, 20, 150, 20),
            ];

            $lineColor = imagecolorallocate($image, 200, 200, 200);

            // Add random lines as noise
            for ($i = 0; $i < 6; $i++) {
                imageline($image, 0, rand() % $height, $width, rand() % $height, $lineColor);
            }

            // Add random dots
            for ($i = 0; $i < 1000; $i++) {
                imagesetpixel($image, rand() % $width, rand() % $height, $lineColor);
            }

            // Load a system font (you can place your own .ttf in /public/fonts/)
            $font = public_path('fonts/OpenSans-Bold.ttf'); 

            // Draw each character with rotation & random color
            for ($i = 0; $i < strlen($code); $i++) {
                $x = 20 + ($i * 25);
                $y = rand(30, 40);
                $angle = rand(-20, 20);
                $color = $textColors[array_rand($textColors)];

                imagettftext($image, rand(18, 22), $angle, $x, $y, $color, $font, $code[$i]);
            }

            ob_start();
            imagepng($image);
            $imageData = ob_get_clean();
            imagedestroy($image);

            return response($imageData)->header('Content-Type', 'image/png');
        // exit;
    }

}

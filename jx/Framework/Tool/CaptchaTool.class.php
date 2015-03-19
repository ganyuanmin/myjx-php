<?php

class CaptchaTool
{

    private static function getRandomString($length)
    {
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        $chars = str_shuffle($chars);
        $chars = substr($chars, 0, $length);
        return $chars;
    }

    public static function generate($length = 4)
    {
        $randomString = self::getRandomString($length);
        new SessionDBTool();
        $_SESSION['randomString'] = $randomString;
        $imagePath = TOOL_PATH.'captcha/captcha_bg' . mt_rand(1, 5) . '.jpg';
        $image = imagecreatefromjpeg($imagePath);
        $imageSize = getimagesize($imagePath);
        $width = $imageSize[0];
        $height = $imageSize[1];
        $white = imagecolorallocate($image, 255, 255, 255);
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $white);
        imagestring($image, 5, $width / 3, $height / 5, $randomString, $white);
        imagejpeg($image);
        imagedestroy($image);
    }
    
    public static function check($captcha)
    {
        return strtolower($captcha) == $_SESSION['randomString'];
    }
}

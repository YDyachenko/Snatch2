<?php

namespace Core\Captcha;

class SimpleCaptcha
{

    protected $imageWidth               = 100;
    protected $imageHeight              = 35;
    protected $fontSize                 = 12;
    protected $codeLength               = 5;
    protected $numberOfBackgroundSymbol = 12;
    protected $font;
    protected $letters                  = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    protected $colors = array("90", "110", "130", "150", "170", "190", "210");
    
    public function __construct($options)
    {
        foreach ($options as $name => $value)
            $this->setOption($name, $value);
    }
    
    protected function setOption($name, $value)
    {
        if (!isset($this->{$name}))
            $this->{$name} = $value;
            
        return $this;
    }

    public function generateRandCode()
    {
        $code = "";
        for ($i = 0; $i < $this->codeLength; $i++) {
            $code .= $this->letters[rand(0, count($this->letters) - 1)];
        }
        return $code;
    }

    protected function getRandColor()
    {
        return $this->colors[rand(0, count($this->colors) - 1)];
    }

    public function printImage($code)
    {
        if (is_array($code) || empty($code) || strlen($code) != $this->codeLength) {
            $code = $this->generateRandCode();
        }

        $src        = imagecreatetruecolor($this->imageWidth, $this->imageHeight);
        $background = imagecolorallocate($src, 255, 255, 255);
        imagefill($src, 0, 0, $background);

        // generate background symbol
        for ($i = 0; $i < $this->numberOfBackgroundSymbol; $i++) {
            $color  = imagecolorallocatealpha($src, rand(0, 255), rand(0, 255), rand(0, 255), 100);
            $letter = $this->letters[rand(0, count($this->letters) - 1)];
            $size   = rand($this->fontSize - 2, $this->fontSize + 2);
            imagettftext(
                    $src, $size, rand(0, 45), rand($this->imageWidth * 0.1, $this->imageWidth - $this->imageWidth * 0.1), rand($this->imageHeight * 0.2, $this->imageHeight), $color, $this->font, $letter
            );
        }

        // generate code
        for ($i = 0; $i < $this->codeLength; $i++) {
            $color  = imagecolorallocatealpha(
                    $src, $this->getRandColor(), $this->getRandColor(), $this->getRandColor(), rand(20, 40)
            );
            $letter = $code[$i];
            $size   = rand($this->fontSize * 2 - 2, $this->fontSize * 2 + 2);
            $x      = ($i + 1) * $this->fontSize + rand(1, 5);
            $y      = (($this->imageHeight * 2) / 3) + rand(0, 5);
            imagettftext(
                    $src, $size, rand(0, 15), $x, $y, $color, $this->font, $letter
            );
        }

        imagegif($src);
    }

}
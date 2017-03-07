<?php
namespace Domino {
class Card {
    private $num1;
    private $num2;
    function __construct($num1, $num2)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;

    }
    function getImage()
    {

        $im = @imagecreate(80, 40)
        or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 255, 200, 200);
        $text_color = imagecolorallocate($im, 0, 0, 0);
        imagestring($im, 24, 20, 15,  $this->num1 . "/" .$this->num2 , $text_color);

        ob_start();
        imagepng($im);
        $final_image = ob_get_contents();
         ob_end_clean();

        return $final_image;
    }


}
}
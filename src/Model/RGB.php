<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * RGB color model
 *
 */
class RGB extends Color{

  /**
   * The red value (0-255)
   * @var float
   */
  public $red;

  /**
   * The green value (0-255)
   * @var float
   */
  public $green;

  /**
   * The blue value (0-255)
   * @var float
   */
  public $blue;

  /**
   * Create a new RGB color
   *
   * @param float|string|array $red – red (0-255)
   * or string or array representation
   * @param float $green - green (0-255)
   * @param float $blue - blue (0-255)
   */
  public function __construct($red, float $green = null, float $blue = null){

    $this->toSelf = "toRGB";

    $this->init([
      [
        'key' => 'red',
        'val' => $red,
        'type' => 'float'
      ],
      [
        'key' => 'green',
        'val' => $green,
        'type' => 'float'
      ],
      [
        'key' => 'blue',
        'val' => $blue,
        'type' => 'float'
      ]
    ]);

    if( $this->red > 255 ){
      $this->red = 255;
    }

    if( $this->green > 255 ){
      $this->green = 255;
    }

    if( $this->blue > 255 ){
      $this->blue = 255;
    }

    if ($this->red < 0 || $this->red > 255) {
      throw new InvalidArgumentException('['.$this->red.','.$this->green.','.$this->blue.']: Parameter red out of range');
    }
    if ($this->green < 0 || $this->green > 255) {
      throw new InvalidArgumentException('['.$this->red.','.$this->green.','.$this->blue.']: Parameter green out of range');
    }
    if ($this->blue < 0 || $this->blue > 255) {
      throw new InvalidArgumentException('['.$this->red.','.$this->green.','.$this->blue.']: Parameter blue out of range');
    }

  }

  /**
   * Create a new Hex
   *
   * @param int $hex the hexidecimal value (i.e. 0x000000)
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public static function create($red, float $green = null, float $blue = null){
    return new RGB($red, $green, $blue);
  }


  /**
   * Get the red value (rounded)
   *
   * @return int The red value
   */
  public function getRed(){
    return (0.5 + $this->red) | 0;
  }

  /**
   * Get the green value (rounded)
   *
   * @return int The green value
   */
  public function getGreen(){
    return (0.5 + $this->green) | 0;
  }

  /**
   * Get the blue value (rounded)
   *
   * @return int The blue value
   */
  public function getBlue(){
    return (0.5 + $this->blue) | 0;
  }

  // /**
  //  * Shortcut for getRed()
  //  *
  //  * @return int The red value
  //  */
  // public function red(){
  //   return $this->getRed();
  // }
  //
  // /**
  //  * Shortcut for getGreen()
  //  *
  //  * @return int The green value
  //  */
  // public function green(){
  //   return $this->getGreen();
  // }
  //
  // /**
  //  * Shortcut for getBlue()
  //  *
  //  * @return int The blue value
  //  */
  // public function blue(){
  //   return $this->getBlue();
  // }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return new Hex($this->getRed() << 16 | $this->getGreen() << 8 | $this->getBlue());
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\Colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    return $this;
  }

  /**
   * Convert the color to RGBA format
   *
   * @param float $alpha
   * @return \wwaz\Colormodel\Model\RGBA the color in RGBA format
   */
  public function toRGBA($alpha = 1){
    $rgb = $this->toArray();
    $rgb[] = $alpha;
    return new RGBA( $rgb );
  }


  /**
   * Convert the color to XYZ format
   *
   * @return \wwaz\Colormodel\Model\XYZ the color in XYZ format
   */
  public function toXYZ(){
    $tmp_r = $this->red / 255;
    $tmp_g = $this->green / 255;
    $tmp_b = $this->blue / 255;
    if ($tmp_r > 0.04045) {
      $tmp_r = pow((($tmp_r + 0.055) / 1.055), 2.4);
    } else {
      $tmp_r = $tmp_r / 12.92;
    }
    if ($tmp_g > 0.04045) {
      $tmp_g = pow((($tmp_g + 0.055) / 1.055), 2.4);
    } else {
      $tmp_g = $tmp_g / 12.92;
    }
    if ($tmp_b > 0.04045) {
      $tmp_b = pow((($tmp_b + 0.055) / 1.055), 2.4);
    } else {
      $tmp_b = $tmp_b / 12.92;
    }
    $tmp_r = $tmp_r * 100;
    $tmp_g = $tmp_g * 100;
    $tmp_b = $tmp_b * 100;
    $new_x = $tmp_r * 0.4124 + $tmp_g * 0.3576 + $tmp_b * 0.1805;
    $new_y = $tmp_r * 0.2126 + $tmp_g * 0.7152 + $tmp_b * 0.0722;
    $new_z = $tmp_r * 0.0193 + $tmp_g * 0.1192 + $tmp_b * 0.9505;
    return new XYZ($new_x, $new_y, $new_z);
  }

  /**
   * Convert the color to Yxy format
   *
   * @return \wwaz\Colormodel\Model\Yxy the color in Yxy format
   */
  public function toYxy(){
    return $this->toXYZ()->toYxy();
  }

  /**
   * Convert the color to HSL format
   *
   * @return \wwaz\Colormodel\Model\HSL the color in HSL format
   */
  public function toHSL(){
    return $this->toHSV()->toHSL();
  }

  /**
   * Convert the color to HSV format
   *
   * @return \wwaz\Colormodel\Model\HSV the color in HSV format
   */
  public function toHSV(){
    $red = $this->red / 255;
    $green = $this->green / 255;
    $blue = $this->blue / 255;


    $min = min($red, $green, $blue);
    $max = max($red, $green, $blue);

    $value = $max;
    $delta = $max - $min;

    if ($delta == 0) {
      return new HSV(0, 0, $value * 100);
    }

    $saturation = 0;

    if ($max != 0) {
      $saturation = $delta / $max;
    } else {
      $saturation = 0;
      $hue = -1;
      return new HSV($hue, $saturation, $value);
    }
    if ($red == $max) {
      $hue = ($green - $blue) / $delta;
    } else {
      if ($green == $max) {
        $hue = 2 + ($blue - $red) / $delta;
      } else {
        $hue = 4 + ($red - $green) / $delta;
      }
    }
    $hue *= 60;
    if ($hue < 0) {
      $hue += 360;
    }

    return new HSV($hue, $saturation * 100, $value * 100);
  }

  /**
   * Convert the color to HSB format
   *
   * @return \wwaz\Colormodel\Model\HSB the color in HSB format
   */
  public function toHSB(){
    return $this->toHSV()->toHSB();
  }

  /**
   * Convert the color to CMY format
   *
   * @return \wwaz\Colormodel\Model\CMY the color in CMY format
   */
  public function toCMY(){
    $cyan = 1 - ($this->red / 255);
    $magenta = 1 - ($this->green / 255);
    $yellow = 1 - ($this->blue / 255);
    return new CMY($cyan, $magenta, $yellow);
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    return $this->toCMY()->toCMYK();
  }

  /**
   * Convert the color to CMYKInt format
   *
   * @return \wwaz\Colormodel\Model\CMYKInt the color in CMYK format
   */
  public function toCMYKInt(){
    return $this->toCMYK()->toCMYKInt();
  }

  /**
   * Convert the color to CIELab format
   *
   * @return \wwaz\Colormodel\Model\CIELab the color in CIELab format
   */
  public function toCIELab(){
    return $this->toXYZ()->toCIELab();
  }

  /**
   * Convert the color to CIELCh format
   *
   * @return \wwaz\Colormodel\Model\CIELCh the color in CIELCh format
   */
  public function toCIELCh(){
    return $this->toCIELab()->toCIELCh();
  }

  /**
   * A string representation of this color in the current format
   *
   * @return string The color in format: $red,$green,$blue (rounded)
   */
  public function __toString(){
    return $this->getRed() . ',' . $this->getGreen() . ',' . $this->getBlue();
  }


  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->getRed(), $this->getGreen(), $this->getBlue()];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['r' => $this->getRed(), 'g' => $this->getGreen(), 'b' => $this->getBlue()];
  }


}

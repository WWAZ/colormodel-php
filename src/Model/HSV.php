<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * HSV color model
 */
class HSV extends Color{

  /**
   * The hue
   * @var float
   */
  public $hue;

  /**
   * The saturation
   * @var float
   */
  public $saturation;

  /**
   * The value
   * @var float
   */
  public $value;

  /**
   * Create a new HSV color
   *
   * @param float|string|array $hue – hue (0-1)
   * or string or array representation
   * @param float $saturation - saturation (0-1)
   * @param float $value - value (0-1)
   */
  public function __construct($hue, $saturation = null, $value = null){
    $this->toSelf = "toHSV";

    $this->init([
      [
        'key' => 'hue',
        'val' => $hue,
        'type' => 'float'
      ],
      [
        'key' => 'saturation',
        'val' => $saturation,
        'type' => 'float'
      ],
      [
        'key' => 'value',
        'val' => $value,
        'type' => 'float'
      ]
    ]);
  }

  // /**
  //  * Returns hue.
  //  *
  //  * @return int the hue
  //  */
  // public function hue(){
  //   return $this->hue;
  // }
  //
  // /**
  //  * Returns saturation.
  //  *
  //  * @return int the saturation
  //  */
  // public function saturation(){
  //   return $this->saturation;
  // }
  //
  // /**
  //  * Returns value.
  //  *
  //  * @return int the value
  //  */
  // public function value(){
  //   return $this->value;
  // }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return $this->toRGB()->toHex();
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\Colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    $hue = $this->hue / 360;
    $saturation = $this->saturation / 100;
    $value = $this->value / 100;
    if ($saturation == 0) {
      $red = $value * 255;
      $green = $value * 255;
      $blue = $value * 255;
    } else {
      $var_h = $hue * 6;
      $var_i = floor($var_h);
      $var_1 = $value * (1 - $saturation);
      $var_2 = $value * (1 - $saturation * ($var_h - $var_i));
      $var_3 = $value * (1 - $saturation * (1 - ($var_h - $var_i)));

      if ($var_i == 0) {
        $var_r = $value;
        $var_g = $var_3;
        $var_b = $var_1;
      } elseif ($var_i == 1) {
        $var_r = $var_2;
        $var_g = $value;
        $var_b = $var_1;
      } elseif ($var_i == 2) {
        $var_r = $var_1;
        $var_g = $value;
        $var_b = $var_3;
      } elseif ($var_i == 3) {
        $var_r = $var_1;
        $var_g = $var_2;
        $var_b = $value;
      } else {
        if ($var_i == 4) {
          $var_r = $var_3;
          $var_g = $var_1;
          $var_b = $value;
        } else {
          $var_r = $value;
          $var_g = $var_1;
          $var_b = $var_2;
        }
      }

      $red = round($var_r * 255);
      $green = round($var_g * 255);
      $blue = round($var_b * 255);
    }
    return new RGB($red, $green, $blue);
  }

  /**
   * Convert the color to RGBA format
   *
   * @param float $alpha
   * @return \wwaz\Colormodel\Model\RGBA the color in RGBA format
   */
  public function toRGBA($alpha = 1){
    $rgb = $this->toRGB()->toArray();
    $rgb[] = $alpha;
    return new RGBA( $rgb );
  }

  /**
   * Convert the color to XYZ format
   *
   * @return \wwaz\Colormodel\Model\XYZ the color in XYZ format
   */
  public function toXYZ(){
    return $this->toRGB()->toXYZ();
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
   * @return \wwaz\Colormodel\Model\HSL the color in HSL format
   */
  public function toHSL(){
    $h = $this->hue;
    $l = (2 - $this->saturation / 100) * $this->value / 2;
    $s = ($l > 0 && $l < 100)
    ? $this->saturation * $this->value / ($l < 50 ? $l * 2 : 200 - $l * 2)
    : 0;

    return new HSL($h, $s, $l);
  }

  /**
   * Convert the color to HSV format
   *
   * @return \wwaz\Colormodel\Model\HSV the color in HSV format
   */
  public function toHSV(){
    return $this;
  }

  /**
   * Convert the color to HSB format
   *
   * @return \wwaz\Colormodel\Model\HSB the color in HSB format
   */
  public function toHSB(){
    // HSB = HSV. HSB extends HSV.
    return new HSB($this->hue, $this->saturation, $this->value);
  }

  /**
   * Convert the color to CMY format
   *
   * @return \wwaz\Colormodel\Model\CMY the color in CMY format
   */
  public function toCMY(){
    return $this->toRGB()->toCMY();
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
    return $this->toRGB()->toCIELab();
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
   * @return string
   */
  public function __toString(){
    return round($this->hue) . ',' . round($this->saturation) . ',' . round($this->value);
  }


  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->hue, $this->saturation, $this->value];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['h' => $this->hue, 's' => $this->saturation, 'v' => $this->value];
  }
}

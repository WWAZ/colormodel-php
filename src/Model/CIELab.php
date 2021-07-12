<?php


namespace wwaz\colormodel\Model;

use wwaz\colormodel\Exceptions\InvalidArgumentException;

/**
 * CIELab color model
 */
class CIELab extends Color{

  /**
   * The lightness
   * @var float
   */
  public $lightness;

  /**
   * The a dimension
   * @var float
   */
  public $a;

  /**
   * The b dimenson
   * @var float
   */
  public $b;

  /**
   * Create a new CIELab color
   *
   * @param float|string|array $lightness – the lightness
   * or string or array representation
   * @param float $a - a dimenson
   * @param float $b - b dimenson
   */
  public function __construct($lightness, float $a = null, float $b = null){

    $this->toSelf = "toCIELab";

    $this->init([
      [
        'key' => 'lightness',
        'val' => $lightness,
        'type' => 'float'
      ],
      [
        'key' => 'a',
        'val' => $a,
        'type' => 'float'
      ],
      [
        'key' => 'b',
        'val' => $b,
        'type' => 'float'
      ]
    ]);
  }

  public static function create($lightness, $a, $b){
    return new CIELab($lightness, $a, $b);
  }

  // public function lightness(){
  //   return $this->lightness;
  // }
  //
  // public function a(){
  //   return $this->a;
  // }
  //
  // public function b(){
  //   return $this->b;
  // }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return $this->toRGB()->toHex();
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    return $this->toXYZ()->toRGB();
  }

  /**
   * Convert the color to RGBA format
   *
   * @param float $alpha
   * @return \wwaz\colormodel\Model\RGBA the color in RGBA format
   */
  public function toRGBA($alpha = 1){
    $rgb = $this->toRGB()->toArray();
    $rgb[] = $alpha;
    return new RGBA( $rgb );
  }

  /**
   * Convert the color to XYZ format
   *
   * @return \wwaz\colormodel\Model\XYZ the color in XYZ format
   */
  public function toXYZ(){
    $ref_X = 95.047;
    $ref_Y = 100.000;
    $ref_Z = 108.883;

    $var_Y = ($this->lightness + 16) / 116;
    $var_X = $this->a / 500 + $var_Y;
    $var_Z = $var_Y - $this->b / 200;

    if (pow($var_Y, 3) > 0.008856) {
      $var_Y = pow($var_Y, 3);
    } else {
      $var_Y = ($var_Y - 16 / 116) / 7.787;
    }
    if (pow($var_X, 3) > 0.008856) {
      $var_X = pow($var_X, 3);
    } else {
      $var_X = ($var_X - 16 / 116) / 7.787;
    }
    if (pow($var_Z, 3) > 0.008856) {
      $var_Z = pow($var_Z, 3);
    } else {
      $var_Z = ($var_Z - 16 / 116) / 7.787;
    }
    $position_x = $ref_X * $var_X;
    $position_y = $ref_Y * $var_Y;
    $position_z = $ref_Z * $var_Z;
    return new XYZ($position_x, $position_y, $position_z);
  }

  /**
   * Convert the color to Yxy format
   *
   * @return \wwaz\colormodel\Model\Yxy the color in Yxy format
   */
  public function toYxy(){
    return $this->toXYZ()->toYxy();
  }

  /**
   * Convert the color to HSL format
   *
   * @return \wwaz\colormodel\Model\HSL the color in HSL format
   */
  public function toHSL(){
    return $this->toHSV()->toHSL();
  }

  /**
   * Convert the color to HSV format
   *
   * @return \wwaz\colormodel\Model\HSV the color in HSV format
   */
  public function toHSV(){
    return $this->toRGB()->toHSV();
  }

  /**
   * Convert the color to HSB format
   *
   * @return \wwaz\colormodel\Model\HSB the color in HSB format
   */
  public function toHSB(){
    return $this->toRGB()->toHSB();
  }

  /**
   * Convert the color to CMY format
   *
   * @return \wwaz\colormodel\Model\CMY the color in CMY format
   */
  public function toCMY(){
    return $this->toRGB()->toCMY();
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    return $this->toCMY()->toCMYK();
  }

  /**
   * Convert the color to CMYKInt format
   *
   * @return \wwaz\colormodel\Model\CMYKInt the color in CMYK format
   */
  public function toCMYKInt(){
    return $this->toCMYK()->toCMYKInt();
  }

  /**
   * Convert the color to CIELab format
   *
   * @return \wwaz\colormodel\Model\CIELab the color in CIELab format
   */
  public function toCIELab(){
    return $this;
  }

  /**
   * Convert the color to CIELCh format
   *
   * @return \wwaz\colormodel\Model\CIELCh the color in CIELCh format
   */
  public function toCIELCh(){
    $var_H = atan2($this->b, $this->a);

    if ($var_H > 0) {
      $var_H = ($var_H / pi()) * 180;
    } else {
      $var_H = 360 - (abs($var_H) / pi()) * 180;
    }

    $lightness = $this->lightness;
    $chroma = sqrt(pow($this->a, 2) + pow($this->b, 2));
    $hue = $var_H;

    return new CIELCh($lightness, $chroma, $hue);
  }

  /**
   * A string representation of this color in the current format
   *
   * @return string The color in format: $lightness,$a,$b
   */
  public function __toString(){
    return sprintf('%01.4f,%01.4f,%01.4f', $this->lightness, $this->a, $this->b);
  }

  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray($round = false){
    return [$this->lightness, $this->a, $this->b];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['l' => $this->lightness, 'a' => $this->a, 'b' => $this->b];
  }
}

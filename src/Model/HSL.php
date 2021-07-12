<?php

namespace wwaz\colormodel\Model;

use wwaz\colormodel\Exceptions\InvalidArgumentException;

/**
 * HSL color model
 */
class HSL extends Color{

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
   * The lightness
   * @var float
   */
  public $lightness;

  /**
   * Create a new HSL color
   *
   * @param float|string|array $hue – hue (0-1)
   * or string or array representation
   * @param float $saturation - saturation (0-1)
   * @param float $lightness - lightness (0-1)
   */
  public function __construct($hue, float $saturation = null, float $lightness = null){

    $this->toSelf = "toHSL";

    if( $saturation > 100 ){
      $saturation = 100;
    }

    if( $lightness > 100 ){
      $lightness = 100;
    }

    if( $saturation > 100 ){
      throw new InvalidArgumentException('['.$hue.','.$saturation.','.$lightness.']: Parameter saturation > 100');
    }
    if( $lightness > 100 ){
      throw new InvalidArgumentException('['.$hue.','.$saturation.','.$lightness.']: Parameter lightness > 100');
    }

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
        'key' => 'lightness',
        'val' => $lightness,
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
  //  * Returns lightness.
  //  *
  //  * @return int the lightness
  //  */
  // public function lightness(){
  //   return $this->lightness;
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
    return $this->toHSV()->toRGB();
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
    return $this->toRGB()->toXYZ();
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
    return $this;
  }

  /**
   * Convert the color to HSV format
   *
   * @return \wwaz\colormodel\Model\HSV the color in HSV format
   */
  public function toHSV(){
    $temp = $this->saturation * ($this->lightness < 50 ? $this->lightness : 100 - $this->lightness) / 100;

    $h = $this->hue;
    $v = $temp + $this->lightness;
    $s = ($this->lightness + $temp > 0)
    ? 200 * $temp / ($this->lightness + $temp)
    : 0;

    return new HSV($h, $s, $v);
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
    return $this->toRGB()->toCIELab();
  }

  /**
   * Convert the color to CIELCh format
   *
   * @return \wwaz\colormodel\Model\CIELCh the color in CIELCh format
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
    return round($this->hue) . ',' . round($this->saturation) . ',' . round($this->lightness);
  }


  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->hue, $this->saturation, $this->lightness];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['h' => $this->hue, 's' => $this->saturation, 'l' => $this->lightness];
  }
}

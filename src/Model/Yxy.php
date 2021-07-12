<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * Yxy color model
 */
class Yxy extends Color
{

  /**
   * The Y
   * @var float
   */
  public $Y;

  /**
   * The x
   * @var float
   */
  public $x;

  /**
   * The y
   * @var float
   */
  public $y;

  /**
   * Create a new Yxy color
   *
   * @param float|string|array $x – x
   * or string or array representation
   * @param float $x The x
   * @param float $y The y
   */
  public function __construct($Y, float $x = null, float $y = null){

    $this->toSelf = "toYxy";

    $this->init([
      [
        'key' => 'Y',
        'val' => $Y,
        'type' => 'float'
      ],
      [
        'key' => 'x',
        'val' => $x,
        'type' => 'float'
      ],
      [
        'key' => 'y',
        'val' => $y,
        'type' => 'float'
      ]
    ]);
  }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return $this->toXYZ()->toRGB()->toHex();
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\Colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    return $this->toXYZ()->toRGB();
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
    $X = ($this->Y == 0) ? 0 : $this->x * ($this->Y / $this->y);
    $Y = $this->Y;
    $Z = ($this->Y == 0) ? 0 : (1 - $this->x - $this->y) * ($this->Y / $this->y);
    return new XYZ($X, $Y, $Z);
  }

  /**
   * Convert the color to Yxy format
   *
   * @return \wwaz\Colormodel\Model\Yxy the color in Yxy format
   */
  public function toYxy(){
    return $this;
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
    return $this->toXYZ()->toHSV();
  }

  /**
   * Convert the color to HSB format
   *
   * @return \wwaz\Colormodel\Model\HSB the color in HSB format
   */
  public function toHSB(){
    return $this->toRGB()->toHSB();
  }

  /**
   * Convert the color to CMY format
   *
   * @return \wwaz\Colormodel\Model\CMY the color in CMY format
   */
  public function toCMY(){
    return $this->toXYZ()->toCMY();
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    return $this->toXYZ()->toCMYK();
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
    return $this->toXYZ()->toCIELCh();
  }

  /**
   * A string representation of this color in the current format
   *
   * @return string The color in format: $Y,$x,$y
   */
  public function __toString(){
    return sprintf('%01.4f,%01.4f,%01.4f', $this->Y, $this->x, $this->y);
  }


  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->Y, $this->x, $this->y];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['Y' => $this->Y, 'x' => $this->x, 'y' => $this->y];
  }
}

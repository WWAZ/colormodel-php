<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * CMY color model
 */
class CMY extends Color{

  /**
   * The cyan
   * @var float
   */
  public $cyan;

  /**
   * The magenta
   * @var float
   */
  public $magenta;

  /**
   * The yellow
   * @var float
   */
  public $yellow;

  /**
   * Create a new CIELab color
   *
   * @param float|string|array $cyan – cyan
   * or string or array representation
   * @param float $magenta - magenta
   * @param float $yellow - yellow
   */
  public function __construct($cyan, float $magenta = null, float $yellow = null){
    $this->toSelf = "toCMY";

    $this->init([
      [
        'key' => 'cyan',
        'val' => $cyan,
        'type' => 'float'
      ],
      [
        'key' => 'magenta',
        'val' => $magenta,
        'type' => 'float'
      ],
      [
        'key' => 'yellow',
        'val' => $yellow,
        'type' => 'float'
      ]
    ]);

    // $this->cyan = $cyan;
    // $this->magenta = $magenta;
    // $this->yellow = $yellow;
  }

  public static function create($cyan, $magenta, $yellow){
    return new CMY($cyan, $magenta, $yellow);
  }


  /**
   * Get the amount of Cyan
   *
   * @return int The amount of cyan
   */
  public function getCyan(){
    return $this->cyan;
  }


  /**
   * Get the amount of Magenta
   *
   * @return int The amount of magenta
   */
  public function getMagenta(){
    return $this->magenta;
  }


  /**
   * Get the amount of Yellow
   *
   * @return int The amount of yellow
   */
  public function getYellow(){
    return $this->yellow;
  }


  // /**
  //  * Shortcut for getCyan()
  //  *
  //  * @return int The amount of cyan
  //  */
  // public function cyan(){
  //   return $this->getCyan();
  // }
  //
  // /**
  //  * Shortcut for getMagenta()
  //  *
  //  * @return int The amount of magenta
  //  */
  // public function magenta(){
  //   return $this->getMagenta();
  // }
  //
  // /**
  //  * Shortcut for getYellow()
  //  *
  //  * @return int The amount of yellow
  //  */
  // public function yellow(){
  //   return $this->getYellow();
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
    $red = (1 - $this->cyan) * 255;
    $green = (1 - $this->magenta) * 255;
    $blue = (1 - $this->yellow) * 255;
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
    return $this->toRGB()->toHSV();
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
    return $this;
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    $var_K = 1;
    $cyan = $this->cyan;
    $magenta = $this->magenta;
    $yellow = $this->yellow;
    if ($cyan < $var_K) {
      $var_K = $cyan;
    }
    if ($magenta < $var_K) {
      $var_K = $magenta;
    }
    if ($yellow < $var_K) {
      $var_K = $yellow;
    }
    if ($var_K == 1) {
      $cyan = 0;
      $magenta = 0;
      $yellow = 0;
    } else {
      $cyan = ($cyan - $var_K) / (1 - $var_K);
      $magenta = ($magenta - $var_K) / (1 - $var_K);
      $yellow = ($yellow - $var_K) / (1 - $var_K);
    }

    $key = $var_K;

    return new CMYK($cyan, $magenta, $yellow, $key);
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
   * @return string The color in format: $cyan,$magenta,$yellow
   */
  public function __toString(){
    return sprintf('%01.4f,%01.4f,%01.4f', $this->cyan, $this->magenta, $this->yellow);
  }

  /**
   * Returns color as string
   *
   * @param boolean $beautify
   * @param int $round
   * @return string
   */
  public function toString($beautify = null, $round = 0){
    $cmy = $this->toAssociativeArray($round);
    $cmy = $cmy['c'] . ',' . $cmy['m'] . ',' . $cmy['y'];
    if( $beautify ){
      return str_replace(',', ', ', $cmy);
    }
    return $cmy;
  }

  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->cyan, $this->magenta, $this->yellow];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['c' => $this->cyan, 'm' => $this->magenta, 'y' => $this->yellow];
  }

}

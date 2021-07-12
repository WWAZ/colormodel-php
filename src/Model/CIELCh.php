<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * CIELCh color model
*/
class CIELCh extends Color{

  /**
   * The lightness
   * @var float
   */
  public $lightness;

  /**
   * The chroma
   * @var float
   */
  public $chroma;

  /**
   * The hue
   * @var float
   */
  public $hue;

  /**
   * Create a new CIELCh color
   *
   * @param float|string|array $lightness – lightness
   * or string or array representation
   * @param float $chroma - chroma
   * @param float $hue - hue
   */
  public function __construct($lightness, float $chroma = null, float $hue = null){
    $this->toSelf = "toCIELCh";

    $this->init([
      [
        'key' => 'lightness',
        'val' => $lightness,
        'type' => 'float'
      ],
      [
        'key' => 'chroma',
        'val' => $chroma,
        'type' => 'float'
      ],
      [
        'key' => 'hue',
        'val' => $hue,
        'type' => 'float'
      ]
    ]);

    $this->hue = fmod($this->hue, 360);
    if ($this->hue < 0) {
      $this->hue += 360;
    }
  }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return $this->toCIELab()->toHex();
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\Colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    return $this->toCIELab()->toRGB();
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
    return $this->toCIELab()->toXYZ();
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
    return $this->toCIELab()->toHSV();
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
    return $this->toCIELab()->toCMY();
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    return $this->toCIELab()->toCMYK();
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
    $hradi = $this->hue * (pi() / 180);
    $a = cos($hradi) * $this->chroma;
    $b = sin($hradi) * $this->chroma;
    return new CIELab($this->lightness, $a, $b);
  }

  /**
   * Convert the color to CIELCh format
   *
   * @return \wwaz\Colormodel\Model\CIELCh the color in CIELCh format
   */
  public function toCIELCh(){
    return $this;
  }

  /**
   * A string representation of this color in the current format
   *
   * @return string The color in format: $lightness,$chroma,$hue
   */
  public function __toString(){
    return sprintf('%01.4f,%01.4f,%01.4f', $this->lightness, $this->chroma, $this->hue);
  }

  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(){
    return [$this->lightness, $this->chroma, $this->hue];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(){
    return ['l' => $this->lightness, 'c' => $this->chroma, 'h' => $this->hue];
  }
}

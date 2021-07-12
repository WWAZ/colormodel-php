<?php

namespace wwaz\colormodel\Model\Traits;

use wwaz\colormodel\Model\RGB;
use wwaz\colormodel\Model\Hex;

/**
 * Color model trait
 * Contains color lightness methods.
 */
trait ColorLightnessTrait{

  /**
   * Describes the lightness value
   * from which a color is perceived as light.
   * (0 - 765)
   *
   * @var int
   */
  protected $lightnessBorder = 480; // 58,82%


  /**
   * Returns color lightness.
   *
   * @return float
   */
  public function lightness($percentage = null){
    $HexColor = $this->toHex();
    $r = hexdec(substr($HexColor, 0, 2));
    $g = hexdec(substr($HexColor, 2, 2));
    $b = hexdec(substr($HexColor, 4, 2));
    if( $percentage ){
      return (100 / $this->lightnessMax()) * ($r + $g + $b) / 100;
    }
    return $r + $g + $b;
  }


  /**
   * Returns or sets lightness border.
   * This value determines, the lightness value
   * from where on the color reception
   * will be declared as light.
   *
   * @param int $border (0 - 765) (optional)
   * @return int $border
   */
  public function lightnessBorder(int $border = null){
    if( $border ){
      $this->lightnessBorder = $border;
    }
    return $this->lightnessBorder;
  }


  /**
   * Returns min lightness value.
   *
   * @return int
   */
  public function lightnessMin(){
    return RGB::create('0,0,0')->lightness();
  }


  /**
   * Returns max lightness value.
   *
   * @return int
   */
  public function lightnessMax(){
    return RGB::create('255,255,255')->lightness();
  }


  /**
   * Returns true when color is dark.
   *
   * @return bool
   */
  public function isDark(){
    return $this->lightness() <= $this->lightnessBorder ? true : false;
  }


  /**
   * Returns true when color is light.
   *
   * @return bool
   */
  public function isLight(){
    return $this->isDark() ? false : true;
  }


  /**
   * Returns lightness reception
   * wether a color is light or dark.
   *
   * @return string
   */
  public function lightnessReception(){
    return $this->isLight() ? 'light' : 'dark';
  }

  /**
   * Returns lightness reception
   * wether a color is light or dark.
   *
   * @return string
   */
  public function lightnessReceptionDifferentiated (){
    $lightness = $this->lightness();
    $border = $this->lightnessBorder();
    $min = $this->lightnessMin();
    $max = $this->lightnessMax();
    $light = ($max - $border) / 3;
    if( $lightness > ($border + ($light * 1)) ){
      return 'soft';
    }
    if( $lightness > ($border + ($light / 2)) ){
      return 'light';
    }
    if( $lightness > ($border - $light * 2) ){
      return 'regular';
    }

    return 'dark';
  }


  /**
   * Returns hard lightness matching text color.
   * Just black or white.
   *
   * @return string - hex
   */
  public function textColorHard(){
    return $this->isLight() ? new Hex(0x000000) : new Hex(0xFFFFFF);
  }


  /**
   * Returns soft lightness matching text color
   * by adjusting the brightness of the text color.
   *
   * @return string - hex
   */
  public function textColorSoft(){
    if( $this->isLight() ){
      return $this->toRGB()->brightness(-55)->toHex()->shorten();
    } else {
      return $this->toRGB()->brightness(60)->toHex()->shorten();
    }
  }


}

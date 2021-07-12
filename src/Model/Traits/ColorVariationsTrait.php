<?php

namespace wwaz\Colormodel\Model\Traits;

use wwaz\Colormodel\Model\CIELCh;
use wwaz\Colormodel\Model\HSV;
use wwaz\Colormodel\Model\RGB;
use wwaz\Colormodel\Colorharmony\Colorharmony;
use wwaz\Colormodel\Harmony\HarmonyFactory;
use wwaz\Colormodel\Colorname\Basename;

/**
 * Color model trait
 * Contains color harmony methods
 */
trait ColorVariationsTrait{

  public function tintVariations($steps = 10, $includeSelf = true){
    return $this->range($this, $this->createColor('rgb', [255,255,255]), $steps, $includeSelf);
  }

  public function shadeVariations($steps = 10, $includeSelf = true){
    return $this->range($this, $this->createColor('rgb', [0,0,0]), $steps, $includeSelf);
  }

  public function hueVariations($steps = 10, $includeSelf = true){
    return $this->hsbAttributeRange('hue', $steps, $includeSelf);
  }

  public function saturationVariations($steps = 10, $includeSelf = true){
    return $this->hsbAttributeRange('saturation', $steps, $includeSelf);
  }

  public function lightnessVariations($steps = 10, $includeSelf = true){
    return $this->hsbAttributeRange('brightness', $steps, $includeSelf);
  }

  protected function hsbAttributeRange($attribute, $steps = 10, $includeSelf = true){

    $step = 10;

    $steps = round($steps / 2) - 1;

    $type = $this->type();

    $HSB = $this->toHSB();

    $colors = [];

    $orgval = $HSB->$attribute;

    for($i=0; $i<$steps; $i++){
      $val = $orgval - (($i+1) * $step);
      $colors[] = clone $HSB->$attribute( $val, true )->toType($type);
    }

    $colors = array_reverse($colors);

    $colors[] = clone $this->toType($type);

    for($i=0; $i<$steps; $i++){
      $val = $orgval + (($i+1) * $step);
      $colors[] = clone $HSB->$attribute( $val, true )->toType($type);
    }

    return $colors;

  }

  /**
   * Calculates range between this color and a destination color
   *
   * @param \wwaz\Colormodel\Model\Color $destinationColor
   * @param int $steps – to reach the destination color
   * @param bool $includeSelf
   * @return \wwaz\Colormodel\Model\Color[] – array or color objects
   */
  protected function range($fromColor, $toColor, $steps = 5, $includeSelf = null){

    $steps++;
    $a = $fromColor->toRGB();
    $b = $toColor->toRGB();
    $colors = [];
    $steps--;
    for ($n = 1; $n < $steps; $n++) {
      $nr = floor($a->red + ($n * ($b->red - $a->red) / $steps));
      $ng = floor($a->green + ($n * ($b->green - $a->green) / $steps));
      $nb = floor($a->blue + ($n * ($b->blue - $a->blue) / $steps));
      if( $fromColor->type() === 'rgba' ){
        $t = new RGBA($nr, $ng, $nb, $this->Color->alpha);
      } else {
        $t = new RGB($nr, $ng, $nb);
      }
      $colors[] = $t;
    }
    if ($includeSelf) {
      array_unshift($colors, $fromColor);
      $colors[] = $toColor;
    }

    // Remove $toColor
    array_pop($colors);

    return $colors;
  }

}

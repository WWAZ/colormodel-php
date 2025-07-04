<?php

namespace wwaz\Colormodel\Model\Traits;

use wwaz\Colormodel\Model\RGB;

/**
 * Color model trait
 * Contains color manipulation methods
 */
trait ColorManipulationTrait
{
    /**
     * Return a grayscale version of the current color
     *
     * @return wwaz\Colormodel\Model\Color The grayscale color
     */
    public function grayscale()
    {
        $a  = $this->toRGB();
        $ds = $a->red * 0.3 + $a->green * 0.59 + $a->blue * 0.11;
        $t  = new RGB($ds, $ds, $ds);
        if ($this->type() === 'rgba') {
            return $t->toRGBA($this->alpha);
        }
        return call_user_func([$t, $this->toSelf]);
    }

    /**
     * Modify the hue by $degreeModifier degrees
     *
     * @param int $degreeModifier Degrees to modify by
     * @param bool $absolute If TRUE set absolute value
     * @return wwaz\Colormodel\Model\Color The modified color
     */
    public function hue($degreeModifier, $absolute = false)
    {
        $a      = $this->toHSB();
        $a->hue = $absolute ? $degreeModifier : $a->hue + $degreeModifier;
        $a->hue = fmod($a->hue, 360);
        if ($this->type() === 'rgba') {
            return $a->toRGBA($this->alpha);
        }
        return call_user_func([$a, $this->toSelf]);
    }

    /**
     * Modify the saturation by $satModifier
     *
     * @param int $satModifier - Value to modify by
     * @param bool $absolute - If TRUE set absolute value
     * @return wwaz\Colormodel\Model\Color - The modified color
     */
    public function saturation($satModifier, $absolute = false)
    {
        $a          = $this->toHSB();
        $saturation = $absolute ? $satModifier : $a->saturation + $satModifier;
        if ($saturation > 100) {
            $saturation = 100;
        }
        if ($saturation < 0) {
            $saturation = 0;
        }
        $a->saturation = $saturation;
        try {
            if ($this->type() === 'rgba') {
                $color = $a->toRGBA($this->alpha);
            } else {
                $color = call_user_func([$a, $this->toSelf]);
            }
        } catch (\Throwable $e) {}

        if (! isset($color)) {
            return $this;
        }

        return $color;
    }

    /**
     * Modify the brightness by $brightnessModifier
     *
     * @param int $brightness - value from 0 to 100
     * @return wwaz\Colormodel\Model\Color - The modified color
     */
    public function brightness($brightness)
    {
        $a         = $this->toHSB();
        $a->brightness = $brightness;
        if ($this->type() === 'rgba') {
            return $a->toRGBA($this->alpha);
        }
        return call_user_func([$a, $this->toSelf]);
    }
}
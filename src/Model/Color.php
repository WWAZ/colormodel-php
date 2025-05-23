<?php

namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Model\Traits\ColorInitializationTrait;
use wwaz\Colormodel\Model\Traits\ColorLightnessTrait;
use wwaz\Colormodel\Model\Traits\ColorManipulationTrait;
use wwaz\Colormodel\Model\Traits\ColorVariationsTrait;

/**
 * Color base class.
 * More handy modification of
 * @see https://github.com/mikeemoo/ColorJizz-PHP
 */
abstract class Color
{
    /**
     * Traits
     */
    use ColorInitializationTrait;
    use ColorManipulationTrait;
    use ColorVariationsTrait;
    use ColorLightnessTrait;

    /**
     * Name of object to convert to it's self.
     *
     * @var string
     */
    protected $toSelf;

    /**
     * Converts this color to given type string.
     *
     * @param string $type – e.g. 'rgb'
     * @return \wwaz\Colormodel\Model\Color
     */
    public function toType($type)
    {
        $methodname = 'to' . strtoupper($type);
        return $this->$methodname();
    }

    /**
     * Returns color model type.
     * e.g. color\Model\RGBA -> rgba.
     *
     * @return string
     */
    public function type()
    {
        $array = explode('\\', get_class($this));
        $last  = $array[count($array) - 1];
        return strtolower($last);
    }

    /**
     * Creates a new color
     *
     * @param string $type
     * @param mixed $value
     * @return \wwaz\Colormodel\Model\Color
     */
    public function createColor($type, $value)
    {
        $classname = __NAMESPACE__ . '\\' . strtoupper($type);
        return new $classname($value);
    }

    // public function complement()
    // {
    //     $orgType = $this->type();
    //     $rgb = $this->toRgb();

    //     $r = 255 - $rgb->getRed();
    //     $g = 255 - $rgb->getGreen();
    //     $b = 255 - $rgb->getBlue();

    //     $toOrg = 'to' . $orgType;
    //     return (new RGB([$r, $g, $b]))->$toOrg();
    // }

    public function complement()
    {
        $orgType = $this->type();
        $hsb = $this->toHsb();
        $hsb->hue(190);
        $toOrg = 'to' . $orgType;
        return $hsb->$toOrg();
    }

    /**
     * Convert the color to Hex format.
     *
     * @return \wwaz\Colormodel\Model\Hex the color in Hex format
     */
    abstract public function toHex();

    /**
     * Convert the color to RGB format.
     *
     * @return \wwaz\Colormodel\Model\RGB the color in RGB format
     */
    abstract public function toRGB();

    /**
     * Convert the color to RGBA format.
     *
     * @return \wwaz\Colormodel\Model\RGBA the color in RGBA format
     */
    abstract public function toRGBA();

    /**
     * Convert the color to XYZ format.
     *
     * @return \wwaz\Colormodel\Model\XYZ the color in XYZ format
     */
    abstract public function toXYZ();

    /**
     * Convert the color to Yxy format.
     *
     * @return \wwaz\Colormodel\Model\Yxy the color in Yxy format
     */
    abstract public function toYxy();

    /**
     * Convert the color to CIELab format.
     *
     * @return \wwaz\Colormodel\Model\CIELab the color in CIELab format
     */
    abstract public function toCIELab();

    /**
     * Convert the color to CIELCh format
     *
     * @return \wwaz\Colormodel\Model\CIELCh the color in CIELCh format
     */
    abstract public function toCIELCh();

    /**
     * Convert the color to CMY format.
     *
     * @return \wwaz\Colormodel\Model\CMY the color in CMY format
     */
    abstract public function toCMY();

    /**
     * Convert the color to CMYK format.
     *
     * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
     */
    abstract public function toCMYK();

    /**
     * Convert the color to toCMYKInt format.
     *
     * @return \wwaz\Colormodel\Model\toCMYKInt the color in toCMYKInt format
     */
    abstract public function toCMYKInt();

    /**
     * Convert the color to HSV format.
     *
     * @return \wwaz\Colormodel\Model\HSV the color in HSV format
     */
    abstract public function toHSV();

    /**
     * Convert the color to HSB format (same as HSV).
     *
     * @return \wwaz\Colormodel\Model\HSB the color in HSB format
     */
    abstract public function toHSB();

    /**
     * Convert the color to HSL format.
     *
     * @return \wwaz\Colormodel\Model\HSL the color in HSL format
     */
    abstract public function toHSL();

    /**
     * Returns html rgb value representation.
     * e.g. rgb(255,0,0)
     *
     * @return string
     */
    public function toHTML()
    {
        return $this->toHex()->toHTML();
    }

    /**
     * Returns html rgb value representation.
     * e.g. rgb(255,0,0,0.5)
     *
     * @return string
     */
    public function toHTMLAlpha($alpha = 1)
    {
        $color = $this->toRGBA($alpha);
        if ($array = $color->toArray()) {
            return 'rgba(' . implode(',', $array) . ')';
        }
        return '';
    }

    /**
     * Returns string.
     * e.g. '255,255,255'
     *
     * @return string
     */
    public function toString($beautify = null)
    {
        if ($beautify) {
            $str = $this->__toString();
            return str_replace(',', ',&nbsp;', $str);
        }
        return $this->__toString();
    }

    /**
     * Returns rounded color string.
     *
     * @param bool $beautify – when true a balnk will be inserted between commas
     */
    public function toRoundedString($beautify = null)
    {
        $str = $this->toString($beautify);
        if (strpos($str, ',') !== false) {
            $str = explode(',', $str);
            foreach ($str as $index => $v) {
                $str[$index] = round(floatVal(trim($v)));
            }
            if ($beautify) {
                return implode(', ', $str);
            }
            return implode(',', $str);
        }
        return $str;
    }

    /**
     * Returns array.
     * e.g. [255, 0, 0]
     *
     * @return array
     */
    public function toArray()
    {
        return false;
    }

    /**
     * Returns asscociative array.
     * e.g. ['r' => 255, 'g' => 0, 'b' => 0]
     *
     * @return array
     */
    public function toAssociativeArray()
    {
        return false;
    }

    /**
     * Find the closest websafe color.
     *
     * @return \wwaz\Colormodel\Model\Color The closest color
     */
    public function websafe()
    {
        $palette = [];
        for ($red = 0; $red <= 255; $red += 51) {
            for ($green = 0; $green <= 255; $green += 51) {
                for ($blue = 0; $blue <= 255; $blue += 51) {
                    $palette[] = new RGB($red, $green, $blue);
                }
            }
        }
        return $this->getNearestColor($palette);
    }

    /**
     * Returns nearest color from color palette.
     * 
     * @param array $palette
     * @return RGB
     */
    protected function getNearestColor($palette) 
    {
        $nearestColor = null;
        $minDistance = PHP_INT_MAX;
    
        foreach ($palette as $color) {
    
            // Euclidean Distance in the RGB Color Space
            $distance = sqrt(
                pow($color->getRed() - $this->toRGB()->getRed(), 2) +
                pow($color->getGreen() - $this->toRGB()->getGreen(), 2) +
                pow($color->getBlue() - $this->toRGB()->getBlue(), 2)
            );
    
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestColor = $color;
            }
        }
    
        return $nearestColor;
    }
}
<?php

namespace wwaz\Colormodel\Model;

/**
 * HSB color model
 */
class HSB extends Color
{
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
     * The brightness
     * @var float
     */
    public $brightness;

    /**
     * Create a new HSB color
     *
     * @param float|string|array $hue – hue (0-1)
     * or string or array representation
     * @param float $saturation - saturation (0-1)
     * @param float $brightness - brightness (0-1)
     */
    public function __construct($hue, $saturation = null, $brightness = null)
    {
        $this->toSelf = "toHSB";

        $this->init([
            [
                'key'  => 'hue',
                'val'  => $hue,
                'type' => 'float',
            ],
            [
                'key'  => 'saturation',
                'val'  => $saturation,
                'type' => 'float',
            ],
            [
                'key'  => 'brightness',
                'val'  => $brightness,
                'type' => 'float',
            ],
        ]);
    }

    /**
     * Convert the color to Hex format
     *
     * @return \wwaz\Colormodel\Model\Hex the color in Hex format
     */
    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    /**
     * Convert the color to RGB format
     *
     * @return \wwaz\Colormodel\Model\RGB the color in RGB format
     */
    public function toRGB()
    {
        $HSV = new HSV($this->hue, $this->saturation, $this->brightness);
        return $HSV->toRGB();
    }

    /**
     * Convert the color to RGBA format
     *
     * @param float $alpha
     * @return \wwaz\Colormodel\Model\RGBA the color in RGBA format
     */
    public function toRGBA($alpha = 1)
    {
        $rgb   = $this->toRGB()->toArray();
        $rgb[] = $alpha;
        return new RGBA($rgb);
    }

    /**
     * Convert the color to XYZ format
     *
     * @return \wwaz\Colormodel\Model\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this->toRGB()->toXYZ();
    }

    /**
     * Convert the color to Yxy format
     *
     * @return \wwaz\Colormodel\Model\Yxy the color in Yxy format
     */
    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    /**
     * Convert the color to HSL format
     * @return \wwaz\Colormodel\Model\HSL the color in HSL format
     */
    public function toHSL()
    {
        $HSV = new HSV($this->hue, $this->saturation, $this->brightness);
        return $HSV->toHSL();
    }

    /**
     * Convert the color to HSB format
     *
     * @return \wwaz\Colormodel\Model\HSB the color in HSB format
     */
    public function toHSV()
    {
        // Same as HSB
        return new HSV($this->hue, $this->saturation, $this->brightness);
    }

    /**
     * Convert the color to HSB format
     *
     * @return \wwaz\Colormodel\Model\HSB the color in HSB format
     */
    public function toHSB()
    {
        return $this;
    }

    /**
     * Convert the color to CMY format
     *
     * @return \wwaz\Colormodel\Model\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this->toRGB()->toCMY();
    }

    /**
     * Convert the color to CMYK format
     *
     * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    /**
     * Convert the color to CMYKInt format
     *
     * @return \wwaz\Colormodel\Model\CMYKInt the color in CMYK format
     */
    public function toCMYKInt()
    {
        return $this->toCMYK()->toCMYKInt();
    }

    /**
     * Convert the color to CIELab format
     *
     * @return \wwaz\Colormodel\Model\CIELab the color in CIELab format
     */
    public function toCIELab()
    {
        return $this->toRGB()->toCIELab();
    }

    /**
     * Convert the color to CIELCh format
     *
     * @return \wwaz\Colormodel\Model\CIELCh the color in CIELCh format
     */
    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string
     */
    public function __toString()
    {
        return round($this->hue) . ',' . round($this->saturation) . ',' . round($this->brightness);
    }

    /**
     * Returns color as indexed array
     *
     * @return array
     */
    public function toArray()
    {
        return [round($this->hue), round($this->saturation), round($this->brightness)];
    }

    /**
     * Returns color as associative array
     *
     * @return array
     */
    public function toAssociativeArray()
    {
        return ['h' => round($this->hue), 's' => round($this->saturation), 'b' => round($this->brightness)];
    }
}
<?php
namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * Hex color model
 */
class Hex extends Color
{
    /**
     * The value of the color
     *
     * @var int
     */
    public $hex;

    protected $shorten = false;

    /**
     * Create a new Hex
     *
     * @param int|string $hex - hexidecimal value
     * ex. 0x000000, 'f00', 'ff0000', '#ff0000'
     */
    public function __construct($hex)
    {
        if (is_string($hex)) {
            $hex = Hex::fromString($hex)->hex;
        }

        if ($hex > 0xFFFFFF || $hex < 0) {
            throw new InvalidArgumentException(sprintf('Parameter hex out of range (%s)', $hex));
        }

        $this->hex    = $hex;
        $this->toSelf = "toHex";
    }

    /**
     * Create a new Hex
     *
     * @param int $hex the hexidecimal value (i.e. 0x000000)
     *
     * @return wwaz\Colormodel\Model\Hex the color in Hex format
     */
    public static function create($hex)
    {
        return new Hex($hex);
    }

    /**
     * Convert the color to Hex format
     *
     * @return wwaz\Colormodel\Model\Hex the color in Hex format
     */
    public function toHex()
    {
        return $this;
    }

    /**
     * Convert the color to RGB format
     *
     * @return wwaz\Colormodel\Model\RGB the color in RGB format
     */
    public function toRGB()
    {
        $hex = $this->hex;

        if (is_string($hex)) {
            $hex = Hex::fromString($hex)->hex;
        }

        $red   = (($hex & 0xFF0000) >> 16);
        $green = (($hex & 0x00FF00) >> 8);
        $blue  = (($hex & 0x0000FF));

        return new RGB($red, $green, $blue);
    }

    /**
     * Convert the color to RGBA format
     *
     * @param float $alpha
     * @return wwaz\Colormodel\Model\RGBA the color in RGBA format
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
     * @return wwaz\Colormodel\Model\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this->toRGB()->toXYZ();
    }

    /**
     * Convert the color to Yxy format
     *
     * @return wwaz\Colormodel\Model\Yxy the color in Yxy format
     */
    public function toYxy()
    {
        return $this->toRGB()->toYxy();
    }

    /**
     * Convert the color to HSL format
     *
     * @return wwaz\Colormodel\Model\HSL the color in HSL format
     */
    public function toHSL()
    {
        return $this->toHSV()->toHSL();
    }

    /**
     * Convert the color to HSV format
     *
     * @return wwaz\Colormodel\Model\HSV the color in HSV format
     */
    public function toHSV()
    {
        return $this->toRGB()->toHSV();
    }

    /**
     * Convert the color to HSB format
     *
     * @return wwaz\Colormodel\Model\HSB the color in HSB format
     */
    public function toHSB()
    {
        // HSB = HSV!
        return $this->toRGB()->toHSB();
    }

    /**
     * Convert the color to CMY format
     *
     * @return wwaz\Colormodel\Model\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this->toRGB()->toCMY();
    }

    /**
     * Convert the color to CMYK format
     *
     * @return wwaz\Colormodel\Model\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    /**
     * Convert the color to CMYKInt format
     *
     * @return wwaz\Colormodel\Model\CMYKInt the color in CMYK format
     */
    public function toCMYKInt()
    {
        return $this->toCMYK()->toCMYKInt();
    }

    /**
     * Convert the color to CIELab format
     *
     * @return wwaz\Colormodel\Model\CIELab the color in CIELab format
     */
    public function toCIELab()
    {
        return $this->toXYZ()->toCIELab();
    }

    /**
     * Convert the color to CIELCh format
     *
     * @return wwaz\Colormodel\Model\CIELCh the color in CIELCh format
     */
    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: RRGGBB
     */
    public function __toString()
    {
        $rgb = $this->toRGB();
        $hex = str_pad(dechex($rgb->getRed()), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb->getGreen()), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb->getBlue()), 2, "0", STR_PAD_LEFT);
        return strtoupper($hex);
    }

    /**
     * Create a new Hex from a string.
     *
     * @param string $str Can be a color name or string hex value (i.e. "FFFFFF")
     * @return wwaz\Colormodel\Model\Hex the color in Hex format
     */
    public static function fromString($str)
    {
        $str = strtolower($str);

        if (array_key_exists($str, self::$HTMLColorNames)) {
            return new Hex(self::$HTMLColorNames[$str]);
        }

        if (substr($str, 0, 1) == '#') {
            $str = substr($str, 1);
        }

        if (strlen($str) == 3) {
            $str = str_repeat($str[0], 2) . str_repeat($str[1], 2) . str_repeat($str[2], 2);
        }

        if (! preg_match('/[0-9A-F]{6}/i', $str)) {
            throw new InvalidArgumentException(sprintf('Parameter str is an invalid hex string (%s)', $str));
        }

        return new Hex(hexdec($str));
    }

    /**
     * When called, toSting methods will shorten
     * the hex code – ex. 'FF0000' -> 'F00'
     *
     * @return $this
     */
    public function shorten()
    {
        $this->shorten = true;
        return $this;
    }

    /**
     * Shortens hex value when possible
     * ex. 'FF0000' -> 'F00'
     *
     * @return string
     */
    private function shortenHex($hex)
    {
        if (strlen($hex) == 6) {
            $c            = $this->toArray();
            $countShorted = 0;
            foreach ($c as $index => $value) {
                if (count(array_count_values(str_split($value))) == 1) {
                    // Same chars - shorten string
                    $c[$index] = substr($c[$index], 0, 1);
                    $countShorted++;
                }
            }
            if ($countShorted === 3) {
                // All three values have been shortened.
                // We can give back a shortened hex value
                $hex = $c[0] . $c[1] . $c[2];
            }
        }
        return $hex;
    }

    /**
     * Returns html color value representation
     * ex. #f00
     *
     * @return string
     */
    public function toHTML()
    {
        return '#' . strtolower($this->shortenHex($this->toString()));
    }

    /**
     * Returns hex value as array
     * ex. ['ff', '00', '00']
     *
     * @return string
     */
    public function toArray()
    {
        $hex  = $this->toString();
        $c[0] = substr($hex, 0, 2);
        $c[1] = substr($hex, 2, 2);
        $c[2] = substr($hex, 4, 2);
        return $c;
    }

    public function websafename()
    {
        foreach (self::$HTMLColorNames as $name => $hex) {
            if (intval($hex) == intval($this->hex)) {
                return $name;
            }
        }
        return 'no match';
    }
}

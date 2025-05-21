<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;
use wwaz\Colormodel\Model\RGB;

class Complementary extends Scheme
{
    public function get()
    {
        $orgType = $this->color->type();
        $rgb = $this->color->toRgb();

        $r = 255 - $rgb->getRed();
        $g = 255 - $rgb->getGreen();
        $b = 255 - $rgb->getBlue();

        $toOrg = 'to' . $orgType;
        return (new RGB([$r, $g, $b]))->$toOrg();
    }
}

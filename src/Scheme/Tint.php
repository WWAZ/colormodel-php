<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;

class Tint extends ContinousScheme
{
    protected $start = 100;

    protected $end = 0;

    protected function generateStep($value)
    {
        return $this->color->saturation($value, true);
    }
}
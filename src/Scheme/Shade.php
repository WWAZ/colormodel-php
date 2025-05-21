<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;

class Shade extends ContinousScheme
{
    protected $start = 100;

    protected $end = 0;

    protected function generateStep($value)
    {
        return $this->color->brightness($value);
    }
}
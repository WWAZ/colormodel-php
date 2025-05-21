<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\SchemeInterface;

class Scheme implements SchemeInterface
{
    protected $color;

    public function __construct(\wwaz\Colormodel\Model\Color $color)
    {
        $this->color = $color;
    }
}

<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;

class Tetradic extends Scheme
{
    public function get()
    {
        return [
            clone $this->color,
            clone $this->color->hue(120),
            clone $this->color->hue(180),
            clone $this->color->hue(-60),
        ];
    }
}
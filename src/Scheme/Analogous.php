<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;

class Analogous extends Scheme
{
    public function get()
    {
        return [
            clone $this->color,
            clone $this->color->hue(-30),
            clone $this->color->hue(30),
        ];
    }
}
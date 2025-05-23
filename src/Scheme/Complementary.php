<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Scheme\Scheme;
use wwaz\Colormodel\Model\RGB;

class Complementary extends Scheme
{
    public function get()
    {
        return [
            clone $this->color,
            clone $this->color->complement(),
        ];
    }
}

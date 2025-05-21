<?php

namespace wwaz\Colormodel\Scheme;

use wwaz\Colormodel\Model\Color;
use wwaz\Colormodel\Scheme\Scheme;

abstract class ContinousScheme extends Scheme
{
    protected $number;

    protected $color;

    protected $start;

    protected $end;

    /**
     * ContinousSchemeBase constructor.
     */
    public function __construct(Color $color, $number)
    {
        $this->color = $color;
        $this->number = $number;
    }

    public function get(){
        return $this->generate();
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    protected function asc()
    {
        return $this->start < $this->end ? true : false;
    }

    protected function desc()
    {
        return $this->asc() ? false : true;
    }

    protected function range()
    {
        return $this->end > $this->start ? $this->end - $this->start : $this->start - $this->end;
    }

    protected function step($number)
    {
        return $this->range() / $number;
    }

    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate()
    {
        $result = [];
        for ($i = 1; $i <= $this->number; $i++) {
            $step = $this->step($this->number);
            if( $this->asc() ){
                $value = $i * $step;
            } else {
                $value = ($this->number - $i + 1) * $step;
            }
            $result[] = $this->generateStep($value);
        }
        return $result;
    }

    abstract protected function generateStep($value);
}
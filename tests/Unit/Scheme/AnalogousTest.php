<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Analogous;
use wwaz\Colormodel\Model\RGB;

final class AnalogousTest extends TestCase
{
    public function testScheme(): void
    {
        $colors = (new Analogous(new RGB(255, 0, 0)))->get();
        $this->assertSame($colors[0]->toRgb()->toString(), '255,0,128');
        $this->assertSame($colors[1]->toRgb()->toString(), '255,0,0');
        $this->assertSame($colors[2]->toRgb()->toString(), '255,128,0');
    }
}
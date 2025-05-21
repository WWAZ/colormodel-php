<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Shade;
use wwaz\Colormodel\Model\RGB;

final class ShadeTest extends TestCase
{
    public function testScheme(): void
    {
        $colors = (new Shade(new RGB(255, 0, 0), 5))->get();
        $this->assertSame($colors[0]->toRgb()->toString(), '255,0,0');
        $this->assertSame($colors[1]->toRgb()->toString(), '204,0,0');
        $this->assertSame($colors[2]->toRgb()->toString(), '153,0,0');
        $this->assertSame($colors[3]->toRgb()->toString(), '102,0,0');
        $this->assertSame($colors[4]->toRgb()->toString(), '51,0,0');
    }
}
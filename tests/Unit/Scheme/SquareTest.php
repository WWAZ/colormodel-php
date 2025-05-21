<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Square;
use wwaz\Colormodel\Model\RGB;

final class SquareTest extends TestCase
{
    public function testScheme(): void
    {
        $colors = (new Square(new RGB(255, 0, 0)))->get();
        $this->assertSame($colors[0]->toRgb()->toString(), '255,0,0');
        $this->assertSame($colors[1]->toRgb()->toString(), '128,255,0');
        $this->assertSame($colors[2]->toRgb()->toString(), '255,0,255');
        $this->assertSame($colors[3]->toRgb()->toString(), '255,0,128');
    }
}
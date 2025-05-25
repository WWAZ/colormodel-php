<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Complementary;
use wwaz\Colormodel\Model\RGB;

final class ComplementaryTest extends TestCase
{
    public function testScheme(): void
    {
        $colors = (new Complementary(new RGB(255, 0, 0)))->get();
        $this->assertSame($colors[0]->toRgb()->toString(), '255,0,0');
        $this->assertSame($colors[1]->toRgb()->toString(), '0,255,255');

        $colors = (new Complementary(new \wwaz\Colormodel\Model\CMYKInt(100, 0, 0, 0)))->get();
        $this->assertSame($colors[0]->toString(), '100,0,0,0');
        $this->assertSame($colors[1]->toString(), '0,100,100,0');
    }
}
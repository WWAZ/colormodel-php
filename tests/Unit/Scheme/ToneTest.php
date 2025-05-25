<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Tone;
use wwaz\Colormodel\Model\RGB;

final class ToneTest extends TestCase
{
    public function testScheme(): void
    {
        $colors = (new Tone(new RGB(255, 0, 0), 5))->get();
        $this->assertSame($colors[0]->toRgb()->toString(), '255,0,0');
        $this->assertSame($colors[1]->toRgb()->toString(), '204,41,41');
        $this->assertSame($colors[2]->toRgb()->toString(), '153,61,61');
        $this->assertSame($colors[3]->toRgb()->toString(), '102,61,61');
        $this->assertSame($colors[4]->toRgb()->toString(), '51,41,41');
    }
}
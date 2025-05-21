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
        $this->assertSame($colors[1]->toRgb()->toString(), '255,51,51');
        $this->assertSame($colors[2]->toRgb()->toString(), '255,102,102');
        $this->assertSame($colors[3]->toRgb()->toString(), '255,153,153');
        $this->assertSame($colors[4]->toRgb()->toString(), '255,204,204');
    }
}
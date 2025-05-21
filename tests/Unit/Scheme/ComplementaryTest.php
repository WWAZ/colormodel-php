<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Scheme\Complementary;
use wwaz\Colormodel\Model\RGB;

final class ComplementaryTest extends TestCase
{
    public function testScheme(): void
    {
        $rgb = (new Complementary(new RGB(255, 0, 0)))->get();
        $this->assertSame($rgb->toString(), '0,255,255');
    }
}
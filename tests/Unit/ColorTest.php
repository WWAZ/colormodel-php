<?php

declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use wwaz\Colormodel\Model\RGB;

final class ColorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testLightness(): void
    {
        $Color = new RGB(255, 255, 255);
        $this->assertSame($Color->lightness(), 765);
        $this->assertSame($Color->isLight(), true);
        $this->assertSame($Color->isDark(), false);

        $this->assertSame($Color->textColorHard()->toHTML(), '#000');
    }

    public function testColorWebsafe(): void
    {
        $Color = new RGB(0, 161, 243);
        $this->assertSame($Color->websafe()->toString(), '0,153,255');
    }
}
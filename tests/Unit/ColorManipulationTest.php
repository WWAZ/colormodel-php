<?php

declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use wwaz\Colormodel\Model\RGB;
use wwaz\Colormodel\Model\RGBA;

final class ColorManipulationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testColorGrayscale(): void
    {
        $Color = new RGB(255, 0, 0);
        $this->assertSame($Color->grayscale()->toString(), '77,77,77');

        $Color = new RGBA(255, 0, 0, 0.5);
        $this->assertSame($Color->grayscale()->toString(), '77,77,77,0.5');
    }

    public function testColorHue(): void
    {
        // Testvalues from Adobe Illustrator
        // 1) RGB 255, 0, 0
        // 2) Switch to HSB
        // 3) Change H = 180
        // 4) Read value from RGB

        $Color = new RGB(255, 0, 0);
        $this->assertSame($Color->hue(180)->toString(), '0,255,255');

        $Color = new RGBA(255, 0, 0, 0.5);
        $this->assertSame($Color->hue(180)->toString(), '0,255,255,0.5');
    }

    public function testColorSaturation(): void
    {
        $Color = new RGB(255, 0, 0);
        $this->assertSame($Color->saturation(-100)->toString(), '255,255,255');
        $this->assertSame($Color->saturation(-5)->toString(), '255,13,13');

        $Color = new RGBA(255, 0, 0, 0.5);
        $this->assertSame($Color->saturation(-100)->toString(), '255,255,255,0.5');
    }

    public function testColorBrightness(): void
    {
        // Testvalues from Adobe Illustrator
        // 1) RGB 255, 0, 0
        // 2) Switch to HSB
        // 3) Change B = 0-100
        // 4) Read value from RGB

        $Color = new RGB(255, 0, 0);
        $this->assertSame($Color->brightness(100)->toString(), '255,0,0');
        $this->assertSame($Color->brightness(50)->toString(), '128,0,0');
        $this->assertSame($Color->brightness(0)->toString(), '0,0,0');

        $Color = new RGBA(255, 0, 0, 0.5);
        $this->assertSame($Color->brightness(50)->toString(), '128,0,0,0.5');
    }
}
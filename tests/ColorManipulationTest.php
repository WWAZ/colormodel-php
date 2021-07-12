<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use wwaz\phpcolorbase\Exceptions\InvalidArgumentException;
use wwaz\phpcolorbase\Model\RGB;
use wwaz\phpcolorbase\Model\RGBA;
use wwaz\phpcolorbase\Model\CMYK;


final class ColorManipulationTest extends TestCase{

  protected function setUp() : void
  {
    parent::setUp();
  }


  public function testColorGrayscale() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->grayscale()->toString(), '77,77,77');

    $Color = new RGBA(255,0,0,0.5);
    $this->assertSame($Color->grayscale()->toString(), '77,77,77,0.5');
  }

  public function testColorHue() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->hue(180)->toString(), '0,161,243');

    $Color = new RGBA(255,0,0,0.5);
    $this->assertSame($Color->hue(180)->toString(), '0,161,243,0.5');
  }

  public function testColorSaturation() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->saturation(-100)->toString(), '255,255,255');
    $this->assertSame($Color->saturation(-5)->toString(), '255,13,13');

    $Color = new RGBA(255,0,0,0.5);
    $this->assertSame($Color->saturation(-100)->toString(), '255,255,255,0.5');
  }

  public function testColorBrightness() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->brightness(100)->toString(), '255,255,255');
    $this->assertSame($Color->brightness(50)->toString(), '255,189,137');
    $this->assertSame($Color->brightness(0)->toString(), '255,0,0');
    $this->assertSame($Color->brightness(-100)->toString(), '53,0,0');

    $Color = new RGBA(255,0,0,0.5);
    $this->assertSame($Color->brightness(100)->toString(), '255,255,255,0.5');
  }



}

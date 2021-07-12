<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;
use wwaz\Colormodel\Model\RGB;
use wwaz\Colormodel\Model\RGBA;
use wwaz\Colormodel\Model\CMYK;


final class ColorTest extends TestCase{

  protected function setUp() : void
  {
    parent::setUp();
  }


  public function testLightness() : void
  {
    $Color = new RGB(255,255,255);
    $this->assertSame($Color->lightness(), 765);
    $this->assertSame($Color->isLight(), true);
    $this->assertSame($Color->isDark(), false);
    $this->assertSame($Color->textColorHard()->shorten()->toString(), '000');
    $this->assertSame($Color->textColorSoft()->shorten()->toString(), '6A6A6A');
  }


  public function testColorWebsafe() : void
  {
    $Color = new RGB(0,161,243);
    $this->assertSame($Color->websafe()->toString(), '0,153,255');
  }




}

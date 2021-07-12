<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use wwaz\phpcolorbase\Exceptions\InvalidArgumentException;
use wwaz\phpcolorbase\Model\RGBA;


final class RGBATest extends TestCase{

  protected function setUp() : void
  {
    parent::setUp();
  }


  public function testInit() : void
  {
    $Color = new RGBA(255,0,0,1);
    $this->assertSame($Color->toString(), '255,0,0,1');

    $Color = new RGBA('255,0,0,0.5');
    $this->assertSame($Color->toString(), '255,0,0,0.5');

    $Color = new RGBA([255,0,0,0]);
    $this->assertSame($Color->toString(), '255,0,0,0');

    $Color = new RGBA([
      'r' => 255,
      'g' => 0,
      'b' => 0,
      'a' => 1
    ]);
    $this->assertSame($Color->toString(), '255,0,0,1');

    $Color = new RGBA([
      'red' => 255,
      'green' => 0,
      'blue' => 0,
      'alpha' => .5
    ]);
    $this->assertSame($Color->toString(), '255,0,0,0.5');

    $this->assertSame($Color->type(), 'rgba');

    $this->assertSame($Color->toArray(), [255,0,0,0.5]);
    $this->assertSame($Color->toAssociativeArray(), ['r' => 255, 'g' => 0, 'b' => 0, 'a' => 0.5]);

    $this->assertSame($Color->toHTML(), 'rgba(255,0,0,0.5)');
  }


  public function testInitException() : void
  {
    $this->expectException(InvalidArgumentException::class);
    $Color = new RGBA(300,0,0,0);
    $Color = new RGBA(255,0,0);
    $Color = new RGBA(255,0,0,4);
  }

  public function testConvert() : void
  {
    $Color = new RGBA(255,0,0,1);
    $this->assertSame($Color->toRGBA()->toString(), '255,0,0,1');
    $this->assertSame($Color->toCMYK()->toString(), '0,1,1,0');
    $this->assertSame($Color->toCMYKInt()->toString(), '0,100,100,0');
    $this->assertSame($Color->toHex()->toString(), 'FF0000');

    $this->assertSame($Color->toHTML(), 'rgba(255,0,0,1)');
    $this->assertSame($Color->toHTMLAlpha(), 'rgba(255,0,0,1)');
    $this->assertSame($Color->toHTMLAlpha(0.5), 'rgba(255,0,0,0.5)');

    $this->assertTrue(is_string( $Color->ToYxy()->toString() ));
    $this->assertTrue(is_string( $Color->ToXYZ()->toString() ));
    $this->assertTrue(is_string( $Color->ToHSV()->toString() ));
    $this->assertTrue(is_string( $Color->ToHSL()->toString() ));
    $this->assertTrue(is_string( $Color->ToCMY()->toString() ));
    $this->assertTrue(is_string( $Color->ToCIELCh()->toString() ));
    $this->assertTrue(is_string( $Color->ToCIELab()->toString() ));
  }


}

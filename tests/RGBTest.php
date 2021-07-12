<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;
use wwaz\Colormodel\Model\RGB;


final class RGBTest extends TestCase{

  protected function setUp() : void
  {
    parent::setUp();
  }


  public function testInit() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->toString(), '255,0,0');

    $Color = new RGB('255,0,0');
    $this->assertSame($Color->toString(), '255,0,0');

    $Color = new RGB([255,0,0]);
    $this->assertSame($Color->toString(), '255,0,0');

    $Color = new RGB([
      'r' => 255,
      'g' => 0,
      'b' => 0
    ]);
    $this->assertSame($Color->toString(), '255,0,0');

    $Color = new RGB([
      'red' => 255,
      'green' => 0,
      'blue' => 0
    ]);
    $this->assertSame($Color->toString(), '255,0,0');

    $this->assertSame($Color->type(), 'rgb');

    $this->assertSame($Color->toString(), '255,0,0');
    $this->assertSame($Color->toArray(), [255,0,0]);
    $this->assertSame($Color->toAssociativeArray(), ['r' => 255, 'g' => 0, 'b' => 0]);

  }


  public function testInitException() : void
  {
    $this->expectException(InvalidArgumentException::class);
    $Color = new RGB(300,0,0);
  }

  public function testConvert() : void
  {
    $Color = new RGB(255,0,0);
    $this->assertSame($Color->toRGB()->toString(), '255,0,0');
    $this->assertSame($Color->toRGBA(0.5)->toString(), '255,0,0,0.5');
    $this->assertSame($Color->toCMYK()->toString(), '0,1,1,0');
    $this->assertSame($Color->toCMYKInt()->toString(), '0,100,100,0');
    $this->assertSame($Color->toHex()->toString(), 'FF0000');

    $this->assertSame($Color->toHTML(), '#f00');
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

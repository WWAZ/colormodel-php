<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;
use wwaz\Colormodel\Model\HEX;


final class HEXTest extends TestCase{

  protected function setUp() : void
  {
    parent::setUp();
  }

  public function testInit() : void
  {
    $Color = new HEX('#ff0000');
    $this->assertSame($Color->toString(), 'FF0000');

    $Color = new HEX('ff0000');
    $this->assertSame($Color->toString(), 'FF0000');

    $Color = new HEX(0xff0000);
    $this->assertSame($Color->toString(), 'FF0000');

    $Color = new HEX('red');
    $this->assertSame($Color->toString(), 'FF0000');

    $Color = new HEX('Red');
    $this->assertSame($Color->toString(), 'FF0000');

    $this->assertSame($Color->type(), 'hex');

    $this->assertSame($Color->toArray(), false);
    $this->assertSame($Color->toAssociativeArray(), false);

    $this->assertSame($Color->shorten()->toString(), 'F00');

    $this->assertSame($Color->toHTML(), '#f00');

    $Color = new HEX('ff4c1b');
    $this->assertSame($Color->toHTML(), '#ff4c1b');

  }


  public function testInitException() : void
  {
    $this->expectException(InvalidArgumentException::class);
    $Color = new HEX('ZZZ');
  }

  public function testConvert() : void
  {
    $Color = new HEX('#ff0000');
    $this->assertSame($Color->toHEX()->toString(), 'FF0000');
    $this->assertSame($Color->toRGB()->toString(), '255,0,0');
    $this->assertSame($Color->toRGBA(0.5)->toString(), '255,0,0,0.5');
    $this->assertSame($Color->toCMYK()->toString(), '0,1,1,0');
    $this->assertSame($Color->toCMYKInt()->toString(), '0,100,100,0');

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

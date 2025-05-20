<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;
use wwaz\Colormodel\Model\CMYK;

final class CMYKTest extends TestCase
{
    
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testInit(): void
    {
        $Color = new CMYK(1, 0, 0, 0);
        $this->assertSame($Color->toString(), '1,0,0,0');

        $Color = new CMYK('1,0,0,0');
        $this->assertSame($Color->toString(), '1,0,0,0');

        $Color = new CMYK([1, 0, 0, 0]);
        $this->assertSame($Color->toString(), '1,0,0,0');

        $Color = new CMYK([100, 0, 0, 0]);
        $this->assertSame($Color->toString(), '1,0,0,0');

        $Color = new CMYK(['100', '50', '0', '0']);
        $this->assertSame($Color->toString(), '1,0.5,0,0');

        $Color = new CMYK([
            'c' => 1,
            'm' => 0,
            'y' => 0,
            'k' => 0,
        ]);
        $this->assertSame($Color->toString(), '1,0,0,0');

        $Color = new CMYK([
            'cyan'    => 1,
            'magenta' => 0,
            'yellow'  => 0,
            'key'     => 0,
        ]);
        $this->assertSame($Color->toString(), '1,0,0,0');

        $this->assertSame($Color->toString(), '1,0,0,0');
        $this->assertSame($Color->toArray(), [1.0, 0.0, 0.0, 0.0]);
        $this->assertSame($Color->toAssociativeArray(), ['c' => 1.0, 'm' => 0.0, 'y' => 0.0, 'k' => 0.0]);

        $this->assertSame($Color->type(), 'cmyk');

        $Color = new CMYK([.943, 0.222, 0.445, 0]);
        $this->assertSame($Color->toString(), '0.943,0.222,0.445,0');
        // Round by 2
        $this->assertSame($Color->toString(null, 2), '0.94,0.22,0.45,0');
        $this->assertSame($Color->toArray(2), [0.94, 0.22, 0.45, 0.0]);
        // Round by 1
        $this->assertSame($Color->toString(null, 1), '0.9,0.2,0.4,0');
    }

    // public function testInitException(): void
    // {
    //     $this->expectException(InvalidArgumentException::class);
    //     $Color = new CMYK(2, 0, 0, 0);
    // }

    public function testConvert(): void
    {
        $Color = new CMYK(1, 0, 0, 0);
        $this->assertSame($Color->toCMYKInt()->toString(), '100,0,0,0');
        $this->assertSame($Color->toRGB()->toString(), '0,255,255');
        $this->assertSame($Color->toRGBA(0.5)->toString(), '0,255,255,0.5');
        $this->assertSame($Color->toHex()->toString(), '00FFFF');

        $this->assertSame($Color->toHTML(), '#0ff');
        $this->assertSame($Color->toHTMLAlpha(), 'rgba(0,255,255,1)');
        $this->assertSame($Color->toHTMLAlpha(0.5), 'rgba(0,255,255,0.5)');

        $this->assertTrue(is_string($Color->ToYxy()->toString()));
        $this->assertTrue(is_string($Color->ToXYZ()->toString()));
        $this->assertTrue(is_string($Color->ToHSV()->toString()));
        $this->assertTrue(is_string($Color->ToHSL()->toString()));
        $this->assertTrue(is_string($Color->ToCMY()->toString()));
        $this->assertTrue(is_string($Color->ToCIELCh()->toString()));
        $this->assertTrue(is_string($Color->ToCIELab()->toString()));
    }

}

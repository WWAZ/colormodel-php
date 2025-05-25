# Color model for PHP

The generation and conversion of colors between different color spaces can be quite simple. Calculating color transformations or variations as well:

	$color = (new Hex('#f00')) 	
		->hue(180)	
		->toCMYK();
		
	echo $color->toString(); // 100,0,0,0

## Requirements

- PHP ^8.0

## Install

    $ composer require wwaz/colormodel-php
   
## Color construction

### Hex
HEX colors use the format #RRGGBB, based on 8-bit values per color channel (00–FF). Internally, #FF0000 corresponds to rgb(255, 0, 0), for example. A shorter notation like #F00 is possible when both characters per channel are identical. 
HEX is common in UI design and web development for defining colors in HTML and CSS. It’s concise, widely supported, and easy to copy or share.

	use wwaz\Colormodel\Model\HEX;
	
	new HEX('f00');
	new HEX('#f00');
	new HEX('#ff0000');
	new HEX('FF0000');
	new HEX(0xff0000);
	new HEX('red');


### RGB
RGB describes colors using three integers from 0 to 255 for red, green, and blue: rgb(255, 0, 0) produces pure red. It is based on additive color mixing, where light colors are combined — full intensity of all three channels (255, 255, 255) results in white. 
RGB is used in digital graphics and UI work where fine-tuned color manipulation is needed. Prefer RGB over HEX when working programmatically with color values – it's easier to manipulate individual channels or apply effects like blending and gradients.

	use wwaz\Colormodel\Model\RGB;
	
	new RGB(255, 0, 0);
	new RGB('255, 0, 0');
	new RGB(['r' => 255, 'g' => 0, 'b' => 0]);
	new RGB(['red' => 255, 'green' => 0, 'blue' => 0]);
	new RGB('red');

### RGBA

RGBA extends RGB by adding an alpha channel for transparency: rgba(r, g, b, a). The alpha value ranges from 0 (fully transparent) to 1 (fully opaque), e.g., rgba(255, 0, 0, 0.5) for semi-transparent red. Use RGBA when you need to control both color and opacity in one declaration.

	use wwaz\Colormodel\Model\RGBA;

	new RGBA(255, 0, 0, 0.5);
	new RGBA('255, 0, 0, 0.5');
	new RGBA(['r' => 255, 'g' => 0, 'b' => 0, 'a' => 0.5]);
	new RGBA(['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 0.5]);
	new RGBA('red');


### HSB

HSB stands for Hue (0–360°), Saturation (0–100%), and Brightness (0–100%). It aligns more closely with human color perception than RGB. It's ideal for color picker tools, since it allows separate control over hue, intensity, and brightness. Also known as HSV.
Use case: Great for color pickers or tools where intuitive color adjustment is needed based on hue, saturation, and brightness.
Dev tip: Use HSB when you want to let users adjust color visually – it’s more human-friendly than RGB for tweaking tones and intensities.

	use wwaz\Colormodel\Model\HSB;

	new HSB(0, 100, 50);
	new HSB('0, 100, 50');
	new HSB(['h' => 0, 's' => 100, 'b' => 50]);
	new HSB(['hue' => 0, 'saturation' => 100, 'brightness' => 50]);
	new HSB('red');

### HSV

HSV stands for Hue (0–360°), Saturation, and Value (both 0–100%). It’s very similar to HSB, where Value represents brightness. The main idea is to separate the color tone (hue) from its intensity (saturation) and lightness (value), which makes it easier to work with for color adjustments, especially in graphics and image editing tools. It’s often used alongside or interchangeably with HSB, since they describe essentially the same model.

	use wwaz\Colormodel\Model\HSV;

	new HSV(0, 100, 50);
	new HSV('0, 100, 50');
	new HSV(['h' => 0, 's' => 100, 'v' => 50]);
	new HSV(['hue' => 0, 'saturation' => 100, 'value' => 50]);
	new HSV('red');

### HSL

HSL stands for Hue (0–360°), Saturation, and Lightness (each 0–100%). Unlike HSB/HSV, Lightness in HSL describes brightness symmetrically: 0% is black, 50% is pure color, and 100% is white.

	use wwaz\Colormodel\Model\HSL;
	
	new HSL(0, 100, 50);
	new HSL('0, 100, 50');
	new HSL(['h' => 0, 's' => 100, 'l' => 50]);
	new HSL(['hue' => 0, 'saturation' => 100, 'lightness' => 50]);
	new HSL('red');

### CMYK

CMYK stands for Cyan, Magenta, Yellow, and Key (Black) and is used in four-color printing. Color values range from 0–100%. Unlike RGB, CMYK is based on subtractive color mixing: the more color you add, the darker the result. Web browsers don’t directly support CMYK—it’s mainly relevant for print design. 

	use wwaz\Colormodel\Model\CMYK;

	new CMYK(1, 0, 0, 0);
	new CMYK(100, 0, 0, 0);
	new CMYK('1, 0, 0, 0');
	new CMYK('100, 0, 0, 0');
	new CMYK(['c' => 1, 'm' => 0, 'y' => 0, 'k' => 0]);
	new CMYK(['cyan' => 100, 'magenta' => 0, 'yellow' => 0, 'key' => 0]);
	new CMYK('cyan');

	$color = new CMYK(1, 0, 0, 0);
	$color->toArray(); // [1, 0, 0, 0]

### CMYKInt

Prefer working with CMYK integer values instead of floats? Then use CMYKInt:

	use wwaz\Colormodel\Model\CMYKInt;

	$color = new CMYKInt(100, 0, 0, 0);
	$color->toArray(); // [100, 0, 0, 0]

Or convert standard CMYK to integer values:
	
	$color = new CMYK(1, 0, 0, 0);
	$color->toCMYKInt()->toArray(); // [100, 0, 0, 0]
	

### CIELab

CIELab describes colors based on perception, using three axes: L (lightness, 0–100), a (green–red), and b (blue–yellow). It’s device-independent and perceptually uniform—meaning that equal numeric differences roughly correspond to equal visual differences. It’s commonly used in color comparison, image processing, and color management.

	use wwaz\Colormodel\Model\CIELab;

	new CIELab(53, 80, 67);
	new CIELab('53, 80, 67');
	new CIELab(['lightness' => 53, 'a' => 80, 'n' => 67]);
	new CIELab(['l' => 53, 'a' => 80, 'b' => 67]);
	new CIELab('red');
	
### CIELCh

CIELCh is the cylindrical transformation of CIELab, using L (lightness), C (chroma, color saturation), and h (hue, color angle in degrees). It makes color distance and hue more intuitively controllable. Ideal for precise color gradation, especially in scientific or typographic contexts. It’s also more visually linear than Lab, meaning transitions look smoother to the human eye.

	use wwaz\Colormodel\Model\CIELCh;

	new CIELCh(53, 105, 40);
	new CIELCh('53, 105, 67');
	new CIELCh(['lightness' => 53, 'chroma' => 105, 'hue' => 40]);
	new CIELCh(['l' => 53, 'c' => 105, 'h' => 40]);
	new CIELCh('red');

### XYZ

CIEXYZ is a device-independent, linear color model that serves as the foundation for many other color spaces. It represents colors using three components: X, Y (lightness), and Z (blue component). Developed in 1931 based on human color perception, it’s often used as a reference space for color conversions and transformations.

	use wwaz\Colormodel\Model\XYZ;

	new XYZ(41, 21, 2);
	new XYZ('41, 21, 2');
	new XYZ(['x' => 41, 'y' => 21, 'z' => 2]);
	new XYZ('red');

## Conversion

The mathematical conversion from one color space to another is incredibly simple:

	use wwaz\Colormodel\Model\HEX;
	
	echo (new HEX('red'))
		->toHSB()
		->hue(100)
		->toRGB()
		->toString(); // 85,255,0

## Output

No matter which output format you need to keep going – pick one of the following:
	
	use wwaz\Colormodel\Model\HEX;

	$color = new HEX('red');
	
	$color->toString(); 	// 255,0,0
	$color->toHtml(); 	 	// rgb(255,0,0)
	$color->toArray(); 		// [255, 0, 0]
	$color->toAssoc();		// ['r' => 255, 'g' => 0, 'b' => 0]

## Mixing colors

Assume you want to mix `#FF0000` (red) and `#0000FF` (blue) → this results in purple (`#800080`):
	
	use wwaz\Colormodel\Model\HEX;

	$color = new Hex('f00');
	$color->mix(new Hex('00f'))->toString(); // 800080

As long as you don’t choose a different mixing ratio, the colors will be mixed in equal parts, meaning 50/50. However, you can change this value by adjusting the weight of the new color value. Here, we’re choosing a weighting of 0.25 – this results in a 75/25 mixing ratio:

	use wwaz\Colormodel\Model\HEX;

	$color->mix(new Hex('00f'), .25)->toString(); // BF0040


## Color schemes

Need color variations? 
	
	use wwaz\Colormodel\Model\RGB;

	$color = new RGB(255, 0, 0);
	
	(new wwaz\Colormodel\Scheme\Complementary($color))->get(); 
			// Array of RGB color models. Values: ['255,0,0', '0,255,255']
			
	(new wwaz\Colormodel\Scheme\Tetradic($color)->get();
	(new wwaz\Colormodel\Scheme\Triadic($color)->get();
	(new wwaz\Colormodel\Scheme\Square($color)->get();
	(new wwaz\Colormodel\Scheme\Analogous($color)->get();
	(new wwaz\Colormodel\Scheme\Tint($color)->get();
	(new wwaz\Colormodel\Scheme\Tone($color)->get();
	(new wwaz\Colormodel\Scheme\Shade($color)->get();
	
And yes – color variations work across all color models:

	$color = new CMYKInt(100, 0, 0, 0);
	(new Cwwaz\Colormodel\Schemeomplementary($color))->get();
			// Array of CMYK color models. Values: ['100,0,0,0', '0,100,100,0']
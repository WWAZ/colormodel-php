<?php


namespace wwaz\Colormodel\Model;

use wwaz\Colormodel\Exceptions\InvalidArgumentException;

/**
 * CMYK color model
 */
class CMYK extends Color{

  /**
    * When true,
    * input and output representation
    * of values is in intValues.
    * e.g. 0,100,0,0
    *
    * @var bool
    */
  protected $intValues = false;

  /**
   * The cyan
   *
   * @var float
   */
  public $cyan;

  /**
   * The magenta
   *
   * @var float
   */
  public $magenta;

  /**
   * The yellow
   *
   * @var float
   */
  public $yellow;

  /**
   * The key (black)
   *
   * @var float
   */
  public $key;

  /**
   * Create a new CMYK color
   *
   * @param float|string|array $cyan – cyan
   * or string or array representation
   * 1
   * || '1,0,0,.2'
   * || [1,0,0,.2]
   * || ['c' => 1, 'm' => 0, 'y' => 0, => 'k' => .2]
   * || ['cyan' => 100, 'magenta' => 0, 'yellow' => 0, => 'key' => .2]
   * @param float $magenta The magenta
   * @param float $yellow The yellow
   * @param float $key The key (black)
   */
  public function __construct($cyan, float $magenta = null, float $yellow = null, float $key = null){

    $this->toSelf = "toCMYK";

    $this->init([
      [
        'key' => 'cyan',
        'val' => $cyan,
        'type' => 'float'
      ],
      [
        'key' => 'magenta',
        'val' => $magenta,
        'type' => 'float'
      ],
      [
        'key' => 'yellow',
        'val' => $yellow,
        'type' => 'float'
      ],
      [
        'key' => 'key',
        'val' => $key,
        'type' => 'float'
      ]
    ]);

  }

  /**
   * Sets value for given key
   *
   * @param string $key
   * @param mixed $value
   */
  protected function setKey($key, $value){
    if( $value > 1){
      throw new InvalidArgumentException('CMYK Values to big!');
    }
    $this->$key = $value;
  }

  /**
   * Creates a CMYK color object statically
   */
  public static function create($cyan, $magenta = null, $yellow = null, $key = null){
    return new CMYK($cyan, $magenta, $yellow, $key);
  }

  /**
   * Get the amount of Cyan
   *
   * @return int The amount of cyan
   */
  public function getCyan(){
    if( $this->intValues ){
      return round($this->cyan * 100, 0);
    }
    return $this->cyan;
  }


  /**
   * Get the amount of Magenta
   *
   * @return int The amount of magenta
   */
  public function getMagenta(){
    if( $this->intValues ){
      return round($this->magenta * 100, 0);
    }
    return $this->magenta;
  }


  /**
   * Get the amount of Yellow
   *
   * @return int The amount of yellow
   */
  public function getYellow(){
    if( $this->intValues ){
      return round($this->yellow * 100, 0);
    }
    return $this->yellow;
  }


  /**
   * Get the key (black)
   *
   * @return int The amount of black
   */
  public function getKey(){
    if( $this->intValues ){
      return round($this->key * 100, 0);
    }
    return $this->key;
  }

  // /**
  //  * Shortcut for getCyan()
  //  *
  //  * @return int The amount of cyan
  //  */
  // public function cyan(){
  //   return $this->getCyan();
  // }
  //
  // /**
  //  * Shortcut for getMagenta()
  //  *
  //  * @return int The amount of magenta
  //  */
  // public function magenta(){
  //   return $this->getMagenta();
  // }
  //
  // /**
  //  * Shortcut for getYellow()
  //  *
  //  * @return int The amount of yellow
  //  */
  // public function yellow(){
  //   return $this->getYellow();
  // }
  //
  // /**
  //  * Shortcut for getKey()
  //  *
  //  * @return int The amount of key
  //  */
  // public function key(){
  //   return $this->getKey();
  // }

  /**
   * Convert the color to CMYKInt format
   *
   * @return \wwaz\Colormodel\Model\CMYKInt the color in Hex format
   */
  public function toCMYKInt(){
    return new CMYKInt($this->cyan * 100, $this->magenta * 100, $this->yellow * 100, $this->key * 100);
  }

  /**
   * Convert the color to Hex format
   *
   * @return \wwaz\Colormodel\Model\Hex the color in Hex format
   */
  public function toHex(){
    return $this->toRGB()->toHex();
  }

  /**
   * Convert the color to RGB format
   *
   * @return \wwaz\Colormodel\Model\RGB the color in RGB format
   */
  public function toRGB(){
    return $this->toCMY()->toRGB();
  }

  /**
   * Convert the color to RGBA format
   *
   * @param float $alpha
   * @return \wwaz\Colormodel\Model\RGBA the color in RGBA format
   */
  public function toRGBA($alpha = 1){
    $rgb = $this->toRGB()->toArray();
    $rgb[] = $alpha;
    return new RGBA( $rgb );
  }

  /**
   * Convert the color to XYZ format
   *
   * @return \wwaz\Colormodel\Model\XYZ the color in XYZ format
   */
  public function toXYZ(){
    return $this->toRGB()->toXYZ();
  }

  /**
   * Convert the color to Yxy format
   *
   * @return \wwaz\Colormodel\Model\Yxy the color in Yxy format
   */
  public function toYxy(){
    return $this->toXYZ()->toYxy();
  }

  /**
   * Convert the color to HSL format
   *
   * @return \wwaz\Colormodel\Model\HSL the color in HSL format
   */
  public function toHSL(){
    return $this->toHSV()->toHSL();
  }

  /**
   * Convert the color to HSV format
   *
   * @return \wwaz\Colormodel\Model\HSV the color in HSV format
   */
  public function toHSV(){
    return $this->toRGB()->toHSV();
  }

  /**
   * Convert the color to HSB format
   *
   * @return \wwaz\Colormodel\Model\HSB the color in HSB format
   */
  public function toHSB(){
    return $this->toRGB()->toHSB();
  }

  /**
   * Convert the color to CMY format
   *
   * @return \wwaz\Colormodel\Model\CMY the color in CMY format
   */
  public function toCMY(){
    $cyan = ($this->cyan * (1 - $this->key) + $this->key);
    $magenta = ($this->magenta * (1 - $this->key) + $this->key);
    $yellow = ($this->yellow * (1 - $this->key) + $this->key);
    return new CMY($cyan, $magenta, $yellow);
  }

  /**
   * Convert the color to CMYK format
   *
   * @return \wwaz\Colormodel\Model\CMYK the color in CMYK format
   */
  public function toCMYK(){
    return $this;
  }

  /**
   * Convert the color to CIELab format
   *
   * @return \wwaz\Colormodel\Model\CIELab the color in CIELab format
   */
  public function toCIELab(){
    return $this->toRGB()->toCIELab();
  }

  /**
   * Convert the color to CIELCh format
   *
   * @return \wwaz\Colormodel\Model\CIELCh the color in CIELCh format
   */
  public function toCIELCh(){
    return $this->toCIELab()->toCIELCh();
  }


  /**
   * Returns color as string
   *
   * @param boolean $beautify
   * @param int $round
   * @return string
   */
  public function toString($beautify = null, $round = 0){
    $cmyk = $this->toAssociativeArray($round);
    $cmyk = $cmyk['c'] . ',' . $cmyk['m'] . ',' . $cmyk['y'] . ',' . $cmyk['k'];
    if( $beautify ){
      return str_replace(',', ', ', $cmyk);
    }
    return $cmyk;
  }


  /**
   * Returns color as indexed array
   *
   * @return array
   */
  public function toArray(int $round = 0){
    $cmyk = $this->toAssociativeArray($round);
    return [$cmyk['c'], $cmyk['m'], $cmyk['y'], $cmyk['k']];
  }


  /**
   * Returns color as associative array
   *
   * @return array
   */
  public function toAssociativeArray(int $round = 0){
    if( $round ){
      return [
        'c' => round($this->getCyan(), $round),
        'm' => round($this->getMagenta(), $round),
        'y' => round($this->getYellow(), $round),
        'k' => round($this->getKey(), $round)
      ];
    }
    return ['c' => $this->getCyan(), 'm' => $this->getMagenta(), 'y' => $this->getYellow(), 'k' => $this->getKey()];
  }
}

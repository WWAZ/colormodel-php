<?php

namespace wwaz\Colormodel\Model;

/**
 * CMYKInt color model
 * extends CMYK. The difference between the two objects is that
 * CMYKInt is constructed and will return integer color values.
 * ex. [100,0,0,0]
 */
class CMYKInt extends CMYK
{
    /**
     * When true,
     * input and output representation
     * of values is in intValues.
     * ex. 0,100,0,0
     *
     * @var bool
     */
    protected $intValues = true;

    /**
     * Create a new CMYK color
     *
     * @param int|string|array $cyan – cyan int
     * or string or array representation
     * 100
     * || '100,0,0,0'
     * || [100,0,0,0]
     * || ['c' => 100, 'm' => 0, 'y' => 0, => 'k' => 0]
     * || ['cyan' => 100, 'magenta' => 0, 'yellow' => 0, => 'key' => 0]
     * @param float $magenta - magenta
     * @param float $yellow - yellow
     * @param float $key - key (black)
     */
    public function __construct(int|string|array $cyan, int $magenta = null, int $yellow = null, int $key = null)
    {

        $this->toSelf = "toCMYKInt";

        if( !is_numeric($cyan) && is_string($cyan) && strpos($cyan, ',') === false  ){
            // Probalby color name
            if( $hex = $this->getColorFromName($cyan) ){
                [$cyan, $magenta, $yellow, $key] = $hex->toCMYKInt()->toArray();
                
            } else {
                throw new InvalidArgumentException('Color name "' . $cyan . '" does not exist');
            }
        }

        $this->init([
            [
                'key'  => 'cyan',
                'val'  => $cyan,
                'type' => 'int',
            ],
            [
                'key'  => 'magenta',
                'val'  => $magenta,
                'type' => 'int',
            ],
            [
                'key'  => 'yellow',
                'val'  => $yellow,
                'type' => 'int',
            ],
            [
                'key'  => 'key',
                'val'  => $key,
                'type' => 'int',
            ],
        ]);

    }

    public function __get($key)
    {
        if ($key === 'cyan') {
            die('!!!');
            return $this->getCyan();
        }
    }

    /**
     * Sets value for given key
     *
     * @param string $key
     * @param mixed $value
     */
    protected function setKey($key, $value)
    {
        $this->$key = $value / 100;
    }

    /**
     * Creates a CMYKInt color statically
     */
    public static function create($cyan, $magenta = null, $yellow = null, $key = null)
    {
        return new CMYKInt($cyan, $magenta, $yellow, $key);
    }
}
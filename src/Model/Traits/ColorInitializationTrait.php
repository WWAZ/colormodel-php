<?php

namespace wwaz\Colormodel\Model\Traits;

/**
 * Color model trait
 * Contains color initialization methods
 */
trait ColorInitializationTrait
{
    /**
     * Initializes color object
     *
     * @param array $params
     */
    protected function init($params)
    {

        $first['val']      = $params[0]['val'];
        $first['key']      = $params[0]['key'];
        $first['keyAlias'] = isset($params[0]['keyAlias']) ? $params[0]['keyAlias'] : false;
        $first['type']     = $params[0]['type'];
        $first['keyShort'] = substr($params[0]['key'], 0, 1);

        if (is_string($first['val'])) {
            $params = $this->initByString($params, $first);
        }
        if (is_array($first['val'])) {
            if (isset($first['val'][0])) {
                // Indexed array
                // like [255, 255, 255]
                $params = $this->initByIndexedArray($params, $first);
            }
            if (isset($first['val'][$first['keyShort']])) {
                // associative array short keys
                // like ['r' => 255, 'g' => 255, 'b' => 255]
                $params = $this->initByAsscociativeArrayShortKeys($params, $first);
            }
            if (isset($first['val'][$first['key']])) {
                // associative array full keys
                // like ['red' => 255, 'green' => 255, 'blue' => 255]
                $params = $this->initByAsscociativeArrayFullKeys($params, $first);
            }
        }

        foreach ($params as $index => $param) {
            if (isset($param['key']) && isset($param['val'])) {
                $this->setKey($param['key'], $param['val']);
            }
        }
        // print_r($params);
        return $params;
    }

    /**
     * Initializes color object by given string
     * Comma seperated string - e.g. 255,255,255
     *
     * @param array $params
     * @param array $first
     * @return array $params
     */
    private function initByString($params, $first)
    {
        if (strpos($first['val'], ',') !== false) {
            $arrval = explode(',', $first['val']);
            for ($i = 0; $i < count($arrval); $i++) {
                if ($first['type'] === 'float') {
                    $params[$i]['val'] = floatval($arrval[$i]);
                } else if ($first['type'] === 'int') {
                    $params[$i]['val'] = intVal($arrval[$i]);
                } else {
                    $params[$i]['val'] = $arrval[$i];
                }
            }
        }
        return $params;
    }

    /**
     * Initializes color object by given indexed array
     * e.g. [255,255,255]
     *
     * @param array $params
     * @param array $first
     * @return array $params
     */
    private function initByIndexedArray($params, $first)
    {
        for ($i = 0; $i < count($first['val']); $i++) {
            if ($first['type'] === 'float') {
                $params[$i]['val'] = floatval($first['val'][$i]);
            } else if ($first['type'] === 'int') {
                $params[$i]['val'] = intval($first['val'][$i]);
            } else {
                $params[$i]['val'] = $first['val'][$i];
            }
        }
        return $params;
    }

    /**
     * Initializes color object by given associative array
     * with short keys e.g. ['r' => 255, 'g' => 255, 'b' => 255]
     *
     * @param array $params
     * @param array $first
     * @return array $params
     */
    private function initByAsscociativeArrayShortKeys($params, $first)
    {
        for ($i = 0; $i < count($params); $i++) {

            // if( isset($params[$i]['keyAlias']) ){
            //   $short = substr($params[$i]['keyAlias'], 0, 1);
            // } else {
            //   $short = substr($params[$i]['key'], 0, 1);
            // }
            $short = substr($params[$i]['key'], 0, 1);

            if ($first['type'] === 'float') {
                $params[$i]['val'] = floatval($first['val'][$short]);
            } else if ($first['type'] === 'float') {
                $params[$i]['val'] = intval($first['val'][$short]);
            } else {
                $params[$i]['val'] = $first['val'][$short];
            }
        }

        return $params;
    }

    /**
     * Initializes color object by given associative array
     * with full keys e.g. ['red' => 255, 'green' => 255, 'blue' => 255]
     *
     * @param array $params
     * @param array $first
     * @return array $params
     */
    private function initByAsscociativeArrayFullKeys($params, $first)
    {
        for ($i = 0; $i < count($params); $i++) {
            // if( isset($params[$i]['keyAlias']) ){
            //   $key = $params[$i]['keyAlias'];
            // } else {
            //   $key = $params[$i]['key'];
            // }
            $key = $params[$i]['key'];
            if ($first['type'] === 'float') {
                $params[$i]['val'] = floatval($first['val'][$key]);
            } else if ($first['type'] === 'int') {
                $params[$i]['val'] = intval($first['val'][$key]);
            } else {
                $params[$i]['val'] = $first['val'][$key];
            }
        }
        return $params;
    }

    /**
     * Sets value for given key
     *
     * @param string $key
     * @param mixed $value
     */
    protected function setKey($key, $value)
    {
        $this->$key = $value;
    }
}
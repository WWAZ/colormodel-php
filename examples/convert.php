<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use wwaz\Colormodel\Model\Hex;
use wwaz\Colormodel\Model\HSB;

$color = new Hex('red');
print_r($color->toHSB()->toArray());

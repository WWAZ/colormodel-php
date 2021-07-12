<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use wwaz\Colormodel\Model\Hex;
use wwaz\Colormodel\Model\HSB;

// $color = new Hex('#97bf0d');
// $color = new Hex('46c0ed');
// $color = new Hex('fdc60c');
$color = new Hex('ff697b');
$color = $color->toHSB();

$t = $color->tintVariations(7, true);

$m = '';
for($i=0; $i<count($t); $i++){
  $m.= renderColor($t[$i]);
}
echo $m;


function renderColor($hsb){
  return '<div style="width: 50px; height: 50px; background: '.$hsb->toHex()->toHTML().'"></div>' . "<br>\n";
}

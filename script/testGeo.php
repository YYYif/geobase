<?php

require_once (__DIR__."/../vendor/autoload.php");
use GeoBase\GeoBaseEnum;
use GeoBase\GeoBaseInfo as Geo;

$geo = new Geo;
$path = dirname(__FILE__) . "/../map/";
//全部城市
/*$allNation   = $geo->getAllNationInfo();
$allProvince = $geo->getAllProvinceInfo();
$allCity     = $geo->getAllCityInfo();
$allDistrict = $geo->getAllDistrictInfo();
$allStreet   = $geo->getAllStreetInfo();*/
//单独查询
/*$nationGetById           = $geo->getNationById(0);
$nationGetByName         = $geo->getCityById(2920);
$nationGetByStandardCode = $geo->getNationByStandardCode(86);*/

$id = file_get_contents($path.'nation_province_ID.json');
$name = file_get_contents($path.'nation_province_Name.json');
$stan = file_get_contents($path.'nation_province_StandardCode.json');

$id = json_decode($id, true);
$name = json_decode($name, true);
$stan = json_decode($stan, true);
echo count($id).PHP_EOL;
echo count($name).PHP_EOL;
echo count($stan).PHP_EOL;
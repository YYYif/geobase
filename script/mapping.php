<?php
require dirname(__FILE__) . "/../vendor/autoload.php";

use GeoBase\GeoBaseEnum;

$path = dirname(__FILE__) . "/../map/";

function mapFileInfo($path)
{
    $file       = scandir($path);
    $jsonFilArr = array();
    foreach ($file as $value) {
        if (strpos($value, '.json') && strpos($value, '.') !== false) {
            $jsonFilArr[] = $path . $value;
        }
    }
    return $jsonFilArr;
}

function doReplace($file)
{
    $info = file_get_contents($file);
    switch ($file) {
        case strpos($file, 'nation_province') !== false:
            $replaceInfo = $info;
            foreach (GeoBaseEnum::$_map2Nation_Province as $replace => $originValue) {
                $replaceInfo = str_replace('"' . $originValue . '"', '"' . $replace . '"', $replaceInfo);
            }
            file_put_contents($file, $replaceInfo);
            echo $file . ' done' . PHP_EOL;
            break;
        case strpos($file, 'province_city') !== false:
            $replaceInfo = $info;
            foreach (GeoBaseEnum::$_map2Province_City as $replace => $originValue) {
                $replaceInfo = str_replace('"' . $originValue . '"', '"' . $replace . '"', $replaceInfo);
            }
            file_put_contents($file, $replaceInfo);
            echo $file . ' done' . PHP_EOL;
            break;
        case strpos($file, 'city_district') !== false:
            $replaceInfo = $info;
            foreach (GeoBaseEnum::$_map2City_District as $replace => $originValue) {
                $replaceInfo = str_replace('"' . $originValue . '"', '"' . $replace . '"', $replaceInfo);
            }
            file_put_contents($file, $replaceInfo);
            echo $file . 'done' . PHP_EOL;
            break;
        case strpos($file, 'district_street') !== false:
            $replaceInfo = $info;
            foreach (GeoBaseEnum::$_map2District_Street as $replace => $originValue) {
                $replaceInfo = str_replace('"' . $originValue . '"', '"' . $replace . '"', $replaceInfo);
            }
            file_put_contents($file, $replaceInfo);
            echo $file . 'done' . PHP_EOL;
            break;
        case (strpos($file, 'street_ID') !== false || strpos($file, 'street_Name') !== false):
            $replaceInfo = $info;
            foreach (GeoBaseEnum::$_map2Street as $replace => $originValue) {
                $replaceInfo = str_replace('"' . $originValue . '"', '"' . $replace . '"', $replaceInfo);
            }
            file_put_contents($file, $replaceInfo);
            echo $file . 'done' . PHP_EOL;
            break;
        default :
            echo 'no found file' . $file . PHP_EOL;
            break;
    }
}

function replaceMapInfo($path)
{
    $jsonFilArr = mapFileInfo($path);
    foreach ($jsonFilArr as $file) {
        doReplace($file);
    }
}

replaceMapInfo($path);
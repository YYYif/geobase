<?php

namespace GeoBase;
class GeoBaseEnum
{
    const PROVINCE_IDS = 'province_ids';
    const PROVINCE_NAME = 'province_name';
    const CITY_IDS = 'city_ids';
    const CITY_NAME = 'city_name';
    const DISTRICT_IDS = 'district_ids';
    const DISTRICT_NAME = 'district_name';
    const STREET_IDS = 'street_ids';
    const STREET_NAME = 'street_name';

    //缺少参数
    const LACK_PARAMS = 'lack params';
    const RESULT_NULL = 'empty result';

    const NATION = "nation";
    const PROVINCE = "province";
    const CITY = "city";
    const DISTRICT = "district";
    const STREET = "street";

    const ID = "id";
    const MOBILE_AREA_CODE = 'mobileareacode';

    public static $_map2Nation_Province = array(
        'A' => 'id',
        'B' => 'enname',
        'C' => 'name',
        'D' => 'showname',
        'E' => 'mobileareacode',
        'F' => 'shortname',
        'G' => 'continent_id',
        'H' => 'py',
        'I' => 'currency',
        'J' => 'currency_ascii',
        'K' => 'latitude',
        'L' => 'longitude',
        'M' => 'province_ids',
    );

    public static $_map2Province_City = array(
        'A' => 'province_id',
        'B' => 'province_name',
        'C' => 'short_name',
        'D' => 'pinyin',
        'E' => 'nation_id',
        'F' => 'standard_code',
        'G' => 'latitude',
        'H' => 'longitude',
        'I' => 'city_ids',
    );

    public static $_map2City_District = array(
        'A' => 'city_id',
        'B' => 'city_name',
        'C' => 'short_name',
        'D' => 'pinyin',
        'E' => 'short_pinyin',
        'F' => 'standard_code',
        'G' => 'province_id',
        'H' => 'google_analytics_code',
        'I' => 'timezone',
        'J' => 'latitude',
        'K' => 'longitude',
        'L' => 'district_ids',
    );

    public static $_map2District_Street = array(
        'A' => 'district_id',
        'B' => 'district_name',
        'C' => 'short_name',
        'D' => 'pinyin',
        'E' => 'location',
        'F' => 'location_g',
        'G' => 'city_id',
        'H' => 'standard_code',
        'I' => 'street_ids',
    );

    public static $_map2Street = array(
        'A' => 'street_id',
        'B' => 'street_name',
        'C' => 'pinyin',
        'D' => 'location',
        'E' => 'location_g',
        'F' => 'district_id',
    );

    public static $nationParam = array(
        'fileName_id' => 'nation_province_ID',
        'fileName_name' => 'nation_province_Name',
        'fileName_standardCode' => 'nation_province_StandardCode',
        'childFileName' => 'province_city_ID',
    );

    public static $provinceParam = array(
        'fileName_id' => 'province_city_ID',
        'fileName_name' => 'province_city_Name',
        'fileName_standardCode' => 'province_city_StandardCode',
        'childFileName' => 'city_district_ID',
    );

    public static $cityParam = array(
        'fileName_id' => 'city_district_ID',
        'fileName_name' => 'city_district_Name',
        'fileName_standardCode' => 'city_district_StandardCode',
        'childFileName' => 'district_street_ID',
    );

    public static $districtParam = array(
        'fileName_id' => 'district_street_ID',
        'fileName_name' => 'district_street_Name',
        'fileName_standardCode' => 'district_street_StandardCode',
        'childFileName' => 'street_ID',
    );

    public static $streetParam = array(
        'fileName_id' => 'street_ID',
        'fileName_name' => 'street_Name',
        'fileName_standardCode' => 'street_StandardCode',
    );

    private static $_definesMapParam = array(
        self::PROVINCE_IDS  => 'M',
        self::PROVINCE_NAME => 'B',
        self::CITY_IDS      => 'I',
        self::CITY_NAME     => 'B',
        self::DISTRICT_IDS  => 'L',
        self::DISTRICT_NAME => 'B',
        self::STREET_IDS    => 'I',
        self::STREET_NAME   => 'B',
    );

    public static function map2Param($param)
    {
        if(isset(self::$_definesMapParam[$param]))
        {
            return  self::$_definesMapParam[$param];
        }
        return false;
    }

    public static function param2MapWithType($param, $type = GeoBaseEnum::NATION)
    {
        switch ($type) {
            case GeoBaseEnum::NATION:
                $flipArr = array_flip(self::$_map2Nation_Province);
                break;
            case GeoBaseEnum::PROVINCE:
                $flipArr = array_flip(self::$_map2Province_City);
                break;
            case GeoBaseEnum::CITY:
                $flipArr = array_flip(self::$_map2City_District);
                break;
            case GeoBaseEnum::DISTRICT:
                $flipArr = array_flip(self::$_map2District_Street);
                break;
            case GeoBaseEnum::STREET:
                $flipArr = array_flip(self::$_map2Street);
                break;
            default:
                $flipArr = array_flip(self::$_map2Nation_Province);
                break;
        }

        if (isset($flipArr[$param])) {
            return $flipArr[$param];
        }

        return null;
    }
}
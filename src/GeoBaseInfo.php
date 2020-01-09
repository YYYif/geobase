<?php

namespace GeoBase;

use GeoBase\GeoBaseEnum;

class GeoBaseInfo
{
    protected $_path;

    public function __construct()
    {
        $this->_path = dirname(__FILE__) . "/../map/";
    }

    /**
     * @info 获取全部国家信息 下级仅包括省份ID集合
     * @author yueyifei1995@163.com
     */
    public function getAllNationInfo()
    {
        $filename = GeoBaseEnum::$nationParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return self::mapRevert2Real(GeoBaseEnum::$_map2Nation_Province, null, $content, true);
        } else {
            return false;
        }
    }

    /**
     * @info 获取全部省份信息 下级仅包括城市ID集合
     * @author yueyifei1995@163.com
     */
    public function getAllProvinceInfo()
    {
        $filename = GeoBaseEnum::$provinceParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return self::mapRevert2Real(GeoBaseEnum::$_map2Province_City, null, $content, true);
        } else {
            return false;
        }
    }

    /**
     * @info 获取全部城市信息 下级仅包括行政区ID集合
     * @author yueyifei1995@163.com
     */
    public function getAllCityInfo()
    {
        $filename = GeoBaseEnum::$cityParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return self::mapRevert2Real(GeoBaseEnum::$_map2City_District, null, $content, true);
        } else {
            return false;
        }
    }

    /**
     * @info 获取全部行政区信息 下级仅包括街道ID集合
     * @author yueyifei1995@163.com
     */
    public function getAllDistrictInfo()
    {
        $filename = GeoBaseEnum::$districtParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return self::mapRevert2Real(GeoBaseEnum::$_map2District_Street, null, $content, true);
        } else {
            return false;
        }
    }

    /**
     * @info 获取全部街道信息
     * @author yueyifei1995@163.com
     */
    public function getAllStreetInfo()
    {
        $filename = GeoBaseEnum::$streetParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return self::mapRevert2Real(GeoBaseEnum::$_map2Street, null, $content, true);
        } else {
            return false;
        }
    }

    /**
     * @param int $nationId
     * @return array|string
     * @info 根据ID获取国家信息，包括下级省份详细信息
     * @author yueyifei1995@163.com
     */
    public function getNationById($nationId)
    {
        if (empty($nationId) && !is_numeric($nationId)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$nationParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $nationId, GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_NAME), GeoBaseEnum::$nationParam['childFileName'],
                GeoBaseEnum::$_map2Nation_Province, GeoBaseEnum::$_map2Province_City);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    public function getNationByMobileAreaCode($mobileAreaCode)
    {
        if (empty($mobileAreaCode) && !is_numeric($mobileAreaCode)) {
            return GeoBaseEnum::LACK_PARAMS;
        }

        $filename          = GeoBaseEnum::$nationParam['fileName_id'];
        $content           = $this->getOffLineGeoText($filename);
        $mapMobileAreaCode = GeoBaseEnum::param2MapWithType(GeoBaseEnum::MOBILE_AREA_CODE);
        $mapNationId       = GeoBaseEnum::param2MapWithType(GeoBaseEnum::ID);

        $result = [];
        foreach ($content as $item) {
            if (!isset($item[$mapMobileAreaCode]) || !isset($item[$mapNationId]) || $item[$mapMobileAreaCode] != $mobileAreaCode) {
                continue;
            }
            $result[] = $this->getNationById($item[$mapNationId]);
        }

        return $result;
    }

    /**
     * @param string $nationName
     * @return array|string
     * @info 根据名称获取国家信息，包括下级省份详细信息
     * @author yueyifei1995@163.com
     */
    public function getNationByName($nationName)
    {
        if (empty($nationName)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$nationParam['fileName_name'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $nationName, GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_NAME), GeoBaseEnum::$nationParam['childFileName'],
                GeoBaseEnum::$_map2Nation_Province, GeoBaseEnum::$_map2Province_City);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $nationStandardCode
     * @return array|string
     * @info 根据国家编码获取国家信息，包括下级省份详细信息
     * @author yueyifei1995@163.com
     */
    public function getNationByStandardCode($nationStandardCode)
    {
        if (empty($nationStandardCode)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$nationParam['fileName_standardCode'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $nationStandardCode,
                GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_IDS), GeoBaseEnum::map2Param(GeoBaseEnum::PROVINCE_NAME),
                GeoBaseEnum::$nationParam['childFileName'], GeoBaseEnum::$_map2Nation_Province,
                GeoBaseEnum::$_map2Province_City);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $provinceId
     * @return array|string
     * @info 根据省份ID获取省份信息，包括下级城市详细信息
     * @author yueyifei1995@163.com
     */
    public function getProvinceById($provinceId)
    {
        if (empty($provinceId) && !is_numeric($provinceId)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$provinceParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $provinceId, GeoBaseEnum::map2Param(GeoBaseEnum::CITY_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::CITY_NAME), GeoBaseEnum::$provinceParam['childFileName'],
                GeoBaseEnum::$_map2Province_City, GeoBaseEnum::$_map2City_District);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param string $provinceName
     * @return array|string
     * @info 根据省份名称获取省份信息，包括下级城市详细信息
     * @author yueyifei1995@163.com
     */
    public function getProvinceByName($provinceName)
    {
        if (empty($provinceName)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$provinceParam['fileName_name'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $provinceName, GeoBaseEnum::map2Param(GeoBaseEnum::CITY_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::CITY_NAME), GeoBaseEnum::$provinceParam['childFileName'],
                GeoBaseEnum::$_map2Province_City, GeoBaseEnum::$_map2City_District);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $standardCode
     * @return array|string
     * @info 根据省份编码获取省份信息，包括下级城市详细信息
     * @author yueyifei1995@163.com
     */
    public function getProvinceByStandardCode($standardCode)
    {
        if (empty($standardCode)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$provinceParam['fileName_standardCode'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $standardCode, GeoBaseEnum::map2Param(GeoBaseEnum::CITY_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::CITY_NAME), GeoBaseEnum::$provinceParam['childFileName'],
                GeoBaseEnum::$_map2Province_City, GeoBaseEnum::$_map2City_District);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $cityId
     * @return array|string
     * @info 根据城市ID获取城市信息，包括下级行政区详细信息
     * @author yueyifei1995@163.com
     */
    public function getCityById($cityId)
    {
        if (empty($cityId) && !is_numeric($cityId)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$cityParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $cityId, GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_NAME), GeoBaseEnum::$cityParam['childFileName'],
                GeoBaseEnum::$_map2City_District, GeoBaseEnum::$_map2District_Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param string $cityName
     * @return array|string
     * @info 根据城市全名称获取城市信息，包括下级行政区详细信息
     * @author yueyifei1995@163.com
     */
    public function getCityByName($cityName)
    {
        if (empty($cityName)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$cityParam['fileName_name'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $cityName, GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_NAME), GeoBaseEnum::$cityParam['childFileName'],
                GeoBaseEnum::$_map2City_District, GeoBaseEnum::$_map2District_Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $standardCode
     * @return array|string
     * @info 根据城市编码获取城市信息，包括下级行政区详细信息
     * @author yueyifei1995@163.com
     */
    public function getCityByStandardCode($standardCode)
    {
        if (empty($standardCode)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$cityParam['fileName_standardCode'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $standardCode, GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::DISTRICT_NAME), GeoBaseEnum::$cityParam['childFileName'],
                GeoBaseEnum::$_map2City_District, GeoBaseEnum::$_map2District_Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $districtId
     * @return array|string
     * @info 根据行政区ID获取行政区信息，包括下级街道详细信息
     * @author yueyifei1995@163.com
     */
    public function getDistrictById($districtId)
    {
        if (empty($districtId) && !is_numeric($districtId)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$districtParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $districtId, GeoBaseEnum::map2Param(GeoBaseEnum::STREET_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::STREET_NAME), GeoBaseEnum::$districtParam['childFileName'],
                GeoBaseEnum::$_map2District_Street, GeoBaseEnum::$_map2Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param string $districtName
     * @return array|string
     * @info 根据行政区名称获取行政区信息，包括下级街道详细信息
     * @author yueyifei1995@163.com
     */
    public function getDistrictByName($districtName)
    {
        if (empty($districtName)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$districtParam['fileName_name'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $districtName, GeoBaseEnum::map2Param(GeoBaseEnum::STREET_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::STREET_NAME), GeoBaseEnum::$districtParam['childFileName'],
                GeoBaseEnum::$_map2District_Street, GeoBaseEnum::$_map2Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param string $standardCode
     * @return array|string
     * @info 根据行政区编码获取行政区信息，包括下级街道详细信息
     * @author yueyifei1995@163.com
     */
    public function getDistrictByStandardCode($standardCode)
    {
        if (empty($standardCode)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$districtParam['fileName_standardCode'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $standardCode, GeoBaseEnum::map2Param(GeoBaseEnum::STREET_IDS),
                GeoBaseEnum::map2Param(GeoBaseEnum::STREET_NAME), GeoBaseEnum::$districtParam['childFileName'],
                GeoBaseEnum::$_map2District_Street, GeoBaseEnum::$_map2Street);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param int $streetId
     * @return array|string
     * @info 根据街道ID获取街道信息
     * @author yueyifei1995@163.com
     */
    public function getStreetById($streetId)
    {
        if (empty($streetId) && !is_numeric($streetId)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$streetParam['fileName_id'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $streetId, null, null, null, GeoBaseEnum::$_map2Street, null);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * @param string $streetName
     * @return array|string
     * @info 根据街道名称获取街道信息
     * @author yueyifei1995@163.com
     */
    public function getStreetByName($streetName)
    {
        if (empty($streetName)) {
            return GeoBaseEnum::LACK_PARAMS;
        }
        $filename = GeoBaseEnum::$streetParam['fileName_name'];
        $content  = $this->getOffLineGeoText($filename);
        if (!empty($content)) {
            return $this->executeContent($content, $streetName, null, null, null, GeoBaseEnum::$_map2Street, null);
        } else {
            return GeoBaseEnum::RESULT_NULL;
        }
    }

    /**
     * 数据根据map映射，将字段名转化为为最终的结果
     * @param array $mapParent
     * @param array $mapChild
     * @param array $initialData
     * @param bool $ifSelectAll
     * @return array
     */
    private function mapRevert2Real($mapParent, $mapChild, $initialData, $ifSelectAll = false)
    {
        $result   = array();
        $tempData = array();
        $subData  = array();
        if (empty($initialData)) {
            return [];
        }
        if ($ifSelectAll) {
            //查询全部父级以及子级信息
            foreach ($initialData as $formatKey => $formatValue) {
                foreach ($formatValue as $parentKey => $parentVal) {
                    $tempData[$mapParent[$parentKey]] = $parentVal;
                }
                //父级ID作为数组的key,以备精确查询
                $result[$formatKey] = $tempData;
            }
        } else {
            //精确查询父级对应所有下级
            foreach ($initialData as $parentKey => $parentVal) {
                if ($parentKey == 'belong_infos') {
                    foreach ($parentVal as $originalKey => $originalChildVal) {
                        foreach ($originalChildVal as $childKey => $childVal) {
                            $tempData[$mapChild[$childKey]] = $childVal;
                        }
                        //将所属下级结果中的key替换为子级名称显示
                        $subData[$originalKey] = $tempData;
                    }
                    $result['belong_infos'] = $subData;
                    continue;
                } else {
                    $result[$mapParent[$parentKey]] = $parentVal;
                }
            }
        }
        return $result;
    }

    /**
     * 接收文本数据，依照父子级关系，得到对应父级详细信息以及对应所有子集信息
     * @param array $content
     * @param mixed $param
     * @param string $childIdIndex
     * @param string $childName
     * @param string $childFileName
     * @param array $mapParent
     * @param array $mapChild
     * @return array
     */
    private function executeContent($content, $param, $childIdIndex, $childName, $childFileName, $mapParent, $mapChild)
    {
        if (isset($content[$param])) {
            $parentInfo = $content[$param];
        } else {
            return [];
        }

        if (isset($parentInfo[$childIdIndex]) && !empty($parentInfo[$childIdIndex])) {
            $childArr = explode(',', $parentInfo[$childIdIndex]);
            foreach ($childArr as $value) {
                $childRes                                           = $this->getOffLineGeoText($childFileName);
                $childInfo                                          = $childRes[$value];
                $parentInfo['belong_infos'][$childInfo[$childName]] = $childInfo;
            }
            return self::mapRevert2Real($mapParent, $mapChild, $parentInfo);
        } else {
            return self::mapRevert2Real($mapParent, $mapChild, $parentInfo);
        }
    }

    /**
     * 接收文本名，取出对应文本中存储信息
     * @param string $fileName
     * @return array|bool
     */
    private function getOffLineGeoText($fileName)
    {
        $path = $this->_path . $fileName . '.json';
        if (file_exists($path)) {
            $data = file_get_contents($path);
            return json_decode($data, true);
        } else {
            return false;
        }
    }
}
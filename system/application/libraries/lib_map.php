<?php

/**
 *
 * Описание файла: Хелпер.
 * Определение Набор правил валидации.
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class lib_map {
    
function pointsInPolygons($points, $polygonsEncoded)
{
	$polygons = array();
	$mbrs = array();
	$result = array();
	for($i = 0, $l = count($polygonsEncoded); $i < $l; $i++)
	{
		$polygons[] = $this->decodeGeoPath($polygonsEncoded[$i]);
		$mbrs[] = $this->MBRfromGeoPoints(end($polygons));
	};
	for($i = 0, $n = count($points); $i < $n; $i++)
	{
		for($j = 0; $j < $l; $j++)
		{
			if ($this->pointInMBR($points[$i], $mbrs[$j]) && $this->pointInPolygon($points[$i], $polygons[$j]))
			{
				$result[] = $points[$i];
			};
		}
	};
	return $result;
}

// ?????????? ????????? ??? ???????
// param $polygons - ?????? ????????? (???????) array[array[GeoPoint]]]
// return string
function encodePolygons($polygons)
{
    $res = array();
	$len = count($polygons);
    for ($i = 0; $i < $len; $i++) 
	{
        $res[] = $this->encodeGeoPath($polygons[$i][0]);
    };
    return implode(";", $res);
}

// ??????????? ??????? ??? ???????.
// param $path - ?????? ????????  [ lat : float, lng : float ]
// return string
function encode4bytes ($x) {
    $chr = '';
    for ($i = 0; $i < 4; $i++) {
        $chr .= chr($x & 0x000000ff);
        $x = $x >> 8;
    }
    return $chr;
}

function getShifts ($path) {
    $codingCoefficient = 1000000;
    $res = array();
    for($i = 0, $l = count($path), $prev = array( 0, 0) ; $i < $l; $i++)
    {
        $res[] = array( (int) round(($path[$i][0] - $prev[0]) * $codingCoefficient),
            (int) round(($path[$i][1] - $prev[1]) * $codingCoefficient));
        $prev = $path[$i];
    }
    return $res;
}

function encodePath4bytes ($path) {
    $result = '';
    $formated = $this->getShifts($path);
    for($i = 0, $l = count($formated); $i < $l; $i++)
    {
        $result .= $this->encode4bytes($formated[$i][1]).$this->encode4bytes($formated[$i][0]);
    }
    return $result;
}


function encodeGeoPath($path)
{
    return str_replace(array('/', '+'), array('_', '-'), base64_encode($this->encodePath4bytes($path)));
}

// ????????????? ????????? ?? base64
// param string  - ?????? ???????????? ?????????, ??????????? ?????? ? ???????
function decodePolygons($encodedCoordinates) 
{
    $encodedPaths = explode(";", $encodedCoordinates);
    $coordinates = array();		
		
    for ($i = 0, $l = count($encodedPaths); $i < $l; $i++) {
        $coordinates[] = $this->decodeGeoPath($encodedPaths[$i]);
    };

    return $coordinates;
}
// ????????????? ??????? ?? base64
// param String
// return GeoPoints[] - ?????? ????????
// примерно сдесь находится ошибка.
function decodeGeoPath($encodedCoordinates) {
  $codingCoefficient = 1000000;
    $byteVector = base64_decode(str_replace(array('_', '-'), array('/', '+'), $encodedCoordinates));
    $l = strlen($byteVector);
    $i = 0;
    $prev = array('lat' => 0, 'lng' =>0);
    $result = array();
    while ($i < $l) {
        $pointx = $pointy = $iterIndex = 0;
        $sub = substr($byteVector, $i, 8);
        while ($iterIndex < 4) {
            $pointx |= (ord($sub[$iterIndex]) << $iterIndex * 8);
            $pointy |= (ord($sub[$iterIndex + 4]) << $iterIndex * 8);
            $iterIndex ++;
            if($pointx >4200000000)$pointx -=4294967296;
            if($pointy >4200000000)$pointy -=4294967296;
        };
        if ( $pointx && $pointy)
        {
            $vector = array('lat' => $pointx / $codingCoefficient, 'lng' => $pointy / $codingCoefficient);
            $point = array('lat' => $vector['lat'] + $prev['lat'], 'lng' => $vector['lng'] + $prev['lng']);
            $prev = $point;

            $result[] = $point;
        };
        $i += 8;
    }
    return $result;
}
// ????????? MBR ??? ???????? ?????? ?????
// param path [] - ?????? GeoPoints
// return MBR [topLeft -> geoPoint, bottomRight -> geoPoint];
function MBRfromGeoPoints($path)
{
	if (!count($path)) {
		return FALSE;
    };
    $min = reset($path);
	$max = $min;
    for ($i = 1, $l = count($path); $i<$l; $i++) {
            $point = $path[$i];
            if ($min['lat'] > $point['lat']) $min['lat'] = $point['lat'];
            if ($min['lng'] > $point['lng']) $min['lng'] = $point['lng'];
            if ($max['lat'] < $point['lat']) $max['lat'] = $point['lat'];
            if ($max['lng'] < $point['lng']) $max['lng'] = $point['lng'];
     }
     return array('topLeft' => $min, 'bottomRight' => $max);
}
/*
 * @param GeoPoint - ?????
 * @param $path Number[GeoPoint]  ?????????? MBR.
 * return TRUE/FALSE
*/

function pointInMBR($point, $mbr)
{	
	return ( ($mbr['topLeft']['lat'] <= $point['lat']) && 
			($mbr['topLeft']['lng'] <= $point['lng']) && 
			($mbr['bottomRight']['lat'] >= $point['lat']) && 
			($mbr['bottomRight']['lng'] >= $point['lng']) );
}

// ??????? MBR ???????????? ??? ????????? MBR
// param {MBR} mbr1, mbr2, ...
// return MBR [topLeft -> geoPoint, bottomRight -> geoPoint];
function MBRfromMBRS($mbr1)
{
   	if (func_num_args() == 1) {
		return $mbr1;
	}
	$mbrs =  func_get_args();
	$min = $mbr1['topLeft'];
    $max = $mbr1['bottomRight'];
	// ??????????? ?? ???????? - ??????????? ?????? min-min ? max-max
	for ($i = 1, $l = func_num_args() - 1; $l; ++$i,--$l) {
		$bounds = $mbrs[$i];
		if ($min['lat'] > $bounds['topLeft']['lat']) $min['lat'] = $bounds['topLeft']['lat'];
		if ($min['lng'] > $bounds['topLeft']['lng']) $min['lng'] = $bounds['topLeft']['lng'];
		if ($max['lat'] < $bounds['bottomRight']['lat']) $max['lat'] = $bounds['bottomRight']['lat'];
		if ($max['lng'] < $bounds['bottomRight']['lng']) $max['lng'] = $bounds['bottomRight']['lng'];
	}
     return array('topLeft' => $min, 'bottomRight' => $max);
}

/*
 * @param GeoPoint - ?????
 * @param $path Number[GeoPoint]  ?????????? ??????????????.
 * return TRUE/FALSE 
*/
function pointInPolygon($point, $path) {
	$intersections = 0;
	$l = count($path)-1;
	// ???????? ????????? ?? ????? ? ????? ?? ??????.
	for ($i = 0; $i < $l; $i++) {
		if ($path[$i]['lat'] == $point['lat'] && $path[$i]['lng'] == $point['lng']) 
		{
			return TRUE;
		}
	};
    // ????????? ????????? ?? ????? ?????? ???????? ??? ?? ??? ???????.
	$inter = 0;

    $prev = $path[$l];
    for ($i = 0; $i < $l; $i++) {
		$next = $path[$i];
        // Check if point is on an horizontal polygon boundary
        if ( ($prev['lng'] == $next['lng']) && ($prev['lng'] == $point['lng']) && ($point['lat'] > min($prev['lat'], $next['lat'])) && ($point['lat'] < max($prev['lat'], $next['lat']))) {
            return TRUE;
        }
        if ( ($point['lng'] > min($prev['lng'], $next['lng'])) && 
			 ($point['lng'] <= max($prev['lng'], $next['lng'])) && 
			 ($point['lat'] <= max($prev['lat'], $next['lat'])) && 
			 ($prev['lng'] != $next['lng']) ) {

			$xinters = ($point['lng'] - $prev['lng']) * ($next['lat'] - $prev['lat']) / ($next['lng'] - $prev['lng']) + $prev['lat'];
            // Check if $point is on the polygon boundary (other than horizontal)
            if ($xinters == $point['lat']) {
                return TRUE;
            }
            if ($prev['lat'] == $next['lat'] || $point['lat'] <= $xinters) {
                    $intersections += ($intersections > 0) ? -1 : 1;
            }
        }
        $prev = $next;
    }
    return (bool) ($intersections != 0) ;
}
        
        
        
        
        

    }
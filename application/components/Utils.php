<?php

class Utils
{


  public static function rightsToInt($rights)
  {
    $right_int = array(
      'guest' => 0,
      'user' => 1,
      'specialist' => 2,
      'admin' => 3,
    );

    return $right_int[$rights];
  }

  public static function getHumanDate($time)
  {
    return str_replace(array(' 1 ', ' 2 ', ' 3 ', ' 4 ', ' 5 ', ' 6 ', ' 7 ', ' 8 ', ' 9 ', ' 10 ', ' 11 ', ' 12 '),
      array(' января ', ' февраля ', ' марта ', ' апреля ', ' мая ', ' июня ', ' июля ', ' августа ', ' сентября ', ' октября ', ' ноября ', ' декабря '),
      date('j n Y H:i', $time));
  }


  public static function dateAgo($date_arr)
  {
    if (!empty($date_arr['days'])) {
      if ($date_arr['days'] > 20) {
        //возвращеам просто число
        return str_replace(array(' 1 ', ' 2 ', ' 3 ', ' 4 ', ' 5 ', ' 6 ', ' 7 ', ' 8 ', ' 9 ', ' 10 ', ' 11 ', ' 12 '),
          array(' января ', ' февраля ', ' марта ', ' апреля ', ' мая ', ' июня ', ' июля ', ' августа ', ' сентября ', ' октября ', ' ноября ', ' декабря '),
          date('j n Y', $date_arr['time']));
      } else
        return $date_arr['days'] . ' ' . Utils::declension($date_arr['days'], array('день', 'дня', 'дней')) . ' назад';
    }
    if (!empty($date_arr['hours']))
      return $date_arr['hours'] . ' ' . Utils::declension($date_arr['hours'], array('час', 'часа', 'часов')) . ' назад';
    if (!empty($date_arr['mins']))
      return $date_arr['mins'] . ' ' . Utils::declension($date_arr['mins'], array('минута', 'минуты', 'минут')) . ' назад';

    return $date_arr['seconds'] . ' ' . Utils::declension($date_arr['seconds'], array('секунда', 'секунды', 'секунд')) . ' назад';
  }

// параметры - число, массив вариантов слова (1, 2 штуки, 5 штук)
  public static function declension($digit, $expr, $onlyword = false)
  {
    if (!is_array($expr)) $expr = array_filter(explode(' ', $expr));
    if (empty($expr[2])) $expr[2] = $expr[1];
    $i = preg_replace('/[^0-9]+/s', '', $digit) % 100;
    if ($onlyword) $digit = '';
    if ($i >= 5 && $i <= 20) $res = $expr[2];
    else
    {
      $i %= 10;
      if ($i == 1) $res = $expr[0];
      elseif ($i >= 2 && $i <= 4) $res = $expr[1];
      else $res = $expr[2];
    }
    return trim($res);
  }


  public function getTimeDifference($cur_time, $time)
  {
    if ($time > $cur_time) {
      $difference = $time - $cur_time;
    } elseif ($time < $cur_time) {
      $difference = $cur_time - $time;
    } else
      $difference = 0;

    $diff_days = floor($difference / 86400);
    $diff_hours = floor($difference / 3600);
    $diff_minutes = floor($difference / 60);
    $diff_seconds = $difference;

    $return = array();
    $return['time'] = $time;
    $return['seconds'] = $diff_seconds;

    $return['days'] = $diff_days;

    // Если разница > суток - 1 час
    if ($diff_hours > 23) {
      $return['hours'] = $diff_hours - (24 * $diff_days);
    } else {
      $return['hours'] = $diff_hours;
    }

    // Если разница > часа - 1 минута
    if ($diff_minutes > 59) {
      $return['mins'] = $diff_minutes - (60 * $diff_hours);
    } else {
      $return['mins'] = $diff_minutes;
    }

    return $return;
  }

  public static function getRandomString($length = 6)
  {

    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";

    $validCharNumber = strlen($validCharacters);


    $result = "";


    for ($i = 0; $i < $length; $i++) {

      $index = mt_rand(0, $validCharNumber - 1);

      $result .= $validCharacters[$index];

    }


    return $result;

  }

  public static function listMonths()
  {
    return array(
      '01' => 'январь',
      '02' => 'февраль',
      '03' => 'март',
      '04' => 'апрель',
      '05' => 'май',
      '06' => 'июнь',
      '07' => 'июль',
      '08' => 'август',
      '09' => 'сентябрь',
      '10' => 'октябрь',
      '11' => 'ноябрь',
      '12' => 'декабрь',

    );
  }

  public static function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
  {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;

    return ($miles ? ($km * 0.621371192) : $km);
  }

  public static function getCenterOfArea($locs)
  {
    $lats = array();
    $lngs = array();
    foreach ($locs as $loc) {
      $lats[] = $loc['lat'];
      $lngs[] = $loc['lng'];
    }
    return array(
      'lat' => array_sum($lats) / count($lats),
      'lng' => array_sum($lngs) / count($lngs),
    );
  }

  public static function getMaxDistanceInArea($locs, $middle)
  {
    $max_distance = 0;
    foreach ($locs as $loc) {
      $distance = self::distance($loc['lat'], $loc['lng'], $middle['lat'], $middle['lng']);
      if ($distance > $max_distance)
        $max_distance = $distance;
    }
    return $max_distance;
  }

  public static function getZoomAndCenter($locs)
  {
    $center = self::getCenterOfArea($locs);

    $max_distance = self::getMaxDistanceInArea($locs, $center);
    $zoomLvl = 10;
    //determine the zoom level out of the calculated distance
    if ($max_distance < 24576)
      $zoomLvl = 1;
    if ($max_distance < 12288)
      $zoomLvl = 2;
    if ($max_distance < 6144)
      $zoomLvl = 3;
    if ($max_distance < 3072)
      $zoomLvl = 4;
    if ($max_distance < 1536)
      $zoomLvl = 5;
    if ($max_distance < 768)
      $zoomLvl = 6;
    if ($max_distance < 384)
      $zoomLvl = 7;
    if ($max_distance < 192)
      $zoomLvl = 8;
    if ($max_distance < 96)
      $zoomLvl = 9;
    if ($max_distance < 48)
      $zoomLvl = 10;
    if ($max_distance < 24)
      $zoomLvl = 11;
    if ($max_distance < 11)
      $zoomLvl = 12;
    if ($max_distance < 4.8)
      $zoomLvl = 13;
    if ($max_distance < 3.2)
      $zoomLvl = 14;
    if ($max_distance < 1.6)
      $zoomLvl = 15;
    if ($max_distance < 0.8)
      $zoomLvl = 16;
    if ($max_distance < 0.3)
      $zoomLvl = 17;
    return array('zoom' => $zoomLvl, 'center' => $center);
  }

  public static function getLevelsDirABC($base, $id, $is_url = false)
  {
    $DS = '/';
    $hash = md5($id);
    $levels = $hash[0] . $DS . $hash[1] . $DS . $hash[2];
    $dir = $base . $DS . $levels;
    if (!$is_url && !is_dir($dir)) {
      self::mkdir($dir);
    }
    return $dir;
  }

  public static function mkdir($dname)
  {
    @mkdir($dname, 0775, true);
    chown($dname, 'www-data');
    //chgrp($dname, 'www-data');
  }

  public static function sizeReadable($size, $max = null, $system = 'si', $retstring = '%01.2f %s')
  {
    // Pick units
    $systems['si']['prefix'] = array('B', 'K', 'MB', 'GB', 'TB', 'PB');
    $systems['si']['size'] = 1000;
    $systems['bi']['prefix'] = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
    $systems['bi']['size'] = 1024;
    $sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];

    // Max unit to display
    $depth = count($sys['prefix']) - 1;
    if ($max && false !== $d = array_search($max, $sys['prefix'])) {
      $depth = $d;
    }

    // Loop
    $i = 0;
    while ($size >= $sys['size'] && $i < $depth) {
      $size /= $sys['size'];
      $i++;
    }

    return sprintf($retstring, $size, $sys['prefix'][$i]);
  }

  public static function priceFormat($price)
  {
    return number_format($price, 0, ",", " ");
  }


}
<?php
namespace EasyJalali;

// This source is contributed from Hijri_Shamsi,Solar(Jalali) Date and Time Functions
// @Author of Origin: Reza Gholampanahi & WebSite : http://jdf.scr.ir
// @License: GNU/LGPL _ Open Source & Free : [all functions]
// @Version: 2.76 =>[ 1399/11/28 = 1442/07/04 = 2021/02/16 ]
// All rights are reserved to https://github.com/MajideND/
// Check Licence on Github or Personal website: https://majid.codes

class Helper
{

  public static function gregorian_to_jalali($gy, $gm, $gd, $mod = '')
  {
    $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
    $days = 355666 + (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
    $jy = -1595 + (33 * ((int) ($days / 12053)));
    $days %= 12053;
    $jy += 4 * ((int) ($days / 1461));
    $days %= 1461;
    if ($days > 365) {
      $jy += (int) (($days - 1) / 365);
      $days = ($days - 1) % 365;
    }
    if ($days < 186) {
      $jm = 1 + (int) ($days / 31);
      $jd = 1 + ($days % 31);
    } else {
      $jm = 7 + (int) (($days - 186) / 30);
      $jd = 1 + (($days - 186) % 30);
    }
    return ($mod == '') ? array($jy, $jm, $jd) : $jy . $mod . $jm . $mod . $jd;
  }


  public static function jalali_to_gregorian($jy, $jm, $jd, $mod = '')
  {
    $jy += 1595;
    $days = -355668 + (365 * $jy) + (((int) ($jy / 33)) * 8) + ((int) ((($jy % 33) + 3) / 4)) + $jd + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
    $gy = 400 * ((int) ($days / 146097));
    $days %= 146097;
    if ($days > 36524) {
      $gy += 100 * ((int) (--$days / 36524));
      $days %= 36524;
      if ($days >= 365) $days++;
    }
    $gy += 4 * ((int) ($days / 1461));
    $days %= 1461;
    if ($days > 365) {
      $gy += (int) (($days - 1) / 365);
      $days = ($days - 1) % 365;
    }
    $gd = $days + 1;
    $sal_a = array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ($gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    for ($gm = 0; $gm < 13 and $gd > $sal_a[$gm]; $gm++) $gd -= $sal_a[$gm];
    return ($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
  }

  public static function convertFormatToRegex($format)
  {
    $specialKeys = array(
      'Y' => array('year', '\d{4}'),
      'y' => array('year', '\d{2}'),
      'm' => array('month', '\d{2}'),
      'n' => array('month', '\d{1,2}'),
      'M' => array('month', '[A-Z][a-z]{3}'),
      'F' => array('month', '[A-Z][a-z]{2,8}'),
      'd' => array('day', '\d{2}'),
      'j' => array('day', '\d{1,2}'),
      'D' => array('day', '[A-Z][a-z]{2}'),
      'l' => array('day', '[A-Z][a-z]{6,9}'),
      'u' => array('hour', '\d{1,6}'),
      'h' => array('hour', '\d{2}'),
      'H' => array('hour', '\d{2}'),
      'g' => array('hour', '\d{1,2}'),
      'G' => array('hour', '\d{1,2}'),
      'i' => array('minute', '\d{2}'),
      's' => array('second', '\d{2}'),
    );
    $formatRegex = '';
    $pattern = str_split($format);
    foreach ($pattern as $key => $patternItem) {
      $lastPattern = isset($pattern[$key - 1]) ? $pattern[$key - 1] : '';
      $skipCurrent = '\\' == $lastPattern;
      if (!$skipCurrent && isset($specialKeys[$patternItem])) {
        $formatRegex .= '(?P<' . $specialKeys[$patternItem][0] . '>' . $specialKeys[$patternItem][1] . ')';
      } else {
        if ('\\' == $patternItem) {
          $formatRegex .= $patternItem;
        } else {
          $formatRegex .= preg_quote($patternItem);
        }
      }
    }
    return $formatRegex;
  }


  public static function jalaliMonthF($monthInt)
  {
    $key = array('فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
    return $key[$monthInt];
  }



  public static function get12Hour($hour, $withZero)
  {
    $hour = date_create_from_format('!H', $hour);
    if ($withZero) {
      return $hour->format('h');
    }else{
      return $hour->format('g');
    }
  }


  public static function getJalaliHourText($hour, $lower = true)
  {
    if($lower){
      if ($hour >= 12) {
        return 'ب.ظ';
      }else{
        return 'ق.ظ';
      }
    }else{
      if ($hour >= 12) {
        return 'بعد از ظهر';
      }else{
        return 'قبل از ظهر';
      }
    }
  }

}

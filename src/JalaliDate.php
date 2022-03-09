<?php
namespace EasyJalali;

use Carbon\Carbon;
use EasyJalali\Helper;

class JalaliDate
{

    public $date;

    public $year;

    public $month;

    public $day;

    public $hour;

    public $minute;

    public $second;

    public static $isGeorgian;

    public function __construct(
        int $year,
        int $month,
        int $day,
        int $hour = null,
        int $minute = null,
        int $second = null
    ) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $hour ? $this->hour = $hour : null;
        $minute ? $this->minute = $minute : null;
        $second ? $this->second = $second : null;
    }

    public static function fromJalali($jalaliDate, $format = 'Y-m-d H:i:s')
    {
        self::$isGeorgian = false;
        $patternRegex = Helper::convertFormatToRegex($format);
        $getParams = preg_match('#^' . $patternRegex . '$#', $jalaliDate, $dateItems);
        if (!$getParams) {
            throw new Exception("Format is not correct!");
            return false;
        }
        foreach ($dateItems as $key => $item) {
            if (is_int($key)) {
                unset($dateItems[$key]);
            }
        }

        $dateParams = Helper::setDateTimeParams($dateItems);

        return new static($dateParams[0], $dateParams[1], $dateParams[2], $dateParams[3] ?? 0, $dateParams[4] ?? 0, $dateParams[5] ?? 0);
    }

    public static function fromCarbon(Carbon $carbon)
    {
        self::$isGeorgian = true;
        return new static($carbon->year, $carbon->month, $carbon->day, $carbon->hour ?? 0, $carbon->minute ?? 0, $carbon->second ?? 0);
    }

    public static function fromGeorgian($georgianDate, $format = 'Y-m-d H:i:s')
    {
        self::$isGeorgian = true;
        $datetimeFormat = date_create_from_format($format, $georgianDate);
        return new static(
            $datetimeFormat->format('Y'),
            $datetimeFormat->format('m'),
            $datetimeFormat->format('d'),
            $datetimeFormat->format('H') ?? 0,
            $datetimeFormat->format('i') ?? 0,
            $datetimeFormat->format('s') ?? 0
        );
    }

    public function toGeorgian()
    {
        self::$isGeorgian = true;
        $georgianArray = Helper::jalali_to_gregorian($this->year, $this->month(), $this->day());
        return new static($georgianArray[0], $georgianArray[1], $georgianArray[2], $this->hour(), $this->minute(), $this->second());
    }

    public function toJalali()
    {
        self::$isGeorgian = false;
        $jalaliArray = Helper::gregorian_to_jalali($this->year(), $this->month(), $this->day());
        return new static($jalaliArray[0], $jalaliArray[1], $jalaliArray[2], $this->hour(), $this->minute(), $this->second());
    }


    public function toFormat($format = 'Y-m-d H:i:s')
    {
        if (self::$isGeorgian) {
            $dateTime = strtotime("$this->year/$this->month/$this->day " . ($this->hour ?? '00') . ":" . ($this->minute ?? '00') . ":" . ($this->second ?? '00'));
            return date($format, $dateTime);
        }
        $resultDateByFormat = '';
        for ($i=0; $i < strlen($format); $i++) { 
            $resultDateByFormat .= $this->getJalaliBySpecialKey($format[$i]);
        }
        return $resultDateByFormat;
    }


    public function getJalaliBySpecialKey($specialKey)
    {
        switch ($specialKey) {

            case 'Y':
                return $this->year();
                break;

            case 'y':
                return $this->year()[3] . $this->year()[4];
                break;

            case 'm':
                $month = $this->month();
                $fullMonth = strlen($month) == 2 ? ('0' . $month) : $month;
                return $fullMonth;
                break;

            case 'n':
                $month = intval($this->month());
                return $month;
                break;

            case 'F':
                $month = $this->month();
                return Helper::jalaliMonthF($month);
                break;

            case 'd':
                $day = $this->day();
                $fullDay = strlen($day) == 2 ? $day :('0' . $day);
                return $fullDay;
                break;

            case 'j':
                $day = intval($this->day());
                return $day;
                break;

            case 'H':
                $hour = intval($this->hour());
                $fullHour = strlen($hour) == 2 ? $hour :('0' . $hour);
                return $fullHour;
                break;

            case 'h':
                $hour = $this->hour();
                return Helper::get12Hour($hour, true);
                break;

            case 'G':
                $hour = intval($this->hour());
                return $hour;
                break;

            case 'g':
                $hour = $this->hour();
                return Helper::get12Hour($hour, false);
                break;

            case 'i':
                $minute = $this->minute();
                $fullMinute = strlen($minute) == 2 ? $minute : ('0' . $minute);
                return $fullMinute;
                break;

            case 's':
                $second = $this->second();
                $fullSecond = strlen($second) == 2 ? $second : ('0' . $second);
                return $fullSecond;
                break;

            case 'a':
                $hour = $this->hour();
                return Helper::getJalaliHourText($hour, true);
                break;

            case 'A':
                $hour = $this->hour();
                return Helper::getJalaliHourText($hour, false);
                break;

            default:
                return $specialKey;
                break;
        }
    }

    public function year()
    {
        return $this->year;
    }

    public function month()
    {
        return $this->month;
    }

    public function day()
    {
        return $this->day;
    }

    public function hour()
    {
        return $this->hour;
    }

    public function hours()
    {
        return $this->hour;
    }

    public function minute()
    {
        return $this->minute;
    }

    public function second()
    {
        return $this->second;
    }
}

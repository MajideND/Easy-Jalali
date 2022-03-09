# Easy Jalali for PHP V1.0.0
- Jalali calendar converter for Persian users in Iran, Afghanistan and other countries that use Jalali calendar.
- Very thanks of other open-source Jalali libraries: [morilog/jalali](https://github.com/morilog/jalali), [jalaali/jalaali-js](https://github.com/jalaali/jalaali-js) and [jdf](https://jdf.scr.ir/jdf)
- In some cases, we may have used some codes or ideas on some of the named libraries.

- Persian (پارسی) Docs: [majid.codes/easy-jalali](https://majid.codes/easy-jalali?lang=fa)

## How to install:

- Using Composer

  ```
  composer require majidcode/easy-jalali
  ```

Note: this library has been tested in Laravel 8.x and Laravel 9.x.

## How to use:

### 1. Create your date from original format:

Create a date with one of the `fromJalali()`, `fromGeorgian()` or `fromCarbon()` methods.

Example:
``` php
//From Georgian:
$georgianDate = JalaliDate::fromGeorgian('2022-01-12 10:59:59', 'Y-d-m H:i:s');
echo $georgianDate->month();

//From Jalali:
$JalaliDate = JalaliDate::fromJalali('1399-12-12 08:29:59', 'Y-m-d H:i:s');
echo $JalaliDate->month();

//From Carbon:
$carbonDate = JalaliDate::fromCarbon(Carbon::now());
echo $carbonDate->month();
```

### 2. Convert to your format:

You can use `toGeorgian()` or `toJalali()` functions to convert your date.

Example:
``` php
//From Georgian to Jalali:
$georgianDate = JalaliDate::fromGeorgian('2022-01-12 10:59:59', 'Y-d-m H:i:s');
$JalaliDate = $georgianDate->toJalali();

//From Jalali to Georgian:
$JalaliDate = JalaliDate::fromJalali('1399-12-12 08:29:59', 'Y-m-d H:i:s');
$georgianDate = $JalaliDate->toGeorgian();

//From Carbon to Jalali:
$carbonDate = JalaliDate::fromCarbon(Carbon::now());
$JalaliDate = $carbonDate->toJalali();
```

### 3. Get your result or format:

You can use [document](#documention) to get different parameters. Format for Georgian date is [PHP date formats](https://www.php.net/manual/en/datetime.format.php) and Jalali dates is like PHP but has been changed or not supported in some cases.

Example:
``` php
//From Georgian to Jalali:
$georgianDate = JalaliDate::fromGeorgian('2022-01-12 10:59:59', 'Y-d-m H:i:s');
$JalaliDate = $georgianDate->toJalali();
echo $JalaliDate->toFormat('ماه F از Y-m-d و h:i:s A');
```


## Example codes:

I have provided some examples in `./example` folder that you are easy to use!

## Documention:

### Supported format characters:

Key | For What? | Supported in Georgian | Supported in Jalali | Example returned values
--- | --- | --- | --- |---
Y | A full numeric representation of a year, 4 digits | + Yes | + Yes | Examples: 2021, 1401
y | A two digit representation of a year | + Yes | + Yes | Examples: 21 or 01
m | Numeric representation of a month, with leading zeros | + Yes | + Yes | 01 through 12
n | Numeric representation of a month, without leading zeros | + Yes | + Yes | 1 through 12
F | A full textual representation of a month, such as January or March | + Yes | + Yes | January through December - فروردین through اسفند
d | Day of the month, 2 digits with leading zeros | + Yes | + Yes | 01 to 31
j | Day of the month without leading zeros | + Yes | + Yes | 1 to 31
a | Lowercase Ante meridiem and Post meridiem | + Yes | + Yes | am or pm - ق.ظ or ب.ظ
A | Uppercase Ante meridiem and Post meridiem | + Yes | + Yes | AM or PM - قبل از ظهر or بعد از ظهر
H | 24-hour format of an hour with leading zeros | + Yes | + Yes | 00 through 23
h | 12-hour format of an hour with leading zeros | + Yes | + Yes | 01 through 12
G | 24-hour format of an hour without leading zeros | + Yes | + Yes | 0 through 23
g | 12-hour format of an hour without leading zeros | + Yes | + Yes | 1 through 12
i | Minutes with leading zeros | + Yes | + Yes | 00 to 59
s | Seconds with leading zeros | + Yes | + Yes | 00 through 59
M | A short textual representation of a month, three letters | + Yes | - No | Jan through Dec
D | A textual representation of a day, three letters | + Yes | - No | Mon through Sun
l | A full textual representation of the day of the week | + Yes | - No | Sunday through Saturday
N | ISO 8601 numeric representation of the day of the week | + Yes | - No | 1 (for Monday) through 7 (for Sunday)
S | English ordinal suffix for the day of the month, 2 characters | + Yes | - No | st, nd, rd or th. Works well with j 
w | Numeric representation of the day of the week | + Yes | - No | 0 (for Sunday) through 6 (for Saturday)
z | The day of the year (starting from 0) | + Yes | - No | 0 through 365
W | ISO 8601 week number of year, weeks starting on Monday | + Yes | - No | Example: 42 (the 42nd week in the year)
t | Number of days in the given month | + Yes | - No | 28 through 31
L | Whether it's a leap year | + Yes | - No | 1 if it is a leap year, 0 otherwise.
--- | Other Official PHP date formats | + Yes | - No | Check [PHP Document](https://www.php.net/manual/en/datetime.format.php)


### Input Functions:

Function Name | Inputs
--- | ---
`fromJalali()` | String $JalaliDate: Jalali datetime string, String $format (default: 'Y-m-d H:i:s'): Jalali datetime format
`fromGeorgian()` | String $georgianDate: Georgian datetime string, String $format (default: 'Y-m-d H:i:s'): Georgian datetime format
`fromCarbon()` | Carbon $carbon: Carbon DateTime
`fromTimestamp()` | Int $timestamp: Georgian timestamp

### Convert Functions:

Function Name | For what? | Requirement
--- | --- | ---
`toJalali()` | To convert your date to Jalali calender | Using after `fromGeorgian()` or `fromCarbon()` 
`toGeorgian()` | To convert your date to Georgian calender | Using after `fromJalali()`

### Output Functions:

Function Name | Input | Return
--- | --- | ---
`toFormat()` | String $format (default: 'Y-m-d H:i:s'): Datetime format based on your date type | String $resultDateByFormat: DateTime based on your $format from input
`toTimestamp()`| --- | Int $timestamp: Timestamp for your Georgian datetime.
`toCarbon()`| --- | Carbon $carbon: A Carbon class with your Georgian datetime.
`year()` | --- | $year
`month()` | --- | $month
`day()` | --- | $day
`hour()` | --- | $hour
`minute()` | --- | $minute
`second()` | --- | $second

### Modify Functions:

Function Name | Input
--- | ---
`addYear()` | Int $years (default: 1): number of years to add datetime
`addMonth()` | Int $months (default: 1): number of months to add datetime
`addDay()` | Int $days (default: 1): number of days to add datetime
`addHour()` | Int $hours (default: 1): number of hours to add datetime
`addMinute()` | Int $minutes (default: 1): number of minutes to add datetime
`addSecond()` | Int $seconds (default: 1): number of seconds to add datetime
`modify()` | Array $datetimeArray: array of different datetime items to increase like: `$datetimeArray['day'] = 25;`

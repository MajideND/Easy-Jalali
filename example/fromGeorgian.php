<?php

require __DIR__ . '/../vendor/autoload.php';
use EasyJalali\JalaliDate;


class Example
{

    public static function test()
    {
        $JalaliDate = JalaliDate::fromGeorgian('2022-01-12 10:59:59', 'Y-d-m H:i:s');
        echo 'تاریخ به شمسی: ' . $JalaliDate->toJalali()->toFormat('ماه F از Y-m-d و h:i:s A');
        return;
    }
}


Example::test();

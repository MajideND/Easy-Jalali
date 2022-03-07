<?php

require __DIR__ . '/../vendor/autoload.php';
use EasyJalali\JalaliDate;


class Example
{

    public static function test()
    {
        $JalaliDate = JalaliDate::fromJalali('1399-12-12 08:29:59', 'Y-m-d H:i:s');
echo 'l jS \of F Y h:i:s A: ' . $JalaliDate->toGeorgian()->toFormat('l jS \of F Y h:i:s A');
echo "\nY-m-d: " . $JalaliDate->toGeorgian()->toFormat('Y-m-d H:i:s');
echo "\nget Hour: " . $JalaliDate->minute();
echo "\nget Second: " . $JalaliDate->second();
echo "\nget Jalali Second: " . $JalaliDate->toGeorgian()->second();
        return;
    }
}


Example::test();




<?php

require __DIR__ . '/../vendor/autoload.php';
use EasyJalali\JalaliDate;

$nowJalali = JalaliDate::now(false)->year();
$nowGeorgian = JalaliDate::now()->toFormat('Y-m-d');
$nextMonthJalali = JalaliDate::now(false)->addMonth()->toFormat('Y-m-d');
$nextWeek = JalaliDate::now()->addDay(7)->toFormat('Y-m-d');
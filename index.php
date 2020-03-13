<?php
require_once 'model.php';

$age = 24;
//$baseTariff = new BaseTariff(true);
//$baseTariff -> calc(1,10, $age);

//$hourTariff = new HourTariff();
//$hourTariff-> calc(0,120,$age);

//$dayTariff = new DayTariff();
//$dayTariff->calc(0,120, $age);
//
$studentTariff = new StudentTariff();
$studentTariff-> calc(0,120, $age);

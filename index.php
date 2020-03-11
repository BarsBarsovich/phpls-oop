<?php
require_once 'model.php';

$age = 35;
$baseTariff = new BaseTariff();
$baseTariff -> calc(10,10, $age);

$hourTariff = new HourTariff();
$hourTariff-> calc(0,120,$age);

$dayTariff = new DayTariff();
$dayTariff->calc(0,120, $age);

$studentTariff = new StudentTariff();
$studentTariff-> calc(0,120, $age);

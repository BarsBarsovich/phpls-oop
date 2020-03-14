<?php

trait Gps
{
    protected $gpsCost = 15;

    public function calcGps(int $hour)
    {
        return $this->gpsCost * $hour;
    }
}

trait AdditionalDriver
{
    protected $driverCost = 100;
}

interface iTariff
{
    public function calc(int $kilos, int $minutes, int $age);
}

abstract class Tariff implements iTariff
{
    protected $costPerMinute;
    protected $costPerKilometer;

    public function calc(int $kilos, int $minutes, int $age)
    {
        $result = (($this->costPerKilometer * $kilos) + ($this->costPerMinute * $minutes)) * $this->getAgeCoeff($age);
        return $result;
    }

    private function getAgeCoeff(int $age)
    {
        if ($age > 18 && $age < 21) {
            return 1.1;
        }
        return 1;
    }

}

class BaseTariff extends Tariff
{
    protected $costPerKilometer = 10;
    protected $costPerMinute = 3;
    private $useGps;
    use Gps;

    public function __construct($useGps = false)
    {
        $this->useGps = $useGps;
    }

    public function calc(int $kilos, int $minutes, int $age)
    {
        $hours = $minutes / 60;
        $gpsCost = 0;
        if ($this->useGps) {
            $gpsCost = $this->calcGps($hours);
        }
        $totalCost = parent::calc($kilos, $minutes, $age) + $gpsCost;
        echo $totalCost;
    }
}

class HourTariff extends Tariff
{
    protected $costPerKilometer = 0;
    protected $costPerMinute = 200;
    use Gps;
    use AdditionalDriver;

    private $useGps;
    private $useDriver;

    public function __construct($useGps = false, $useDriver = false)
    {
        $this->useGps = $useGps;
        $this->useDriver = $useDriver;
    }

    public function calc(int $kilos, int $minutes, int $age)
    {
        $hour = ceil($minutes / 60);
        $convertedMinutes = $hour * 60;

        $gpsCost = 0;
        if ($this->useGps) {
            $gpsCost = $this->calcGps($hour);
        }

        $driverCost = 0;
        if ($this->useDriver) {
            $driverCost = $this->driverCost;
        }

        $totalCost = parent::calc($kilos, $convertedMinutes, $age) + $gpsCost + $driverCost;
        echo $totalCost;
    }
}

class DayTariff extends Tariff
{
    protected $costPerKilometer = 1;
    protected $costPerMinute = 1000;
    private $useGps;
    private $useAdditionalDriver;
    use Gps;
    use AdditionalDriver;

    public function __construct($useGps = false, $useAdditionalDriver = false)
    {
        $this->useGps = $useGps;
        $this->useAdditionalDriver = $useAdditionalDriver;
    }


    public function calc(int $kilos, int $minutes, int $age)
    {

        $days = ceil($minutes / 1440);
        $convertedMinutes = $days * 1440;

        $gpsCost = 0;

        if ($this->useGps) {
            $this->calcGps($days / 24);
        }

        $driverCost = 0;

        if ($this->useAdditionalDriver) {
            $driverCost = $this->driverCost;
        }

        $totalCost = parent::calc($kilos, $convertedMinutes, $age) + $driverCost + $gpsCost;
        echo $totalCost;
    }
}

class StudentTariff extends Tariff
{
    protected $costPerKilometer = 4;
    protected $costPerMinute = 1;
    private $useTrait;
    use Gps;

    public function __construct($useGps = false)
    {
        $this->useTrait = $useGps;
    }

    public function calc(int $kilos, int $minutes, int $age)
    {
        if ($age > 25) {
            die('Неправильный возраст');
        }

        $cost = 0;
        if ($this->useTrait) {
            $cost = $this->calcGps($minutes);
        }

        $cost = $cost + parent::calc($kilos, $minutes, $age);
        echo $cost;
    }
}

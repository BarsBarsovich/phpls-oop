<?php

trait Gps
{
    protected $gpsCost = 15;
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

}

class BaseTariff extends Tariff
{
    protected $costPerKilometer = 10;
    protected $costPerMinute = 3;
    private $useGps;
    use Gps;

    public function __construct($useGps)
    {
        $this->useGps = $useGps;
    }

    public function calc(int $kilos, int $minutes, int $age)
    {
        $gpsCostPerKilometer = 1;
        $gpsCostPerHour = 1;
        if ($this->useGps) {
            $gpsCostPerKilometer = $this->gpsCost * $this->costPerKilometer * $kilos;
            $gpsCostPerHour = $this->gpsCost * $this->costPerMinute * $minutes;
        }
        echo 'Per kilometer' . $gpsCostPerKilometer + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $gpsCostPerHour + $this->costPerHour * $kilos * 0.1 * getAgeRange($age) ? 0.1 : 1;
    }
}

class HourTariff extends Tariff
{
    protected $costPerKilometer = 0;
    private $costPerHour = 200;
    use Gps;
    use AdditionalDriver;

    private $useGps;
    private $useDriver;

    public function __construct($useGps, $useDriver)
    {
        $this->useGps = $useGps;
        $this->useDriver = $useDriver;
    }

    public function calc(int $kilos = 0, int $minutes, int $age)
    {
        $gpsCostPerKilometer = 0;
        $gpsCostPerHour = 0;
        $driverCostPerKilometer = 0;
        $driverCostPerHour = 0;

        if ($this->useGps) {
            $gpsCostPerKilometer = $this->gpsCost * $this->costPerKilometer * $kilos;
            $gpsCostPerHour = $this->gpsCost * $this->costPerHour * $minutes;
        }

        if ($this->useDriver) {
            $driverCostPerKilometer = $this->driverCost * $this->costPerKilometer;
            $driverCostPerHour = $this->driverCost * $this->costPerHour;
        }

        echo 'Per kilometer' . $gpsCostPerKilometer + $driverCostPerKilometer + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $gpsCostPerHour + $driverCostPerHour + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;

    }
}

class DayTariff extends Tariff
{
    protected $costPerKilometer = 1;
    private $costPerHour = 1000;
    private $useGps;
    private $useAdditionalDriver;
    use Gps;
    use AdditionalDriver;

    public function __construct($useGps, $useAdditionalDriver)
    {
        $this->useGps = $useGps;
        $this->useAdditionalDriver = $useAdditionalDriver;
    }


    public function calc(int $kilos = 0, int $minutes, int $age)
    {

        $gpsCostPerKilometer = 0;
        $gpsCostPerMinute = 0;
        if ($this->useGps) {
            $gpsCostPerKilometer = $this->gpsCost * $this->costPerKilometer * $kilos;
            $gpsCostPerMinute = $this->gpsCost * $this->costPerHour * $minutes;
        }

        $driverCostPerKilometer = 0;
        $driverCostPerMinute = 0;
        if ($this->useAdditionalDriver) {
            $driverCostPerKilometer = $this->driverCost * $this->costPerKilometer * $kilos;
            $driverCostPerMinute = $this->driverCost * $this->costPerMinute * $minutes;

        }

        echo 'Per kilometer' . $gpsCostPerKilometer + $driverCostPerKilometer + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $gpsCostPerMinute + $driverCostPerMinute + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;
    }
}

class StudentTariff extends Tariff
{
    protected $costPerKilometer = 4;
    private $costPerHour = 1;
    private $useTrait;
    use Gps;

    public function __construct($useGps)
    {
        $this->useTrait = $useGps;
    }

    public function calc(int $kilos = 0, int $minutes, int $age)
    {
        if ($age > 25) {
            die('Неправильный возраст');
        }

        $cost = 0;
        if ($this->trait) {
            $cost = $this->gpsCost;
        }
        echo 'Per kilometer' . ($cost * $this->costPerKilometer) + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;;
        echo 'Per Hour' . ($cost * $this->costPerKilometer) + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;
    }
}

function getAgeRange(int $age)
{
    return $age > 18 && $age < 21;
}


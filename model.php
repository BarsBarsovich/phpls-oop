<?php

trait Gps
{
    protected $gpsCost = 15;
}

trait AdditionalDriver
{
    protected  $driverCost = 100;
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
    private $useTrait;
    use Gps;

    public function __construct($useTrait)
    {
        $this->useTrait = $useTrait;
    }

    public function calc(int $kilos, int $minutes, int $age)
    {
        $cost = 1;
        if ($this->useTrait) {
            $cost = $this->gpsCost;
        }
        echo 'Per kilometer' . $cost + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $cost + $this->costPerHour * $kilos * 0.1 * getAgeRange($age) ? 0.1 : 1;
    }
}

class HourTariff extends Tariff
{
    protected $costPerKilometer = 0;
    private $costPerHour = 200;
    use Gps;
    use AdditionalDriver;

    private $trait;

    public function __construct($isNeedTrait)
    {
        $this->trait = $isNeedTrait;
    }

    public function calc(int $kilos = 0, int $minutes, int $age)
    {
        $cost = 0;

        if ($this->trait) {
            $cost = $this->gpsCost;
            $cost = $cost + $this->driverCost;
        }
        echo 'Per kilometer' . $cost + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $cost + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;

    }
}

class DayTariff extends Tariff
{
    protected $costPerKilometer = 1;
    private $costPerHour = 1000;
    private $trait;
    use Gps;
    use AdditionalDriver;

    public function __construct($isNeedTrait)
    {
        $this->trait = $isNeedTrait;
    }


    public function calc(int $kilos = 0, int $minutes, int $age)
    {

        $cost = 0;
        if ($this->trait) {
            $cost = $this->gpsCost;
            $cost = $cost + $this->driverCost;
        }
        echo 'Per kilometer' . $cost + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;
        echo 'Per Hour' . $cost + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;
        return;

    }
}

class StudentTariff extends Tariff
{
    protected $costPerKilometer = 4;
    private $costPerHour = 1;
    private $useTrait;
    use Gps;

    public function __construct($needTrait)
    {
        $this->useTrait = $needTrait;
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
        echo 'Per kilometer' . $cost + $this->costPerKilometer * $kilos * getAgeRange($age) ? 0.1 : 1;;
        echo 'Per Hour' . $cost + $this->costPerHour * $kilos * getAgeRange($age) ? 0.1 : 1;
    }
}

function getAgeRange(int $age){
    return $age > 18 && $age < 21;
}


<?php

namespace Pleskachov\PhpPro\Core\WEB\Controllers;


use Div;
use Expo;
use Multi;
use Qwe;
use SmartCalculator;
use Sub;
use Sum;

require_once __DIR__ . '/../../../Training/calc/cli_calculator.php';


$calculator = new SmartCalculator();


class TestController
{
    public function TestCalcController()
    {
        /**
         * @var SmartCalculator $calculator
         */

        return $calculator->actionRegistration(new Sum())
            ->actionRegistration(new Sub())
            ->actionRegistration(new Multi())
            ->actionRegistration(new Expo())
            ->actionRegistration(new Qwe())
            ->actionRegistration(new Div());
    }
}
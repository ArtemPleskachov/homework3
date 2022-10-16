<?php


class NumberValidator
{
    protected int|float $value;

    public function __construct($value)
    {
        $this->isNumber($value);
        $this->value = $value;
    }

    protected function isNumber($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException($value . ' - is not a number');
        }
    }
}

interface ICanCalculate
{
    public function calculate(int|float $val1, int|float $val2): int|float;

    public static function getSignature(): string;

}

abstract class Action implements ICanCalculate
{
    const SIGNATURE = '';

    public static function getSignature(): string
    {
        return static::SIGNATURE;
    }
}

class Sum implements ICanCalculate
{

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        return $val1 + $val2;
    }

    public static function getSignature(): string
    {
        return '+';
    }
}

class Sub extends Action
{
    const SIGNATURE = '-';

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        return $val1 - $val2;
    }
}

class Multi extends Action
{
    const SIGNATURE = '*';

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        return $val1 * $val2;
    }
}

class Expo extends Multi
{
    const SIGNATURE = '**';

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        return pow($val1, (int)$val2);
    }
}


class Div extends Action
{
    const SIGNATURE = '/';

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        if ($val2 == 0) {
            throw new InvalidArgumentException('Zero Divided');
        }
        return $val1 / $val2;
    }
}

class Qwe implements ICanCalculate
{

    public function calculate(float|int $val1, float|int $val2): int|float
    {
        return 0;
    }

    public static function getSignature(): string
    {
        return '!';
    }
}

class Calculator
{
    protected array $calculatePossibilities = [];

    public function calculate($val1, $val2, $operator)
    {
        new NumberValidator($val1);
        new NumberValidator($val2);
        if (!isset($this->calculatePossibilities[$operator])) {
            throw new InvalidArgumentException('The operation "' . $operator . '" is impossible');
        }
        return $this->calculatePossibilities[$operator]->calculate($val1, $val2);
    }

    public function actionRegistration(ICanCalculate $action): static
    {
        $this->calculatePossibilities[$action::getSignature()] = $action;
        return $this;
    }

    public function getCalculatePossibilities(): array
    {
        return array_keys($this->calculatePossibilities);
    }
}

class SmartCalculator extends Calculator
{
    public function calculateExpression(string $exp)
    {
        $data = explode(' ', $exp);
        new NumberValidator($data[0]);
        new NumberValidator($data[2]);

        return $this->calculate($data[0], $data[2], $data[1]);
    }
}

//
//$calc = new SmartCalculator();
//$calc->actionRegistration(new Sum())
//    ->actionRegistration(new Sub())
//    ->actionRegistration(new Multi())
//    ->actionRegistration(new Div())
//    ->actionRegistration(new Expo());
//
//echo $calc->calculate(10, 2, '/');
//echo PHP_EOL;
//echo $calc->calculateExpression('23 - 3');
//echo PHP_EOL;


<?php

interface FigureTemplate
{
    public function perimeter();

    public function square();
}

class Triangle implements FigureTemplate
{
    public $side1;
    public $side2;
    public $side3;

    public function __construct($side1, $side2, $side3)
    {
        $this->side1 = $side1;
        $this->side2 = $side2;
        $this->side3 = $side3;
    }

    public function perimeter()
    {
        return $this->side1 + $this->side2 + $this->side3;
    }

    public function square(): float
    {
        $perimeter = $this->perimeter();
        return sqrt($perimeter / 2 * ($perimeter / 2 - $this->side1) * ($perimeter / 2 - $this->side2) * ($perimeter / 2 - $this->side3));
    }
}

class Rectangle implements FigureTemplate
{
    public $side1;
    public $side2;

    public function __construct($side1, $side2)
    {
        $this->side1 = $side1;
        $this->side2 = $side2;
    }

    public function perimeter()
    {
        return ($this->side1 + $this->side2) * 2;
    }

    public function square()
    {
        return $this->side1 * $this->side2;
    }
}

class Square extends Rectangle
{
    public $side1;

    public function __construct($side1)
    {
        $this->side1 = $side1;
    }

    public function perimeter()
    {
        return ($this->side1) * 4;
    }

    public function square()
    {
        return pow($this->side1, 2);
    }
}

class InputData
{
    public $sidesNumber;

    public function __construct($sidesNumber)
    {
        $this->sidesNumber = $sidesNumber + 1;
        $sides = $this->inputSides();

        if ($this->sidesNumber === 1) {
            $calculate = new Square($sides[0]);
        } elseif ($this->sidesNumber === 2) {
            $calculate = new Rectangle($sides[0], $sides[1]);
        } else {
            $calculate = new Triangle($sides[0], $sides[1], $sides[2]);
        }
        echo 'Периметр фигуры ' . $calculate->perimeter() . PHP_EOL;
        echo 'Площадь фигуры ' . $calculate->square() . PHP_EOL;
    }

    public function inputSides(): array
    {
        $sides = [];
        $sideNumber = 1;
        while ($sideNumber <= $this->sidesNumber) {
            $side = readline("Длина стороны $sideNumber: ");
            if (!is_numeric($side) || empty($side)) {
                echo 'Укажите число отличное от нуля!' . PHP_EOL;
                continue;
            }
            $sides[] = abs($side);
            $sideNumber++;
        }
        return $sides;
    }
}

do {
    $inputType = readline('Укажите фигуру (0 - квадрат, 1 - прямоугольник;  2 - треугольник; 3 - выход): ');
} while (!in_array($inputType, [0, 1, 2, 3]));
if (intval($inputType) === 3)
    die();
$figure = new InputData($inputType);
<?php

require_once 'calc.php';

function separator()
{
    return str_repeat('*', 70) . PHP_EOL;
}

$calculator = new SmartCalculator();

try {

    $calculator->actionRegistration(new Sum())
        ->actionRegistration(new Sub())
        ->actionRegistration(new Multi())
        ->actionRegistration(new Expo())
        ->actionRegistration(new Qwe())
        ->actionRegistration(new Div());

} catch (Exception $e) {
    echo $e->getMessage();
    echo separator();
    exit;
} catch (\Error $err) {
    echo $err > getMessage();
    echo separator();
    exit;
}

echo separator();
echo 'Консольний калькулятор' . PHP_EOL;
echo 'Введіть простий вираз для обчислення двох чисел' . PHP_EOL;
echo 'Наприклад: 5 * 2' . PHP_EOL;
echo 'Доступні дії: ' . implode(', ', $calculator->getCalculatePossibilities()) . PHP_EOL;
echo separator();


$inputData = readline('Введіть вираз: ');
try {
    $result = $calculator->calculateExpression($inputData);
    echo 'Результат: ' . $inputData . ' = ' . $result . PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
} catch (\Error $err) {
    echo $err->getMessage();
}
echo PHP_EOL;
echo separator();

exit;
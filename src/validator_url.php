<?php
echo 'I`m work now' . PHP_EOL;
class Someclass
{
    public int $a;

    /**
     * @param $a
     */
    public function __construct($a)
    {
        $this->a = $a;
    }

    public function somedoing(){
        return $this->a**2;
    }
}

$b = new Someclass(2);

echo $b->somedoing() . PHP_EOL;


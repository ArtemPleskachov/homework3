<?php


//метод __toString()
class Message
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }
    public function __toString(): string
    {
       return $this->text;
    }
}

$message = new Message('I`m sting');
echo $message;


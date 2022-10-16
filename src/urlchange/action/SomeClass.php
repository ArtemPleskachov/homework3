<?php
namespace PhpPro\urlchange\action;


class SomeClass
{
    public function DoSomeThing() {
        return 'Hello';
    }

    public function __toString(): string
    {
        return 'Hell0 mother fucker';
    }
}

$someobj = new SomeClass();
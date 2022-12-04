<?php
namespace Pleskachov\PhpPro\Core\Interfaces;


interface ISingleton
{
    public static function getInstance(): self;
}
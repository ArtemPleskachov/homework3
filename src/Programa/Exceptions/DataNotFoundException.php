<?php
namespace Pleskachov\PhpPro\Programa\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $message = 'Data not found';
}
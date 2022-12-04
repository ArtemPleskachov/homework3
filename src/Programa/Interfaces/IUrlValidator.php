<?php
namespace Pleskachov\PhpPro\Programa\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function validateUrl(string $url): bool;


    /**
     * @param string $url
     * @return bool
     */
    public function checkRealUrl(string $url): bool;

}
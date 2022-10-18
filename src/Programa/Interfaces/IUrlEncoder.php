<?php
namespace PhpPro\Programa\Interfaces;

use InvalidArgumentException;

interface IUrlEncoder
{

    /**
     * @param string $url
     * @throws \InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string;
}


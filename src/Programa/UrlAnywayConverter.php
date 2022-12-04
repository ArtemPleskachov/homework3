<?php

namespace Pleskachov\PhpPro\Programa\Utility;

use Pleskachov\PhpPro\Programa\UrlConverter;


class UrlAnywayConverter extends UrlConverter
{
    /**
     * @param string $url
     * @return string
     */

    public function encode(string $url): string
    {
        $this->validateUrl($url);
        return $this->generateAndSaveCode($url);
    }
}
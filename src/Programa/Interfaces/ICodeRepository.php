<?php

namespace Pleskachov\PhpPro\Programa\Interfaces;

use Pleskachov\PhpPro\Programa\Exceptions\DataNotFoundException;
use Pleskachov\PhpPro\Programa\ValueObject\UrlCodePair;


interface ICodeRepository
{
    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlCodePair) : bool;

    /**
     * @param string $code
     * @return bool
     */
    public function codeIsset(string $code): bool; //перевірка чи є вже такий код чи нема

    /**
     * @param string $code
     * @throws DataNotFoundException
     * @return string url
     */
    public function getUrlByCode(string $code): string;

    /**
     * @param string $url
     * @throws DataNotFoundException
     * @return string code
     */
    public function getCodeByUrl(string $url): string;





}


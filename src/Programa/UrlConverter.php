<?php
namespace PhpPro\Programa;

use InvalidArgumentException;
use PhpPro\Programa\Interfaces\{
    ICodeRepository,
    IUrlDecoder,
    IUrlEncoder
};

use PhpPro\Programa\{
    Exceptions\DataNotFoundException,
    ValueObject\UrlCodePair
};

class UrlConverter implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 10;

    protected ICodeRepository $repository;
    protected int $codeLength;
    protected string $codeChairs = '0123456789abcdefghijklmnoprstuywxyz';

    /**
     * @param ICodeRepository $repository
     * @param int $codeLength
     */
    public function __construct(ICodeRepository $repository, int $codeLength = self::CODE_LENGTH) //тут робимо фішку зі статичними методами хз, треба дивитись відео або запитати
    {
        $this->repository = $repository;
        $this->codeLength = $codeLength;
    }

    public function encodeAnyway(string $url): string
    {
        $this->validateUrl($url);
        return $this->generateAndSaveCode($url);
    }


    public function decode(string $code): string
    {
        try {
            $code = $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new \http\Exception\InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
        return $code;
    }


    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return string
     */

    public function encode(string $url): string
    {
        $this->validateUrl($url);
        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (DataNotFoundException $e) {
            $code = $this->generateAndSaveCode($url);
        }
        return $code;
    }

    protected function generateAndSaveCode(string $url): string
    {
        $code = $this->generateUniqueCode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }

    protected function validateUrl(string $url): bool
    {
        if (empty($url)
            || !filter_var($url, FILTER_VALIDATE_URL)
            || !$this->checkRealUrl($url)) {
            throw new \http\Exception\InvalidArgumentException('Url not work');
        }
        return true;
    }

    protected function checkRealUrl(string $url): bool
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($response === 200 || $response === 301);
    }

    protected function generateUniqueCode(): string
    {
        $date = new \DateTime();
        $str = $this->codeChairs . mb_strtoupper($this->codeChairs) . $date->getTimestamp();
        return substr(str_shuffle($str), 0, $this->codeLength);

    }









}
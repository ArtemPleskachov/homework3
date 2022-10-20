<?php
namespace Pleskachov\PhpPro\Programa;

use InvalidArgumentException;
use Pleskachov\PhpPro\Programa\Interfaces\{ICodeRepository, IUrlDecoder, IUrlEncoder, IUrlValidator};
use Pleskachov\PhpPro\Programa\{
    Exceptions\DataNotFoundException,
    ValueObject\UrlCodePair};

class UrlConverter implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 10;
    const CODE_CHAIRS = '0123456789abcdefghijklmnoprstuywxyz';

    protected IUrlValidator $validator;
    protected ICodeRepository $repository;
    protected int $codeLength;

    /**
     * @param ICodeRepository $repository
     * @param int $codeLength
     */

    public function __construct(
        ICodeRepository $repository,
        IUrlValidator $validator,
        int $codeLength = self::CODE_LENGTH)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->codeLength = $codeLength;
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

    protected function generateUniqueCode(): string
    {
        $date = new \DateTime();
        $str = static::CODE_CHAIRS . mb_strtoupper(static::CODE_CHAIRS) . $date->getTimestamp();
        return substr(str_shuffle($str), 0, $this->codeLength);

    }

    protected function validateUrl(string $url): bool
    {
        return $this->validator->validateUrl($url);
    }

    /**
     * @param string $code
     * @return string
     */









}
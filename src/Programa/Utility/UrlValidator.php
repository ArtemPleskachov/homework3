<?php
namespace Pleskachov\PhpPro\Programa\Utility;

use Pleskachov\PhpPro\Programa\Interfaces\IUrlValidator;

class UrlValidator implements IUrlValidator
{

    /**
     * @inheritDoc
     */
    public function validateUrl(string $url): bool
    {
        if (empty($url)
            || !filter_var($url, FILTER_VALIDATE_URL)
            || !$this->checkRealUrl($url)) {
            throw new \http\Exception\InvalidArgumentException('Url not work');
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function checkRealUrl(string $url): bool
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($response === 200 || $response === 301);
    }
}
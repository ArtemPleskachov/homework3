<?php
namespace Pleskachov\PhpPro\Programa\Utility;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use Pleskachov\PhpPro\Programa\Interfaces\IUrlValidator;
use InvalidArgumentException;


class UrlValidator implements IUrlValidator
{
    protected ClientInterface $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return bool
     */

    public function validateUrl(string $url): bool
    {
        if (empty($url)
            || !filter_var($url, FILTER_VALIDATE_URL)
            || !$this->checkRealUrl($url)) {
            throw new InvalidArgumentException('Url not work');
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function checkRealUrl(string $url): bool
    {
        $allowCodes = [
          200, 201, 301, 302
        ];
        try {
            $response = $this->client->request('GET', $url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode(), $allowCodes));
        } catch (ConnectException $exception) {
            throw new \InvalidArgumentException($exception->getMessage(), $exception->getCode());
        }

    }
}
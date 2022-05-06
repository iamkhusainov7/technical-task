<?php

namespace App\ApiDataProviders;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

abstract class ApiDataProviderTemplate
{
    protected const URL_PARAM_KEY = 'url_param';

    public function __construct(
        private readonly ClientInterface $request
    ) {
    }

    /**
     * @throws GuzzleException
     */
    protected function get(string $url, Collection $options): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->parseUrl($url, $options->get(self::URL_PARAM_KEY, []));

        return $this->request->request(\Laravel\Lumen\Http\Request::METHOD_GET, $url, $options->toArray());
    }

    protected function parseUrl(string $url, array $params)
    {
        foreach ($params as $key => $value) {
            if (! preg_match("/\{$key}/", $url)) {
                continue;
            }

            $url = preg_replace("/\{$key}/", $value, $url);
        }

        return $url;
    }
}

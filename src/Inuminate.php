<?php

namespace TPG\Inuminate;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Spatie\Fork\Fork;
use TPG\Inuminate\Contracts\InuminateInterface;

class Inuminate implements InuminateInterface
{
    public function __construct(protected string $siteKey, protected ?string $url = 'https://inuminate.com')
    {
    }

    public function track(): void
    {
        try {
            $client = new Client();

            $client->post($this->endpoint('api/hit'), [
                'json' => [
                    's' => $this->siteKey,
                    'l' => $this->href(),
                    'p' => $this->protocol(),
                    'h' => $this->hostname(),
                    'r' => $this->referer(),
                    'a' => $this->agent(),
                ],
            ]);

        } catch (\Exception $e) {
            //
        }
    }

    protected function endpoint(string $uri): string
    {
        $url = $this->url.(str_ends_with($this->url, '/') ? '' : '/');

        return $url.(str_starts_with($uri, '/') ? substr($uri, 1) : $uri);
    }

    protected function href(): string
    {
        return $this->protocol().'://'.$this->hostname().$_SERVER['REQUEST_URI'];
    }

    protected function protocol(): string
    {
        return isset($_SERVER['HTTPS']) ? 'https' : 'http';
    }

    protected function referer(): ?string
    {
        $referer = $_SERVER['HTTP_REFERER'];

        if (str_contains($referer, $this->hostname())) {
            return null;
        }

        return $referer;
    }

    protected function hostname(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    protected function agent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}

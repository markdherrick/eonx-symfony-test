<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserGeneratorService
{

    private $client;
    private $baseUrl;

    public function __construct(string $baseUrl, HttpClientInterface $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    public function getRandomUsersFromExternalAPI(string $country, string $fields, string $page = '1', string $results): array
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/api',
            [
                'query' => [
                    'nat' => $country,
                    'inc' => $fields,
                    'page' => $page,
                    'results' => $results,
                ]
            ]
        );

        $content = json_decode((string) ($response->getContent()), true);

        return $content;
    }
}

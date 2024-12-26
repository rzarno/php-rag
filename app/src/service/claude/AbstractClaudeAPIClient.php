<?php

namespace service\claude;

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

abstract class AbstractClaudeAPIClient
{
    protected HttpClient $client;
    protected string $apiKey;
    protected string $baseUrl = 'https://api.anthropic.com/v1';

    public function __construct()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Get API key from environment
        $this->apiKey = $_ENV['ANTHROPIC_API_KEY'];

        $this->client = new HttpClient([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'anthropic-version' => '2023-06-01',
                'x-api-key' => $this->apiKey,
                'content-type' => 'application/json'
            ]
        ]);
    }
}
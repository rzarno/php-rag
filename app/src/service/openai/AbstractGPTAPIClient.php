<?php
declare(strict_types=1);

namespace service\openai;

use OpenAI;
use OpenAI\Client;

abstract class AbstractGPTAPIClient
{
    protected Client $client;

    public function __construct()
    {
        $apiKey = file_get_contents(__DIR__ . '/../api_key.txt');
        $this->client = OpenAI::Client($apiKey);
    }
}
<?php

namespace service\claude;

use Dotenv\Dotenv;

abstract class AbstractClaudeAPIClient
{
    protected string $apiKey;

    public function __construct()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Get API key from environment
        $this->apiKey = $_ENV['ANTHROPIC_API_KEY'];
    }

    protected function request(string $prompt, string $endpoint, string $model): array
    {
        $url = 'https://api.anthropic.com/v1/' . $endpoint;

        $maxTokens = 2048;
        $temperature = 0;
        $messages = [
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ];

        $data = [
            'model' => $model,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
            'messages' => $messages
        ];

        $jsonData = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'x-api-key: ' . $this->apiKey,
                'anthropic-version: 2023-06-01',
                'content-type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response, true);
        error_log(json_encode($responseData) . PHP_EOL);

        return $responseData;
    }
}
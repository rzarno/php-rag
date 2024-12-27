<?php

namespace service\gemini;

use Dotenv\Dotenv;

abstract class AbstractGeminiAPIClient
{
    protected string $apiKey;

    public function __construct()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Get API key from environment
        $this->apiKey = $_ENV['GOOGLE_GEMINI_API_KEY'];
    }

    protected function request(string $method, string $model, array $data): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:$method?key=" . $this->apiKey;

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
            CURLOPT_HTTPHEADER => ['content-type: application/json'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response, true);

        return $responseData;
    }
}

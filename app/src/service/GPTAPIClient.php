<?php
namespace app\src\service;

use OpenAI;
use OpenAI\Client;

class GPTAPIClient
{
    private string $model = 'gpt-4o';
    private string $embeddingModel = 'text-embedding-ada-002';
    private Client $client;

    public function __construct()
    {
        $apiKey = file_get_contents('../api_key.txt');
        $this->client = OpenAI::Client($apiKey);
    }

    public function getEmbeddings(string $document): string
    {
        $response = $this->client->embeddings()->create([
            'input' => $document,
            'model' => $this->embeddingModel
        ]);
        return json_encode($response->embeddings[0]->embedding);
    }

    public function generateText(string $prompt, string $sourceDocuments): string
    {
        # prepare API input
        $input = $sourceDocuments . "\n\n##### INPUT: \n"  . $prompt . "\n##### RESPONSE:\n";

        # get API response
        $response = $this->client->chat()->create([
            'model' => $this->model,
            'messages' => [
                [
                    'content' => $input,
                    'role' => 'user'
                ]
            ]
        ]);

        return $response->choices[0]->message->content;
    }
}
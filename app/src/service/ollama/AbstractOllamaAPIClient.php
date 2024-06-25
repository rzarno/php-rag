<?php
namespace service\ollama;

use GuzzleHttp\Client;

Abstract class AbstractOllamaAPIClient
{
    protected function request(string $input)
    {
        # get response
        $client = new Client();
        $response = $client->request('POST', 'http://ollama-container:11434' . $this->getEndpoint(), [
            'body' => json_encode($this->getBodyParams($input))
        ]);
        return $response->getBody()->getContents();
    }

    abstract protected function getEndpoint(): string;

    abstract protected function getBodyParams(string $input): array;
}
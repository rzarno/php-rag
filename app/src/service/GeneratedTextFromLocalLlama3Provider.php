<?php
declare(strict_types=1);

namespace service;

use service\pipeline\Payload;
use League\Pipeline\StageInterface;

final class GeneratedTextFromLocalLlama3Provider implements StageInterface
{
    public function generateText(string $prompt, string $sourceDocuments): string
    {
        # prepare input
        $input = $sourceDocuments . "\n\n##### INPUT: \n"  . $prompt . "\n##### RESPONSE:\n";

        # get response
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://localhost:11434/api/generate', [
            'body' => json_encode([
                "model" => "llama3",
                "prompt" => $input
            ])
        ]);
        $body = $response->getBody()->getContents();
        $rows = preg_split('/\n/', $body);
        $response = array_map(function($item){
            $row = json_decode($item, true);
            return $row['response'];
        }, $rows);

        return implode('', $response);
    }

    /**
     * @param Payload $payload
     * @return string
     */
    public function __invoke($payload)
    {
        return $this->generateText($payload->getPrompt(), $payload->getRagPrompt());
    }
}
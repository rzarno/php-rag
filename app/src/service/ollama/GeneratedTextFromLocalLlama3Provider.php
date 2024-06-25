<?php
declare(strict_types=1);

namespace service\ollama;

use service\GeneratedTextProviderInterface;
use League\Pipeline\StageInterface;
use service\pipeline\Payload;

final class GeneratedTextFromLocalLlama3Provider extends AbstractOllamaAPIClient
    implements StageInterface, GeneratedTextProviderInterface
{
    public function generateText(string $prompt, string $sourceDocuments): string
    {
        # prepare input
        $input = $sourceDocuments . "\n\n##### INPUT: \n"  . $prompt . "\n##### RESPONSE:\n";
        $body = $this->request($input);

        $rows = preg_split('/\n/', $body);
        $response = array_map(function($item){
            $row = json_decode($item, true);
            if ($row) {
                return $row['response'];
            }
            return '';
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

    protected function getEndpoint(): string
    {
        return '/api/generate';
    }

    protected function getBodyParams(string $input): array
    {
        return [
            "model" => "llama3",
            "prompt" => $input
        ];
    }
}
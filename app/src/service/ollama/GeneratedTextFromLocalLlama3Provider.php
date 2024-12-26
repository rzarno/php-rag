<?php
declare(strict_types=1);

namespace service\ollama;

use service\GeneratedTextProviderInterface;
use League\Pipeline\StageInterface;
use service\pipeline\Payload;

final class GeneratedTextFromLocalLlama3Provider extends AbstractOllamaAPIClient
    implements StageInterface, GeneratedTextProviderInterface
{
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
            "model" => "llama3.2",
            "prompt" => $input
        ];
    }
}
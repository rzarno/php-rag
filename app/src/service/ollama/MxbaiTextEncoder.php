<?php
declare(strict_types=1);

namespace service\ollama;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;
use service\TextEncoderInterface;

final class MxbaiTextEncoder extends AbstractOllamaAPIClient
    implements StageInterface, TextEncoderInterface
{
    private string $embeddingModel = 'mxbai-embed-large';

    public function getEmbeddings(string $document): string
    {
        $response = $this->request($document);
        return json_encode(json_decode($response, true)['embedding']);
    }

    /**
     * @param Payload $payload
     * @return Payload
     */
    public function __invoke($payload)
    {
        return $payload->setEmbeddingPrompt($this->getEmbeddings($payload->getPrompt()));
    }

    protected function getEndpoint(): string
    {
        return '/api/embeddings';
    }

    protected function getBodyParams(string $input): array
    {
        return [
            "model" => $this->embeddingModel,
            "prompt" => $input
        ];
    }
}
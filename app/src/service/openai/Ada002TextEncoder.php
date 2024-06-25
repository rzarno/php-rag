<?php
declare(strict_types=1);

namespace service\openai;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;
use service\TextEncoderInterface;

final class Ada002TextEncoder extends AbstractGPTAPIClient
    implements StageInterface, TextEncoderInterface
{
    private string $embeddingModel = 'text-embedding-ada-002';

    public function getEmbeddings(string $document): string
    {
        $response = $this->client->embeddings()->create([
            'input' => $document,
            'model' => $this->embeddingModel
        ]);
        return json_encode($response->embeddings[0]->embedding);
    }

    /**
     * @param Payload $payload
     * @return Payload
     */
    public function __invoke($payload)
    {
        return $payload->setEmbeddingPrompt($this->getEmbeddings($payload->getPrompt()));
    }
}
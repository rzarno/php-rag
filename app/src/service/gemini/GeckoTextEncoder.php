<?php

namespace service\gemini;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;
use service\TextEncoderInterface;

final class GeckoTextEncoder extends AbstractGeminiAPIClient
    implements StageInterface, TextEncoderInterface
{
    private string $embeddingModel = 'textembedding-gecko';

    public function getEmbeddings(string $document): string
    {
        $modelPath = $this->getModelPath($this->embeddingModel);

        // Create the request
        $instance = [
            'content' => $document
        ];

        // Get embeddings from Gemini API
        $response = $this->client->predict($modelPath, [
            'instances' => [$instance]
        ]);

        // Extract and encode embeddings
        $embeddings = $response->predictions[0]->embeddings->values;
        return json_encode($embeddings);
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
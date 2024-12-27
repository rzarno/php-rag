<?php

namespace service\gemini;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;
use service\TextEncoderInterface;

final class GeminiTextEncoder extends AbstractGeminiAPIClient
    implements StageInterface, TextEncoderInterface
{
    private string $embeddingModel = 'text-embedding-004';

    public function getEmbeddings(string $document): string
    {
        //TODO add chunks embeddings
        $document = substr($document, 0, 9000);
        // Create the request
        $embeddings = $this->request(
            'embedContent',
            $this->embeddingModel,
            [
                'content' => ['parts' => [[
                    'text' => $document
                ]]]
            ]
        );
        return json_encode($embeddings['embedding']['values']);
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
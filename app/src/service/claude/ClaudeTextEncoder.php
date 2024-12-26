<?php

namespace service\claude;

use League\Pipeline\StageInterface;
use service\TextEncoderInterface;

final class ClaudeTextEncoder extends AbstractClaudeAPIClient
    implements StageInterface, TextEncoderInterface
{
    public function getEmbeddings(string $document): string
    {
        $response = $this->client->post('/embeddings', [
            'json' => [
                'model' => 'claude-3-sonnet-20241022',
                'input' => $document
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return json_encode($result['embeddings'][0]);
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

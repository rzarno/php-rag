<?php

namespace service;

use service\pipeline\Payload;
use League\Pipeline\StageInterface;
use Rajentrivedi\TokenizerX\TokenizerX;

class RAGPromptProvider implements StageInterface
{
    const CONTEXT_TOKEN_COUNT = 1000;

    public function getRAGPrompt(array $documentsChosen, string $prompt): string
    {
        $contextTokenCount = self::CONTEXT_TOKEN_COUNT - TokenizerX::count($prompt) - 20;
        $input = '';
        foreach ($documentsChosen as $document) {
            $input .= $document['text'] . "\n";
            $tokens = TokenizerX::tokens($input, "gpt-4");

            if (count($tokens) > $contextTokenCount) {
                break;
            }
        }

        return  $input;
    }

    /**
     * @param Payload $payload
     * @return Payload
     */
    public function __invoke($payload)
    {
        return $payload->setRagPrompt($this->getRAGPrompt($payload->getSimilarDocuments(), $payload->getPrompt()));
    }
}
<?php

namespace service;

use Rajentrivedi\TokenizerX\TokenizerX;

class RAGInputProvider
{
    const CONTEXT_TOKEN_COUNT = 1000;

    public function getRAGInput(array $documentsChosen, string $prompt): string
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
}
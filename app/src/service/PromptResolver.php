<?php

namespace app\src\service;

class PromptResolver
{
    public function getPromptFromInput(): string
    {
        $prompt = $_POST['prompt'] ?? null;
        if (! $prompt) {
            $prompt = $argv[0] ?? null;
        }
        if (! $prompt) {
            $prompt = 'What is the result of 2 + 2?';
        }
        return $prompt;
    }
}
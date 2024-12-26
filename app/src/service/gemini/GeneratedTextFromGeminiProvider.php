<?php

namespace service\gemini;

use League\Pipeline\StageInterface;
use service\GeneratedTextProviderInterface;
use service\pipeline\Payload;

final class GeneratedTextFromGeminiProvider extends AbstractGeminiAPIClient
    implements StageInterface, GeneratedTextProviderInterface
{
    private string $model = 'gemini-pro';

    public function generateText(string $prompt, string $sourceDocuments): string
    {
        $modelPath = $this->getModelPath($this->model);

        // Prepare the content
        $content = $sourceDocuments . "\n\n##### INPUT: \n" . $prompt . "\n##### RESPONSE:\n";

        // Create the request
        $instance = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $content]]
                ]
            ]
        ];

        $parameters = [
            'temperature' => 0.7,
            'maxOutputTokens' => 2048,
            'topP' => 0.8,
            'topK' => 40
        ];

        // Call Gemini API
        $response = $this->client->predict($modelPath, [
            'instances' => [$instance],
            'parameters' => $parameters
        ]);

        // Extract the generated text from response
        $prediction = $response->predictions[0];
        return $prediction->candidates[0]->content->parts[0]->text;
    }

    /**
     * @param Payload $payload
     * @return string
     */
    public function __invoke($payload)
    {
        return $this->generateText($payload->getPrompt(), $payload->getRagPrompt());
    }
}
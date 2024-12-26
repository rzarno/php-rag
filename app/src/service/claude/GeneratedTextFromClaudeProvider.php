<?php

namespace service\claude;

use League\Pipeline\StageInterface;
use service\GeneratedTextProviderInterface;

final class GeneratedTextFromClaudeProvider extends AbstractClaudeAPIClient
    implements StageInterface, GeneratedTextProviderInterface
{
    private string $model = 'claude-3-sonnet-20241022';

    public function generateText(string $prompt, string $sourceDocuments): string
    {
        // Prepare API input
        $messages = [
            [
                'role' => 'user',
                'content' => $sourceDocuments . "\n\n##### INPUT: \n" . $prompt . "\n##### RESPONSE:\n"
            ]
        ];

        // Make API request
        $response = $this->client->post('/messages', [
            'json' => [
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => 4096
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result['content'][0]['text'];
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
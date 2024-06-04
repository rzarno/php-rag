<?php

use service\Encoder;

require __DIR__ . '/vendor/autoload.php';

const CONTEXT_TOKEN_COUNT = 1000;
$apiKey = file_get_contents('api_key.txt');
$prompt = $argv[1];
if (! $prompt) {
    $prompt = 'What is the result of 2 + 2?';
}

$client = OpenAI::Client($apiKey);
$model = 'gpt-4o';

$documents = []; //TODO add documents and process

$encoder = new Encoder(); //TODO implement encoder
$contextTokenCount = CONTEXT_TOKEN_COUNT - count($encoder->encode($prompt)) - 20;
$input = '';
foreach($documents as $document) {
    $input .= $document . PHP_EOL;
    $tokens = $encoder->encode($input);

    if (count($tokens) > $contextTokenCount) {
        $input = $encoder->decode(array_slice($tokens, 0, $contextTokenCount));
        break;
    }
}

$input .= "\n\n##### INPUT: \n"  . $prompt . "\n##### RESPONSE:\n";

$response = $client->chat()->create([
    'model' => $model,
    'messages' => [
        [
            'content' => $input,
            'role' => 'user'
        ]
    ]
]);

echo $input;
echo $response->choices[0]->message->content;
echo "\n";
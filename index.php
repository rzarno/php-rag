<?php

use Rajentrivedi\TokenizerX\TokenizerX;
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

#load documents
$path    = 'documents';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
$documents = [];
foreach($files as $file) {
    $document = file_get_contents($path . '/' . $file);
    $documents[] = $document;
}

#prpare RAG input
$contextTokenCount = CONTEXT_TOKEN_COUNT - TokenizerX::count($prompt) - 20;
$input = '';
foreach($documents as $document) {
    $input .= $document . "\n";
    $tokens = TokenizerX::tokens($input, "gpt-4");

    if (count($tokens) > $contextTokenCount) {
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
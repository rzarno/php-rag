<?php

use service\Encoder;

require __DIR__ . '/../../vendor/autoload.php';

$apiKey = 'XXX';

$client = OpenAI::Client($apiKey);
$model = 'gpt-3.5-turbo-instructs';

$documents = []; //TODO add documents and process

$input = '';
$prompt = '';//TODO add prompt
$encoder = new Encoder(); //TODO implement encoder
$contextTokenCount = (integer)$_ENV['CONTEXT_TOKEN_COUNT'] - count($encoder->encode($prompt)) - 20;

foreach($documents as $document) {
    $input .= $document . PHP_EOL;
    $tokens = $encoder->encode($input);

    if (count($tokens) > $contextTokenCount) {
        $input = $encoder->decode(array_slice($tokens, 0, $contextTokenCount));
        break;
    }
}

$input .= PHP_EOL . PHP_EOL . "### Instruction: " . PHP_EOL . $prompt . PHP_EOL . "### Response: " . PHP_EOL;


$response = $this->client->chat()->create([
    'model' => $this->model,
    'messages' => [
        [
            'content' => $input,
            'role' => 'user'
        ]
    ]
]);
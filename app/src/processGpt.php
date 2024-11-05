<?php

use service\openai\Ada002TextEncoder;
use League\Pipeline\FingersCrossedProcessor;
use League\Pipeline\Pipeline;
use service\DocumentProvider;
use service\openai\GeneratedTextFromGPTProvider;
use service\pipeline\Payload;
use service\PromptResolver;
use service\RAGPromptProvider;

require __DIR__ . '/vendor/autoload.php';

$promptResolver = new PromptResolver();
$textEncoder = new Ada002TextEncoder();
$documentProvider = new DocumentProvider();
$generatedTextProvider = new GeneratedTextFromGPTProvider();
$ragPromptProvider = new RAGPromptProvider();

$payload = new Payload();

$pipeline = (new Pipeline(new FingersCrossedProcessor()))
    ->pipe($promptResolver) //get prompt from POST or CLI
    ->pipe($textEncoder) //get embeddings for prompt
    ->pipe($documentProvider) //find documents with similarity to prompt
    ->pipe($ragPromptProvider) //prepare RAG input - combine prompt with matched source documents
    ->pipe($generatedTextProvider); //get API response

$response = $pipeline->process($payload);

if (isset($_GET['api'])) {
    echo $response;
} else {
    echo "<h1>RESPONSE:</h1>";
    echo "<br /><br />";
    echo $response;
    echo "<br /><br /><br /><br />";
    echo "<h1>DOCUMENTS:</h1>";
    echo "<br /><br />";
    echo $payload->getRagPrompt();
}
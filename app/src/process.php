<?php
use League\Pipeline\FingersCrossedProcessor;
use League\Pipeline\Pipeline;
use service\DocumentProvider;
use service\GeneratedTextProvider;
use service\pipeline\Payload;
use service\PromptResolver;
use service\RAGPromptProvider;
use service\TextEncoder;

require __DIR__ . '/vendor/autoload.php';

$promptResolver = new PromptResolver();
$textEncoder = new TextEncoder();
$documentProvider = new DocumentProvider();
$ragPromptProvider = new RAGPromptProvider();
$generatedTextProvider = new GeneratedTextProvider();
$payload = new Payload();

$pipeline = (new Pipeline(new FingersCrossedProcessor()))
    ->pipe($promptResolver) //get prompt from POST or CLI
    ->pipe($textEncoder) //get embeddings for prompt
    ->pipe($documentProvider) //find documents with similarity to prompt
    ->pipe($ragPromptProvider) //prepare RAG input - combine prompt with matched source documents
    ->pipe($generatedTextProvider); //get API response

$response = $pipeline->process($payload);


echo "<h1>DOCUMENTS:</h1>";
echo "<br /><br />";
echo $payload->getRagPrompt();
echo "<br /><br /><br /><br />";
echo "<h1>RESPONSE:</h1>";
echo "<br /><br />";
echo $response;
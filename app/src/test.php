<?php
use service\GeneratedTextFromLocalLlama3Provider;
use service\pipeline\Payload;

require __DIR__ . '/vendor/autoload.php';

$payload = new Payload();
$generatedTextProvider = new GeneratedTextFromLocalLlama3Provider();
$payload->setPrompt('What is the result of 2 + 2?')->setRagPrompt('');
echo $generatedTextProvider($payload);
die;
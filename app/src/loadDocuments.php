<?php

use service\DocumentLoader;
use service\ollama\MxbaiTextEncoder;
use service\openai\Ada002TextEncoder;

require __DIR__ . '/vendor/autoload.php';

//$textEncoder = new Ada002TextEncoder(); //Use for setup option "B" with OpenAI API
$textEncoder = new MxbaiTextEncoder(); //Use for setup option "A" with ollama Llama local model
$documentLoader = new DocumentLoader($textEncoder);

#load documents
$documentLoader->loadDocuments();
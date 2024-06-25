<?php

use service\DocumentLoader;
use service\ollama\MxbaiTextEncoder;
use service\openai\Ada002TextEncoder;

require __DIR__ . '/vendor/autoload.php';

//$textEncoder = new Ada002TextEncoder()
$textEncoder = new MxbaiTextEncoder();
$documentLoader = new DocumentLoader($textEncoder);

#load documents
$documentLoader->loadDocuments();
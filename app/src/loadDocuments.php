<?php
use service\TextEncoder;
use service\DocumentLoader;

require __DIR__ . '/vendor/autoload.php';

$textEncoder = new TextEncoder();
$documentLoader = new DocumentLoader($textEncoder);

#load documents
$documentLoader->loadDocuments();
<?php
use service\DocumentLoader;
use service\DocumentRepository;
use service\GPTAPIClient;

require __DIR__ . '/vendor/autoload.php';

sleep(20);
$documentRrepository = new DocumentRepository();
$apiClient = new GPTAPIClient();
$documentLoader = new DocumentLoader($apiClient, $documentRrepository);

#load documents
$documentLoader->loadDocuments();
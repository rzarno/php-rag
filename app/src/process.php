<?php

use service\DocumentLoader;
use service\DocumentRepository;
use service\GPTAPIClient;
use service\PromptResolver;
use service\RAGInputProvider;

require __DIR__ . '/vendor/autoload.php';

$documentRrepository = new DocumentRepository();
$apiClient = new GPTAPIClient();
$promptResolver = new PromptResolver();
$ragProvider = new RAGInputProvider();
$documentLoader = new DocumentLoader($apiClient, $documentRrepository);

#load documents
$documentLoader->loadDocuments();
#get prompt from POST or CLI or create default "2+2="
$prompt = $promptResolver->getPromptFromInput();
# get embeddings for prompt
$embeddingPrompt = $apiClient->getEmbeddings($prompt);
#find documents with similarity to prompt
$documentsChosen = $documentRrepository->getSimilarDocuments($embeddingPrompt);
# prepare RAG input - combine prompt with matched source documents
$input = $ragProvider->getRAGInput($documentsChosen, $prompt);

# get API response
$response = $apiClient->generateText($prompt, $input);

echo "<h1>DOCUMENTS:</h1>";
echo "<br /><br />";
echo $input;
echo "<br /><br /><br /><br />";
echo "<h1>RESPONSE:</h1>";
echo "<br /><br />";
echo $response;
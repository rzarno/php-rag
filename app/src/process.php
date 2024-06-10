<?php

use app\src\service\DocumentRepository;
use app\src\service\GPTAPIClient;
use app\src\service\PromptResolver;
use app\src\service\RAGInputProvider;

require __DIR__ . '/vendor/autoload.php';

$repository = new DocumentRepository();
$apiClient = new GPTAPIClient();
#get prompt from POST or CLI or create default "2+2="
$prompt = (new PromptResolver())->getPromptFromInput();
$ragProvider = new RAGInputProvider();


#load documents
$path    = 'documents';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
$documents = [];
foreach($files as $file) {
    $document = file_get_contents($path . '/' . $file);
    $documents[] = $document;

    #load documents to postgres database
    $response = $apiClient->getEmbeddings($document);
    $repository->insertDocument($document, $response);
}

# get embeddings for prompt
$embeddingPrompt = $apiClient->getEmbeddings($prompt);

#find documents with similarity to prompt
$documentsChosen = $repository->getSimilarDocuments($embeddingPrompt);

# prepare RAG input
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
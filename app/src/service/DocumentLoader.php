<?php
namespace app\src\service;

class DocumentLoader
{
    public function __construct(
        private readonly GPTAPIClient $apiClient,
        private readonly DocumentRepository $documentRepository
    ) {
    }

    public function loadDocuments(): void
    {
        $path    = '../documents';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach($files as $file) {
            $document = file_get_contents($path . '/' . $file);

            #load documents to postgres database
            $response = $this->apiClient->getEmbeddings($document);
            $this->documentRepository->insertDocument($document, $response);
        }
    }
}
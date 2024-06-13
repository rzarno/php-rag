<?php
namespace service;

class DocumentLoader
{
    public function __construct(
        private readonly GPTAPIClient $apiClient,
        private readonly DocumentRepository $documentRepository
    ) {
    }

    public function loadDocuments(): void
    {
        $path    = __DIR__ . '/../documents';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach($files as $file) {
            $document = file_get_contents($path . '/' . $file);

            #load documents to postgres database
            $responseDocument = $this->apiClient->getEmbeddings($document);
            $meta = substr($document, 0, 300);
            $responseMeta = $this->apiClient->getEmbeddings($meta);

            $this->documentRepository->insertDocument($document, $responseDocument, $responseMeta);
        }
    }
}
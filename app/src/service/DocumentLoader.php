<?php
declare(strict_types=1);

namespace service;


final class DocumentLoader extends AbstractDocumentRepository
{
    public function __construct(
        private readonly TextEncoder $textEncoder
    ) {
        parent::__construct();
    }

    public function loadDocuments(): void
    {
        $path    = __DIR__ . '/../documents';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach($files as $file) {
            $document = file_get_contents($path . '/' . $file);

            #load documents to postgres database
            $responseDocument = $this->textEncoder->getEmbeddings($document);

            $this->insertDocument($document, $responseDocument);
        }
    }

    private function insertDocument(string $document, string $embedding): bool
    {
        $statement = $this->connection->prepare("INSERT INTO document(text, embedding) VALUES(:doc, :embed)");

        return $statement->execute([
            'doc' => $document,
            'embed' => $embedding,
        ]);
    }

}
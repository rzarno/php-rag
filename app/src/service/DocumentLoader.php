<?php
namespace service;


class DocumentLoader extends AbstractDocumentRepository
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
            $meta = substr($document, 0, 300);
            $responseMeta = $this->textEncoder->getEmbeddings($meta);

            $this->insertDocument($document, $responseDocument, $responseMeta);
        }
    }

    private function insertDocument(string $document, string $embedding, string $meta): bool
    {
        $statement = $this->connection->prepare("INSERT INTO document(text, embedding) VALUES(:doc, :embed)");

        return $statement->execute([
            'doc' => $document,
            'embed' => $embedding,
        ]);
    }

}
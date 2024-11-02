<?php
declare(strict_types=1);

namespace service;

final class DocumentLoader extends AbstractDocumentRepository
{
    public function __construct(
        private readonly TextEncoderInterface $textEncoder
    ) {
        parent::__construct();
    }

    public function loadDocuments(): void
    {
        $path    = __DIR__ . '/../documents';
        $files = array_diff(scandir($path), array('.', '..'));
        $total = count($files);

        $skipFirstN = 0; //replace this to skip documents for debugging
        foreach($files as $index => $file) {
            if ($index < $skipFirstN) {
                continue;
            }
            $document = file_get_contents($path . '/' . $file);
            //cut document to tokens limit 8192
            if (str_word_count($document) >= 0.75 * 8000) {
                $words = explode(' ', $document);
                $document = implode(' ', array_slice($words, 0, 6000));
            }
            //load documents to postgres database
            try {
                $responseDocument = $this->textEncoder->getEmbeddings($document);
            } catch (\Throwable $e) {
                error_log($e->getMessage());
            }

            $this->insertDocument($document, $responseDocument);
            $this->showProgress($index, $total);
        }
        fwrite(STDOUT, "Loading documents complete\n");
    }

    private function showProgress(int $index, int $total): void
    {
        $numLoaded = $index + 1;
        $progress = '';
        if ($numLoaded % 10 === 0) {
            for ($i = 0; $i < $numLoaded / 10; $i++) {
                $progress .= '-';
            }
            fwrite(STDOUT, "{$progress}\nLoaded {$numLoaded} of {$total} source documents to vector DB\n");
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
<?php
declare(strict_types=1);

namespace service;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;

final class DocumentProvider extends AbstractDocumentRepository implements StageInterface
{
    public function getSimilarDocuments(
        string $prompt,
        string $embeddingPrompt,
        bool $useReranking = false
    ): array {
        $stmt = $this->connection->prepare("SELECT name, text from document order by embedding <-> :embeddingPrompt limit 10;");
        $stmt->execute(['embeddingPrompt' => $embeddingPrompt]);
        $documents = $stmt->fetchAll();
        error_log('RETRIEVED DOCUMENTS:'. PHP_EOL);
        $documentsNames = [];
        foreach ($documents as &$document) {
            $documentsNames[] = $document['name'];
            error_log($document['name'] . PHP_EOL);
        }
        if ($useReranking) {
            $documents = $this->rerank($prompt, $documents);
        } else {
            $documents = array_map(function ($document) {
                return $document['text'];
            }, $documents);
        }

        return [$documents, $documentsNames];
    }

    /**
     * Sometimes its worth to use efficient algorithm for querying vector DB and more precise to rerank chosen documents in
     */
    public function rerank(string $prompt, array $documents): array
    {
        $documentsReranked = [];
        foreach ($documents as $document) {
            $intersection = array_intersect(explode(' ', $document['text']), explode(' ', $prompt));
            $index = count($intersection);
            while (isset($documentsReranked[$index])) {
                $index++;
            }
            $documentsReranked[$index] = $document['text'];
        }
        krsort($documentsReranked);
        return $documentsReranked;
    }

    /**
     * @param Payload $payload
     * @return Payload
     */
    public function __invoke($payload)
    {
        [$documents, $documentsNames] = $this->getSimilarDocuments(
            $payload->getPrompt(),
            $payload->getEmbeddingPrompt()
        );
        $payload->setSimilarDocuments($documents);
        $payload->setSimilarDocumentsNames($documentsNames);

        return $payload;
    }
}
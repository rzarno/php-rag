<?php
declare(strict_types=1);

namespace service;

use League\Pipeline\StageInterface;
use service\pipeline\Payload;

final class DocumentProvider extends AbstractDocumentRepository implements StageInterface
{
    public function getSimilarDocuments(string $prompt, string $embeddingPrompt): array
    {
        $stmt = $this->connection->prepare("SELECT text from document order by embedding <-> :embeddingPrompt limit 15;");
        $stmt->execute(['embeddingPrompt' => $embeddingPrompt]);
        $documents = $stmt->fetchAll();
        return $this->rerank($prompt, $documents);
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
        return $payload->setSimilarDocuments(
            $this->getSimilarDocuments($payload->getPrompt(), $payload->getEmbeddingPrompt())
        );
    }
}
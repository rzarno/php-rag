<?php
namespace app\src\service;

use PDO;
use PDOException;

class DocumentRepository
{
    private PDO $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO('pgsql:host=postgres;port=5432;dbname='.$_ENV["POSTGRES_DB"] .'',''.$_ENV["POSTGRES_USER"] .'',''.$_ENV["POSTGRES_PASSWORD"] .'');
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function insertDocument(string $document, string $embedding): bool
    {
        $statement = $this->connection->prepare("INSERT INTO document(text, embedding) VALUES(:doc, :embed)");
        return $statement->execute([
            "doc" => $document,
            "embed" => $embedding
        ]);
    }

    public function getSimilarDocuments(string $embeddingPrompt): array
    {
        return $this->connection->query("SELECT text from document order by embedding <-> '" . $embeddingPrompt . "'  desc limit 2;")
            ->fetchAll();
    }
}
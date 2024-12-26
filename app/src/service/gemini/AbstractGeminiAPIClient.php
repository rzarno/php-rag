<?php

namespace service\gemini;


use Dotenv\Dotenv;
use Google\Cloud\Core\ServiceBuilder;

abstract class AbstractGeminiAPIClient
{
    protected $client;
    protected string $projectId;
    protected string $location = 'us-central1';

    public function __construct()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Get project ID from environment
        $this->projectId = $_ENV['GOOGLE_PROJECT_ID'];
        $credentialsPath = $_ENV['GOOGLE_CREDENTIALS_PATH'];

        // Initialize Google Cloud client
        $cloud = new ServiceBuilder([
            'keyFilePath' => $credentialsPath
        ]);

        $this->client = $cloud->aiPlatform();
    }

    protected function getModelPath(string $modelId): string
    {
        return sprintf(
            'projects/%s/locations/%s/publishers/google/models/%s',
            $this->projectId,
            $this->location,
            $modelId
        );
    }
}

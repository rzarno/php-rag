<?php
declare(strict_types=1);

namespace Command\Rag;

use Minicli\Command\CommandController;
use function Laravel\Prompts\textarea;
use function Laravel\Prompts\spin;
use League\Pipeline\FingersCrossedProcessor;
use League\Pipeline\Pipeline;
use service\DocumentProvider;
use service\GeneratedTextProvider;
use service\pipeline\Payload;
use service\PromptResolver;
use service\RAGPromptProvider;
use service\TextEncoder;


final class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->info("Php Rag application");

        do {
            $question = textarea(
                label: 'Find answer in websites database.',
                placeholder: 'What is specialization of programmer and lecturer Michał Żarnecki based on his website content...',
                required: 'A question is required.'
            );

            spin(
                fn () => $this->process($question),
                'Fetching response...'
            );

        }while($question);
    }

    private function process(string $question)
    {
        $_POST['prompt'] = $question;

        $promptResolver = new PromptResolver();
        $textEncoder = new TextEncoder();
        $documentProvider = new DocumentProvider();
        $ragPromptProvider = new RAGPromptProvider();
        $generatedTextProvider = new GeneratedTextProvider();
        $payload = new Payload();

        $pipeline = (new Pipeline(new FingersCrossedProcessor()))
            ->pipe($promptResolver) //get prompt from POST or CLI
            ->pipe($textEncoder) //get embeddings for prompt
            ->pipe($documentProvider) //find documents with similarity to prompt
            ->pipe($ragPromptProvider) //prepare RAG input - combine prompt with matched source documents
            ->pipe($generatedTextProvider); //get API response
        $response = $pipeline->process($payload);

        $this->info($payload->getRagPrompt(), true);
        $this->display("You asked: " .$question);
        $this->success("Response: " .$response);
        $this->newline();

    }
}
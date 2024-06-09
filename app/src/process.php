<?php
try {
    $conn = new PDO('pgsql:host=postgres;port=5432;dbname='.$_ENV["POSTGRES_DB"] .'',''.$_ENV["POSTGRES_USER"] .'',''.$_ENV["POSTGRES_PASSWORD"] .'');
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

#get prompt from POST or CLI or create default "2+2="
$prompt = $_POST['prompt'] ?? null;
if (! $prompt) {
    $prompt = $argv[0] ?? null;
}
if (! $prompt) {
    $prompt = 'What is the result of 2 + 2?';
}

use Rajentrivedi\TokenizerX\TokenizerX;

require __DIR__ . '/vendor/autoload.php';

const CONTEXT_TOKEN_COUNT = 1000;
$apiKey = file_get_contents('api_key.txt');

$client = OpenAI::Client($apiKey);
$model = 'gpt-4o';

$statement = $conn->prepare('CREATE TABLE IF NOT EXISTS document (id serial PRIMARY KEY, text text)');
$statement->execute();

#load documents
$path    = 'documents';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
$documents = [];
foreach($files as $file) {
    $document = file_get_contents($path . '/' . $file);
    $documents[] = $document;

    #load documents to postgres database
    $statement = $conn->prepare("INSERT INTO document(text) VALUES(:doc)");
    $statement->execute(array(
        "doc" => $document
    ));
}

# prepare RAG input
$contextTokenCount = CONTEXT_TOKEN_COUNT - TokenizerX::count($prompt) - 20;
$input = '';
foreach($documents as $document) {
    $input .= $document . "\n";
    $tokens = TokenizerX::tokens($input, "gpt-4");

    if (count($tokens) > $contextTokenCount) {
        break;
    }
}

# prepare API input
$input .= "\n\n##### INPUT: \n"  . $prompt . "\n##### RESPONSE:\n";

# get API response
$response = $client->chat()->create([
    'model' => $model,
    'messages' => [
        [
            'content' => $input,
            'role' => 'user'
        ]
    ]
]);
echo "<h1>DOCUMENTS:</h1>";
echo "<br /><br />";
echo $input;
echo "<br /><br /><br /><br />";
echo "<h1>RESPONSE:</h1>";
echo "<br /><br />";
echo $response->choices[0]->message->content;
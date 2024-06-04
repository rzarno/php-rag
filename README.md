# Creating RAG (Retrieval Augmented Generation) application oin PHP

based on https://github.com/Krisseck/php-rag

This application uses LLM (Large Language Model) GPT-4o accessed via OpenAI API in order to generate text based on the user input. 
The user input is used to retrieve relevant information from the database and then the retrieved information is used to generate the text.
This approach combines power of transformers and access to source documents.

## Setup:
1. Run in CLI: `composer install`
2. Create api_key.txt file and put there your OpenAI API key

## Usage:

Run in CLI: `php index.php`

In cli run

### Example output:
```
##### INPUT:
What is the result of 2 + 2?
##### RESPONSE:
The result of 2 + 2 is 4.
```

# Creating RAG (Retrieval Augmented Generation) application in PHP

based on https://github.com/Krisseck/php-rag

This application uses LLM (Large Language Model) GPT-4o accessed via OpenAI API in order to generate text based on the user input. 
The user input is used to retrieve relevant information from the database and then the retrieved information is used to generate the text.
This approach combines power of transformers and access to source documents.

## Setup:
1. Run in CLI: `cd app/src && composer install`
2. Create api_key.txt file inside app/src and put there your OpenAI API key
3. Run in CLI: `cd ../../ && composer install`

## Usage:

Run in CLI: `php index.php "What is the result of 2 + 2?"`

In cli run

### Example output:
#### Example 1
```
##### INPUT:
What is the result of 2 + 2?
##### RESPONSE:
The result of 2 + 2 is 4.
```

#### Example 2
```
##### INPUT: 
what is specialization of Michał Żarnecki based on his website content
##### RESPONSE:
Based on the content of Michał Żarnecki's website, his specialization focuses on programming and lecturing in areas related to:

1. **Programming Languages**: Python, PHP, and JavaScript.
2. **Artificial Intelligence (AI) and Machine Learning**: Designing systems and solutions related to AI/machine learning, data mining, and big data.
3. **Natural Language Processing (NLP)**: Working with NLP for various applications.
4. **Big Data and Data Mining**: Expertise in data handling at large scales and mining valuable information.
5. **Lecturing**: Delivering e-learning courses and lectures on topics like machine learning.
6. **Developing Business Intelligence Tools**: Creating applications such as AI chatbots for business document analysis and search engines.
7. **Conference Speaking**: Presenting on topics like integrating machine learning models in PHP.

Key technologies and frameworks he works with include AWS, TensorFlow, PyTorch, ScikitLearn, Neo4j, Elasticsearch, Docker, and various NLP and machine learning libraries such as LangChain, RAG, and more.
```
## Concept:
<img src="ai_chatbot_llm_rag.jpg" width="1000px"/>


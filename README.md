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
Michał Żarnecki is a programmer and lecturer specializing in several key areas related to modern software development and data-driven technologies.
 
His expertise includes:
1. **Programming Languages**: Python, PHP, JavaScript.
2. **AI and Machine Learning**: Designing systems and solutions related to artificial intelligence and machine learning.
3. **Data Mining and Big Data**: Extracting valuable insights from large datasets. 
4. **Natural Language Processing (NLP)**: Working on systems that understand and generate human language. 
5. **Software Development Frameworks**: Utilizing various tools and frameworks such as Streamlit, TensorFlow, PyTorch, and langchain. 
6. **Database Systems**: Implementing and working with databases like PostgreSQL, Elasticsearch, Neo4j, and others.
 
His portfolio highlights projects such as an AI chatbot for analyzing company documents and a self-driving vehicle based on TensorFlow and Raspberry Pi.
Additionally, he has contributed to conferences and created e-learning courses focused on machine learning, underscoring his dual role as a developer and educator.
```
## Concept:
<img src="ai_chatbot_llm_rag.jpg" width="1000px"/>


# Creating RAG (Retrieval Augmented Generation) application in PHP

This application uses LLM (Large Language Model) GPT-4o accessed via OpenAI API in order to generate text based on the user input. 
The user input is used to retrieve relevant information from the database and then the retrieved information is used to generate the text.
This approach combines power of transformers and access to source documents.

## Setup:
1. Run in CLI: `cd app/src && composer install`
2. Create api_key.txt file inside app/src and put there your OpenAI API key
3. Run docker-compose: `docker-compose up`
4. Open address 127.0.0.1 in browser and ask your question

<img src="app_form.png" />

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

#### Example 3
```
##### INPUT: 
Is Michał Żarnecki programmer the same person as Michał Żarnecki audio engineer?

##### RESPONSE:
Based on the information provided, it appears that Michał Żarnecki the programmer and Michał Żarnecki the audio engineer are not the same person.
Here’s why:
1. **Fields of Expertise**:
 - Michał Żarnecki, the audio engineer, was a well-known operator and reżyser dźwięku (sound director) in Poland, with notable contributions to the Polish film industry, as mentioned in the Wikipedia excerpt.
 - Michal Żarnecki, the programmer, has a portfolio focused on programming in Python, PHP, and JavaScript, with projects related to AI, machine learning, data mining, and software development.
2. **Lifespan**:
 - Michał Żarnecki the audio engineer was born on November 12, 1946, and passed away on November 21, 2016.
 - The projects listed in Michał Żarnecki the programmer’s portfolio date from 2014 to 2016, which would be conflicting if he had passed away in 2016 and was actively working in those years. 
3. **Occupational Focus**:
 - The audio engineer has a career documented in film sound engineering and education.
 - The programmer’s career is centered around software development, mobile applications, ERP systems, and consulting in technology.

Given the distinct differences in their professional domains, timelines, and expertise, it is highly unlikely that they are the same individual
```

## Concept:
<img src="ai_chatbot_llm_rag.jpg" width="1000px"/>


## Resources:
websites used to fill vector database come from "Website Classification" dataset on Kaggle
author: Hetul Mehta
link: https://www.kaggle.com/datasets/hetulmehta/website-classification?resource=download

related articles/repositories:

https://medium.com/mlearning-ai/create-a-chatbot-in-python-with-langchain-and-rag-85bfba8c62d2

https://github.com/Krisseck/php-rag
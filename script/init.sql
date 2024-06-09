CREATE EXTENSION IF NOT EXISTS vector;

CREATE TABLE IF NOT EXISTS document (
    id serial PRIMARY KEY,
    embedding vector,
    text text,
    created_at timestamptz DEFAULT now()
);
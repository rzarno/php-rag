#!/bin/bash

# Start Ollama in the background.
/bin/ollama serve &
# Record Process ID.
pid=$!

# Pause for Ollama to start.
sleep 5

echo "🔴 Retrieve LLAMA3 model..."
ollama pull llama3.3
echo "🟢 Done!"

echo "🔴 Retrieve mxbai embedding model..."
ollama pull mxbai-embed-large
echo "🟢 Done!"

# Wait for Ollama process to finish.
wait $pid
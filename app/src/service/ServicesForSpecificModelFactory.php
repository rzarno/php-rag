<?php

namespace service;
use service\claude\ClaudeTextEncoder;
use service\claude\GeneratedTextFromClaudeProvider;
use service\gemini\GeckoTextEncoder;
use service\gemini\GeneratedTextFromGeminiProvider;
use service\ollama\GeneratedTextFromLocalLlama3Provider;
use service\ollama\GeneratedTextFromMixtralProvider;
use service\ollama\MxbaiTextEncoder;
use service\openai\Ada002TextEncoder;
use service\openai\GeneratedTextFromGPTProvider;

class ServicesForSpecificModelFactory
{
    public function getGeneratedTextProvider(string $model): GeneratedTextProviderInterface
    {
        $mapping = [
            'GPT-4o' => GeneratedTextFromGPTProvider::class,
            'Claude-3.5' => GeneratedTextFromClaudeProvider::class,
            'Llama3.2' => GeneratedTextFromLocalLlama3Provider::class,
            'Mixtral' => GeneratedTextFromMixtralProvider::class,
            'Gemini2' => GeneratedTextFromGeminiProvider::class,
        ];

        if (! isset($mapping[$model])) {
            throw new \Exception(sprintf('No service found for model %s', static::class));
        }
        return new $mapping[$model];
    }

    public function getEmbeddingsService(string $model): TextEncoderInterface
    {
        $mapping = [
            'GPT-4o' => Ada002TextEncoder::class,
            'Claude-3.5' => ClaudeTextEncoder::class,
            'Llama3.2' => MxbaiTextEncoder::class,
            'Mixtral' => MxbaiTextEncoder::class,
            'Gemini2' => GeckoTextEncoder::class,
        ];

        if (! isset($mapping[$model])) {
            throw new \Exception(sprintf('No service found for model %s', static::class));
        }
        return new $mapping[$model];
    }

}
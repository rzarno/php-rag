<?php
namespace service;

interface TextEncoderInterface
{
    /**
     * @param string $document
     * @return string[] chunks with embeddings
     */
    public function getEmbeddings(string $document): array;
}
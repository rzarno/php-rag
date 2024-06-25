<?php
namespace service;

interface TextEncoderInterface
{
    public function getEmbeddings(string $document): string;
}
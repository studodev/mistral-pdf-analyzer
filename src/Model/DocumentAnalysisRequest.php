<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class DocumentAnalysisRequest
{
    #[Assert\NotBlank]
    #[Assert\Url(requireTld: true)]
    private ?string $documentUrl;

    #[Assert\NotBlank]
    private ?string $prompt;

    public function getDocumentUrl(): ?string
    {
        return $this->documentUrl;
    }

    public function setDocumentUrl(string $documentUrl): static
    {
        $this->documentUrl = $documentUrl;

        return $this;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function setPrompt(?string $prompt): static
    {
        $this->prompt = $prompt;

        return $this;
    }
}

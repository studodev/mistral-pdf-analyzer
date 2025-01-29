<?php

namespace App\Model;

class DocumentAnalysisResponse
{
    private string $documentType;

    private string $language;

    private int $pageCount;

    public ?string $documentDate;

    private string $userResponse;

    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): static
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function getDocumentDate(): ?string
    {
        return $this->documentDate;
    }

    public function setDocumentDate(?string $documentDate): static
    {
        $this->documentDate = $documentDate;

        return $this;
    }

    public function getUserResponse(): string
    {
        return $this->userResponse;
    }

    public function setUserResponse(string $userResponse): static
    {
        $this->userResponse = $userResponse;

        return $this;
    }
}

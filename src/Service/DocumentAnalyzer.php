<?php

namespace App\Service;

use App\Model\DocumentAnalysisRequest;
use App\Model\DocumentAnalysisResponse;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class DocumentAnalyzer
{
    private const DEFAULT_PROMPT = <<<string
        Tu es une IA spécialisée dans l'analyse de documents. 
        Ta tâche est d’analyser le PDF fourni et de retourner une réponse strictement au format JSON.
        
        Le JSON doit respecter cette structure :
        {
          "document_type": "string",
          "language": "string",
          "page_count": "integer",
          "document_date": "string",
          "user_response": "string"
        }
        
        document_type : Catégorie du document (ex. : "facture", "contrat", "rapport").
        language : Langue principale du document (code ISO 639-1, ex. : "fr", "en").
        page_count : Nombre total de pages du document.
        document_date : Date de création ou de mise à jour du document, uniquement si elle est disponible dans le document (format ISO 8601, ex. : "2024-01-29").
        user_response : Réponse au prompt utilisateur en fonction du contenu du document, uniquement sous forme de texte.
    string;

    public function __construct(
        private HttpClientInterface $http,
        private SerializerInterface $serializer,
        #[Autowire('%document_analyzer%')] private array $config,
    ) {}

    public function analyze(DocumentAnalysisRequest $analysisRequest): DocumentAnalysisResponse
    {
        $payload = [
            'model' => $this->config['model'],
            'response_format' => [
                'type' => 'json_object',
            ],
            'messages' => [
                [
                    'content' => self::DEFAULT_PROMPT,
                    'role' => 'system',
                ],
                [
                    'content' => [
                        [
                            'type' => 'document_url',
                            'document_url' => $analysisRequest->getDocumentUrl(),
                        ],
                    ],
                    'role' => 'user',
                ],
                [
                    'content' => $analysisRequest->getPrompt(),
                    'role' => 'user',
                ],
            ],
        ];

        $url = sprintf('%s%s', $this->config['base_url'], $this->config['endpoint']);
        $response = $this->http->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->config['api_key']),
            ],
            'json' => $payload,
        ]);

        $responseData = $response->toArray();
        $chatData = $responseData['choices'][0]['message']['content'];

        return $this->serializer->deserialize($chatData, DocumentAnalysisResponse::class, 'json');
    }
}

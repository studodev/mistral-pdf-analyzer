<?php

namespace App\Controller;

use App\Form\DocumentAnalysisType;
use App\Model\DocumentAnalysisRequest;
use App\Service\DocumentAnalyzer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'app_document_analysis_')]
final class DocumentAnalysisController extends AbstractController
{
    public function __construct(private DocumentAnalyzer $documentAnalyzer)
    {
    }

    #[Route(path: '/', name: 'analyze')]
    public function analyze(Request $request): Response
    {
        $analysisRequest = new DocumentAnalysisRequest();
        $form = $this->createForm(DocumentAnalysisType::class, $analysisRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $analysisResponse = $this->documentAnalyzer->analyze($analysisRequest);

            return $this->render('document_analysis/result.html.twig', [
                'response' => $analysisResponse,
            ]);
        }

        return $this->render('document_analysis/analyze.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

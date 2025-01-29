<?php

namespace App\Controller;

use App\Form\DocumentAnalysisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'app_document_analysis_')]
final class DocumentAnalysisController extends AbstractController
{
    #[Route(path: '/', name: 'analyze')]
    public function analyze(Request $request): Response
    {
        $form = $this->createForm(DocumentAnalysisType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            return $this->render('document_analysis/result.html.twig', [
                'result' => null,
            ]);
        }

        return $this->render('document_analysis/analyze.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

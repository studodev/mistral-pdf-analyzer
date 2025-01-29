<?php

namespace App\Form;

use App\Model\DocumentAnalysisRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DocumentAnalysisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentUrl', UrlType::class, [
                'label' => 'URL du document',
            ])
            ->add('prompt', TextareaType::class, [
                'label' => 'Instructions',
                'attr' => [
                    'rows' => 10,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentAnalysisRequest::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}

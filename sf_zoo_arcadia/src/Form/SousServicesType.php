<?php

namespace App\Form;

use App\Entity\SousService;
use App\Entity\Images;
use App\Entity\Services;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSousService', TextType::class, [
                'label' => 'Nom du Sous-Service',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('services_nom', EntityType::class, [
                'class' => Services::class,
                'choice_label' => 'nomService',
                'label' => 'Service associé'
            ])
            ->add('images', EntityType::class, [
                'class' => Images::class,
                'choice_label' => 'nom',
                'label' => 'Images',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousService::class,
        ]);
    }
}

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Services;
use App\Entity\SousService;
use App\Entity\Images;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ]);


        if ($options['include_images']) {
            $builder->add('images', EntityType::class, [
                'class' => Images::class,
                'choice_label' => 'nom',
                'label' => 'Images',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ]);
        }


        if ($options['is_sous_service']) {
            $builder->add('service', EntityType::class, [
                'class' => Services::class,
                'choice_label' => 'nomService',
                'label' => 'Service associé',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, 
            'is_sous_service' => false, 
            'include_images' => true, 
        ]);
    }
}

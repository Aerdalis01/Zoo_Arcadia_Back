<?php

namespace App\Form;

use App\Entity\Services;
use App\Entity\Images;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomService', TextType::class, [
                'label' => 'Nom du Service',
            ])
            ->add('titreService', TextType::class, [
                'label' => 'Titre du Service',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}

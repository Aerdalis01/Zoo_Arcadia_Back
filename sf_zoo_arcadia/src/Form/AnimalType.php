<?php

namespace App\Form;

use App\Entity\Animaux;
use App\Entity\Races;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('createdAt', TextType::class)
            ->add('race', EntityType::class, [
                'class' => Races::class,
                'choice_label' => 'name',
            ])
            ->add('imagePath', TextType::class, [
                'mapped' => false, 
                'required' => false,
            ])
            ->add('imageSubDirectory', TextType::class, [
                'mapped' => false, 
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animaux::class,
        ]);
    }
}

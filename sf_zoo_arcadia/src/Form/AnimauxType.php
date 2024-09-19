<?php

namespace App\Form;

use App\Entity\Animaux;
use App\Entity\Races;
use App\Entity\Habitats;
use App\Entity\ZooArcadia;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('race', EntityType::class, [
                'class' => Races::class,
                'choice_label' => 'nom',
                'required' => true,
            ])
            ->add('image', ImagesType::class, [
                'label' => 'Informations sur l\'image',
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

<?php

namespace App\Form;

use App\Entity\Habitats;
use App\Entity\ZooArcadia;
use App\Entity\Images;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'habitat'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'habitat'
            ])
            ->add('zooArcadia', EntityType::class, [
                'class' => ZooArcadia::class,
                'choice_label' => 'nom',
                'label' => 'Zoo Arcadia'
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
            'data_class' => Habitats::class,
        ]);
    }
}

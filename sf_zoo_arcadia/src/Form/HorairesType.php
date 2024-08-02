<?php

namespace App\Form;

use App\Entity\Horaires;
use App\Entity\InfoService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour', ChoiceType::class, [
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
            ])
            ->add('heureOuverture', TextType::class, [
                'mapped' => false, // This field is not directly mapped to the Horaires entity
            ])
            ->add('heureFermeture', TextType::class, [
                'mapped' => false, // This field is not directly mapped to the Horaires entity
            ])
            ->add('infoService', EntityType::class, [
                'class' => InfoService::class,
                'choice_label' => 'name',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Horaires::class,
        ]);
    }
}

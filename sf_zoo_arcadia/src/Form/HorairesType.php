<?php

namespace App\Form;

use App\Entity\Horaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', TextType::class, [
                'label' => 'Jour',
                'required' => false
            ])
            ->add('heureOuvertureZoo', DateTimeType::class, [
                'label' => 'Heure d\'ouverture',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('heureFermetureZoo', DateTimeType::class, [
                'label' => 'Heure de fermeture',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('horairesServices', TextType::class, [
                'label' => 'Horaires des services',
                'required' => false,
            ])
            ->add('titreHoraire', TextType::class, [
                'label' => 'Titre de l\'horaire',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaires::class,
        ]);
    }
}

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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour', TextType::class, [
                'label' => 'Jour',
            ])
            ->add('heureOuvertureZoo', DateTimeType::class, [
                'label' => 'Heure d\'ouverture du zoo',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('heureFermetureZoo', DateTimeType::class, [
                'label' => 'Heure de fermeture du zoo',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('horairesServices', TextType::class, [
                'label' => 'Horaires des services',
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

<?php
namespace App\Form;

use App\Entity\RapportAlimentation;
use App\Entity\Employe;
use App\Entity\Animaux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportAlimentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date'
            ])
            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure'
            ])
            ->add('nourriture', TextType::class, [
                'label' => 'Nourriture'
            ])
            ->add('quantite', TextType::class, [
                'label' => 'Quantité'
            ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'username',
                'label' => 'Employé'
            ])
            ->add('animal', EntityType::class, [
                'class' => Animaux::class,
                'choice_label' => 'prenom', 
                'label' => 'Animal'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RapportAlimentation::class,
            'csrf_protection' => false,
        ]);
    }
}

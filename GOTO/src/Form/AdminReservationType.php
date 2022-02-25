<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date')
            ->add('Heure')
            ->add('Nbrpersonnes')
            ->add('Vip')
            ->add('Nbrbebes')
            ->add('Statut', ChoiceType::class ,[
                'choices' => [
                    'En Attente' => 'En Attente',
                    'Confirmée' => 'Confirmée',
                    'Annulée' => 'Annulée',
                ],
                'empty_data' => 'En Attente',
            ])
            ->add('lieu', EntityType::class,[
                'class' => Lieu::class,
                'choice_label' => 'nom'

            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}

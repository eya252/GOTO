<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceGroupView;
use Symfony\Component\Form\ChoiceList\View\ChoiceListView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date',DateType::class,[
                'data'=> new \DateTime("now")
            ])
            ->add('Heure')
            ->add('Nbrpersonnes')
            ->add('Vip')
            ->add('Nbrbebes')

            ->add('lieu',EntityType::class,[

                'class'=>Lieu::class,'choice_label'=>'nom'
            ])
            ->add('Statut',TextType::class,[
                'attr'=>[
                    'readonly'=>'Statut',
                    'empty_data' => 'En Attente',
                    'class'=>'form_group',
                    'style'=>'color:#AAAAAA;',
                    'value' => 'En Attente'
                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}

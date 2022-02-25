<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Type',TextType::class,[
                'label'=>'Type categorie',
                 'attr'=>[
                     'placeholder'=>'Merci de saisir le type',
                     'class'=>'Type'
                 ]
            ])
            ->add('Description',TextType::class,[
                'label'=>'Description categorie',
                'attr'=>[
                    'placeholder'=>'Merci de saisir la description',
                    'class'=>'Description'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}

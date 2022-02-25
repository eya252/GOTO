<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Lieu;
use Doctrine\DBAL\Types\TextType;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom',
                    'class'=>'form-group'
                ]
            ])
            ->add('Description')

            ->add('MenuFile',FileType::class,[
                'label'=>'Menu (PDF file)',
                'mapped'=>false,
                'required'=>false,
                /*
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024K',
                        'mimeTypes'=> 'application/pdf',
                        'mimeTypesMessage'=>'Veuillez télécharger un document PDF',
                    ])
                ],*/
            ])
            ->add('Budget')
            ->add('categorie',EntityType::class,[
             'class'=>Categorie::class,
             'choice_label'=>'type'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}




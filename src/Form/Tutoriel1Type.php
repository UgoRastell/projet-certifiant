<?php

namespace App\Form;

use App\Entity\Tutoriel;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tutoriel1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('fichier_PDF')
            ->add('fichier_video')
            ->add('categories', EntityType::class, [ // Utilisez le EntityType
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple' => true, // Indique une relation ManyToMany
                'expanded' => true, // Peut être false en fonction de votre conception
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutoriel::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Tutoriel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TutorielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre')
        ->add('description')
        ->add('fichier_PDF', FileType::class, [
            'label' => 'Fichier PDF',
            'required' => false, // Rendre le champ facultatif si nécessaire
        ])
        ->add('fichier_video', FileType::class, [
            'label' => 'Fichier vidéo',
            'required' => false, // Rendre le champ facultatif si nécessaire
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutoriel::class,
        ]);
    }
}

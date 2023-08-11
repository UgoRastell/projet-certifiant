<?php
namespace App\Form;

use App\Entity\Tutoriel;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class Tutoriel1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('fichier_PDF', FileType::class, [
                'label' => 'Fichier PDF',
                'required' => false,
                'attr' => ['class' => 'form-control-file']
            ])
            ->add('fichier_video', FileType::class, [
                'label' => 'Fichier vidéo',
                'required' => false,
                'attr' => ['class' => 'form-control-file']
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function () {
                    return ['class' => 'form-check-input'];
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutoriel::class,
        ]);
    }
}




<?php

namespace App\Controller\Admin;

use App\Entity\Tutoriel;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TutorielCrudController extends AbstractCrudController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Tutoriel::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('tutoriel')
            ->setEntityLabelInPlural('Tutoriel')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('description'),
            TextField::new('categoryNames', 'Categories')
            ->hideOnForm(),        
            ImageField::new('fichier_PDF')
            ->setLabel('PDF')
            ->setBasePath('uploads/fichiers/')
            ->setUploadDir('public/uploads/fichiers/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->hideOnIndex()
            ->setFormTypeOptions([
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '1000M', // Limite de taille maximale de 10 Mo
                        'mimeTypes' => [
                            'application/pdf', // Type MIME autorisé : PDF
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide.', // Message en cas d'erreur de type MIME
                    ]),
                ],
            ]),
        ImageField::new('fichier_video')
            ->setLabel('Vidéo')
            ->setBasePath('uploads/videos/')
            ->setUploadDir('public/uploads/videos/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->hideOnIndex()
            ->setFormTypeOptions([
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '1000M', // Limite de taille maximale de 10 Mo
                        // Ajoutez d'autres types MIME autorisés pour les vidéos si nécessaire
                        'mimeTypes' => [
                            'video/mp4', // Exemple : MP4
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une vidéo valide.', // Message en cas d'erreur de type MIME
                    ]),
                ],
            ]),
        
            AssociationField::new('categories', 'Categories')
                ->autocomplete()
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
            
            
        ];
        

    }

    // // Ajouter cette méthode pour le débogage lors de la soumission du formulaire de création
    // public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     dd($entityInstance); // Cela affichera les données du formulaire soumis
    //     parent::persistEntity($entityManager, $entityInstance);
    // }
 
}

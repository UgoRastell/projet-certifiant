<?php

namespace App\Controller\Admin;

use App\Entity\Tutoriel;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
                ->hideOnIndex(),
            ImageField::new('fichier_video')
                ->setLabel('Vidéo')
                ->setBasePath('uploads/videos/')
                ->setUploadDir('public/uploads/videos/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->hideOnIndex(),
            AssociationField::new('categories', 'Categories')
                ->autocomplete()
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'multiple' => true,
                ])
            
        ];
        
    }
 
}

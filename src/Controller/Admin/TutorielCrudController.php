<?php

namespace App\Controller\Admin;

use App\Entity\Tutoriel;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
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

    public function configureActions(Actions $actions): Actions
    {
        // Ajouter une action personnalisée
        $customAction = Action::new('customAction', 'Custom Action', 'fa fa-cogs')
            ->linkToCrudAction('customActionHandler'); // Cette méthode sera appelée lorsque l'action est exécutée

        return $actions
            ->add(Crud::PAGE_INDEX, $customAction); // Ajouter l'action à la page d'index
    }

    public function customActionHandler(AdminContext $context)
    {
        // Ici, vous pouvez exécuter votre propre logique pour l'action personnalisée
        // Par exemple, dump les données de la requête pour voir ce qui est envoyé
        dump($context->getRequest()->request->all());

        // Vous pouvez également rediriger l'utilisateur vers une autre page
        return $this->redirectToRoute('some_route');
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
                    'by_reference' => false,
                    'multiple' => true,
                ])
            
        ];
        
        
    }

    
 
}

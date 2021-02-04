<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Articles')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajout d\'un article')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modification de l\'article');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            TextField::new('content', 'Contenu'),
            ImageField::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('image')
                ->setBasePath('/uploads/images')
                ->hideOnForm(),
            VichImageField::new('imageFile')->onlyOnForms(),
            TextField::new('quote', 'Citation')
            // AssociationField::new('category', 'Catégorie'),
            // ImageField::new('imageFile', 'Image')
            //     ->setFormType(VichImageType::class)
            //     ->onlyOnForms(),
            // ImageField::new('image')
            //     ->hideOnForm(),
            // VichImageField::new('imageFile')->onlyOnForms()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus-circle')->setLabel('Ajouter un article');
            })
        ;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

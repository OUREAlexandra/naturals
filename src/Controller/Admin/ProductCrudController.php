<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Produits')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajout d\'un produit')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modification du produit');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            NumberField::new('quantity', 'Quantité'),
            NumberField::new('price', 'Prix'),
            TextField::new('description', 'Description'),
            BooleanField::new('is_activated', 'Activé'),
            AssociationField::new('category', 'Catégorie'),
            TextField::new('slug', 'Slug'),
            ImageField::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('image')
                ->setBasePath('/uploads/images')
                ->hideOnForm(),
            VichImageField::new('imageFile')->onlyOnForms()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus-circle')->setLabel('Ajouter un produit');
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

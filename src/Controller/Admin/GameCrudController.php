<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');

        yield TextareaField::new('description', 'Description')
            ->hideOnIndex();

        yield DateField::new('releaseDate', 'Date de sortie');

        yield IntegerField::new('price', 'Prix')
            ->setHelp('Ex: 25000');

        yield AssociationField::new('editor', 'Éditeur');

        yield AssociationField::new('genres', 'Genres');
    }
}
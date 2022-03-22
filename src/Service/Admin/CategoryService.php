<?php

namespace App\Service\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAvailableCategories()
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

        $categoriesArray = [];

        foreach($categories as $category){
            $name = $category->getName();
            $id = $category->getId();
            $categoriesArray[$name] = $id;
        }

        return $categoriesArray;
    }
}
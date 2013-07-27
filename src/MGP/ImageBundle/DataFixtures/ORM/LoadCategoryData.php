<?php

namespace MGP\ImageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use MGP\ImageBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load Category Fixtures
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class LoadCategoryData implements FixtureInterface
{

    /**
     * Load the fixtures
     * 
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories =
            [
                'portraits',
                'landscapes',
                'animals',
                'sports',
                'buildings',
                'others'
            ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setStatus(1);
            $manager->persist($category);
        }
        $manager->flush();
    }
}

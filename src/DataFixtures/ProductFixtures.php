<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['Суші сет', 350, 'sushi', 'Асорті з 8 ролів'],
            ['Рамен', 200, 'ramen', 'Традиційний японський суп'],
            ['Зелений чай', 50, 'drinks', 'Чай з Японії'],
            ['Темпура', 120, 'sushi', 'Смажені овочі і морепродукти'],
        ];

        foreach ($products as [$name, $price, $category, $description]) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setCategory($category);
            $product->setDescription($description);
            $manager->persist($product);
        }

        $manager->flush();
    }
}

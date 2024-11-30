<?php

namespace App\DataFixtures;

use App\Entity\Product as EntityProduct;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Product extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $randomCreatedAt = $this->randomDate('2020-01-01', '2023-12-31');

        for ($i = 1; $i <= 100; $i++) {
            $product = new EntityProduct();
            $product->setName("Product $i")
                    ->setReference("REF-$i")
                    ->setCategory("Category-$i")
                    ->setDescription("description-$i")
                    ->setDropshipping(random_int(0,1))
                    ->setCreatedAt($randomCreatedAt);
            $manager->persist($product);
        }
        $manager->flush();
    }

    function randomDate($startDate, $endDate):DateTimeImmutable {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
    
        // Générer un timestamp aléatoire entre les deux
        $randomTimestamp = random_int($startTimestamp, $endTimestamp);

        // Retourner une instance de DateTimeImmutable
        return new DateTimeImmutable("@$randomTimestamp");
    }
    
}

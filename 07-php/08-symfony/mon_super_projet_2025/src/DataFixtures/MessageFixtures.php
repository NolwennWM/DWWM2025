<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();

        $categories = [];
        for($i=0; $i < 10; $i++)
        {
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i=0; $i < 50; $i++) 
        { 
            $message = new Message();
            $message->setContent($faker->realTextBetween(50,500))
                    ->setCategory($faker->optional(0.9)->randomElement($categories))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($message);
        }
        $manager->flush();
    }
}

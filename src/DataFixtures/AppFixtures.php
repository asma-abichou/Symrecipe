<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;



class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        //Ingredients
        $ingredients = [];
        for ($i=1; $i<=50; $i++)
        {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                        ->setPrice(mt_rand(0,100));
            $manager->persist($ingredient);
        }
        $ingredients[] = $ingredient;
        //Recipes
        for ($j=1; $j<=25; $j++)
        {
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
                   ->setTime(mt_rand(0,1)== 1 ? mt_rand(1,1440): null)
                   ->setNbPeople(mt_rand(0,1)== 1 ? mt_rand(1,50): null)
                   ->setDifficulty(mt_rand(0,1)== 1 ? mt_rand(1,5): null)
                   ->setTime(mt_rand(0,1)== 1 ? mt_rand(1,1440): null)
                   ->setDescription($this->faker->text(300))
                   ->setPrice(mt_rand(0,1)== 1 ? mt_rand(1,1000): null)
                   ->setIsFavorite(mt_rand(0,1) == 1 ? true : false);
            $manager->persist($recipe);
            for ($k=1; $k<=25; $k++)
            {
                 $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients)-1)]); ;
            }
            $manager->persist($recipe);
        }
        //User
        for($k=1; $k<=10 ; $k++)
        {
            $user = new User();
            $user->setFullName($this->faker->name())
                 ->setPseudo($this->faker->firstName())
                 ->setEmail($this->faker->email())
                 ->setRoles(['ROLE_USER'])
                 ->setPlainPassword('password');
            $manager->persist($user);
        }
        $manager->flush();
    }
}

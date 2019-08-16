<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\Size;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $catHomme = new Category();
        $catHomme->setName('Homme');
        $catHomme->setDescription('Les articles destinés aux hommes');

        $manager->persist($catHomme);

        $catFemme = new Category();
        $catFemme->setName('Femme');
        $catFemme->setDescription('Les articles destinés aux femmes');

        $manager->persist($catFemme);

        $manager->flush();

        $categories = [$catHomme, $catFemme];

        //Sizes
        $sizeSmall = new Size();
        $sizeSmall->setName('small');
        $sizeSmall->setName('small');
        $manager->persist($sizeSmall);
        $sizeNormal = new Size();
        $sizeNormal->setName('normal');
        $sizeNormal->setName('normal');
        $manager->persist($sizeNormal);
        $sizeLarge = new Size();
        $sizeLarge->setName('large');
        $sizeLarge->setName('large');
        $manager->persist($sizeLarge);
        $sizes = [$sizeSmall, $sizeNormal, $sizeLarge];

        $manager->flush();

        $codesProduct = ['soldes', 'normal'];

        $firstOrder = new Order();

        for($i=0; $i<10; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setDescription($faker->text);
            for($j=0;$j<count($sizes);$j++) {
                $product->addSize($sizes[$j]);    
            }
            $product->setPrice($faker->randomFloat(2, 10, 1000));
            $product->setReference($faker->randomNumber(6));
            $product->setCode($codesProduct[$faker->numberBetween(0,1)]);
            $product->setStatus('published');
            $product->setPublishedAt(new \DateTime());
            $product->setUrlImage('chaise_longue2.jpg');
            $product->setCategory($categories[$faker->numberBetween(0,1)]);

            $manager->persist($product);

            $firstOrder->addProduct($product);
            $manager->persist($firstOrder);

        }

        $user = new User();
        $user->setEmail($faker->email);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'the_new_password'
        ));

        $user->addOrder($firstOrder);
        $firstOrder->setUser($user);
        $manager->persist($user);

        $manager->flush();
    }
}

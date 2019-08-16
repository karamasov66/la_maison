<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture {
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $faker = Faker\Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin, 'admin'
        ));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $manager->flush();
    }
}

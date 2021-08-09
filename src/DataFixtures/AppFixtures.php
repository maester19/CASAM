<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\User as EntityUser;
use App\Entity\Ville;
use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $ville = new Ville();

        $ville->setNom($faker->word())
            ->setPays($faker->country()); 
            
        $manager->persist($ville);

        $etablissement = new Etablissement();

        $etablissement->setNom($faker->word())
                ->setDescription($faker->word(9, true))
                ->setType("public")
                ->setVille($ville);

        $manager->persist($etablissement);

        $user = New User();

        $user->setEmail('user@mail.com')
            ->setPrenom($faker->word())
            ->setNom($faker->word())
            ->setNiveau(3)
            ->setRoles(["ROLE_ADMIN"])
            ->setFiliere($faker->word(2, true))
            ->setVille($ville)
            ->setEtablissement($etablissement);

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }
}

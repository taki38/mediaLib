<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
    // Ajout d'un administrateur
        $user = new User();
        $user->setEmail('takieddinesehailia@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($user, 'azerty');
        $user->setPassword($password);
        $user->setFirstname('Takieddine');
        $user->setLastname('SEHAILIA');

        $manager->persist($user);
        $manager->flush();

    // Ajout d'un utilisateur
        $user1 = new User();
        $user1->setEmail('libmedia@gmail.com');
        $user1->setRoles(['ROLE_USER']);
        $password = $this->encoder->encodePassword($user1, 'azerty');
        $user1->setPassword($password);
        $user1->setFirstname('Media');
        $user1->setLastname('LIB');

        $manager->persist($user1);
        $manager->flush();

    // Ajout d'une tache
        $task = new Task();
        $task->setTitle('Github');
        $task->setDescription('Mettre à jour la branche Main');
        $task->setUserId($user1);

        $manager->persist($task);
        $manager->flush();
    }
}

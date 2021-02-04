<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadUserData extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User("Test");
//        $user->setPassword('$2y$13$N2Ct43KmtqehxpF4NR3/3eNledPA6cOdbL2A1YR/wdVylBriT4ESC');
        $user->setPassword( $this->encoder->encodePassword($user, 'testtest') );
        $user->setName('Вася Пупкин');
        $manager->persist($user);
        $manager->flush();
    }
}
